<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class PengaduanController extends Controller
{
    public function index()
    {
        $pengaduans = \App\Models\Pengaduan::with('user')->latest()->get();
        return view('admins.pengajuan.pengaduan', compact('pengaduans'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,diproses,selesai,ditolak',
            'tanggapan' => 'nullable|string',
        ]);

        $pengaduan = \App\Models\Pengaduan::findOrFail($id);
        $pengaduan->update([
            'status' => $request->status,
            'tanggapan' => $request->tanggapan,
            'is_read' => true,
        ]);



        return redirect()->back()->with('success', 'Status pengaduan berhasil diperbarui!');
    }
}
