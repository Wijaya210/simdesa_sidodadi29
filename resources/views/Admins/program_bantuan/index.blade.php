@extends('layouts.app')

@section('content')
    <div class="row mb-4" data-aos="fade-down">
        <div class="col-12">
            <div class="glass-card bg-primary text-white p-4 d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold mb-0">🎁 Kelola Program Bantuan</h2>
                    <p class="mb-0 opacity-75">Tambah dan kelola program bantuan untuk warga.</p>
                </div>
                <div>
                    <a href="{{ route('admins.dashboard') }}" class="btn btn-light text-primary fw-bold shadow-sm me-2">
                        <i class="fas fa-arrow-left me-2"></i>Dashboard
                    </a>
                    <button class="btn btn-success fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#addModal">
                        <i class="fas fa-plus me-2"></i>Tambah Program
                    </button>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">
        @forelse($programs as $program)
            <div class="col-md-4" data-aos="fade-up">
                <div class="glass-card h-100 p-0 overflow-hidden d-flex flex-column">
                    <div class="position-relative">
                        @if($program->gambar)
                            <img src="{{ asset('images/program_bantuan/' . $program->gambar) }}" class="w-100"
                                alt="{{ $program->nama_program }}" style="height: 200px; object-fit: cover;">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                <i class="fas fa-hand-holding-heart fa-4x text-muted opacity-50"></i>
                            </div>
                        @endif
                        <div class="position-absolute top-0 end-0 m-2">
                            <div class="dropdown">
                                <button class="btn btn-light btn-sm rounded-circle shadow-sm" type="button"
                                    data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end border-0 shadow">
                                    <li>
                                        <button class="dropdown-item" data-bs-toggle="modal"
                                            data-bs-target="#editModal{{ $program->id }}">
                                            <i class="fas fa-edit text-warning me-2"></i>Edit
                                        </button>
                                    </li>
                                    <li>
                                        <form action="{{ route('admin.program-bantuan.destroy', $program->id) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button class="dropdown-item text-danger"
                                                onclick="return confirm('Hapus program ini?')">
                                                <i class="fas fa-trash me-2"></i>Hapus
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 flex-grow-1">
                        <h5 class="fw-bold text-primary mb-2">{{ $program->nama_program }}</h5>
                        <p class="text-muted small mb-0">{{ Str::limit($program->deskripsi, 100) }}</p>
                    </div>
                </div>
            </div>

            <!-- Edit Modal -->
            <div class="modal fade" id="editModal{{ $program->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content border-0 shadow-lg rounded-4">
                        <div class="modal-header bg-warning text-dark">
                            <h5 class="modal-title fw-bold">Edit Program</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form action="{{ route('admin.program-bantuan.update', $program->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf @method('PUT')
                            <div class="modal-body bg-light">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Nama Program</label>
                                    <input type="text" name="nama_program" class="form-control"
                                        value="{{ $program->nama_program }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Deskripsi</label>
                                    <textarea name="deskripsi" class="form-control" rows="4"
                                        required>{{ $program->deskripsi }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Ganti Gambar (Opsional)</label>
                                    <input type="file" name="gambar" class="form-control" accept="image/*">
                                </div>
                            </div>
                            <div class="modal-footer border-0">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-warning fw-bold">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="glass-card py-5">
                    <h4 class="text-muted fw-bold">Belum ada program bantuan.</h4>
                    <p class="text-muted">Klik tombol "Tambah Program" untuk membuat baru.</p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title fw-bold">Tambah Program Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.program-bantuan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body bg-light">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Program</label>
                            <input type="text" name="nama_program" class="form-control" required
                                placeholder="Contoh: BLT Dana Desa">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" rows="4" required
                                placeholder="Jelaskan detail program..."></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Gambar (Opsional)</label>
                            <input type="file" name="gambar" class="form-control" accept="image/*">
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success fw-bold">Simpan Program</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection