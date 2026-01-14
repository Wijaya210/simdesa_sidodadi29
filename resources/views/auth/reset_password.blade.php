@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="card-header bg-primary text-white text-center py-4">
                        <h4 class="mb-0">Reset Password</h4>
                        <p class="small mb-0">Masukkan kode OTP dan password baru Anda</p>
                    </div>
                    <div class="card-body p-5">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('password.update') }}" method="POST">
                            @csrf
                            <div class="mb-4 text-center">
                                <label for="otp" class="form-label fw-bold">Kode OTP</label>
                                <input type="text" name="otp" id="otp"
                                    class="form-control form-control-lg text-center letter-spacing-5 @error('otp') is-invalid @enderror"
                                    placeholder="123456" maxlength="6" required autofocus>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label fw-bold">Password Baru</label>
                                <input type="password" name="password" id="password" class="form-control form-control-lg"
                                    minlength="8" required>
                            </div>

                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label fw-bold">Konfirmasi Password
                                    Baru</label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="form-control form-control-lg" minlength="8" required>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">Reset Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .letter-spacing-5 {
            letter-spacing: 1rem;
            font-size: 2rem;
            font-weight: bold;
        }

        .letter-spacing-5::placeholder {
            letter-spacing: 0;
            font-size: 1rem;
            font-weight: normal;
        }
    </style>
@endsection