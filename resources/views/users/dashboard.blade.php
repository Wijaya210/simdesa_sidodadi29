@extends('layouts.app')

@section('content')
<div class="row mb-4" data-aos="fade-down">
    <div class="col-12">
        <div class="glass-card bg-primary text-white p-4">
            <h2 class="fw-bold mb-0">Dashboard Warga</h2>
            <p class="mb-0 opacity-75">Selamat datang kembali, {{ auth()->user()->name }}!</p>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="row g-4 mb-5">
    <div class="col-md-3" data-aos="fade-up" data-aos-delay="100">
        <div class="glass-card h-100 text-center py-4">
            <i class="fas fa-users fa-3x text-primary mb-3"></i>
            <h3 class="h2 fw-bold mb-1">120</h3>
            <p class="text-muted mb-0">Total Warga</p>
        </div>
    </div>
    <div class="col-md-3" data-aos="fade-up" data-aos-delay="200">
        <div class="glass-card h-100 text-center py-4">
            <i class="fas fa-user-shield fa-3x text-secondary mb-3"></i>
            <h3 class="h2 fw-bold mb-1">5</h3>
            <p class="text-muted mb-0">Admin Desa</p>
        </div>
    </div>
    <div class="col-md-3" data-aos="fade-up" data-aos-delay="300">
        <div class="glass-card h-100 text-center py-4">
            <i class="fas fa-envelope-open-text fa-3x text-warning mb-3"></i>
            <h3 class="h2 fw-bold mb-1">18</h3>
            <p class="text-muted mb-0">Pengaduan Masuk</p>
        </div>
    </div>
    <div class="col-md-3" data-aos="fade-up" data-aos-delay="400">
        <div class="glass-card h-100 text-center py-4">
            <i class="fas fa-hand-holding-heart fa-3x text-danger mb-3"></i>
            <h3 class="h2 fw-bold mb-1">7</h3>
            <p class="text-muted mb-0">Program Bantuan</p>
        </div>
    </div>
</div>

<!-- Potensi Desa & Informasi -->
<div class="row g-4">
    <!-- Potensi Desa -->
    <div class="col-md-6" data-aos="fade-right">
        <div class="glass-card h-100">
            <div class="d-flex align-items-center mb-4">
                <div class="bg-success text-white rounded-circle p-3 me-3">
                    <i class="fas fa-leaf fa-lg"></i>
                </div>
                <h4 class="fw-bold mb-0">Potensi Desa</h4>
            </div>
            
            <div class="accordion" id="accordionPotensi">
                <div class="accordion-item border-0 mb-3 shadow-sm rounded overflow-hidden">
                    <h2 class="accordion-header">
                        <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTani">
                            🌾 Pertanian & Perkebunan
                        </button>
                    </h2>
                    <div id="collapseTani" class="accordion-collapse collapse show" data-bs-parent="#accordionPotensi">
                        <div class="accordion-body bg-light">
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Padi</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Sawi & Bayam</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Kangkung</li>
                                <li><i class="fas fa-check text-success me-2"></i>Tebu</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="accordion-item border-0 shadow-sm rounded overflow-hidden">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTernak">
                            🐄 Peternakan
                        </button>
                    </h2>
                    <div id="collapseTernak" class="accordion-collapse collapse" data-bs-parent="#accordionPotensi">
                        <div class="accordion-body bg-light">
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Ayam & Itik</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Kambing & Domba</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Sapi Perah & Biasa</li>
                                <li><i class="fas fa-check text-success me-2"></i>Perikanan</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Informasi Desa -->
    <div class="col-md-6" data-aos="fade-left">
        <div class="glass-card h-100">
            <div class="d-flex align-items-center mb-4">
                <div class="bg-info text-white rounded-circle p-3 me-3">
                    <i class="fas fa-map-marked-alt fa-lg"></i>
                </div>
                <h4 class="fw-bold mb-0">Informasi Wilayah</h4>
            </div>

            <div class="p-3 bg-light rounded-3 mb-3">
                <p class="mb-0 text-muted small">
                    Desa Sidodadi terletak di dataran rendah dengan ketinggian ±4m dpl. 
                    Suhu rata-rata 22°C – 30°C, sangat mendukung aktivitas pertanian.
                </p>
            </div>

            <div class="row g-3">
                <div class="col-6">
                    <div class="border rounded p-3 text-center h-100 bg-white">
                        <h5 class="fw-bold text-primary mb-1">99.7 Ha</h5>
                        <small class="text-muted">Luas Wilayah</small>
                    </div>
                </div>
                <div class="col-6">
                    <div class="border rounded p-3 text-center h-100 bg-white">
                        <h5 class="fw-bold text-primary mb-1">2.839</h5>
                        <small class="text-muted">Jiwa Penduduk</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection