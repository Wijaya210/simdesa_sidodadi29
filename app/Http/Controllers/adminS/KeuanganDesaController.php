<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\KeuanganDesa;
use Illuminate\Http\Request;
use App\Helpers\ActivityLogger;

class KeuanganDesaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = KeuanganDesa::latest('tanggal')->latest('id')->get();

        $totalMasuk = KeuanganDesa::where('jenis', 'masuk')->sum('jumlah');
        $totalKeluar = KeuanganDesa::where('jenis', 'keluar')->sum('jumlah');
        $saldo = $totalMasuk - $totalKeluar;

        return view('admins.keuangan.index', compact('transactions', 'totalMasuk', 'totalKeluar', 'saldo'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admins.keuangan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'keterangan' => 'required|string|max:255',
            'jenis' => 'required|in:masuk,keluar',
            'jumlah' => 'required|numeric|min:0',
            'sumber' => 'nullable|string|max:255',
        ]);

        KeuanganDesa::create($request->all());

        ActivityLogger::log('Create', 'Menambahkan transaksi keuangan: ' . $request->keterangan . ' (Rp ' . number_format($request->jumlah, 0, ',', '.') . ')');

        return redirect()->route('admin.keuangan.index')->with('success', 'Transaksi berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $keuangan = KeuanganDesa::findOrFail($id);
        return view('admins.keuangan.edit', compact('keuangan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $keuangan = KeuanganDesa::findOrFail($id);

        $request->validate([
            'tanggal' => 'required|date',
            'keterangan' => 'required|string|max:255',
            'jenis' => 'required|in:masuk,keluar',
            'jumlah' => 'required|numeric|min:0',
            'sumber' => 'nullable|string|max:255',
        ]);

        $keuangan->update($request->all());

        ActivityLogger::log('Update', 'Memperbarui transaksi keuangan: ' . $keuangan->keterangan);

        return redirect()->route('admin.keuangan.index')->with('success', 'Transaksi berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $keuangan = KeuanganDesa::findOrFail($id);
        $keterangan = $keuangan->keterangan;
        $keuangan->delete();

        ActivityLogger::log('Delete', 'Menghapus transaksi keuangan: ' . $keterangan);

        return redirect()->route('admin.keuangan.index')->with('success', 'Transaksi berhasil dihapus!');
    }
}
