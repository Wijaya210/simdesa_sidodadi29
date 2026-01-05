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
                $path = $file->storeAs(
                    'public/surat_uploads/' . auth()->id() . '/' . time(),
                    $file->getClientOriginalName()
                );
                // Simpan path relatif untuk diakses via storage link
                $files[] = str_replace('public/', 'storage/', $path);
            }
            $detail['files'] = $files;
        }

        $data = [
            'user_id' => auth()->user()->id,
            'jenis_surat' => $request->jenis_surat,
            'status' => 'pending',
            'catatan_admin' => null,
            'detail' => $detail,
        ];

        SuratPengajuan::create($data);

        return redirect()->route('surat-pengajuan.index')
            ->with('success', 'Pengajuan berhasil dikirim! Status dapat dilihat di riwayat.');
    }

    // ======================
    //       DETAIL PAGE
    // ======================
    public function detail($id)
    {
        $pengajuan = SuratPengajuan::where('user_id', auth()->id())
            ->findOrFail($id);

        /**
         * Pastikan $detail berupa ARRAY
         * Jika DB menyimpan JSON string → otomatis decode
         * Jika null → jadikan array kosong
         */
        $detail = is_array($pengajuan->detail)
            ? $pengajuan->detail
            : json_decode($pengajuan->detail, true) ?? [];

        return view('users.pengajuan.detail', compact('pengajuan', 'detail'));
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
        if (!in_array($pengajuan->status, ['disetujui', 'approved'])) {
            return redirect()->back()->with('error', 'Hanya surat yang sudah disetujui yang dapat diunduh.');
        }

        // Decode detail jika berupa JSON
        $detail = is_array($pengajuan->detail)
            ? $pengajuan->detail
            : json_decode($pengajuan->detail, true) ?? [];

        // Load view PDF sesuai jenis surat
        $pdf = Pdf::loadView('pdf.surat.' . $pengajuan->jenis_surat, [
            'pengajuan' => $pengajuan,
            'detail' => $detail,
            'user' => $pengajuan->user
        ]);

        // Nama file untuk download
        $namaFile = 'Surat_' . ucfirst($pengajuan->jenis_surat) . '_' . date('Y-m-d') . '.pdf';

        // Download PDF
        return $pdf->download($namaFile);
    }
}
