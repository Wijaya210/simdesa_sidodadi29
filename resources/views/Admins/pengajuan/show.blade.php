@extends('layouts.app')

@section('content')
<div class="row justify-content-center" data-aos="fade-up">
    <div class="col-lg-10">
        
        <a href="{{ route('admin.surat.index') }}" class="btn btn-light text-primary fw-bold mb-4 shadow-sm">
            <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
        </a>

        <div class="glass-card">
            <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                <h4 class="fw-bold text-primary mb-0">📄 Detail Pengajuan Surat</h4>
                @if ($surat->status == 'pending' || $surat->status == 'menunggu')
                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">Menunggu Verifikasi</span>
                @elseif ($surat->status == 'disetujui')
                    <span class="badge bg-success px-3 py-2">Disetujui</span>
                @else
                    <span class="badge bg-danger px-3 py-2 rounded-pill">Ditolak</span>
                @endif
            </div>

            <div class="row mb-5">
                <div class="col-md-6">
                    <div class="bg-light p-4 rounded-4 h-100">
                        <h5 class="fw-bold text-secondary mb-3"><i class="fas fa-user me-2"></i>Data Pemohon</h5>
                        <table class="table table-borderless mb-0">
                            <tr>
                                <td class="text-muted ps-0">Nama Lengkap</td>
                                <td class="fw-bold">{{ $surat->user->name }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted ps-0">NIK</td>
                                <td class="fw-bold">{{ $surat->user->nik ?? '-' }}</td>
                            </tr>

                        </table>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="bg-light p-4 rounded-4 h-100">
                        <h5 class="fw-bold text-secondary mb-3"><i class="fas fa-file-alt me-2"></i>Informasi Surat</h5>
                        <table class="table table-borderless mb-0">
                            <tr>
                                <td class="text-muted ps-0">Jenis Surat</td>
                                <td class="fw-bold text-primary">{{ strtoupper(str_replace('_', ' ', $surat->jenis_surat)) }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted ps-0">Tanggal Ajuan</td>
                                <td class="fw-bold">{{ \Carbon\Carbon::parse($surat->created_at)->translatedFormat('d F Y, H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="mb-5">
                <h5 class="fw-bold text-primary mb-3">📋 Detail Isian Form</h5>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        @php
                            $detail = is_array($surat->detail) ? $surat->detail : json_decode($surat->detail, true) ?? [];
                        @endphp
                        
                        @foreach($detail as $key => $value)
                            @if($key != 'files')
                            <tr>
                                <th class="bg-light" width="30%">{{ ucwords(str_replace('_', ' ', $key)) }}</th>
                                <td>{{ is_array($value) ? json_encode($value) : $value }}</td>
                            </tr>
                            @endif
                        @endforeach
                    </table>
                </div>
            </div>

            <div class="mb-5">
                <h5 class="fw-bold text-primary mb-3">📎 Berkas Lampiran</h5>
                <div class="row g-3">
                    @if(isset($detail['files']) && is_array($detail['files']))
                        @foreach($detail['files'] as $file)
                            <div class="col-md-3 col-sm-6">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-body text-center p-3">
                                        @php $ext = pathinfo($file, PATHINFO_EXTENSION); @endphp
                                        
                                        @if(in_array(strtolower($ext), ['jpg', 'jpeg', 'png']))
                                            <div class="rounded overflow-hidden mb-2" style="height: 100px;">
                                                <img src="{{ asset($file) }}" class="w-100 h-100" style="object-fit: cover;" alt="Lampiran">
                                            </div>
                                        @else
                                            <i class="fas fa-file-pdf fa-3x text-danger mb-3"></i>
                                        @endif
                                        
                                        <a href="{{ asset($file) }}" target="_blank" class="btn btn-sm btn-outline-primary w-100 stretched-link">
                                            Lihat File
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-12">
                            <div class="alert alert-light border text-center text-muted">Tidak ada berkas lampiran.</div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="bg-light p-4 rounded-4 border-top border-3 border-primary">
                <h5 class="fw-bold text-primary mb-3">⚡ Aksi Admin</h5>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('admin.surat.preview', $surat->id) }}" target="_blank" class="btn btn-info text-white fw-bold">
                        <i class="fas fa-eye me-2"></i>Preview PDF
                    </a>

                    @if($surat->status == 'pending' || $surat->status == 'menunggu')
                        <form action="{{ route('admin.surat.approve', $surat->id) }}" method="POST">
                            @csrf
                            <button class="btn btn-success fw-bold">
                                <i class="fas fa-check-circle me-2"></i>Setujui Pengajuan
                            </button>
                        </form>

                        <form action="{{ route('admin.surat.reject', $surat->id) }}" method="POST">
                            @csrf
                            <button class="btn btn-warning text-dark fw-bold">
                                <i class="fas fa-times-circle me-2"></i>Tolak Pengajuan
                            </button>
                        </form>
                    @endif

                    <form action="{{ route('admin.surat.delete', $surat->id) }}" method="POST" onsubmit="return confirm('Hapus surat ini permanen?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger fw-bold">
                            <i class="fas fa-trash me-2"></i>Hapus Data
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection