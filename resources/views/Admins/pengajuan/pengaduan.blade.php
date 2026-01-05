@extends('layouts.app')

@section('content')
<div class="row mb-4" data-aos="fade-down">
    <div class="col-12">
        <div class="glass-card bg-primary text-white p-4 d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold mb-0">📢 Manajemen Pengaduan</h2>
                <p class="mb-0 opacity-75">Tanggapi laporan dan aspirasi warga.</p>
            </div>
            <a href="{{ route('admins.dashboard') }}" class="btn btn-light text-primary fw-bold shadow-sm">
                <i class="fas fa-arrow-left me-2"></i>Dashboard
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
            <thead class="bg-light">
                <tr>
                    <th>No</th>
                    <th>Pelapor</th>
                    <th>Judul & Foto</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Tanggapan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pengaduans as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <div class="fw-bold">{{ $item->user->name }}</div>
                        <small class="text-muted">{{ $item->user->nik ?? '-' }}</small>
                    </td>
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
                        <div style="max-width: 200px;">
                            @if($item->tanggapan)
                                <span class="text-success small"><i class="fas fa-check me-1"></i>{{ Str::limit($item->tanggapan, 50) }}</span>
                            @else
                                <span class="text-muted small fst-italic">Belum ditanggapi</span>
                            @endif
                        </div>
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#responseModal{{ $item->id }}">
                            <i class="fas fa-reply me-1"></i>Tanggapi
                        </button>
                    </td>
                </tr>

                <!-- Modal Tanggapan -->
                <div class="modal fade" id="responseModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content border-0 shadow-lg rounded-4">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title fw-bold">Tanggapi Pengaduan</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <form action="{{ route('admin.pengaduan.update', $item->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body bg-light">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Isi Pengaduan:</label>
                                        <div class="p-3 bg-white rounded border">{{ $item->isi }}</div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Update Status</label>
                                        <select name="status" class="form-select">
                                            <option value="pending" {{ $item->status == 'pending' ? 'selected' : '' }}>Menunggu</option>
                                            <option value="diproses" {{ $item->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                            <option value="selesai" {{ $item->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                            <option value="ditolak" {{ $item->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Berikan Tanggapan</label>
                                        <textarea name="tanggapan" class="form-control" rows="4" placeholder="Tulis tanggapan Anda di sini...">{{ $item->tanggapan }}</textarea>
                                    </div>
                                </div>
                                <div class="modal-footer border-0">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary fw-bold">Simpan Tanggapan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <img src="https://cdn-icons-png.flaticon.com/512/7486/7486754.png" alt="Empty" style="width: 64px; opacity: 0.5;" class="mb-3">
                        <p>Belum ada pengaduan masuk.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
