<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use App\Models\StatistikDesa;
use App\Models\AgamaDesa;
use App\Models\PekerjaanDesa;
use Illuminate\Http\Request;

class StatistikController extends Controller
{
    public function index()
    {
        $desa = Desa::with(['statistik', 'agama', 'pekerjaan'])->first();

        if (!$desa) {
            return view('statistik.index', ['error' => 'Data belum tersedia']);
        }

        return view('statistik.index', compact('desa'));
    }
}
