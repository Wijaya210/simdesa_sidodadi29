@extends('layouts.app')

@section('content')
    <div class="row justify-content-center" data-aos="fade-up">
        <div class="col-lg-8">

            <a href="{{ route('surat-pengajuan.index') }}" class="btn btn-light text-primary fw-bold mb-4 shadow-sm">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Riwayat
            </a>

            <div class="glass-card">
                <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                    <h4 class="fw-bold text-primary mb-0">📄 Detail Pengajuan Surat</h4>
                    @if ($pengajuan->status == 'pending')
                        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">Menunggu</span>
                    @elseif ($pengajuan->status == 'approved' || $pengajuan->status == 'disetujui')
                        <span class="badge bg-success px-3 py-2 rounded-pill">Disetujui</span>
                    @else
                        <span class="badge bg-danger px-3 py-2 rounded-pill">Ditolak</span>
                    @endif
                </div>

                <div class="mb-4">
                    <h5 class="fw-bold text-secondary mb-3">Informasi Utama</h5>
                    <div class="bg-light p-4 rounded-4 position-relative">
                        <div class="row mb-2">
                            <div class="col-md-4 text-muted">Jenis Surat</div>
                            <div class="col-md-8 fw-bold text-primary">
                                {{ strtoupper(str_replace('_', ' ', $pengajuan->jenis_surat)) }}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 text-muted">Tanggal Pengajuan</div>
                            <div class="col-md-8 fw-bold">{{ $pengajuan->created_at->format('d F Y, H:i') }} WIB</div>
                        </div>

                        @if(in_array($pengajuan->status, ['disetujui', 'approved']))
                            <div
                                class="position-absolute top-50 end-0 translate-middle-y me-4 d-none d-md-block text-center bg-white p-2 rounded shadow-sm">
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=80x80&data={{ urlencode(url()->current()) }}"
                                    width="80" alt="QR Code">
                                <div class="small text-muted mt-1" style="font-size: 0.65rem;">Verifikasi Surat</div>
                            </div>
                        @endif
                    </div>
                </div>

                <div>
                    <h5 class="fw-bold text-secondary mb-3">Data Pengajuan</h5>
                    @if (!empty($fields))
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                @foreach ($fields as $key => $label)
                                    <tr>
                                        <th class="bg-light" width="35%">{{ $label }}</th>
                                        <td>{{ $detail[$key] ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    @else
                        <p class="text-muted fst-italic">Tidak ada detail tambahan untuk jenis surat ini.</p>
                    @endif
                </div>

                {{-- File Uploads Hidden as per request --}}

                @if(in_array($pengajuan->status, ['disetujui', 'approved']))
                    <div class="mt-5 text-center">
                        <a href="{{ route('surat-pengajuan.download', $pengajuan->id) }}"
                            class="btn btn-success btn-lg px-5 shadow-lg">
                            <i class="fas fa-download me-2"></i>Download Surat Resmi
                        </a>
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection