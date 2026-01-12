@extends('layouts.app')

@section('content')
    <div class="row mb-4" data-aos="fade-down">
        <div class="col-12">
            <div class="glass-card bg-primary text-white p-4">
                <h2 class="fw-bold mb-0">Dashboard Admin</h2>
                <p class="mb-0 opacity-75">Selamat datang, Administrator! Kelola data desa dengan mudah.</p>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-5">
        <div class="col-md-3" data-aos="fade-up" data-aos-delay="100">
            <div class="glass-card h-100 text-center py-4">
                <i class="fas fa-users fa-3x text-primary mb-3"></i>
                <h3 class="h2 fw-bold mb-1">{{ $totalWarga }}</h3>
                <p class="text-muted mb-0">Total Warga</p>
            </div>
        </div>
        <div class="col-md-3" data-aos="fade-up" data-aos-delay="200">
            <div class="glass-card h-100 text-center py-4">
                <i class="fas fa-file-alt fa-3x text-secondary mb-3"></i>
                <h3 class="h2 fw-bold mb-1">{{ $suratMasuk }}</h3>
                <p class="text-muted mb-0">Surat Masuk</p>
            </div>
        </div>
        <div class="col-md-3" data-aos="fade-up" data-aos-delay="300">
            <div class="glass-card h-100 text-center py-4">
                <i class="fas fa-bullhorn fa-3x text-warning mb-3"></i>
                <h3 class="h2 fw-bold mb-1">{{ $pengaduan }}</h3>
                <p class="text-muted mb-0">Pengaduan</p>
            </div>
        </div>
        <div class="col-md-3" data-aos="fade-up" data-aos-delay="400">
            <div class="glass-card h-100 text-center py-4">
                <i class="fas fa-hand-holding-heart fa-3x text-danger mb-3"></i>
                <h3 class="h2 fw-bold mb-1">{{ $programBantuan }}</h3>
                <p class="text-muted mb-0">Program Bantuan</p>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row g-4 mb-5">
        <div class="col-md-6" data-aos="fade-right">
            <div class="glass-card h-100">
                <h4 class="fw-bold text-primary mb-4"><i class="fas fa-bolt me-2"></i>Aksi Cepat</h4>
                <div class="d-grid gap-3">
                    <a href="{{ route('admin.surat.index') }}" class="btn btn-outline-primary btn-lg text-start">
                        <i class="fas fa-file-signature me-2"></i>Verifikasi Surat Pengajuan
                    </a>
                    <a href="{{ route('admin.pengaduan.index') }}" class="btn btn-outline-warning btn-lg text-start">
                        <i class="fas fa-exclamation-circle me-2"></i>Tanggapi Pengaduan
                    </a>
                    <a href="{{ route('admin.program-bantuan.index') }}" class="btn btn-outline-success btn-lg text-start">
                        <i class="fas fa-plus-circle me-2"></i>Tambah Program Bantuan
                    </a>
                    <a href="{{ route('admin.statistik.index') }}" class="btn btn-outline-info btn-lg text-start">
                        <i class="fas fa-chart-pie me-2"></i>Kelola Statistik Desa
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6" data-aos="fade-left">
            <div class="glass-card h-100">
                <h4 class="fw-bold text-primary mb-4"><i class="fas fa-chart-line me-2"></i>Aktivitas Terbaru</h4>
                <div class="list-group list-group-flush">
                    <div class="list-group-item bg-transparent border-bottom py-3">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1 fw-bold">Pengajuan Surat Baru</h6>
                            <small class="text-muted">Baru saja</small>
                        </div>
                        <p class="mb-1 small text-muted">Cek menu surat untuk melihat pengajuan terbaru.</p>
                    </div>
                    <div class="list-group-item bg-transparent border-bottom py-3">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1 fw-bold">Pengaduan Masuk</h6>
                            <small class="text-muted">Hari ini</small>
                        </div>
                        <p class="mb-1 small text-muted">Cek menu pengaduan untuk melihat laporan warga.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection