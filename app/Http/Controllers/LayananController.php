<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pertanyaan;
use App\Models\Aplikasi;
use App\Models\Faq;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\PertanyaanDijawab;
use App\Services\WhatsAppService;

class LayananController extends Controller
{
    // Menampilkan halaman form layanan
    public function index(Request $request)
    {
        $selectedApp = null;

        // Cek parameter 'app' dari URL
        if ($request->has('app')) {
            $appParam = strtoupper(trim($request->get('app')));

            // Validasi aplikasi ada dan aktif
            $aplikasi = Aplikasi::where('inisial', $appParam)
                ->where('is_active', true)
                ->first();

            if ($aplikasi) {
                $selectedApp = $aplikasi->inisial;
            }
        }

        // Cek parameter 'token' dari URL (opsional untuk keamanan)
        if ($request->has('token') && !$selectedApp) {
            $token = trim($request->get('token'));

            // Validasi token dan ambil aplikasi terkait
            $aplikasi = Aplikasi::where('access_token', $token)
                ->where('is_active', true)
                ->first();

            if ($aplikasi) {
                $selectedApp = $aplikasi->inisial;
            }
        }

        // Jika tidak ada parameter yang valid, tampilkan halaman error
        if (!$selectedApp) {
            return view('layanan.access-denied');
        }

        // Ambil daftar aplikasi dari database (hanya yang aktif)
        $aplikasiList = Aplikasi::active()
            ->orderBy('inisial')
            ->pluck('inisial', 'inisial');

        return view('layanan.index', compact('aplikasiList', 'selectedApp'));
    }

    // Menyimpan pertanyaan ke database
    public function store(Request $request)
    {
        $rules = [
            'aplikasi' => 'required|string|max:255',
            'pertanyaan' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'email' => 'nullable|email|max:255',
            'whatsapp' => 'nullable|string|min:10|max:20',
        ];

        $messages = [
            'aplikasi.required' => 'Pilih aplikasi terlebih dahulu',
            'pertanyaan.required' => 'Pertanyaan harus diisi',
            'gambar.image' => 'File harus berupa gambar',
            'gambar.mimes' => 'Format gambar harus: jpeg, png, jpg, atau gif',
            'gambar.max' => 'Ukuran gambar maksimal 2MB',
            'email.email' => 'Format email tidak valid',
            'whatsapp.min' => 'Nomor WhatsApp minimal 10 digit',
        ];

        // Only validate CAPTCHA if enabled
        if (config('captcha.enabled', true)) {
            $rules['g-recaptcha-response'] = 'required|captcha';
            $messages['g-recaptcha-response.required'] = 'Mohon centang CAPTCHA';
            $messages['g-recaptcha-response.captcha'] = 'Verifikasi CAPTCHA gagal, silakan coba lagi';
        }

        // Validasi input
        $validator = Validator::make($request->all(), $rules, $messages);

        // Validasi custom: minimal satu kontak harus diisi
        $validator->after(function ($validator) use ($request) {
            if (empty($request->email) && empty($request->whatsapp)) {
                $validator->errors()->add('kontak', 'Minimal satu kontak (Email atau WhatsApp) harus diisi');
            }
        });

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        // Simpan ke database
        try {
            $gambarPath = null;

            // Handle upload gambar
            if ($request->hasFile('gambar')) {
                $file = $request->file('gambar');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/pertanyaan'), $filename);
                $gambarPath = 'uploads/pertanyaan/' . $filename;
            }

            $pertanyaan = Pertanyaan::create([
                'aplikasi' => $request->aplikasi,
                'pertanyaan' => $request->pertanyaan,
                'gambar' => $gambarPath,
                'email' => $request->email,
                'whatsapp' => $request->whatsapp,
                'ip_address' => $request->ip(),
                'status' => 'pending'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pertanyaan Anda berhasil dikirim! Admin akan segera menghubungi Anda.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.'
            ], 500);
        }
    }

    // Halaman admin
    public function admin(Request $request)
    {
        $admin = auth()->guard('admin')->user();

        // Dapatkan daftar aplikasi yang di-handle oleh admin
        $adminAplikasi = $admin->aplikasi_list;

        $query = Pertanyaan::query()
            ->whereIn('aplikasi', $adminAplikasi)
            ->orderBy('created_at', 'desc');

        // Base query untuk statistik (mengikuti filter yang sama)
        $statsQuery = Pertanyaan::query()->whereIn('aplikasi', $adminAplikasi);

        // Filter berdasarkan aplikasi
        if ($request->has('aplikasi') && $request->aplikasi != '') {
            $query->byAplikasi($request->aplikasi);
            $statsQuery->byAplikasi($request->aplikasi);
        }

        // Filter berdasarkan status
        if ($request->has('status') && $request->status != '') {
            $query->byStatus($request->status);
            // Status filter tidak diterapkan ke stats agar tetap menampilkan breakdown
        }

        $pertanyaan = $query->get();

        // Statistik DINAMIS - berdasarkan filter aplikasi yang dipilih
        $stats = [
            'total' => (clone $statsQuery)->count(),
            'pending' => (clone $statsQuery)->where('status', 'pending')->count(),
            'replied' => (clone $statsQuery)->where('status', 'replied')->count(),
            'closed' => (clone $statsQuery)->where('status', 'closed')->count(),
            'dengan_email' => (clone $statsQuery)->whereNotNull('email')->where('email', '!=', '')->count(),
            'dengan_whatsapp' => (clone $statsQuery)->whereNotNull('whatsapp')->where('whatsapp', '!=', '')->count(),
        ];

        // Daftar aplikasi untuk filter (hanya aplikasi yang di-handle)
        $aplikasiList = Pertanyaan::select('aplikasi')
            ->whereIn('aplikasi', $adminAplikasi)
            ->distinct()
            ->pluck('aplikasi');

        return view('layanan.admin', compact('pertanyaan', 'stats', 'aplikasiList'));
    }

    // Menampilkan form untuk balas pertanyaan
    public function showReplyForm($id)
    {
        $admin = auth()->guard('admin')->user();
        $pertanyaan = Pertanyaan::findOrFail($id);

        // Cek apakah admin berhak menangani aplikasi ini
        if (!$admin->handlesAplikasi($pertanyaan->aplikasi)) {
            abort(403, 'Anda tidak memiliki akses untuk aplikasi ini.');
        }

        return view('layanan.reply', compact('pertanyaan'));
    }

