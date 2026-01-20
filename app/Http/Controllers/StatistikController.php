<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use App\Models\StatistikDesa;
use App\Models\AgamaDesa;
use App\Models\PekerjaanDesa;
use App\Models\User;
use Illuminate\Http\Request;

class StatistikController extends Controller
{
    public function index()
    {
        $desa = Desa::with(['statistik', 'agama', 'pekerjaan'])->first();

        if (!$desa) {
            return view('statistik.index', ['error' => 'Data belum tersedia']);
        }

        // Data Dinamis dari database Warga
        $dynamicStats = [
            'total_penduduk' => User::where('role', 'warga')->count(),
            'laki_laki' => User::where('role', 'warga')->where('jenis_kelamin', 'L')->count(),
            'perempuan' => User::where('role', 'warga')->where('jenis_kelamin', 'P')->count(),
        ];

        return view('statistik.index', compact('desa', 'dynamicStats'));
    }
}
