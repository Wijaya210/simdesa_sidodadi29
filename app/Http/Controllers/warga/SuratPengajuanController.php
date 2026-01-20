<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\SuratPengajuan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class SuratPengajuanController extends Controller
{
    public function index()
    {
        $jenisSurat = [
            'nikah' => 'Surat Pengantar Nikah',
            'pindah' => 'Surat Keterangan Pindah (Keluar)',
            'tanah' => 'Surat Keterangan Riwayat Tanah',
            'usaha' => 'Surat Keterangan Usaha (SKU)',
            'ahli_waris' => 'Surat Keterangan Ahli Waris',
            'sktm' => 'Surat Keterangan Tidak Mampu',
        ];

        $pengajuans = SuratPengajuan::where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('users.pengajuan.surat', compact('pengajuans', 'jenisSurat'));
    }

    public function create()
    {
        return view('users.pengajuan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_surat' => 'required',
            'file_attachments.*' => 'file|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);

        $detail = $request->except(['_token', 'jenis_surat', 'file_attachments']);

        // Handle File Uploads
        if ($request->hasFile('file_attachments')) {
            $files = [];
            foreach ($request->file('file_attachments') as $file) {
                // Simpan file ke storage/app/public/surat_uploads/user_id/timestamp
                $filename = $file->getClientOriginalName();
                $storagePath = 'surat_uploads/' . auth()->id() . '/' . time();
                $path = $file->storeAs($storagePath, $filename, 'public');

                // Simpan path relatif untuk diakses via asset() -> storage/surat_uploads/...
                $files[] = 'storage/' . $path;
            }
            $detail['files'] = $files;
        }

        try {
            \Illuminate\Support\Facades\DB::beginTransaction();

            // 1. Simpan Parent (SuratPengajuan)
            $pengajuan = SuratPengajuan::create([
                'user_id' => auth()->user()->id,
                'jenis_surat' => $request->jenis_surat,
                'status' => 'pending',
                'tanggal_pengajuan' => now(),
                'catatan_admin' => null,
                'detail' => $detail, // Tetap simpan JSON sebagai backup/mudah akses di view lama
            ]);

            // 2. Simpan Child ke Tabel Spesifik
            switch ($request->jenis_surat) {
                case 'nikah':
                    \App\Models\SuratPengajuanNikah::create([
                        'surat_pengajuan_id' => $pengajuan->id,
                        'nama_pasangan' => $request->nama_pasangan,
                        'alamat_pasangan' => $request->alamat_pasangan,
                    ]);
                    break;
                case 'pindah':
                    \App\Models\SuratPengajuanPindah::create([
                        'surat_pengajuan_id' => $pengajuan->id,
                        'alamat_tujuan' => $request->alamat_tujuan,
                        'provinsi_tujuan' => $request->provinsi_tujuan,
                    ]);
                    break;
                case 'tanah':
                    \App\Models\SuratPengajuanTanah::create([
                        'surat_pengajuan_id' => $pengajuan->id,
                        'luas_tanah' => $request->luas_tanah,
                        'lokasi_tanah' => $request->lokasi_tanah,
                    ]);
                    break;
                case 'usaha':
                    \App\Models\SuratPengajuanUsaha::create([
                        'surat_pengajuan_id' => $pengajuan->id,
                        'nama_usaha' => $request->nama_usaha,
                        'jenis_usaha' => $request->jenis_usaha,
                        'alamat_usaha' => $request->alamat_usaha,
                    ]);
                    break;
                case 'ahli_waris':
                    \App\Models\SuratPengajuanAhliWaris::create([
                        'surat_pengajuan_id' => $pengajuan->id,
                        'tgl_kematian' => $request->tgl_kematian,
                        'hubungan_pewaris' => $request->hubungan_pewaris,
                    ]);
                    break;
                case 'sktm':
                    \App\Models\SuratPengajuanSktm::create([
                        'surat_pengajuan_id' => $pengajuan->id,
                        'keperluan' => $request->keperluan,
                        'nama_anak' => $request->nama_anak,
                        'asal_sekolah' => $request->asal_sekolah,
                    ]);
                    break;
            }

            \Illuminate\Support\Facades\DB::commit();

            // Log activity
            \App\Helpers\ActivityLogger::log('Create', 'Pengajuan surat baru: ' . $request->jenis_surat);

            return redirect()->route('surat-pengajuan.index')
                ->with('success', 'Pengajuan berhasil dikirim! Data tersimpan di database.');

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage())->withInput();
        }
    }

    // ======================
    //       DETAIL PAGE
    // ======================
    public function detail($id)
    {
        $pengajuan = SuratPengajuan::where('user_id', auth()->id())
            ->findOrFail($id);

        $detail = $pengajuan->detail ?? [];

        // Mapping Label untuk Detail sesuai Jenis Surat
        $fieldMap = [
            'nikah' => ['nama_pasangan' => 'Nama Calon Pasangan', 'alamat_pasangan' => 'Alamat Calon Pasangan'],
            'pindah' => ['alamat_tujuan' => 'Alamat Tujuan', 'provinsi_tujuan' => 'Provinsi Tujuan'],
            'tanah' => ['lokasi_tanah' => 'Lokasi Tanah', 'luas_tanah' => 'Luas Tanah (m²)'],
            'usaha' => ['nama_usaha' => 'Nama Usaha', 'jenis_usaha' => 'Jenis Usaha', 'alamat_usaha' => 'Alamat Usaha'],
            'ahli_waris' => ['hubungan_pewaris' => 'Hubungan Pewaris', 'tgl_kematian' => 'Tanggal Kematian'],
            'sktm' => ['keperluan' => 'Keperluan', 'nama_anak' => 'Nama Anak (Jika ada)', 'asal_sekolah' => 'Asal Sekolah/Univ (Jika ada)'],
        ];

        $fields = $fieldMap[$pengajuan->jenis_surat] ?? [];

        return view('users.pengajuan.detail', compact('pengajuan', 'detail', 'fields'));
    }

    // ======================
    //     DOWNLOAD PDF
    // ======================
    public function download($id)
    {
        // Cari pengajuan surat milik user yang login
        $pengajuan = SuratPengajuan::where('user_id', auth()->id())
            ->findOrFail($id);

        // Validasi: hanya surat yang sudah disetujui yang bisa didownload
        if ($pengajuan->status !== 'disetujui') {
            return redirect()->back()->with('error', 'Surat belum disetujui oleh admin.');
        }
        $detail = $pengajuan->detail ?? [];

        // Generate QR Code as SVG Base64 for PDF (Avoids PHP GD dependency)
        $qrUrl = route('surat.validasi', $pengajuan->id);
        $qrApiUrl = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . urlencode($qrUrl) . "&format=svg";

        try {
            $qrCodeData = file_get_contents($qrApiUrl);
            $qrCode = base64_encode($qrCodeData);
        } catch (\Exception $e) {
            $qrCode = null;
        }

        // Fetch data Desa untuk header dan tanda tangan
        $desa = \App\Models\Desa::first();

        // Load view PDF sesuai jenis surat
        $pdf = Pdf::loadView('pdf.surat.' . $pengajuan->jenis_surat, [
            'pengajuan' => $pengajuan,
            'detail' => $detail,
            'user' => $pengajuan->user,
            'qrCode' => $qrCode,
            'qrUrl' => $qrUrl,
            'desa' => $desa
        ]);

        // Nama file untuk download
        $namaFile = 'Surat_' . ucfirst($pengajuan->jenis_surat) . '_' . date('Y-m-d') . '.pdf';

        // Download PDF
        return $pdf->download($namaFile);
    }
}
