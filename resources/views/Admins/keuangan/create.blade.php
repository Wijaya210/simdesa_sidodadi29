@extends('layouts.app')

@section('content')
    <div class="row justify-content-center" data-aos="fade-up">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                <div class="card-body p-0">
                    <div class="bg-primary p-4 d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="text-white mb-1"><i class="fas fa-plus-circle me-2"></i>Tambah Transaksi</h4>
                            <p class="text-white-50 mb-0">Masukkan data pemasukan atau pengeluaran baru.</p>
                        </div>
                        <a href="{{ route('admin.keuangan.index') }}" class="btn btn-light btn-sm rounded-3">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <form action="{{ route('admin.keuangan.store') }}" method="POST">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Tanggal</label>
                                <input type="date" name="tanggal"
                                    class="form-control bg-light @error('tanggal') is-invalid @enderror"
                                    value="{{ old('tanggal', date('Y-m-d')) }}" required readonly tabindex="-1"
                                    onclick="return false;">
                                @error('tanggal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Jenis Transaksi</label>
                                <select name="jenis" class="form-select @error('jenis') is-invalid @enderror" required>
                                    <option value="masuk" {{ old('jenis') == 'masuk' ? 'selected' : '' }}>Pemasukan (Masuk)
                                    </option>
                                    <option value="keluar" {{ old('jenis') == 'keluar' ? 'selected' : '' }}>Pengeluaran
                                        (Keluar)</option>
                                </select>
                                @error('jenis')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Keterangan</label>
                            <input type="text" name="keterangan"
                                class="form-control @error('keterangan') is-invalid @enderror"
                                value="{{ old('keterangan') }}"
                                placeholder="Contoh: Pembelian alat kantor, Bantuan Dana Desa" required>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Jumlah (Rp)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">Rp</span>
                                    <input type="number" name="jumlah"
                                        class="form-control @error('jumlah') is-invalid @enderror"
                                        value="{{ old('jumlah') }}" required>
                                </div>
                                @error('jumlah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Sumber / Kategori</label>
                                <input type="text" name="sumber" class="form-control @error('sumber') is-invalid @enderror"
                                    value="{{ old('sumber') }}" placeholder="Contoh: PAD, Dana Desa, Banprov">
                                @error('sumber')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4 opacity-50">

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary py-2 rounded-3 fw-bold">
                                <i class="fas fa-save me-1"></i> Simpan Transaksi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection