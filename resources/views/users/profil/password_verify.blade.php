@extends('layouts.app')

@section('content')
    <div class="row justify-content-center" data-aos="fade-up">
        <div class="col-md-5">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-4">
                        <div class="bg-primary-subtle text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 80px; height: 80px;">
                            <i class="fas fa-envelope-open-text fa-2x"></i>
                        </div>
                        <h4 class="fw-bold">Verifikasi OTP</h4>
                        <p class="text-muted">Masukkan 6 digit kode yang dikirim ke email Anda untuk mengonfirmasi perubahan
                            password.</p>
                    </div>

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

                    <form action="{{ route('users.profile.password.verify.process') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted text-uppercase text-center d-block">Kode
                                OTP</label>
                            <input type="text" name="otp"
                                class="form-control form-control-lg text-center fw-bold letter-spacing-5" maxlength="6"
                                placeholder="000000" required autofocus>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary py-2 rounded-3 fw-bold">
                                <i class="fas fa-check-circle me-1"></i> Verifikasi & Ubah Password
                            </button>
                            <a href="{{ route('users.profile') }}" class="btn btn-light py-2 rounded-3 text-muted">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
                <div class="card-footer bg-light border-0 p-4 text-center">
                    <p class="small text-muted mb-0">Tidak menerima kode? <br>
                        <span class="text-primary fw-bold" style="cursor: pointer;" onclick="location.reload()">Kirim
                            Ulang</span> (Muat ulang halaman)
                    </p>
                </div>
            </div>
        </div>
    </div>

    <style>
        .letter-spacing-5 {
            letter-spacing: 10px;
            font-size: 2rem;
        }
    </style>
@endsection