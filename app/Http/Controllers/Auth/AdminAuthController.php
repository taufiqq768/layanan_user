<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminAplikasi;
use App\Models\Aplikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminAuthController extends Controller
{
    // Tampilkan form login
    public function showLoginForm()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('layanan.admin');
        }
        return view('auth.admin-login');
    }

    // Proses login
    public function login(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ];

        $messages = [
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 6 karakter',
        ];

        // Only validate CAPTCHA if enabled
        if (config('captcha.enabled', true)) {
            $rules['g-recaptcha-response'] = 'required|captcha';
            $messages['g-recaptcha-response.required'] = 'Mohon centang CAPTCHA';
            $messages['g-recaptcha-response.captcha'] = 'Verifikasi CAPTCHA gagal, silakan coba lagi';
        }

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::guard('admin')->attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended(route('layanan.admin'))->with('success', 'Login berhasil!');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput();
    }

    // Tampilkan form register
    public function showRegisterForm()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('layanan.admin');
        }

        // Ambil daftar aplikasi dari database (hanya yang aktif)
        $aplikasiList = Aplikasi::active()
            ->orderBy('inisial')
            ->get();

        return view('auth.admin-register', compact('aplikasiList'));
    }

    // Proses register
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|min:6|confirmed',
            'aplikasi' => 'required|array|min:1',
            'aplikasi.*' => 'string',
        ], [
            'name.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'aplikasi.required' => 'Pilih minimal satu aplikasi',
            'aplikasi.min' => 'Pilih minimal satu aplikasi',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            // Buat admin
            $admin = Admin::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Simpan aplikasi yang di-handle
            foreach ($request->aplikasi as $app) {
                AdminAplikasi::create([
                    'admin_id' => $admin->id,
                    'aplikasi' => $app,
                ]);
            }

            // Auto login setelah register
            Auth::guard('admin')->login($admin);

            return redirect()->route('layanan.admin')->with('success', 'Registrasi berhasil! Selamat datang.');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', 'Logout berhasil!');
    }
}
