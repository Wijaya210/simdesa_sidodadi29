<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PengaduanController extends Controller
{
    public function index()
    {
        $pengaduans = \App\Models\Pengaduan::where('user_id', auth()->id())
            ->latest()
            ->get();
        return view('users.pengajuan.pengaduan', compact('pengaduans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('pengaduan', 'public');
        }

        \App\Models\Pengaduan::create([
            'user_id' => auth()->id(),
            'judul' => $request->judul,
            'isi' => $request->isi,
            'foto' => $fotoPath,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Pengaduan berhasil dikirim!');
    }
}
