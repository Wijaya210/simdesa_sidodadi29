@extends('layouts.app')

@section('content')
<div class="row mb-4" data-aos="fade-down">
    <div class="col-12">
        <div class="glass-card bg-primary text-white p-4 d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold mb-0">📢 Layanan Pengaduan</h2>
                <p class="mb-0 opacity-75">Sampaikan aspirasi dan keluhan Anda untuk kemajuan desa.</p>
            </div>
            <a href="{{ route('users.dashboard') }}" class="btn btn-light text-primary fw-bold shadow-sm">
                <i class="fas fa-arrow-left me-2"></i>Dashboard
            </a>
        </div>
    </div>
</div>

<div class="row g-4">
    {{-- Form Pengaduan --}}
    <div class="col-lg-4" data-aos="fade-right">
        <div class="glass-card h-100">
            <h4 class="fw-bold text-primary mb-4"><i class="fas fa-edit me-2"></i>Buat Pengaduan</h4>
            
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-bold">Judul Laporan</label>
                    <input type="text" name="judul" class="form-control" required placeholder="Contoh: Jalan Rusak di RT 01">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Isi Laporan</label>
                    <textarea name="isi" class="form-control" rows="5" required placeholder="Jelaskan detail pengaduan Anda..."></textarea>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-bold">Bukti Foto (Opsional)</label>
                    <input type="file" name="foto" class="form-control" accept="image/*">
                </div>
                <button type="submit" class="btn btn-primary w-100 py-2 fw-bold shadow-sm">
                    <i class="fas fa-paper-plane me-2"></i> Kirim Laporan
                </button>
            </form>
        </div>
    </div>

    {{-- Riwayat Pengaduan --}}
    <div class="col-lg-8" data-aos="fade-left">
        <div class="glass-card h-100">
            <h4 class="fw-bold text-primary mb-4"><i class="fas fa-history me-2"></i>Riwayat Pengaduan Saya</h4>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th>No</th>
                            <th>Judul & Foto</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Tanggapan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pengaduans as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $item->judul }}</div>
                                @if($item->foto)
                                    <a href="{{ asset('storage/' . $item->foto) }}" target="_blank" class="btn btn-xs btn-outline-info mt-1" style="font-size: 0.75rem; padding: 2px 8px;">
                                        <i class="fas fa-image me-1"></i>Lihat Foto
                                    </a>
                                @endif
                            </td>
                            <td>{{ $item->created_at->format('d M Y') }}</td>
                            <td>
                                @if ($item->status == 'pending')
                                    <span class="badge bg-warning text-dark">Menunggu</span>
                                @elseif ($item->status == 'diproses')
                                    <span class="badge bg-info">Diproses</span>
                                @elseif ($item->status == 'selesai')
                                    <span class="badge bg-success">Selesai</span>
                                @elseif ($item->status == 'ditolak')
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </td>
                            <td>
                                @if($item->tanggapan)
                                    <div class="bg-light p-2 rounded small border-start border-4 border-success">
                                        {{ $item->tanggapan }}
                                    </div>
                                @else
                                    <span class="text-muted small fst-italic">Belum ada tanggapan</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <img src="https://cdn-icons-png.flaticon.com/512/7486/7486754.png" alt="Empty" style="width: 64px; opacity: 0.5;" class="mb-3">
                                <p>Belum ada pengaduan yang Anda kirim.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
