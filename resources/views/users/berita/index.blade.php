@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-5">
            <div class="col-12 text-center" data-aos="fade-up">
                <h2 class="fw-bold section-title">Kabar Desa Sidodadi</h2>
                <p class="text-muted">Informasi terbaru seputar kegiatan dan perkembangan desa</p>
            </div>
        </div>

        <div class="row">
            @forelse ($berita as $item)
                <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="{{ 100 * $loop->iteration }}">
                    <div class="card h-100 shadow-sm border-0 hover-card">
                        <div class="position-relative">
                            @if($item->gambar)
                                <img src="{{ asset('images/berita/' . $item->gambar) }}" class="card-img-top news-img"
                                    alt="{{ $item->judul }}" style="height: 200px; object-fit: cover;">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                    <i class="fas fa-newspaper fa-3x text-secondary"></i>
                                </div>
                            @endif
                            <div class="position-absolute top-0 end-0 bg-primary text-white px-3 py-1 rounded-start mt-3">
                                <small>{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</small>
                            </div>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold">
                                <a href="{{ route('berita.show', $item->slug) }}"
                                    class="text-decoration-none text-dark stretched-link">
                                    {{ Str::limit($item->judul, 50) }}
                                </a>
                            </h5>
                            <p class="card-text text-muted mb-4">
                                {{ Str::limit(strip_tags($item->konten), 100) }}
                            </p>
                            <div class="mt-auto d-flex justify-content-between align-items-center">
                                <span class="text-primary fw-bold text-decoration-none">
                                    Baca Selengkapnya <i class="fas fa-arrow-right ms-1"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="text-muted">
                        <i class="fas fa-newspaper fa-4x mb-3"></i>
                        <h5>Belum ada berita yang tersedia.</h5>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <style>
        .hover-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hover-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        }
    </style>
@endsection