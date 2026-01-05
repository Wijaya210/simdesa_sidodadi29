<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\SuratPengajuan;
use Illuminate\Http\Request;

use Barryvdh\DomPDF\Facade\Pdf;

class SuratPengajuanController extends Controller
{
    // Preview PDF untuk Admin
    public function preview($id)
    {
        $surat = SuratPengajuan::with('user')->findOrFail($id);

        // Decode detail jika berupa JSON (meskipun sudah dicast di model, jaga-jaga)
        $detail = is_array($surat->detail)
            ? $surat->detail
            : json_decode($surat->detail, true) ?? [];

        // Load view PDF sesuai jenis surat
        $pdf = Pdf::loadView('pdf.surat.' . $surat->jenis_surat, [
            'pengajuan' => $surat,
            'detail' => $detail,
            'user' => $surat->user
        ]);

        return $pdf->stream('Preview_' . $surat->jenis_surat . '.pdf');
    }
    // Halaman daftar semua surat
    public function index()
    {
        $surats = SuratPengajuan::with('user')->latest()->get();

        return view('admins.pengajuan.surat', compact('surats'));
    }

    // Halaman detail surat
    public function show($id)
    {
        $surat = SuratPengajuan::with('user')->findOrFail($id);

        return view('admins.pengajuan.show', compact('surat'));
    }

    // Menyetujui surat
    public function approve($id)
    {
        $surat = SuratPengajuan::findOrFail($id);
        $surat->status = 'disetujui';
        $surat->save();

        return redirect()->back()->with('success', 'Surat berhasil disetujui.');
    }

    // Menolak surat
    public function reject($id)
    {
        $surat = SuratPengajuan::findOrFail($id);
        $surat->status = 'ditolak';
        $surat->save();

        return redirect()->back()->with('success', 'Surat berhasil ditolak.');
    }

    // Menghapus surat
    public function destroy($id)
    {
        $surat = SuratPengajuan::findOrFail($id);
        $surat->delete();

        return redirect()->route('admin.surat.index')
            ->with('success', 'Surat berhasil dihapus.');
    }
}
