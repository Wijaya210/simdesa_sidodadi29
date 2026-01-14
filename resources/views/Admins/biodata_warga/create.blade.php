@extends('layouts.app')

@section('content')
    <div class="row justify-content-center" data-aos="fade-down">
        <div class="col-md-10">
            <div class="glass-card p-0 overflow-hidden">
                <div class="bg-primary text-white p-4 d-flex justify-content-between align-items-center">
                    <h4 class="fw-bold mb-0">➕ Tambah Data Warga</h4>
                    <a href="{{ route('admin.biodata-warga.index') }}" class="btn btn-light btn-sm fw-bold text-primary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>

                <div class="p-4">
                    <form action="{{ route('admin.biodata-warga.store') }}" method="POST" autocomplete="off">
                        @csrf

                        <h5 class="text-primary fw-bold mb-3 border-bottom pb-2">Informasi Pribadi</h5>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" required placeholder="Sesuai KTP">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">NIK <span class="text-danger">*</span></label>
                                <input type="text" name="nik" class="form-control digits-16" required
                                    placeholder="16 Digit NIK" maxlength="16" minlength="16" pattern="\d*">
                            </div>
                            <!-- Email dihapus sesuai request, auto-generate di controller -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">No. KK</label>
                                <input type="text" name="no_kk" class="form-control digits-16" placeholder="16 Digit No. KK"
                                    maxlength="16" minlength="16" pattern="\d*">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Jenis Kelamin <span class="text-danger">*</span></label>
                                <select name="jenis_kelamin" class="form-select" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Tanggal Lahir <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_lahir" class="form-control" required>
                            </div>
                        </div>

                        <h5 class="text-primary fw-bold mb-3 border-bottom pb-2">Alamat & Pekerjaan</h5>
                        <div class="row g-3 mb-4">
                            <div class="col-md-8">
                                <label class="form-label fw-bold">Alamat Rumah</label>
                                <input type="text" name="alamat" class="form-control" placeholder="Nama Jalan / Dusun">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">RT / RW</label>
                                <input type="text" name="rt_rw" class="form-control" placeholder="001/002">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Pekerjaan</label>
                                <input type="text" name="pekerjaan" class="form-control"
                                    placeholder="Contoh: Petani, PNS, Swasta" autocomplete="off">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Status Kependudukan <span
                                        class="text-danger">*</span></label>
                                <select name="jenis_kependudukan" class="form-select" required>
                                    <option value="tetap">Warga Tetap</option>
                                    <option value="pendatang">Pendatang</option>
                                    <option value="pindah">Pindah</option>
                                </select>
                            </div>
                        </div>

                        <div class="alert alert-info py-2">
                            <i class="fas fa-info-circle me-2"></i> Password default akun warga adalah <strong>NIK</strong>
                            yang didaftarkan.
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <button type="reset" class="btn btn-secondary px-4 fw-bold">Reset</button>
                            <button type="submit" class="btn btn-primary px-4 fw-bold">Simpan Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @if(!isset($js_validation_added))
        <script>
            document.querySelectorAll('.digits-16').forEach(input => {
                input.addEventListener('input', function () {
                    this.value = this.value.replace(/[^0-9]/g, '').substring(0, 16);
                });
            });
        </script>
        @php $js_validation_added = true; @endphp
    @endif
@endsection