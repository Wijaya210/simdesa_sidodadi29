@extends('layouts.app')

@section('content')
    <div class="row justify-content-center" data-aos="fade-up">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                <div class="card-body p-0">
                    <div class="bg-primary p-4 d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="text-white mb-1"><i class="fas fa-user-circle me-2"></i>Profil Saya</h4>
                            <p class="text-white-50 mb-0">Informasi akun dan pengaturan keamanan.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-5">
                    <!-- Profile Info Card -->
                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-body p-4 text-center">
                            <div class="mb-3">
                                <i class="fas fa-user-circle fa-5x text-primary opacity-25"></i>
                            </div>
                            <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
                            <p class="text-muted small mb-3">{{ $user->email }}</p>

                            <div class="d-flex justify-content-center">
                                @if($user->is_registered)
                                    <span
                                        class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill">
                                        <i class="fas fa-check-circle me-1"></i> Akun Aktif
                                    </span>
                                @else
                                    <span
                                        class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-2 rounded-pill">
                                        <i class="fas fa-exclamation-circle me-1"></i> Belum Aktif
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="card-footer bg-light border-0 p-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted small">NIK</span>
                                <span class="fw-bold small">{{ $user->nik }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted small">Jenis Kelamin</span>
                                <span
                                    class="fw-bold small">{{ $user->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-0">
                                <span class="text-muted small">Tanggal Lahir</span>
                                <span
                                    class="fw-bold small">{{ $user->tanggal_lahir ? date('d M Y', strtotime($user->tanggal_lahir)) : '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-7">
                    <!-- Change Password Card -->
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4 text-primary"><i class="fas fa-key me-2"></i>Ubah Password</h5>

                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
                                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            @if($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4" role="alert">
                                    <ul class="mb-0 ps-3">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            <form action="{{ route('users.profile.password') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label fw-bold small text-muted text-uppercase">Password Saat
                                        Ini</label>
                                    <input type="password" name="current_password" class="form-control" required>
                                </div>

                                <hr class="my-4 opacity-25">

                                <div class="mb-3">
                                    <label class="form-label fw-bold small text-muted text-uppercase">Password Baru</label>
                                    <input type="password" name="password" class="form-control"
                                        placeholder="Minimal 8 karakter" required>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-bold small text-muted text-uppercase">Konfirmasi Password
                                        Baru</label>
                                    <input type="password" name="password_confirmation" class="form-control" required>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary py-2 rounded-3 fw-bold">
                                        <i class="fas fa-save me-1"></i> Simpan Password Baru
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection