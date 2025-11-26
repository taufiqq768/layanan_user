<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faq;
use App\Models\Aplikasi;
use Illuminate\Support\Facades\Validator;

class ManajemenFaqController extends Controller
{
    public function index()
    {
        $faqList = Faq::orderBy('aplikasi')->orderBy('urutan')->get();
        $aplikasiList = Aplikasi::active()->get();

        return view('manajemen.faq', compact('faqList', 'aplikasiList'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'aplikasi' => 'required|string|max:50',
            'pertanyaan' => 'required|string',
            'jawaban' => 'required|string',
            'urutan' => 'required|integer|min:0',
            'is_active' => 'required|boolean',
        ], [
            'aplikasi.required' => 'Aplikasi harus dipilih',
            'pertanyaan.required' => 'Pertanyaan harus diisi',
            'jawaban.required' => 'Jawaban harus diisi',
            'urutan.required' => 'Urutan harus diisi',
            'urutan.min' => 'Urutan minimal 0',
            'is_active.required' => 'Status aktif harus dipilih',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        try {
            Faq::create($request->all());

            return response()->json([
                'success' => true,
                'message' => 'FAQ berhasil ditambahkan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $faq = Faq::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'aplikasi' => 'required|string|max:50',
            'pertanyaan' => 'required|string',
            'jawaban' => 'required|string',
            'urutan' => 'required|integer|min:0',
            'is_active' => 'required|boolean',
        ], [
            'aplikasi.required' => 'Aplikasi harus dipilih',
            'pertanyaan.required' => 'Pertanyaan harus diisi',
            'jawaban.required' => 'Jawaban harus diisi',
            'urutan.required' => 'Urutan harus diisi',
            'urutan.min' => 'Urutan minimal 0',
            'is_active.required' => 'Status aktif harus dipilih',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        try {
            $faq->update($request->all());

            return response()->json([
                'success' => true,
                'message' => 'FAQ berhasil diupdate'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $faq = Faq::findOrFail($id);
            $faq->delete();

            return response()->json([
                'success' => true,
                'message' => 'FAQ berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
