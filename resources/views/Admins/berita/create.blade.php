@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold">Tambah Berita</h5>
                            <a href="{{ route('admin.berita.index') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-arrow-left me-1"></i> Kembali
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="judul" class="form-label">Judul Berita <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul"
                                    name="judul" value="{{ old('judul') }}" required>
                                @error('judul')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="tanggal" class="form-label">Tanggal <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal"
                                    name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                                @error('tanggal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="gambar" class="form-label">Gambar Utama <span
                                        class="text-danger">*</span></label>
                                <input type="file" class="form-control @error('gambar') is-invalid @enderror" id="gambar"
                                    name="gambar" accept="image/*" required onchange="previewImage()">
                                <div class="form-text">Format: JPG, JPEG, PNG. Maksimal 2MB.</div>
                                @error('gambar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <div class="mt-2">
                                    <img id="img-preview" src="#" alt="Preview" class="img-thumbnail d-none"
                                        style="height: 150px;">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="konten" class="form-label">Isi Berita <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('konten') is-invalid @enderror" id="konten"
                                    name="konten" rows="10" required>{{ old('konten') }}</textarea>
                                @error('konten')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i> Simpan Berita
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewImage() {
            const image = document.querySelector('#gambar');
            const imgPreview = document.querySelector('#img-preview');

            if (image.files && image.files[0]) {
                const oFReader = new FileReader();
                oFReader.readAsDataURL(image.files[0]);

                oFReader.onload = function (oFREvent) {
                    imgPreview.src = oFREvent.target.result;
                    imgPreview.classList.remove('d-none');
                }
            }
        }
    </script>
@endsection