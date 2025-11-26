<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\AdminAplikasi;
use App\Models\Aplikasi;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ManajemenAdminController extends Controller
{
    public function index()
    {
        $admins = Admin::with('aplikasi')->get();
        $aplikasiList = Aplikasi::active()->get();

        return view('manajemen.admin', compact('admins', 'aplikasiList'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|string|min:6',
            'aplikasi' => 'required|array|min:1',
            'aplikasi.*' => 'exists:aplikasi,inisial',
        ], [
            'name.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 6 karakter',
            'aplikasi.required' => 'Pilih minimal 1 aplikasi',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        try {
            $admin = Admin::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Assign aplikasi ke admin
            foreach ($request->aplikasi as $aplikasi) {
                AdminAplikasi::create([
                    'admin_id' => $admin->id,
                    'aplikasi' => $aplikasi,
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Admin berhasil ditambahkan'
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
        $admin = Admin::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email,' . $id,
            'password' => 'nullable|string|min:6',
            'aplikasi' => 'required|array|min:1',
            'aplikasi.*' => 'exists:aplikasi,inisial',
        ], [
            'name.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.min' => 'Password minimal 6 karakter',
            'aplikasi.required' => 'Pilih minimal 1 aplikasi',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        try {
            $updateData = [
                'name' => $request->name,
                'email' => $request->email,
            ];

            if ($request->filled('password')) {
                $updateData['password'] = Hash::make($request->password);
            }

            $admin->update($updateData);

            // Update aplikasi
            AdminAplikasi::where('admin_id', $admin->id)->delete();
            foreach ($request->aplikasi as $aplikasi) {
                AdminAplikasi::create([
                    'admin_id' => $admin->id,
                    'aplikasi' => $aplikasi,
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Admin berhasil diupdate'
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
            $admin = Admin::findOrFail($id);

            // Hapus relasi aplikasi
            AdminAplikasi::where('admin_id', $admin->id)->delete();

            // Hapus admin
            $admin->delete();

            return response()->json([
                'success' => true,
                'message' => 'Admin berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
