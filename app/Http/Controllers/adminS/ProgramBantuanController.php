<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\ProgramBantuan;
use Illuminate\Http\Request;


class ProgramBantuanController extends Controller
{
    public function index()
    {
        $programs = ProgramBantuan::latest()->get();
        return view('Admins.program_bantuan.index', compact('programs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_program' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imageName = null;
        if ($request->hasFile('gambar')) {
            $imageName = time() . '.' . $request->gambar->extension();
            $request->gambar->move(public_path('images/program_bantuan'), $imageName);
        }

        ProgramBantuan::create([
            'nama_program' => $request->nama_program,
            'deskripsi' => $request->deskripsi,
            'gambar' => $imageName,
        ]);

        return redirect()->back()->with('success', 'Program bantuan berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_program' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $program = ProgramBantuan::findOrFail($id);

        if ($request->hasFile('gambar')) {
            if ($program->gambar && file_exists(public_path('images/program_bantuan/' . $program->gambar))) {
                unlink(public_path('images/program_bantuan/' . $program->gambar));
            }
            $imageName = time() . '.' . $request->gambar->extension();
            $request->gambar->move(public_path('images/program_bantuan'), $imageName);
            $program->gambar = $imageName;
        }

        $program->update([
            'nama_program' => $request->nama_program,
            'deskripsi' => $request->deskripsi,
            'gambar' => $program->gambar,
        ]);

        return redirect()->back()->with('success', 'Program bantuan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $program = ProgramBantuan::findOrFail($id);
        if ($program->gambar && file_exists(public_path('images/program_bantuan/' . $program->gambar))) {
            unlink(public_path('images/program_bantuan/' . $program->gambar));
        }
        $program->delete();

        return redirect()->back()->with('success', 'Program bantuan berhasil dihapus!');
    }
}
