@extends('layouts.app')

@section('content')
<div class="row mb-4" data-aos="fade-down">
    <div class="col-12">
        <div class="glass-card bg-primary text-white p-4 d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold mb-0">🎁 Program Bantuan Desa</h2>
                <p class="mb-0 opacity-75">Informasi transparan mengenai bantuan sosial untuk warga.</p>
            </div>
            <a href="{{ route('users.dashboard') }}" class="btn btn-light text-primary fw-bold shadow-sm">
                <i class="fas fa-arrow-left me-2"></i>Dashboard
            </a>
        </div>
    </div>
</div>

<div class="row g-4">
    @forelse($programs as $index => $program)
    <div class="col-md-4" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
        <div class="glass-card h-100 p-0 overflow-hidden d-flex flex-column">
            <div class="position-relative">
                @if($program->gambar)
                    <img src="{{ asset('storage/' . $program->gambar) }}" class="w-100" alt="{{ $program->nama_program }}" style="height: 220px; object-fit: cover;">
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center" style="height: 220px;">
                        <i class="fas fa-hand-holding-heart fa-4x text-muted opacity-50"></i>
                    </div>
                @endif
                <div class="position-absolute top-0 end-0 m-3">
                    <span class="badge bg-white text-primary shadow-sm px-3 py-2 rounded-pill fw-bold">Aktif</span>
                </div>
            </div>
            
            <div class="p-4 flex-grow-1 d-flex flex-column">
                <h4 class="fw-bold text-primary mb-3">{{ $program->nama_program }}</h4>
                <p class="text-muted mb-4 flex-grow-1">{{ Str::limit($program->deskripsi, 120) }}</p>
                
                <button type="button" class="btn btn-outline-primary w-100 fw-bold rounded-pill" data-bs-toggle="modal" data-bs-target="#detailModal{{ $program->id }}">
                    Lihat Detail Program
                </button>
            </div>
        </div>
    </div>

    <!-- Detail Modal -->
    <div class="modal fade" id="detailModal{{ $program->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="modal-header bg-primary text-white border-0 p-4">
                    <h5 class="modal-title fw-bold"><i class="fas fa-info-circle me-2"></i>Detail Program</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    @if($program->gambar)
                        <img src="{{ asset('storage/' . $program->gambar) }}" class="w-100" alt="{{ $program->nama_program }}" style="max-height: 350px; object-fit: cover;">
                    @endif
                    <div class="p-4">
                        <h3 class="fw-bold text-primary mb-3">{{ $program->nama_program }}</h3>
                        <div class="bg-light p-3 rounded-3 text-muted" style="line-height: 1.8;">
                            {!! nl2br(e($program->deskripsi)) !!}
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 bg-light">
                    <button type="button" class="btn btn-secondary px-4 rounded-pill fw-bold" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5" data-aos="zoom-in">
        <div class="glass-card py-5">
            <div class="mb-4">
                <i class="fas fa-box-open fa-4x text-muted opacity-50 floating-icon"></i>
            </div>
            <h4 class="text-muted fw-bold">Belum ada program bantuan saat ini.</h4>
            <p class="text-muted">Silakan cek kembali di lain waktu.</p>
        </div>
    </div>
    @endforelse
</div>
@endsection
