@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="card-header bg-primary text-white text-center py-4">
                        <h4 class="mb-0">Lupa Password</h4>
                        <p class="small mb-0">Masukkan Email untuk menerima kode OTP</p>
                    </div>
                    <div class="card-body p-5">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('password.email') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="identifier" class="form-label fw-bold">Email</label>
                                <input type="text" name="identifier" id="identifier"
                                    class="form-control form-control-lg @error('identifier') is-invalid @enderror"
                                    placeholder="Masukkan Email" required autofocus>
                                @error('identifier')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">Kirim Kode OTP</button>
                            </div>
                        </form>

                        <div class="mt-4 text-center">
                            <a href="{{ route('login') }}" class="text-decoration-none">Kembali ke Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection