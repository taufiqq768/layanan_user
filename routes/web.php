<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\ManajemenAdminController;
use App\Http\Controllers\ManajemenAplikasiController;
use App\Http\Controllers\ManajemenFaqController;

// Halaman utama layanan user
Route::get('/', [LayananController::class, 'index'])->name('layanan.index');

// Route untuk submit pertanyaan
Route::post('/layanan/submit', [LayananController::class, 'store'])->name('layanan.store');

// Route untuk halaman FAQ
Route::get('/faq', [LayananController::class, 'faq'])->name('layanan.faq');

// Route untuk authentication admin
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::get('/admin/register', [AdminAuthController::class, 'showRegisterForm'])->name('admin.register');
Route::post('/admin/register', [AdminAuthController::class, 'register']);
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Route admin yang dilindungi middleware
Route::middleware(['admin'])->group(function () {
    // Route untuk halaman admin
    Route::get('/admin/layanan', [LayananController::class, 'admin'])->name('layanan.admin');

    // Route untuk halaman balas pertanyaan
    Route::get('/admin/layanan/{id}/reply', [LayananController::class, 'showReplyForm'])->name('layanan.reply');

    // Route untuk mengirim jawaban
    Route::post('/admin/layanan/{id}/reply', [LayananController::class, 'sendReply'])->name('layanan.sendReply');

    // Route untuk update status pertanyaan
    Route::post('/admin/layanan/{id}/status', [LayananController::class, 'updateStatus'])->name('layanan.updateStatus');

    // Route untuk Manajemen Admin
    Route::prefix('admin/manajemen')->group(function () {
        // Manajemen Admin
        Route::get('/admin', [ManajemenAdminController::class, 'index'])->name('manajemen.admin.index');
        Route::post('/admin', [ManajemenAdminController::class, 'store'])->name('manajemen.admin.store');
        Route::put('/admin/{id}', [ManajemenAdminController::class, 'update'])->name('manajemen.admin.update');
        Route::delete('/admin/{id}', [ManajemenAdminController::class, 'destroy'])->name('manajemen.admin.destroy');

        // Manajemen Aplikasi
        Route::get('/aplikasi', [ManajemenAplikasiController::class, 'index'])->name('manajemen.aplikasi.index');
        Route::post('/aplikasi', [ManajemenAplikasiController::class, 'store'])->name('manajemen.aplikasi.store');
        Route::put('/aplikasi/{id}', [ManajemenAplikasiController::class, 'update'])->name('manajemen.aplikasi.update');
        Route::delete('/aplikasi/{id}', [ManajemenAplikasiController::class, 'destroy'])->name('manajemen.aplikasi.destroy');

        // Manajemen FAQ
        Route::get('/faq', [ManajemenFaqController::class, 'index'])->name('manajemen.faq.index');
        Route::post('/faq', [ManajemenFaqController::class, 'store'])->name('manajemen.faq.store');
        Route::put('/faq/{id}', [ManajemenFaqController::class, 'update'])->name('manajemen.faq.update');
        Route::delete('/faq/{id}', [ManajemenFaqController::class, 'destroy'])->name('manajemen.faq.destroy');
    });
});
