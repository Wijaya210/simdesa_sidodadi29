<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Desa;
use App\Models\StatistikDesa;
use App\Models\AgamaDesa;
use App\Models\PekerjaanDesa;
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

        return view('admins.statistik.index', compact('desa', 'statistik', 'agamas', 'pekerjaans'));
    }

    public function update(Request $request)
    {
        $desa = Desa::first();
        if (!$desa) {
            return redirect()->back()->with('error', 'Data desa belum diinisialisasi.');
        }

        $request->validate([
            'jumlah_penduduk' => 'required|integer|min:0',
            'jumlah_laki_laki' => 'required|integer|min:0',
            'jumlah_perempuan' => 'required|integer|min:0',
            'jumlah_keluarga' => 'required|integer|min:0',
            'luas_wilayah' => 'required|numeric|min:0',
            'agama' => 'nullable|array',
            'pekerjaan' => 'nullable|array',
            'new_pekerjaan_name' => 'nullable|string|max:255',
            'new_pekerjaan_value' => 'nullable|integer|min:0',
        ]);

        // Update Statistik Umum
        $statistik = StatistikDesa::firstOrCreate(['desa_id' => $desa->id]);
        $statistik->update([
            'jumlah_penduduk' => $request->jumlah_penduduk,
            'jumlah_laki_laki' => $request->jumlah_laki_laki,
            'jumlah_perempuan' => $request->jumlah_perempuan,
            'jumlah_keluarga' => $request->jumlah_keluarga,
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
