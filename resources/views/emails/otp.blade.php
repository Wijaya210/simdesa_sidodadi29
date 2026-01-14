<!DOCTYPE html>
<html>

<head>
    <title>Kode Verifikasi OTP</title>
</head>

<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px;">
        <h2 style="color: #007bff; text-align: center;">{{ $title }}</h2>
        <p>Halo,</p>
        <p>{{ $messageText }}</p>
        <div style="text-align: center; margin: 30px 0;">
            <span
                style="font-size: 32px; font-weight: bold; letter-spacing: 5px; background: #f4f4f4; padding: 10px 20px; border-radius: 5px; border: 1px solid #ccc;">
                {{ $otp }}
            </span>
        </div>
        <p>Kode ini akan kadaluarsa dalam 10 menit. Jika Anda tidak merasa melakukan hal ini, silakan abaikan email ini.
        </p>
        <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">
        <p style="font-size: 12px; color: #777; text-align: center;">
            &copy; {{ date('Y') }} Simdesa Sidodadi. All rights reserved.
        </p>
    </div>
</body>

</html>