<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpVerificationMail;
use Carbon\Carbon;

class UsersController extends Controller
{
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    /**
     * Menampilkan halaman dashboard untuk user (warga).
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        $stats = [
            'total_warga' => User::where('role', 'warga')->count(),
            'total_admin' => User::where('role', 'admin')->count(),
            'total_pengaduan' => \App\Models\Pengaduan::count(),
            'total_bantuan' => \App\Models\ProgramBantuan::count(),
            'luas_wilayah' => \App\Models\StatistikDesa::first()->luas_wilayah ?? 0,
        ];

        return view('users.dashboard', compact('stats'));
    }

    /**
     * Menampilkan halaman profil warga.
     */
    public function profile()
    {
        $user = Auth::user();
        return view('users.profil.profil', compact('user'));
    }

    /**
     * Memperbarui password warga (Step 1: Kirim OTP).
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ], [
            'password.min' => 'Password baru minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        $user = Auth::user();

        // Generate OTP
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $otpExpiresAt = Carbon::now()->addMinutes(10);

        // Update user OTP info
        $user->update([
            'otp' => $otp,
            'otp_expires_at' => $otpExpiresAt,
        ]);

        // Simpan password baru di session secara terenkripsi sementara
        session([
            'pending_new_password' => $request->password,
            'password_otp_requested' => true
        ]);

        // Kirim Email OTP
        try {
            Mail::to($user->email)->send(new OtpVerificationMail(
                $otp,
                'Ubah Password Simdesa Sidodadi',
                'Anda sedang mencoba untuk mengubah password akun Anda. Gunakan kode OTP di bawah ini untuk memverifikasi perubahan:'
            ));
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Gagal mengirim email verifikasi: ' . $e->getMessage()]);
        }

        return redirect()->route('users.profile.password.verify')->with('success', 'Kode OTP telah dikirim ke email ' . $user->email);
    }

    /**
     * Menampilkan form verifikasi OTP ubah password.
     */
    public function showPasswordVerifyForm()
    {
        if (!session('password_otp_requested')) {
            return redirect()->route('users.profile');
        }
        return view('users.profil.password_verify');
    }

    /**
     * Memverifikasi OTP dan mengupdate password (Step 2).
     */
    public function verifyPasswordUpdate(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6',
        ]);

        $user = Auth::user();

        if (!$user || $user->otp !== $request->otp) {
            return back()->withErrors(['otp' => 'Kode OTP salah.']);
        }

        if (Carbon::now()->isAfter($user->otp_expires_at)) {
            return back()->withErrors(['otp' => 'Kode OTP sudah kadaluarsa. Silakan coba lagi.']);
        }

        $newPassword = session('pending_new_password');

        if (!$newPassword) {
            return redirect()->route('users.profile')->withErrors(['error' => 'Sesi berakhir, silakan ulangi proses.']);
        }

        // Update password
        $user->update([
            'password' => Hash::make($newPassword),
            'otp' => null,
            'otp_expires_at' => null,
        ]);

        // Login ulang agar session tetap valid (opsional tapi bagus)
        Auth::login($user);

        // Bersihkan session
        session()->forget(['pending_new_password', 'password_otp_requested']);

        return redirect()->route('users.profile')->with('success', 'Password berhasil diperbarui!');
    }
}
