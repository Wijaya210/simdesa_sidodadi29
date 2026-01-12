<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function show()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'nik' => 'required|numeric',
            'email' => 'required|email|unique:users,email',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        // Cari data warga yang sudah didaftarkan oleh admin berdasarkan NIK
        $user = User::where('nik', $request->nik)
            ->where('is_admin_added', true)
            ->first();

        // Jika NIK tidak ditemukan di data admin
        if (!$user) {
            return back()->withInput()->withErrors(['nik' => 'NIK Anda tidak terdaftar di data warga desa. Silakan hubungi admin untuk pendaftaran data warga terlebih dahulu.']);
        }

        // Jika warga sudah pernah registrasi sebelumnya
        if ($user->is_registered) {
            return back()->withInput()->withErrors(['nik' => 'Akun dengan NIK ini sudah terdaftar. Silakan login atau gunakan fitur lupa password.']);
        }

        // Update data warga yang ada (aktivasi akun)
        $user->update([
            'name' => $request->name, // Update nama jika ada perubahan dari KTP
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_registered' => true,
        ]);

        // Login otomatis
        Auth::login($user);

        // Redirect ke dashboard
        return redirect()->route('users.dashboard');
    }
}
