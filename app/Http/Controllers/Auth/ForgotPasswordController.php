<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpVerificationMail;
use Carbon\Carbon;
use Illuminate\Validation\Rules\Password;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.forgot_password');
    }

    public function sendResetOtp(Request $request)
    {
        $request->validate([
            'identifier' => 'required|string', // Bisa Email atau NIK
        ]);

        $user = User::where('email', $request->identifier)
            ->orWhere('nik', $request->identifier)
            ->first();

        if (!$user) {
            return back()->withErrors(['identifier' => 'Data tidak ditemukan. Pastikan Email atau NIK sudah terdaftar.']);
        }

        if (!$user->email) {
            return back()->withErrors(['identifier' => 'Akun ini belum memiliki email terdaftar. Silakan hubungi admin.']);
        }

        // Generate OTP
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $otpExpiresAt = Carbon::now()->addMinutes(10);

        // Simpan OTP ke user
        $user->update([
            'otp' => $otp,
            'otp_expires_at' => $otpExpiresAt,
        ]);

        // Kirim Email OTP
        try {
            Mail::to($user->email)->send(new OtpVerificationMail(
                $otp,
                'Reset Password Simdesa Sidodadi',
                'Anda telah meminta pengaturan ulang kata sandi. Gunakan kode OTP di bawah ini untuk melanjutkan:'
            ));
        } catch (\Exception $e) {
            return back()->withErrors(['identifier' => 'Gagal mengirim email. Silakan coba lagi nanti.']);
        }

        // Simpan info ke session
        session(['reset_nik' => $user->nik]);

        return redirect()->route('password.reset.form')->with('success', 'Kode OTP reset password telah dikirim ke email ' . $user->email);
    }

    public function showResetForm()
    {
        if (!session('reset_nik')) {
            return redirect()->route('password.request');
        }
        return view('auth.reset_password');
    }

    public function reset(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $nik = session('reset_nik');
        $user = User::where('nik', $nik)->first();

        if (!$user || $user->otp !== $request->otp) {
            return back()->withErrors(['otp' => 'Kode OTP salah.']);
        }

        if (Carbon::now()->isAfter($user->otp_expires_at)) {
            return back()->withErrors(['otp' => 'Kode OTP sudah kadaluarsa. Silakan minta kode baru.']);
        }

        // Update Password
        $user->update([
            'password' => Hash::make($request->password),
            'otp' => null,
            'otp_expires_at' => null,
        ]);

        // Bersihkan session
        session()->forget('reset_nik');

        return redirect()->route('login')->with('success', 'Password berhasil diubah. Silakan login dengan password baru Anda.');
    }
}
