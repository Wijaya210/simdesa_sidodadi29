@extends('layouts.app')

@section('content')
    <div class="container-fluid" data-aos="fade-up">
        <div class="row mb-4">
            <div class="col-12">
                <div class="glass-card p-4 bg-primary text-white d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="fw-bold mb-0">📊 Kelola Statistik Desa</h3>
                        <p class="mb-0 text-white-50">Update data kependudukan secara manual untuk ditampilkan di grafik
                            publik.
                        </p>
                    </div>
                    <a href="{{ route('admins.dashboard') }}" class="btn btn-light btn-sm fw-bold">
                        <i class="fas fa-arrow-left me-2"></i>Dashboard
                    </a>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.statistik.update') }}" method="POST">
            @csrf
            <div class="row g-4">
                <!-- Statistik Umum -->
                <div class="col-md-6">
                    <div class="glass-card p-4 h-100">
                        <h5 class="fw-bold text-primary mb-3 border-bottom pb-2">📍 Info Umum & Gender</h5>
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold">Total Penduduk</label>
                                <input type="number" name="jumlah_penduduk" class="form-control"
                                    value="{{ $statistik->jumlah_penduduk }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Laki-laki</label>
                                <input type="number" name="jumlah_laki_laki" class="form-control"
                                    value="{{ $statistik->jumlah_laki_laki }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Perempuan</label>
                                <input type="number" name="jumlah_perempuan" class="form-control"
                                    value="{{ $statistik->jumlah_perempuan }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Jumlah Keluarga</label>
                                <input type="number" name="jumlah_keluarga" class="form-control"
                                    value="{{ $statistik->jumlah_keluarga }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Luas Wilayah (km²)</label>
                                <input type="number" step="0.01" name="luas_wilayah" class="form-control"
                                    value="{{ $statistik->luas_wilayah }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statistik Agama -->
                <div class="col-md-6">
                    <div class="glass-card p-4 h-100">
                        <h5 class="fw-bold text-warning mb-3 border-bottom pb-2">☪️ Data Agama</h5>
                        <div class="row g-3">
                            @foreach($agamas as $agama)
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">{{ $agama->agama }}</label>
                                    <input type="number" name="agama[{{ $agama->id }}]" class="form-control"
                                        value="{{ $agama->jumlah }}">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Statistik Pekerjaan -->
                <div class="col-12">
                    <div class="glass-card p-4">
                        <h5 class="fw-bold text-success mb-3 border-bottom pb-2">💼 Data Pekerjaan</h5>
                        <div class="row g-3">
                            @foreach($pekerjaans as $p)
                                <div class="col-md-3">
                                    <div class="input-group">
                                        <span class="input-group-text bg-light fw-bold">{{ $p->pekerjaan }}</span>
                                        <input type="number" name="pekerjaan[{{ $p->id }}]" class="form-control"
                                            value="{{ $p->jumlah }}">
                                        <button type="button" class="btn btn-outline-danger"
                                            onclick="confirmDelete({{ $p->id }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <hr class="my-4">
                        <h6 class="fw-bold">Tambah Kategori Pekerjaan Baru</h6>
                        <div class="row g-3 align-items-end">
                            <div class="col-md-5">
                                <label class="form-label">Nama Pekerjaan (misal: Petani)</label>
                                <input type="text" name="new_pekerjaan_name" class="form-control"
                                    placeholder="Contoh: Buruh">
                            </div>
                            <div class="col-md-5">
                                <label class="form-label">Jumlah</label>
                                <input type="number" name="new_pekerjaan_value" class="form-control" placeholder="0">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">Simpan Semua</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4 text-end">
                <button type="submit" class="btn btn-warning btn-lg px-5 fw-bold shadow">
                    <i class="fas fa-save me-2"></i>SIMPAN PERUBAHAN DATA
                </button>
            </div>
        </form>
    </div>

    <form id="delete-pekerjaan-form" method="POST" style="display:none;">
        @csrf
        @method('DELETE')
    </form>

    <script>
        function confirmDelete(id) {
            if (confirm('Hapus kategori pekerjaan ini?')) {
                let form = document.getElementById('delete-pekerjaan-form');
                form.action = '/admin/statistik/pekerjaan/' + id;
                form.submit();
            }
        }
    </script>
@endsection