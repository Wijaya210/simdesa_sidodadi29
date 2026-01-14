@extends('layouts.app')

@section('content')
    <div class="row mb-4" data-aos="fade-down">
        <div class="col-12">
            <div class="glass-card bg-primary text-white p-4 d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold mb-0">📄 Manajemen Surat</h2>
                    <p class="mb-0 opacity-75">Kelola pengajuan surat dari warga.</p>
                </div>
                <a href="{{ route('admins.dashboard') }}" class="btn btn-light text-primary fw-bold shadow-sm">
                    <i class="fas fa-arrow-left me-2"></i>Dashboard
                </a>
            </div>
        </div>
    </div>

    <div class="glass-card" data-aos="fade-up">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="bg-light">
                    <tr>
                        <th>No</th>
                        <th>Pemohon</th>
                        <th>Jenis Surat</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($surats as $index => $s)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-light rounded-circle p-2 me-2 text-primary">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <span class="{{ $s->is_read ? '' : 'fw-bold' }}">{{ $s->user->name }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light text-primary border border-primary">
                                    {{ strtoupper(str_replace('_', ' ', $s->jenis_surat)) }}
                                </span>
                            </td>
                            <td class="{{ $s->is_read ? '' : 'fw-bold' }}">{{ $s->created_at->format('d M Y') }}</td>
                            <td>
                                @if($s->status == 'pending' || $s->status == 'menunggu')
                                    <span class="badge bg-warning text-dark"><i class="fas fa-clock me-1"></i>Menunggu</span>
                                @elseif($s->status == 'disetujui')
                                    <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Disetujui</span>
                                @else
                                    <span class="badge bg-danger"><i class="fas fa-times-circle me-1"></i>Ditolak</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.surat.show', $s->id) }}" class="btn btn-sm btn-info text-white"
                                        title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form action="{{ route('admin.surat.delete', $s->id) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Hapus surat ini?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <img src="https://cdn-icons-png.flaticon.com/512/7486/7486754.png" alt="Empty"
                                    style="width: 64px; opacity: 0.5;" class="mb-3">
                                <p>Belum ada pengajuan surat.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection