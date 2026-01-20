@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow-lg rounded-4">
                    <div class="card-header bg-primary text-white text-center py-4 rounded-top-4">
                        <h5 class="mb-0 fw-bold">
                            <i class="fas fa-check-circle me-2"></i> VALIDASI SURAT
                        </h5>
                        <p class="mb-0 mt-2 opacity-75 small">Sistem Informasi Manajemen Desa Sidodadi</p>
                    </div>
                    <div class="card-body p-4 p-md-5">

                        @if($surat->status == 'disetujui')
                            <div class="text-center mb-5">
                                <i class="fas fa-certificate fa-5x text-success mb-3"></i>
                                <h3 class="fw-bold text-success">SURAT VALID</h3>
                                <p class="text-muted">Dokumen ini sah dan terdaftar di sistem kami.</p>
                            </div>
                        @else
                            <div class="text-center mb-5">
                                <i class="fas fa-exclamation-triangle fa-5x text-warning mb-3"></i>
                                <h3 class="fw-bold text-warning">STATUS: {{ strtoupper($surat->status) }}</h3>
                                <p class="text-muted">Dokumen ini belum disetujui atau sedang dalam proses.</p>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <td class="fw-bold text-muted" width="35%">Jenis Surat</td>
                                        <td class="fw-bold text-dark">:
                                            {{ ucfirst(str_replace('_', ' ', $surat->jenis_surat)) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-muted">Nomor Surat</td>
                                        <td class="fw-bold text-dark">:
                                            {{ $surat->id }}/{{ strtoupper($surat->jenis_surat) }}/{{ $surat->created_at->format('Y') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-muted">Nama Pemohon</td>
                                        <td>: {{ $surat->user->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-muted">NIK</td>
                                        <td>: {{ $surat->user->nik }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-muted">Tanggal Pengajuan</td>
                                        <td>:
                                            {{ \Carbon\Carbon::parse($surat->tanggal_pengajuan)->translatedFormat('d F Y') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-muted">Tanggal Disetujui</td>
                                        <td>: {{ $surat->updated_at->translatedFormat('d F Y') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="alert alert-info d-flex align-items-center mt-4" role="alert">
                            <i class="fas fa-info-circle fa-2x me-3"></i>
                            <div>
                                Halaman ini merupakan bukti validitas dokumen yang dikeluarkan oleh Pemerintah Desa
                                Sidodadi.
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection