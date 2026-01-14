<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class BiodataWargaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'warga')->where('is_admin_added', true);

        // Filter pencarian jika ada
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('nik', 'like', "%$search%");
            });
        }

        // Ambil data dengan terbaru
        $wargas = $query->latest()->get();

        return view('admins.biodata_warga.index', compact('wargas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admins.biodata_warga.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nik' => 'required|digits:16|unique:users',
            'no_kk' => 'nullable|digits:16',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string|max:255',
            'rt_rw' => 'nullable|string|max:20',
            'pekerjaan' => 'nullable|string|max:255',
            'jenis_kependudukan' => 'required|in:tetap,pindah,pendatang',
            'password' => 'nullable|string|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'nik' => $request->nik,
            'no_kk' => $request->no_kk,
            'role' => 'warga',
            'is_admin_added' => true,
            'is_registered' => false,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'rt_rw' => $request->rt_rw,
            'pekerjaan' => $request->pekerjaan,
            'jenis_kependudukan' => $request->jenis_kependudukan,
            'password' => Hash::make($request->password ?? $request->nik),
        ]);

        return redirect()->route('admin.biodata-warga.index')->with('success', 'Data warga berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $warga = User::findOrFail($id);

        // Prevent editing non-admin-added citizens or non-warga accounts
        if ($warga->role !== 'warga' || !$warga->is_admin_added) {
            return redirect()->back()->with('error', 'Hanya data warga yang ditambahkan admin yang dapat diedit di sini.');
        }

        return view('admins.biodata_warga.edit', compact('warga'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $warga = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'nik' => ['required', 'digits:16', Rule::unique('users')->ignore($warga->id)],
            'no_kk' => 'nullable|digits:16',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string|max:255',
            'rt_rw' => 'nullable|string|max:20',
            'pekerjaan' => 'nullable|string|max:255',
            'jenis_kependudukan' => 'required|in:tetap,pindah,pendatang',
            'password' => 'nullable|string|min:6',
        ]);

        $data = [
            'name' => $request->name,
            'nik' => $request->nik,
            'no_kk' => $request->no_kk,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'rt_rw' => $request->rt_rw,
            'pekerjaan' => $request->pekerjaan,
            'jenis_kependudukan' => $request->jenis_kependudukan,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $warga->update($data);

        return redirect()->route('admin.biodata-warga.index')->with('success', 'Data warga berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $warga = User::findOrFail($id);

        if ($warga->role !== 'warga' || !$warga->is_admin_added) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus data ini dari menu ini.');
        }

        $warga->delete();

        return redirect()->back()->with('success', 'Data warga berhasil dihapus!');
    }
}
