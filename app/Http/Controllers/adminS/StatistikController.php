<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Desa;
use App\Models\StatistikDesa;
use App\Models\AgamaDesa;
use App\Models\PekerjaanDesa;
use App\Models\User;
use Illuminate\Http\Request;

class StatistikController extends Controller
{
    public function index()
    {
        $desa = Desa::first();
        if (!$desa) {
            return redirect()->back()->with('error', 'Data desa belum diinisialisasi.');
        }

        $statistik = StatistikDesa::where('desa_id', $desa->id)->first();
        $agamas = AgamaDesa::where('desa_id', $desa->id)->get();
        $pekerjaans = PekerjaanDesa::where('desa_id', $desa->id)->get();

        // Data Dinamis dari database Warga
        $dynamicStats = [
            'total_penduduk' => User::where('role', 'warga')->count(),
            'laki_laki' => User::where('role', 'warga')->where('jenis_kelamin', 'L')->count(),
            'perempuan' => User::where('role', 'warga')->where('jenis_kelamin', 'P')->count(),
        ];

        return view('admins.statistik.index', compact('desa', 'statistik', 'agamas', 'pekerjaans', 'dynamicStats'));
    }

    public function update(Request $request)
    {
        $desa = Desa::first();
        if (!$desa) {
            return redirect()->back()->with('error', 'Data desa belum diinisialisasi.');
        }

        $request->validate([
            'luas_wilayah' => 'required|numeric|min:0',
            'agama' => 'nullable|array',
            'pekerjaan' => 'nullable|array',
            'new_pekerjaan_name' => 'nullable|string|max:255',
            'new_pekerjaan_value' => 'nullable|integer|min:0',
        ]);

        // Update Statistik Umum (Hanya Luas Wilayah yang manual, sisanya otomatis)
        $statistik = StatistikDesa::firstOrCreate(['desa_id' => $desa->id]);
        $statistik->update([
            'luas_wilayah' => $request->luas_wilayah,
        ]);

        // Update Agama
        if ($request->has('agama')) {
            foreach ($request->agama as $id => $jumlah) {
                AgamaDesa::where('id', $id)->where('desa_id', $desa->id)->update(['jumlah' => $jumlah]);
            }
        }

        // Update Pekerjaan
        if ($request->has('pekerjaan')) {
            foreach ($request->pekerjaan as $id => $jumlah) {
                PekerjaanDesa::where('id', $id)->where('desa_id', $desa->id)->update(['jumlah' => $jumlah]);
            }
        }

        // Handle Penambahan Pekerjaan Baru
        if ($request->filled('new_pekerjaan_name')) {
            PekerjaanDesa::create([
                'desa_id' => $desa->id,
                'pekerjaan' => $request->new_pekerjaan_name,
                'jumlah' => $request->new_pekerjaan_value ?? 0,
            ]);
        }

        return redirect()->back()->with('success', 'Statistik berhasil diperbarui!');
    }

    public function destroyPekerjaan($id)
    {
        PekerjaanDesa::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Data pekerjaan berhasil dihapus!');
    }
}
