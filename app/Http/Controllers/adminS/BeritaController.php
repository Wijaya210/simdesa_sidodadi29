<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class BeritaController extends Controller
{
    public function index()
    {
        $berita = \App\Models\Berita::latest()->get();
        return view('admins.berita.index', compact('berita'));
    }

    public function create()
    {
        return view('admins.berita.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'tanggal' => 'required|date',
        ]);

        $imageName = time() . '.' . $request->gambar->extension();
        $request->gambar->move(public_path('images/berita'), $imageName);

        \App\Models\Berita::create([
            'judul' => $request->judul,
            'slug' => \Illuminate\Support\Str::slug($request->judul),
            'konten' => $request->konten,
            'gambar' => $imageName,
            'tanggal' => $request->tanggal,
        ]);



        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $berita = \App\Models\Berita::findOrFail($id);
        return view('admins.berita.edit', compact('berita'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'tanggal' => 'required|date',
        ]);

        $berita = \App\Models\Berita::findOrFail($id);

        if ($request->hasFile('gambar')) {
            // Delete old image
            if (file_exists(public_path('images/berita/' . $berita->gambar))) {
                unlink(public_path('images/berita/' . $berita->gambar));
            }

            $imageName = time() . '.' . $request->gambar->extension();
            $request->gambar->move(public_path('images/berita'), $imageName);
            $berita->gambar = $imageName;
        }

        $berita->judul = $request->judul;
        $berita->slug = \Illuminate\Support\Str::slug($request->judul);
        $berita->konten = $request->konten;
        $berita->tanggal = $request->tanggal;
        $berita->save();



        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $berita = \App\Models\Berita::findOrFail($id);

        if (file_exists(public_path('images/berita/' . $berita->gambar))) {
            unlink(public_path('images/berita/' . $berita->gambar));
        }

        $judul = $berita->judul;
        $berita->delete();


        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil dihapus.');
    }
}
