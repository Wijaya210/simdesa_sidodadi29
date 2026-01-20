@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('berita.index') }}">Berita</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Detail</li>
                    </ol>
                </nav>

                <article class="bg-white rounded-3 shadow-sm p-4 border mb-5">
                    <h1 class="fw-bold mb-3">{{ $berita->judul }}</h1>

                    <div class="text-muted mb-4 d-flex align-items-center">
                        <i class="far fa-calendar-alt me-2"></i>
                        {{ \Carbon\Carbon::parse($berita->tanggal)->format('d F Y') }}
                        <span class="mx-2">•</span>
                        <i class="fas fa-user-circle me-2"></i> Admin Desa
                    </div>

                    @if($berita->gambar)
                        <div class="mb-4 text-center">
                            <img src="{{ asset('images/berita/' . $berita->gambar) }}" alt="{{ $berita->judul }}"
                                class="img-fluid rounded shadow-sm" style="max-height: 500px; width: 100%; object-fit: cover;">
                        </div>
                    @endif

                    <div class="article-content lh-lg text-justify text-break">
                        {!! nl2br(e($berita->konten)) !!}
                    </div>
                </article>

                <div class="d-flex justify-content-between align-items-center mb-5">
                    <a href="{{ route('berita.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Berita
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection