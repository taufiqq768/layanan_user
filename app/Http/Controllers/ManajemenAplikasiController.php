<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aplikasi;
use Illuminate\Support\Facades\Validator;

class ManajemenAplikasiController extends Controller
{
    public function index()
    {
        $aplikasiList = Aplikasi::orderBy('inisial')->get();

        return view('manajemen.aplikasi', compact('aplikasiList'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'inisial' => 'required|string|max:50|unique:aplikasi,inisial',
            'nama' => 'required|string|max:255',
            'is_active' => 'required|boolean',
        ], [
            'inisial.required' => 'Inisial harus diisi',
            'inisial.unique' => 'Inisial sudah terdaftar',
            'nama.required' => 'Nama aplikasi harus diisi',
            'is_active.required' => 'Status aktif harus dipilih',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        try {
            Aplikasi::create($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Aplikasi berhasil ditambahkan'
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
        $aplikasi = Aplikasi::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'inisial' => 'required|string|max:50|unique:aplikasi,inisial,' . $id,
            'nama' => 'required|string|max:255',
            'is_active' => 'required|boolean',
        ], [
            'inisial.required' => 'Inisial harus diisi',
            'inisial.unique' => 'Inisial sudah terdaftar',
            'nama.required' => 'Nama aplikasi harus diisi',
            'is_active.required' => 'Status aktif harus dipilih',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        try {
            $aplikasi->update($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Aplikasi berhasil diupdate'
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
            $aplikasi = Aplikasi::findOrFail($id);
            $aplikasi->delete();

            return response()->json([
                'success' => true,
                'message' => 'Aplikasi berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
