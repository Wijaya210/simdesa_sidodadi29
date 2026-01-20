<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpVerificationMail;
use Carbon\Carbon;

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
            'nik' => 'required|digits:16',
            'email' => 'required|email|unique:users,email',
            'password' => ['required', 'confirmed', Password::min(8)],
            'g-recaptcha-response' => 'required',
        ]);

        // Verifikasi reCAPTCHA
        $response = \Illuminate\Support\Facades\Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => env('RECAPTCHA_SECRET_KEY'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip(),
        ]);

        if (!$response->json()['success']) {
            return back()->withInput()->withErrors(['g-recaptcha-response' => 'Verifikasi reCAPTCHA gagal. Silakan coba lagi.']);
        }

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

        // Generate OTP
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $otpExpiresAt = Carbon::now()->addMinutes(10);

        // Update data warga yang ada (tahap verifikasi)
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'otp' => $otp,
            'otp_expires_at' => $otpExpiresAt,
        ]);

        // Kirim Email OTP
        try {
            Mail::to($user->email)->send(new OtpVerificationMail($otp));
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['email' => 'Gagal mengirim email verifikasi. Pastikan email Anda benar atau hubungi admin. Error: ' . $e->getMessage()]);
        }

        // Simpan NIK di session untuk verifikasi
        session(['verify_nik' => $user->nik]);

        // Redirect ke form verifikasi
        return redirect()->route('register.verify.form')->with('success', 'Kode OTP telah dikirim ke email ' . $user->email);
    }

    public function showVerifyForm()
    {
        if (!session('verify_nik')) {
            return redirect()->route('register');
        }
        return view('auth.otp_verify');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6',
        ]);

        $nik = session('verify_nik');
        if (!$nik) {
            return redirect()->route('register');
        }

        $user = User::where('nik', $nik)->first();

        if (!$user || $user->otp !== $request->otp) {
            return back()->withErrors(['otp' => 'Kode OTP salah.']);
        }

        if (Carbon::now()->isAfter($user->otp_expires_at)) {
            return back()->withErrors(['otp' => 'Kode OTP sudah kadaluarsa. Silakan registrasi ulang atau klik kirim ulang.']);
        }

        // Aktivasi Akun
        $user->update([
            'is_registered' => true,
            'otp' => null,
            'otp_expires_at' => null,
            'email_verified_at' => Carbon::now(),
        ]);

        // Bersihkan session
        session()->forget('verify_nik');

        // Login otomatis
        Auth::login($user);

        return redirect()->route('users.dashboard')->with('success', 'Email berhasil diverifikasi! Selamat datang.');
    }
}
