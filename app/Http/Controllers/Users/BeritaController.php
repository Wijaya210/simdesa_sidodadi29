<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    public function index()
    {
        $berita = \App\Models\Berita::latest()->get();
        return view('users.berita.index', compact('berita'));
    }

    public function show($slug)
    {
        $berita = \App\Models\Berita::where('slug', $slug)->firstOrFail();
        return view('users.berita.show', compact('berita'));
    }
}
