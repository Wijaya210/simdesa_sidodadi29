<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <-- TAMBAHKAN INI

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // <-- ganti pakai Auth

        return view('Admins.dashboard', compact('user'));
    }
}
