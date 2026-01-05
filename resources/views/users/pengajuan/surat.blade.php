@extends('layouts.app')

@section('content')
<div class="row mb-4" data-aos="fade-down">
    <div class="col-12">
        <div class="glass-card bg-primary text-white p-4 d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold mb-0">Riwayat Pengajuan Surat</h2>
                <p class="mb-0 opacity-75">Kelola dan pantau status pengajuan surat Anda.</p>
            </div>
            <a href="{{ route('surat-pengajuan.create') }}" class="btn btn-light text-primary fw-bold shadow-sm">
                <i class="fas fa-plus me-2"></i>Ajukan Baru
            </a>
        </div>
    </div>
</div>

<div class="glass-card" data-aos="fade-up">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Jenis Surat</th>
                    <th>Tanggal Pengajuan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pengajuans as $index => $pengajuan)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td class="fw-bold text-primary">{{ strtoupper(str_replace('_', ' ', $pengajuan->jenis_surat)) }}</td>
                    <td>{{ \Carbon\Carbon::parse($pengajuan->created_at)->format('d M Y, H:i') }}</td>
                    <td>
                        @if($pengajuan->status == 'pending')
                            <span class="badge bg-warning text-dark"><i class="fas fa-clock me-1"></i>Menunggu</span>
                        @elseif($pengajuan->status == 'disetujui' || $pengajuan->status == 'approved')
                            <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Disetujui</span>
                        @else
                            <span class="badge bg-danger"><i class="fas fa-times-circle me-1"></i>Ditolak</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('surat-pengajuan.detail', $pengajuan->id) }}" class="btn btn-sm btn-info text-white me-1">
                            <i class="fas fa-eye"></i> Detail
                        </a>
                        
                        @if(in_array($pengajuan->status, ['disetujui', 'approved']))
                            <a href="{{ route('surat-pengajuan.download', $pengajuan->id) }}" class="btn btn-sm btn-success">
                                <i class="fas fa-download"></i> Unduh
                            </a>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5 text-muted">
                        <img src="https://cdn-icons-png.flaticon.com/512/7486/7486754.png" alt="Empty" style="width: 64px; opacity: 0.5;" class="mb-3">
                        <p>Belum ada riwayat pengajuan surat.</p>
                        <a href="{{ route('surat-pengajuan.create') }}" class="btn btn-sm btn-outline-primary">Ajukan Sekarang</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection