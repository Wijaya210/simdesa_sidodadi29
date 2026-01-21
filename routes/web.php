<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Warga\SuratPengajuanController;
use App\Http\Controllers\Admins\SuratPengajuanController as AdminSuratPengajuanController;
use App\Http\Controllers\Admins\BeritaController as AdminBeritaController;
use App\Http\Controllers\Users\BeritaController as UserBeritaController;

// ========================
// Beranda
// ========================
Route::get('/', [BerandaController::class, 'index'])->name('beranda');
Route::get('/statistik', [\App\Http\Controllers\StatistikController::class, 'index'])->name('statistik.index');
Route::get('/surat-validasi/{id}', [\App\Http\Controllers\ValidasiSuratController::class, 'index'])->name('surat.validasi');

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
Route::get('/register/verify', [RegisterController::class, 'showVerifyForm'])->name('register.verify.form');
Route::post('/register/verify', [RegisterController::class, 'verify'])->name('register.verify');

// ========================
// LOGIN
// ========================
Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'process'])->name('login.process');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ========================
// FORGOT PASSWORD
// ========================
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetOtp'])->name('password.email');
Route::get('/reset-password', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset.form');
Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])->name('password.update');

// Dashboard (hanya user login)
Route::middleware('auth')->group(function () {
    Route::get('/warga/dashboard', [UsersController::class, 'dashboard'])->name('users.dashboard');
    Route::get('/warga/profil', [UsersController::class, 'profile'])->name('users.profile');
    Route::post('/warga/profil/password', [UsersController::class, 'updatePassword'])->name('users.profile.password');
    Route::get('/warga/profil/password-verify', [UsersController::class, 'showPasswordVerifyForm'])->name('users.profile.password.verify');
    Route::post('/warga/profil/password-verify', [UsersController::class, 'verifyPasswordUpdate'])->name('users.profile.password.verify.process');
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
    // BERITA - USER
    // ========================
    Route::get('/berita', [UserBeritaController::class, 'index'])->name('berita.index');
    Route::get('/berita/{slug}', [UserBeritaController::class, 'show'])->name('berita.show');

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
        // BERITA - ADMIN
        // ========================
        Route::resource('berita', AdminBeritaController::class);

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
