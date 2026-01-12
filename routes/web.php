<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\warga\SuratPengajuanController;
use App\Http\Controllers\admins\SuratPengajuanController as AdminSuratPengajuanController;

// ========================
// Beranda
// ========================
Route::get('/', [BerandaController::class, 'index'])->name('beranda');
Route::get('/statistik', [\App\Http\Controllers\StatistikController::class, 'index'])->name('statistik.index');

// ========================
// LOGIN & LOGOUT ADMIN
// ========================
Route::get('/logout-admins', [AdminsController::class, 'logout'])->name('admins.logout');

// Dashboard admin (hanya admin login)
Route::get('/admin/dashboard', [AdminsController::class, 'dashboard'])
    ->name('admins.dashboard')
    ->middleware('auth');

// ========================
// REGISTER USER
// ========================
Route::get('/register', [RegisterController::class, 'show'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

// ========================
// LOGIN
// ========================
Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'process'])->name('login.process');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Dashboard (hanya user login)
Route::middleware('auth')->group(function () {
    Route::get('/warga/dashboard', [UsersController::class, 'dashboard'])->name('users.dashboard');
    Route::get('/warga/profil', [UsersController::class, 'profile'])->name('users.profile');
    Route::post('/warga/profil/password', [UsersController::class, 'updatePassword'])->name('users.profile.password');
});

// ========================
// SURAT PENGAJUAN
// ========================
Route::middleware('auth')->group(function () {
    Route::resource('surat-pengajuan', SuratPengajuanController::class);
    Route::get('/surat-pengajuan/{id}/detail', [SuratPengajuanController::class, 'detail'])
        ->name('surat-pengajuan.detail');
    Route::get('/surat-pengajuan/{id}/download', [SuratPengajuanController::class, 'download'])
        ->name('surat-pengajuan.download');

    // ========================
    // PENGADUAN
    // ========================
    Route::get('/pengaduan', [\App\Http\Controllers\Warga\PengaduanController::class, 'index'])->name('pengaduan.index');
    Route::post('/pengaduan', [\App\Http\Controllers\Warga\PengaduanController::class, 'store'])->name('pengaduan.store');

    // ========================
    // PROGRAM BANTUAN - USER
    // ========================
    Route::get('/program-bantuan', [\App\Http\Controllers\Users\ProgramBantuanController::class, 'index'])->name('program-bantuan.index');

    // ========================
    // SURAT PENGAJUAN - ADMIN
    // ========================
    Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/surat', [AdminSuratPengajuanController::class, 'index'])->name('surat.index');
        Route::get('/surat/{id}', [AdminSuratPengajuanController::class, 'show'])->name('surat.show');
        Route::get('/surat/{id}/preview', [AdminSuratPengajuanController::class, 'preview'])->name('surat.preview');
        Route::post('/surat/{id}/approve', [AdminSuratPengajuanController::class, 'approve'])->name('surat.approve');
        Route::post('/surat/{id}/reject', [AdminSuratPengajuanController::class, 'reject'])->name('surat.reject');
        Route::delete('/surat/{id}', [AdminSuratPengajuanController::class, 'destroy'])->name('surat.delete');

        // ========================
        // PENGADUAN - ADMIN
        // ========================
        Route::get('/pengaduan', [\App\Http\Controllers\Admins\PengaduanController::class, 'index'])->name('pengaduan.index');
        Route::put('/pengaduan/{id}', [\App\Http\Controllers\Admins\PengaduanController::class, 'update'])->name('pengaduan.update');

        // ========================
        // PROGRAM BANTUAN - ADMIN
        // ========================
        Route::resource('program-bantuan', \App\Http\Controllers\Admins\ProgramBantuanController::class);

        // ========================
        // BIODATA WARGA - ADMIN
        // ========================
        Route::resource('biodata-warga', \App\Http\Controllers\Admins\BiodataWargaController::class);

        // ========================
        // STATISTIK - ADMIN
        // ========================
        Route::get('/statistik', [\App\Http\Controllers\Admins\StatistikController::class, 'index'])->name('statistik.index');
        Route::post('/statistik/update', [\App\Http\Controllers\Admins\StatistikController::class, 'update'])->name('statistik.update');
        Route::delete('/statistik/pekerjaan/{id}', [\App\Http\Controllers\Admins\StatistikController::class, 'destroyPekerjaan'])->name('statistik.pekerjaan.delete');

        // ========================
        // KEUANGAN DESA - ADMIN
        // ========================
        Route::resource('keuangan', \App\Http\Controllers\Admins\KeuanganDesaController::class);
    });
});
