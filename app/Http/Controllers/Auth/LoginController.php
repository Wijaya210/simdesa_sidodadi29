<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function show()
    {
        return view('auth.login'); // form login sama untuk semua
    }

    public function process(Request $request)
    {
        // Validasi input
        $request->validate([
            'login' => 'required|email', // Hanya Email
            'password' => 'required',
        ]);

        $credentials = [
            'email' => $request->login,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Redirect berdasarkan role
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admins.dashboard');
            }

            return redirect()->route('users.dashboard');
        }

        // Jika gagal
        return back()->with('error', 'Email/NIK atau password salah!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('beranda');
    }
}
