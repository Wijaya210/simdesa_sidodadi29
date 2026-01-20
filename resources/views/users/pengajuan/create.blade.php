@extends('layouts.app')

@section('content')
    <style>
        .letter-card {
            background: #fff;
            border: 2px solid #f0f0f0;
            border-radius: 20px;
            padding: 25px 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
            text-decoration: none;
        }

        .letter-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08);
            border-color: #0d6efd;
        }

        .letter-card .icon-box {
            width: 60px;
            height: 60px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            margin-bottom: 15px;
            transition: all 0.3s ease;
        }

        .letter-name {
            font-weight: 700;
            font-size: 0.9rem;
            color: #444;
            line-height: 1.3;
            margin-top: 5px;
        }
    </style>

    <div class="row justify-content-center" data-aos="fade-up">
        <div class="col-lg-10">

            @if (!request('type'))
                {{-- MODE 1: PILIH JENIS SURAT --}}
                <a href="{{ route('surat-pengajuan.index') }}" class="btn btn-light text-primary fw-bold mb-4 shadow-sm">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Riwayat
                </a>

                <div class="glass-card">
                    <div class="text-center mb-5">
                        <h2 class="fw-bold text-primary">📝 Ajukan Surat Baru</h2>
                        <p class="text-muted">Silakan pilih jenis surat yang ingin Anda ajukan.</p>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-4 col-6">
                            <a href="{{ route('surat-pengajuan.create', ['type' => 'nikah']) }}" class="letter-card">
                                <div class="icon-box bg-primary-subtle text-primary">
                                    <i class="fas fa-heart"></i>
                                </div>
                                <div class="letter-name">Surat Pengantar Nikah</div>
                            </a>
                        </div>
                        <div class="col-md-4 col-6">
                            <a href="{{ route('surat-pengajuan.create', ['type' => 'pindah']) }}" class="letter-card">
                                <div class="icon-box bg-info-subtle text-info">
                                    <i class="fas fa-truck-moving"></i>
                                </div>
                                <div class="letter-name">Surat Keterangan Pindah</div>
                            </a>
                        </div>
                        <div class="col-md-4 col-6">
                            <a href="{{ route('surat-pengajuan.create', ['type' => 'tanah']) }}" class="letter-card">
                                <div class="icon-box bg-success-subtle text-success">
                                    <i class="fas fa-map-marked-alt"></i>
                                </div>
                                <div class="letter-name">Surat Riwayat Tanah</div>
                            </a>
                        </div>
                        <div class="col-md-4 col-6">
                            <a href="{{ route('surat-pengajuan.create', ['type' => 'usaha']) }}" class="letter-card">
                                <div class="icon-box bg-warning-subtle text-warning">
                                    <i class="fas fa-store"></i>
                                </div>
                                <div class="letter-name">Surat Usaha (SKU)</div>
                            </a>
                        </div>
                        <div class="col-md-4 col-12">
                            <a href="{{ route('surat-pengajuan.create', ['type' => 'ahli_waris']) }}" class="letter-card">
                                <div class="icon-box bg-danger-subtle text-danger">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div class="letter-name">Keterangan Ahli Waris</div>
                            </a>
                        </div>
                        <div class="col-md-4 col-12">
                            <a href="{{ route('surat-pengajuan.create', ['type' => 'sktm']) }}" class="letter-card">
                                <div class="icon-box bg-dark-subtle text-dark">
                                    <i class="fas fa-hand-holding-usd"></i>
                                </div>
                                <div class="letter-name">Surat Keterangan Tidak Mampu (SKTM)</div>
                            </a>
                        </div>
                    </div>
                </div>
            @else
                {{-- MODE 2: FORM PENGISIAN --}}
                <a href="{{ route('surat-pengajuan.create') }}" class="btn btn-light text-primary fw-bold mb-4 shadow-sm">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Pilihan Surat
                </a>

                <div class="glass-card">
                    <div class="text-center mb-5">
                        <h2 class="fw-bold text-primary">📝 Form Pengajuan Surat</h2>
                        <h5 class="text-muted">{{ ucfirst(str_replace('_', ' ', request('type'))) }}</h5>
                    </div>

                    <form id="formPengajuan" action="{{ route('surat-pengajuan.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="jenis_surat" id="jenisSurat" value="{{ request('type') }}" required>

                        <div id="kontenFormDinamis">
                            <div class="card border-0 bg-light rounded-4 mb-4 p-4">
                                <h5 class="fw-bold text-primary mb-4"><i class="fas fa-file-upload me-2"></i>1. Dokumen
                                    Persyaratan</h5>
                                <div id="uploadChecklist" class="vstack gap-3">
                                    {{-- Checklist file akan dimasukkan di sini oleh JS --}}
                                </div>
                            </div>

                            <div class="card border-0 bg-light rounded-4 mb-5 p-4">
                                <h5 class="fw-bold text-primary mb-4"><i class="fas fa-edit me-2"></i>2. Data Tambahan</h5>
                                <div class="table-responsive">
                                    <table class="table table-borderless">
                                        <tbody id="persyaratanTabelBody"></tbody>
                                    </table>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg w-100 py-3 fw-bold shadow-lg">
                                <i class="fas fa-paper-plane me-2"></i> Kirim Pengajuan Surat
                            </button>
                        </div>
                    </form>
                </div>
            @endif
        </div>
    </div>

    <script>
        const dataSurat = {
            nikah: {
                files: [
                    "Pengantar RT & RW", "Fotokopi KTP Calon Suami & Calon Istri",
                    "Fotokopi Kartu Keluarga (KK)", "Fotokopi Akta Kelahiran",
                    "Fotokopi Ijazah Terakhir", "Pas Foto 2x3 (3 lembar)",
                    "Surat Pernyataan Belum Menikah (bermaterai)"
                ],
                persyaratan: [{
                    syarat: "Nama Calon Pasangan",
                    keterangan: `<input type="text" class="form-control" name="nama_pasangan" placeholder="Nama lengkap calon suami/istri" required>`
                },
                {
                    syarat: "Alamat Pasangan",
                    keterangan: `<textarea class="form-control" name="alamat_pasangan" rows="2" placeholder="Alamat lengkap calon pasangan" required></textarea>`
                }
                ]
            },
            pindah: {
                files: [
                    "Pengantar RT & RW", "Fotokopi KTP", "Fotokopi Kartu Keluarga (KK)",
                    "Surat Pernyataan Bersedia Menerima dari Lurah/Kades tujuan",
                    "Surat Pernyataan Pindah (formulir kelurahan)"
                ],
                persyaratan: [{
                    syarat: "Alamat Tujuan Pindah",
                    keterangan: `<textarea class="form-control" name="alamat_tujuan" rows="2" placeholder="Isi alamat lengkap tujuan pindah" required></textarea>`
                },
                {
                    syarat: "Provinsi Tujuan",
                    keterangan: `<input type="text" class="form-control" name="provinsi_tujuan" placeholder="Contoh: Jawa Tengah" required>`
                }
                ]
            },
            tanah: {
                files: [
                    "Pengantar RT & RW", "Fotokopi KTP Pemohon", "Fotokopi Kartu Keluarga (KK)",
                    "Fotokopi Bukti Tanah (Letter C/SPPT/Akta Jual Beli lama)",
                    "Surat Pernyataan Riwayat Kepemilikan (bermaterai)",
                    "Denah Lokasi Tanah"
                ],
                persyaratan: [{
                    syarat: "Luas Tanah (m²)",
                    keterangan: `<input type="number" class="form-control" name="luas_tanah" placeholder="Cth: 150" required>`
                },
                {
                    syarat: "Lokasi Tanah",
                    keterangan: `<textarea class="form-control" name="lokasi_tanah" rows="2" placeholder="Jalan, RT/RW, dan batas-batas tanah" required></textarea>`
                }
                ]
            },
            usaha: {
                files: [
                    "Pengantar RT & RW", "Fotokopi KTP Pemohon", "Fotokopi Kartu Keluarga (KK)",
                    "Pas Foto Berwarna 3x4", "Surat Keterangan Tempat Usaha (Sertifikat/Sewa)",
                    "Surat Izin Tetangga (jika diperlukan)"
                ],
                persyaratan: [{
                    syarat: "Nama Usaha",
                    keterangan: `<input type="text" class="form-control" name="nama_usaha" placeholder="Contoh: Warung Sembako Bpk. Budi" required>`
                },
                {
                    syarat: "Jenis Usaha",
                    keterangan: `<input type="text" class="form-control" name="jenis_usaha" placeholder="Contoh: Perdagangan (Sembako)" required>`
                },
                {
                    syarat: "Alamat Usaha",
                    keterangan: `<textarea class="form-control" name="alamat_usaha" rows="2" placeholder="Isi alamat lengkap tempat usaha" required></textarea>`
                }
                ]
            },
            ahli_waris: {
                files: [
                    "Pengantar RT & RW", "Fotokopi KTP Semua Ahli Waris",
                    "Fotokopi Kartu Keluarga (KK) Pewaris",
                    "Fotokopi Surat Keterangan Kematian Pewaris",
                    "Fotokopi Buku Nikah/Akta Perkawinan Pewaris",
                    "Daftar Rinci Harta Warisan"
                ],
                persyaratan: [{
                    syarat: "Tanggal Kematian Pewaris",
                    keterangan: `<input type="date" class="form-control" name="tgl_kematian" required>`
                },
                {
                    syarat: "Hubungan dengan Pewaris",
                    keterangan: `<input type="text" class="form-control" name="hubungan_pewaris" placeholder="Contoh: Anak Kandung, Istri Sah" required>`
                }
                ]
            },
            sktm: {
                files: [
                    "Pengantar RT & RW", "Fotokopi KTP Pemohon", "Fotokopi Kartu Keluarga (KK)",
                    "Surat Pernyataan Tidak Mampu (bermaterai)"
                ],
                persyaratan: [{
                    syarat: "Keperluan",
                    keterangan: `<textarea class="form-control" name="keperluan" rows="2" placeholder="Contoh: Persyaratan Beasiswa Sekolah, Keringanan Biaya RS" required></textarea>`
                },
                {
                    syarat: "Nama Anak (Opsional)",
                    keterangan: `<input type="text" class="form-control" name="nama_anak" placeholder="Isi jika untuk keperluan anak sekolah">`
                },
                {
                    syarat: "Asal Sekolah/Universitas (Opsional)",
                    keterangan: `<input type="text" class="form-control" name="asal_sekolah" placeholder="Isi jika untuk keperluan anak sekolah">`
                }
                ]
            }
        };

        document.addEventListener('DOMContentLoaded', function () {
            const types = new URLSearchParams(window.location.search);
            const jenisSurat = document.getElementById('jenisSurat')?.value;

            if (jenisSurat && dataSurat[jenisSurat]) {
                tampilkanForm(jenisSurat);
            }
        });

        function tampilkanForm(jenisSurat) {
            const uploadChecklist = document.getElementById('uploadChecklist');
            const persyaratanTabelBody = document.getElementById('persyaratanTabelBody');

            if (!dataSurat[jenisSurat]) return;

            const data = dataSurat[jenisSurat];

            // 1. Tampilkan Checklist Upload File
            let uploadHTML = '';
            data.files.forEach((file, index) => {
                const fieldName = 'file_attachments[]';
                uploadHTML += `
                                <div class="bg-white p-3 rounded shadow-sm d-flex align-items-center justify-content-between">
                                    <span class="fw-medium"><i class="fas fa-file-alt text-secondary me-2"></i> ${file} <span class="text-danger">*</span></span>
                                    <input type="file" class="form-control form-control-sm w-50" name="${fieldName}" required>
                                </div>
                            `;
            });
            uploadChecklist.innerHTML = uploadHTML;

            // 2. Tampilkan Tabel Persyaratan
            let persyaratanHTML = '';
            data.persyaratan.forEach(item => {
                persyaratanHTML += `
                                <tr>
                                    <td class="fw-bold pt-3" style="width: 35%;">${item.syarat}</td>
                                    <td>${item.keterangan}</td>
                                </tr>
                            `;
            });
            persyaratanTabelBody.innerHTML = persyaratanHTML;
        }
    </script>
@endsection