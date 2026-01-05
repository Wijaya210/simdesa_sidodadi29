<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('users.login');
    }

    /**
     * Menampilkan halaman dashboard untuk user (warga).
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        return view('users.dashboard');
    }
}
