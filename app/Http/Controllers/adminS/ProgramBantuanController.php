<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\ProgramBantuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('program_bantuan', 'public');
        }

        ProgramBantuan::create([
            'nama_program' => $request->nama_program,
            'deskripsi' => $request->deskripsi,
            'gambar' => $gambarPath,
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
            if ($program->gambar) {
                Storage::disk('public')->delete($program->gambar);
            }
            $program->gambar = $request->file('gambar')->store('program_bantuan', 'public');
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
        if ($program->gambar) {
            Storage::disk('public')->delete($program->gambar);
        }
        $program->delete();

        return redirect()->back()->with('success', 'Program bantuan berhasil dihapus!');
    }
}
