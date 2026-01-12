<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminsController extends Controller
{

    // Halaman dashboard admin
    public function dashboard()
    {
        $totalWarga = User::where('role', 'warga')->count();
        $suratMasuk = \App\Models\SuratPengajuan::count();
        $pengaduan = \App\Models\Pengaduan::count();
        $programBantuan = \App\Models\ProgramBantuan::count();

        return view('Admins.dashboard', compact('totalWarga', 'suratMasuk', 'pengaduan', 'programBantuan'));
    }

    // Logout admin
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}


