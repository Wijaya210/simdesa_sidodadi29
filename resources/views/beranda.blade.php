@extends('layouts.app')

@section('main_class', '')

@section('content')
<div class="hero-section mb-5">
    <div class="hero-overlay"></div>
    <div class="container hero-content" data-aos="fade-up">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-3 fw-bold mb-4 text-white">Selamat Datang di<br>Desa Sidodadi</h1>
                <p class="lead mb-5 opacity-90">
                    Wujudkan pelayanan publik yang transparan, cepat, dan efisien untuk kemajuan bersama.
                    Akses layanan desa dari mana saja dan kapan saja.
                </p>
                <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                    @guest
                        <a href="{{ route('login') }}"
                            class="btn btn-light btn-lg px-5 me-md-2 text-primary fw-bold shadow">
                            <i class="fas fa-sign-in-alt me-2"></i>Masuk
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg px-5">
                            <i class="fas fa-user-plus me-2"></i>Daftar
                        </a>
                    @else
                        <a href="{{ route('users.dashboard') }}"
                            class="btn btn-light btn-lg px-5 text-primary fw-bold shadow">
                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                        </a>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container pb-5">


        <!-- Features Section -->
        <div class="row g-4 mb-5">
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="glass-card h-100 text-center">
                    <div class="mb-4">
                        <i class="fas fa-file-alt fa-4x text-primary floating-icon"></i>
                    </div>
                    <h3 class="h4 fw-bold mb-3">Pengajuan Surat</h3>
                    <p class="text-muted">
                        Ajukan surat pengantar nikah, pindah, usaha, dan lainnya secara online tanpa antri.
                    </p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="glass-card h-100 text-center">
                    <div class="mb-4">
                        <i class="fas fa-bullhorn fa-4x text-accent floating-icon" style="color: var(--accent-color);"></i>
                    </div>
                    <h3 class="h4 fw-bold mb-3">Layanan Pengaduan</h3>
                    <p class="text-muted">
                        Sampaikan aspirasi dan keluhan Anda langsung kepada perangkat desa untuk ditindaklanjuti.
                    </p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                <div class="glass-card h-100 text-center">
                    <div class="mb-4">
                        <i class="fas fa-hand-holding-heart fa-4x text-secondary floating-icon"
                            style="color: var(--secondary-color);"></i>
                    </div>
                    <h3 class="h4 fw-bold mb-3">Program Bantuan</h3>
                    <p class="text-muted">
                        Informasi transparan mengenai program bantuan sosial dan penerima manfaat di desa.
                    </p>
                </div>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="glass-card text-center py-5 mb-5" data-aos="zoom-in">
            <div class="row">
                <div class="col-md-4 mb-4 mb-md-0">
                    <h2 class="display-4 fw-bold text-primary">1.5k+</h2>
                    <p class="text-muted mb-0">Penduduk</p>
                </div>
                <div class="col-md-4 mb-4 mb-md-0">
                    <h2 class="display-4 fw-bold text-primary">500+</h2>
                    <p class="text-muted mb-0">Kepala Keluarga</p>
                </div>
                <div class="col-md-4">
                    <h2 class="display-4 fw-bold text-primary">24/7</h2>
                    <p class="text-muted mb-0">Layanan Online</p>
                </div>
            </div>
        </div>
@endsection