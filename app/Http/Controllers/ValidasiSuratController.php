<?php

namespace App\Http\Controllers;

use App\Models\SuratPengajuan;
use Illuminate\Http\Request;

class ValidasiSuratController extends Controller
{
    public function index($id)
    {
        $surat = SuratPengajuan::with('user')->findOrFail($id);

        return view('validasi.surat', compact('surat'));
    }
}
