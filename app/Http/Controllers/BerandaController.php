<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BerandaController extends Controller
{
    public function index()
    {
        // Jika user sudah login, langsung redirect ke dashboard masing-masing
        if (auth()->check()) {
            if (auth()->user()->role === 'admin') {
                return redirect()->route('admins.dashboard');
            }
            return redirect()->route('users.dashboard');
        }

        // Menghitung jumlah warga yang ada di sistem (baik yang sudah registrasi maupun belum)
        $jumlahPenduduk = \App\Models\User::where('role', 'warga')->count();

        // Menghitung jumlah warga yang sudah melakukan registrasi/aktivasi akun (is_registered = true)
        $jumlahPenggunaAktif = \App\Models\User::where('role', 'warga')
            ->where('is_registered', true)
            ->count();

        return view('beranda', compact('jumlahPenduduk', 'jumlahPenggunaAktif'));
    }
}