    // Mengirim jawaban via email dan/atau WhatsApp
    public function sendReply(Request $request, $id)
    {
        $admin = auth()->guard('admin')->user();
        $pertanyaan = Pertanyaan::findOrFail($id);

        // Cek apakah admin berhak menangani aplikasi ini
        if (!$admin->handlesAplikasi($pertanyaan->aplikasi)) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses untuk aplikasi ini.'
            ], 403);
        }

        // Validasi input
        $validator = Validator::make($request->all(), [
            'jawaban' => 'required|string',
            'replied_by' => 'required|string|max:255',
            'gambar_jawaban' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'jawaban.required' => 'Jawaban harus diisi',
            'replied_by.required' => 'Nama admin harus diisi',
            'gambar_jawaban.image' => 'File harus berupa gambar',
            'gambar_jawaban.mimes' => 'Format gambar harus: jpeg, png, jpg, atau gif',
            'gambar_jawaban.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $sendEmail = $request->has('send_email') && $request->send_email == '1';
        $sendWhatsapp = $request->has('send_whatsapp') && $request->send_whatsapp == '1';

        // Validasi minimal satu metode pengiriman
        if (!$sendEmail && !$sendWhatsapp) {
            return response()->json([
                'success' => false,
                'message' => 'Pilih minimal satu metode pengiriman (Email atau WhatsApp)'
            ], 422);
        }

        try {
            // Set timeout maksimal untuk keseluruhan proses (30 detik)
            set_time_limit(30);

            $gambarJawabanPath = $pertanyaan->gambar_jawaban;

            // Handle upload gambar jawaban
            if ($request->hasFile('gambar_jawaban')) {
                // Hapus gambar lama jika ada
                if ($pertanyaan->gambar_jawaban && file_exists(public_path($pertanyaan->gambar_jawaban))) {
                    unlink(public_path($pertanyaan->gambar_jawaban));
                }

                $file = $request->file('gambar_jawaban');
                $filename = 'jawaban_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/pertanyaan'), $filename);
                $gambarJawabanPath = 'uploads/pertanyaan/' . $filename;
            }

            // Update data pertanyaan DULU - ini yang paling penting
            $pertanyaan->update([
                'jawaban' => $request->jawaban,
                'gambar_jawaban' => $gambarJawabanPath,
                'replied_by' => $request->replied_by,
                'replied_at' => now(),
                'status' => 'replied'
            ]);

            // Kirim response DULU sebelum proses email/WA
            $response = response()->json([
                'success' => true,
                'message' => 'Jawaban berhasil disimpan! Notifikasi sedang dikirim ke pengguna.'
            ]);

            // Kirim response dan flush output buffer
            if (function_exists('fastcgi_finish_request')) {
                $response->send();
                fastcgi_finish_request();
            }

            // Proses notifikasi SETELAH response dikirim (tidak akan block user)
            $messages = [];

            // Kirim via Email
            if ($sendEmail && $pertanyaan->email) {
                try {
                    Mail::to($pertanyaan->email)->send(new PertanyaanDijawab($pertanyaan));
                    \Log::info("Email sent successfully to {$pertanyaan->email}");
                } catch (\Exception $e) {
                    \Log::error('Email sending failed: ' . $e->getMessage());
                }
            }

            // Kirim via WhatsApp
            if ($sendWhatsapp && $pertanyaan->whatsapp) {
                try {
                    $whatsappService = new WhatsAppService();

                    // Format pesan WhatsApp
                    $waMessage = "*Jawaban untuk Pertanyaan Anda*\n\n";

                    if ($pertanyaan->nomor_tiket) {
                        $waMessage .= "🎫 *Nomor Tiket:* {$pertanyaan->nomor_tiket}\n\n";
                    }

                    $waMessage .= "*Aplikasi:* {$pertanyaan->aplikasi}\n\n";
                    $waMessage .= "*Pertanyaan Anda:*\n{$pertanyaan->pertanyaan}\n\n";
                    $waMessage .= "*Jawaban:*\n{$pertanyaan->jawaban}\n\n";
                    $waMessage .= "_Dijawab oleh: {$pertanyaan->replied_by}_\n";
                    $waMessage .= "_Tanggal: " . now()->format('d/m/Y H:i') . "_";

                    $result = $whatsappService->sendMessage($pertanyaan->whatsapp, $waMessage);

                    if ($result['success']) {
                        \Log::info("WhatsApp sent successfully to {$pertanyaan->whatsapp}");

                        // Kirim gambar
                        if ($pertanyaan->gambar) {
                            $whatsappService->sendImage(
                                $pertanyaan->whatsapp,
                                $pertanyaan->gambar,
                                '📷 Screenshot pertanyaan Anda'
                            );
                        }

                        if ($pertanyaan->gambar_jawaban) {
                            $whatsappService->sendImage(
                                $pertanyaan->whatsapp,
                                $pertanyaan->gambar_jawaban,
                                '📷 Screenshot jawaban dari admin'
                            );
                        }
                    }
                } catch (\Exception $e) {
                    \Log::error('WhatsApp sending failed: ' . $e->getMessage());
                }
            }

            return $response;

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    // Update status pertanyaan
    public function updateStatus(Request $request, $id)
    {
        $admin = auth()->guard('admin')->user();
        $pertanyaan = Pertanyaan::findOrFail($id);

        // Cek apakah admin berhak menangani aplikasi ini
        if (!$admin->handlesAplikasi($pertanyaan->aplikasi)) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses untuk aplikasi ini.'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,replied,closed'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Status tidak valid'
            ], 422);
        }

        $pertanyaan->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Status berhasil diupdate'
        ]);
    }

    // Menampilkan halaman FAQ berdasarkan aplikasi
    public function faq(Request $request)
    {
        $aplikasi = $request->get('aplikasi');

        if (!$aplikasi) {
            return redirect()->route('layanan.index')
                ->with('error', 'Pilih aplikasi terlebih dahulu');
        }

        // Ambil data FAQ berdasarkan aplikasi
        $faqList = Faq::active()
            ->byAplikasi($aplikasi)
            ->orderBy('created_at', 'desc')
            ->get();

        // Ambil info aplikasi
        $aplikasiInfo = Aplikasi::where('inisial', $aplikasi)->first();

        if (!$aplikasiInfo) {
            return redirect()->route('layanan.index')
                ->with('error', 'Aplikasi tidak ditemukan');
        }

        return view('layanan.faq', compact('faqList', 'aplikasiInfo'));
    }
}
