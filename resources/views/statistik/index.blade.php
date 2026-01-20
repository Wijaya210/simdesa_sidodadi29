@extends('layouts.app')

@section('content')
    <div class="container-fluid" data-aos="fade-up">
        @if(isset($error))
            <div class="text-center py-5">
                <div class="glass-card p-5 d-inline-block">
                    <h2 class="text-muted mb-0">⚠️ {{ $error }}</h2>
                    <p class="mt-2">Silakan kembali lagi nanti setelah data diisi oleh Admin.</p>
                </div>
            </div>
        @else
                <div class="row mb-5 text-center">
                    <div class="col-12">
                        <h1 class="fw-bold text-primary">📊 Statistik Desa {{ $desa->nama_desa }}</h1>
                        <p class="lead text-muted">Transparansi data kependudukan berdasarkan kategori.</p>
                        <div class="d-flex justify-content-center gap-3 mt-3">
                            <div class="badge bg-light text-dark shadow-sm p-3">
                                <h5 class="mb-0 fw-bold">{{ $dynamicStats['total_penduduk'] }}</h5>
                                <small>Total Penduduk</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-4">
                    <!-- Grafik Gender -->
                    <div class="col-md-4">
                        <div class="glass-card p-4 text-center h-100 shadow-lg">
                            <h5 class="fw-bold mb-4">👫 Perbandingan Gender</h5>
                            <canvas id="genderChart"></canvas>
                        </div>
                    </div>

                    <!-- Grafik Agama -->
                    <div class="col-md-4">
                        <div class="glass-card p-4 text-center h-100 shadow-lg">
                            <h5 class="fw-bold mb-4">☪️ Distribusi Agama</h5>
                            <canvas id="agamaChart"></canvas>
                        </div>
                    </div>

                    <!-- Grafik Pekerjaan -->
                    <div class="col-md-4">
                        <div class="glass-card p-4 text-center h-100 shadow-lg">
                            <h5 class="fw-bold mb-4">💼 Kategori Pekerjaan</h5>
                            <canvas id="pekerjaanChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Load Chart.js from CDN -->
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

            <script>
                // Data Gender
                const ctxGender = document.getElementById('genderChart');
                new Chart(ctxGender, {
                    type: 'doughnut',
                    data: {
                        labels: ['Laki-laki', 'Perempuan'],
                        datasets: [{
                            data: [{{ $dynamicStats['laki_laki'] }}, {{ $dynamicStats['perempuan'] }}],
                            backgroundColor: ['#4e73df', '#f6c23e'],
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { position: 'bottom' }
                        }
                    }
                });

                // Data Agama
                const ctxAgama = document.getElementById('agamaChart');
                new Chart(ctxAgama, {
                    type: 'pie',
                    data: {
                        labels: {!! json_encode($desa->agama->pluck('agama')) !!},
                        datasets: [{
                            data: {!! json_encode($desa->agama->pluck('jumlah')) !!},
                            backgroundColor: ['#1cc88a', '#36b9cc', '#f68d2e', '#e74a3b', '#858796', '#5a5c69'],
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { position: 'bottom' }
                        }
                    }
                });

                // Data Pekerjaan
                const ctxPekerjaan = document.getElementById('pekerjaanChart');
                new Chart(ctxPekerjaan, {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($desa->pekerjaan->pluck('pekerjaan')) !!},
                        datasets: [{
                            label: 'Jumlah Pekerja',
                            data: {!! json_encode($desa->pekerjaan->pluck('jumlah')) !!},
                            backgroundColor: '#4e73df',
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: { beginAtZero: true }
                        },
                        plugins: {
                            legend: { display: false }
                        }
                    }
                });
            </script>
        @endif

    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            border: 1px solid rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .glass-card:hover {
            transform: translateY(-5px);
        }
    </style>
@endsection