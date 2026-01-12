@extends('layouts.app')

@section('content')
    <div class="row" data-aos="fade-up">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                <div class="card-body p-0">
                    <div class="bg-primary p-4 d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="text-white mb-1"><i class="fas fa-wallet me-2"></i>Keuangan Desa</h4>
                            <p class="text-white-50 mb-0">Kelola pemasukan dan pengeluaran desa.</p>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admins.dashboard') }}" class="btn btn-light btn-sm rounded-3">
                                <i class="fas fa-arrow-left me-1"></i> Dashboard
                            </a>
                            <a href="{{ route('admin.keuangan.create') }}" class="btn btn-success btn-sm rounded-3">
                                <i class="fas fa-plus-circle me-1"></i> Tambah Transaksi
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row mb-4" data-aos="fade-up" data-aos-delay="100">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 text-white bg-primary mb-3">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-0 opacity-75">Total Pemasukan</p>
                            <h3 class="mb-0 fw-bold">Rp {{ number_format($totalMasuk, 0, ',', '.') }}</h3>
                        </div>
                        <i class="fas fa-arrow-down fa-2x opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 text-white bg-danger mb-3">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-0 opacity-75">Total Pengeluaran</p>
                            <h3 class="mb-0 fw-bold">Rp {{ number_format($totalKeluar, 0, ',', '.') }}</h3>
                        </div>
                        <i class="fas fa-arrow-up fa-2x opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 text-white bg-success mb-3">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-0 opacity-75">Saldo Saat Ini</p>
                            <h3 class="mb-0 fw-bold">Rp {{ number_format($saldo, 0, ',', '.') }}</h3>
                        </div>
                        <i class="fas fa-coins fa-2x opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row" data-aos="fade-up" data-aos-delay="200">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
                            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="bg-light text-muted">
                                <tr>
                                    <th class="border-0 px-4 py-3">No</th>
                                    <th class="border-0 px-4 py-3">Tanggal</th>
                                    <th class="border-0 px-4 py-3">Keterangan</th>
                                    <th class="border-0 px-4 py-3">Sumber</th>
                                    <th class="border-0 px-4 py-3">Jenis</th>
                                    <th class="border-0 px-4 py-3 text-end">Jumlah</th>
                                    <th class="border-0 px-4 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transactions as $index => $item)
                                    <tr>
                                        <td class="px-4 py-3 text-muted">{{ $index + 1 }}</td>
                                        <td class="px-4 py-3 fw-medium text-dark">{{ date('d M Y', strtotime($item->tanggal)) }}
                                        </td>
                                        <td class="px-4 py-3 text-dark">{{ $item->keterangan }}</td>
                                        <td class="px-4 py-3 text-muted small">{{ $item->sumber ?? '-' }}</td>
                                        <td class="px-4 py-3">
                                            @if($item->jenis == 'masuk')
                                                <span
                                                    class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill">
                                                    <i class="fas fa-plus-circle me-1"></i> Masuk
                                                </span>
                                            @else
                                                <span
                                                    class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2 rounded-pill">
                                                    <i class="fas fa-minus-circle me-1"></i> Keluar
                                                </span>
                                            @endif
                                        </td>
                                        <td
                                            class="px-4 py-3 text-end fw-bold {{ $item->jenis == 'masuk' ? 'text-success' : 'text-danger' }}">
                                            Rp {{ number_format($item->jumlah, 0, ',', '.') }}
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="{{ route('admin.keuangan.edit', $item->id) }}"
                                                    class="btn btn-outline-warning btn-sm rounded-3">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.keuangan.destroy', $item->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-3"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5 text-muted">
                                            <i class="fas fa-info-circle fa-2x mb-3 d-block opacity-25"></i>
                                            Belum ada data transaksi.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection