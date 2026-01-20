<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode Verifikasi OTP</title>
</head>

<body
    style="margin: 0; padding: 0; background-color: #f4f7f6; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td style="padding: 40px 0; text-align: center;">
                <!-- Main Container -->
                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%"
                    style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); overflow: hidden;">

                    <!-- Header -->
                    <tr>
                        <td style="background-color: #0d6efd; padding: 30px; text-align: center;">
                            <h1
                                style="color: #ffffff; margin: 0; font-size: 24px; font-weight: 700; letter-spacing: 1px;">
                                SIMDESA SIDODADI</h1>
                            <p style="color: #e0e0e0; margin: 5px 0 0; font-size: 14px;">Sistem Informasi Manajemen Desa
                            </p>
                        </td>
                    </tr>

                    <!-- Body Content -->
                    <tr>
                        <td style="padding: 40px 30px;">
                            <h2 style="color: #333333; margin-top: 0; font-size: 20px; text-align: center;">{{ $title }}
                            </h2>
                            <p
                                style="color: #666666; font-size: 16px; line-height: 1.6; text-align: center; margin-bottom: 30px;">
                                {{ $messageText }}
                            </p>

                            <!-- OTP Box -->
                            <div
                                style="background-color: #f8f9fa; border-radius: 8px; padding: 20px; text-align: center; margin-bottom: 30px; border: 2px dashed #0d6efd;">
                                <span
                                    style="font-size: 36px; font-weight: 800; letter-spacing: 8px; color: #0d6efd; display: block;">{{ $otp }}</span>
                            </div>

                            <p style="color: #666666; font-size: 14px; line-height: 1.5; text-align: center;">
                                Kode ini hanya berlaku selama <strong>10 menit</strong>. <br>
                                Mohon jangan bagikan kode ini kepada siapapun, termasuk pihak desa.
                            </p>

                            <div
                                style="margin-top: 30px; border-top: 1px solid #eeeeee; padding-top: 20px; text-align: center;">
                                <p style="color: #999999; font-size: 13px; margin: 0;">
                                    Jika Anda tidak merasa melakukan pendaftaran ini, silakan abaikan email ini.
                                </p>
                            </div>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td
                            style="background-color: #f8f9fa; padding: 20px; text-align: center; border-top: 1px solid #eeeeee;">
                            <p style="color: #888888; font-size: 12px; margin: 0;">
                                &copy; {{ date('Y') }} Pemerintah Desa Sidodadi. <br>
                                All rights reserved.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>