@extends('layouts.app')

@section('content')
    <div class="row mb-4" data-aos="fade-down">
        <div class="col-12">
            <div class="glass-card bg-primary text-white p-4 d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold mb-0">👥 Data Warga</h2>
                    <p class="mb-0 opacity-75">Kelola data kependudukan desa.</p>
                </div>
                <div>
                    <a href="{{ route('admins.dashboard') }}" class="btn btn-light text-primary fw-bold shadow-sm me-2">
                        <i class="fas fa-arrow-left me-2"></i>Dashboard
                    </a>
                    <a href="{{ route('admin.biodata-warga.create') }}" class="btn btn-success fw-bold shadow-sm">
                        <i class="fas fa-user-plus me-2"></i>Tambah Warga
                    </a>
                </div>
    </div>

    <div class="row mb-4" data-aos="fade-up">
        <div class="col-12">
            <div class="glass-card p-3 shadow-sm border-0" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border-radius: 15px;">
                <form action="{{ route('admin.biodata-warga.index') }}" method="GET" class="row g-2 align-items-center">
                    <div class="col-md-10">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0" style="border-radius: 10px 0 0 10px;">
                                <i class="fas fa-search text-primary"></i>
                            </span>
                            <input type="text" name="search" class="form-control border-start-0 ps-0" 
                                style="border-radius: 0 10px 10px 0;"
                                placeholder="Cari Nama Lengkap atau NIK warga..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary fw-bold" style="border-radius: 10px;">
                                <i class="fas fa-search me-2"></i>Cari
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="glass-card p-4" data-aos="fade-up">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="bg-light">
                    <tr>
                        <th class="py-3">No</th>
                        <th class="py-3">Nama Lengkap</th>
                        <th class="py-3">NIK / No KK</th>
                        <th class="py-3">Alamat</th>
                        <th class="py-3">Pekerjaan</th>
                        <th class="py-3 text-center">Status</th>
                        <th class="py-3 text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($wargas as $index => $warga)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <div class="fw-bold text-primary">{{ $warga->name }}</div>
                                <small class="text-muted">{{ $warga->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }} |
                                    {{ \Carbon\Carbon::parse($warga->tanggal_lahir)->format('d M Y') }}</small>
                            </td>
                            <td>
                                <div><span class="badge bg-light text-dark border">NIK: {{ $warga->nik ?? '-' }}</span></div>
                                <div class="mt-1"><span class="badge bg-light text-dark border">KK:
                                        {{ $warga->no_kk ?? '-' }}</span></div>
                            </td>
                            <td>
                                <div>{{ $warga->alamat }}</div>
                                <small class="text-muted">RT/RW: {{ $warga->rt_rw ?? '-' }}</small>
                            </td>
                            <td>{{ $warga->pekerjaan ?? '-' }}</td>
                            <td class="text-center">
                                @if($warga->jenis_kependudukan == 'tetap')
                                    <span class="badge bg-success">Warga Tetap</span>
                                @elseif($warga->jenis_kependudukan == 'pindah')
                                    <span class="badge bg-warning text-dark">Pindah</span>
                                @else
                                    <span class="badge bg-info">Pendatang</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.biodata-warga.edit', $warga->id) }}"
                                    class="btn btn-warning btn-sm shadow-sm me-1">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.biodata-warga.destroy', $warga->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm shadow-sm"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data warga ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="fas fa-users-slash fa-3x mb-3 opacity-50"></i>
                                <p>Belum ada data warga.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection