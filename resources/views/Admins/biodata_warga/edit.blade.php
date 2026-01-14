@extends('layouts.app')

@section('content')
    <div class="row justify-content-center" data-aos="fade-down">
        <div class="col-md-10">
            <div class="glass-card p-0 overflow-hidden">
                <div class="bg-warning text-dark p-4 d-flex justify-content-between align-items-center">
                    <h4 class="fw-bold mb-0">✏️ Edit Data Warga</h4>
                    <a href="{{ route('admin.biodata-warga.index') }}" class="btn btn-light btn-sm fw-bold text-dark">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>

                <div class="p-4">
                    <form action="{{ route('admin.biodata-warga.update', $warga->id) }}" method="POST" autocomplete="off">
                        @csrf
                        @method('PUT')

                        <h5 class="text-primary fw-bold mb-3 border-bottom pb-2">Informasi Pribadi</h5>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" required value="{{ $warga->name }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">NIK <span class="text-danger">*</span></label>
                                <input type="text" name="nik" class="form-control digits-16" required 
                                    value="{{ $warga->nik }}" maxlength="16" minlength="16" pattern="\d*">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">No. KK</label>
                                <input type="text" name="no_kk" class="form-control digits-16" 
                                    value="{{ $warga->no_kk }}" maxlength="16" minlength="16" pattern="\d*">
                            </div>
                            <!-- Email dihapus sesuai request, auto-generate di controller -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Jenis Kelamin <span class="text-danger">*</span></label>
                                <select name="jenis_kelamin" class="form-select" required>
                                    <option value="L" {{ $warga->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ $warga->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Tanggal Lahir <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_lahir" class="form-control" required
                                    value="{{ $warga->tanggal_lahir }}">
                            </div>
                        </div>

                        <h5 class="text-primary fw-bold mb-3 border-bottom pb-2">Alamat & Pekerjaan</h5>
                        <div class="row g-3 mb-4">
                            <div class="col-md-8">
                                <label class="form-label fw-bold">Alamat Rumah</label>
                                <input type="text" name="alamat" class="form-control" value="{{ $warga->alamat }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">RT / RW</label>
                                <input type="text" name="rt_rw" class="form-control" value="{{ $warga->rt_rw }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Pekerjaan</label>
                                <input type="text" name="pekerjaan" class="form-control" value="{{ $warga->pekerjaan }}"
                                    autocomplete="off">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Status Kependudukan <span
                                        class="text-danger">*</span></label>
                                <select name="jenis_kependudukan" class="form-select" required>
                                    <option value="tetap" {{ $warga->jenis_kependudukan == 'tetap' ? 'selected' : '' }}>Warga
                                        Tetap</option>
                                    <option value="pendatang" {{ $warga->jenis_kependudukan == 'pendatang' ? 'selected' : '' }}>Pendatang</option>
                                    <option value="pindah" {{ $warga->jenis_kependudukan == 'pindah' ? 'selected' : '' }}>
                                        Pindah</option>
                                </select>
                            </div>
                        </div>

                        <h5 class="text-danger fw-bold mb-3 border-bottom pb-2">Ubah Password (Opsional)</h5>
                        <div class="row g-3 mb-4">
                            <div class="col-md-12">
                                <label class="form-label fw-bold">Password Baru</label>
                                <input type="password" name="password" class="form-control"
                                    placeholder="Kosongkan jika tidak ingin mengubah password" autocomplete="new-password">
                            </div>
                        </div>


                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <a href="{{ route('admin.biodata-warga.index') }}"
                                class="btn btn-secondary px-4 fw-bold">Batal</a>
                            <button type="submit" class="btn btn-warning px-4 fw-bold">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@if(!isset($js_validation_added))
<script>
    document.querySelectorAll('.digits-16').forEach(input => {
        input.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '').substring(0, 16);
        });
    });
</script>
@php $js_validation_added = true; @endphp
@endif
@endsection