<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Keterangan Riwayat Tanah</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
            line-height: 1.4;
            margin: 20px 40px;
        }

        .header {
            text-align: center;
            margin-bottom: 15px;
            border-bottom: 2px solid #000;
            padding-bottom: 5px;
        }

        .header h2 {
            margin: 2px 0;
            font-size: 14pt;
            text-transform: uppercase;
        }

        .header p {
            margin: 1px 0;
            font-size: 9pt;
        }

        .title {
            text-align: center;
            margin: 15px 0 10px 0;
            text-decoration: underline;
            font-weight: bold;
            font-size: 12pt;
        }

        .content {
            text-align: justify;
            margin: 10px 0;
        }

        .data-table {
            margin: 10px 0 10px 40px;
        }

        .data-table tr td:first-child {
            width: 180px;
            vertical-align: top;
        }

        .data-table tr td:nth-child(2) {
            width: 10px;
            vertical-align: top;
        }

        .signature {
            margin-top: 30px;
            float: right;
            text-align: center;
            width: 200px;
        }

        .signature .name {
            margin-top: 40px;
            font-weight: bold;
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="header">
        <table style="width: 100%; border-bottom: 2px solid #000; padding-bottom: 10px;">
            <tr>
                <td style="width: 90px; text-align: center;">
                    <img src="{{ public_path('images/gambar_logo_sidoarjo.png') }}" style="width: 80px; height: auto;">
                </td>
                <td style="text-align: center;">
                    <h2 style="margin: 0; font-size: 14pt;">PEMERINTAH KABUPATEN SIDOARJO</h2>
                    <h2 style="margin: 0; font-size: 14pt;">KECAMATAN CANDI</h2>
                    <h2 style="margin: 0; font-size: 16pt;">DESA SIDODADI</h2>
                    <p style="margin: 2px 0 0 0; font-size: 10pt;">
                        Jalan Raya Sidodadi No.1983, Sidodadi, Kec. Candi, Kabupaten Sidoarjo, Jawa Timur 61271
                    </p>
                </td>
            </tr>
        </table>
    </div>

    <div class="title">
        SURAT KETERANGAN RIWAYAT TANAH<br>
        Nomor: {{ $pengajuan->id }}/SKRT/{{ date('Y') }}
    </div>

    <div class="content">
        <p>Yang bertanda tangan di bawah ini Kepala Desa Sidodadi, Kecamatan Candi,
            Kabupaten Sidoarjo, dengan ini menerangkan bahwa:</p>

        <table class="data-table">
            <tr>
                <td>Nama Pemilik</td>
                <td>:</td>
                <td>{{ $user->name }}</td>
            </tr>
            <tr>
                <td>NIK</td>
                <td>:</td>
                <td>{{ $user->nik }}</td>
            </tr>
        </table>

        <p style="margin-top: 30px;">
            Adalah benar memiliki/menguasai sebidang tanah dengan keterangan sebagai berikut:
        </p>

        <table class="data-table">
            <tr>
                <td>Lokasi Tanah</td>
                <td>:</td>
                <td>{{ $detail['lokasi_tanah'] ?? '-' }}</td>
            </tr>
            <tr>
                <td>Luas Tanah</td>
                <td>:</td>
                <td>{{ $detail['luas_tanah'] ?? '-' }} m²</td>
            </tr>
        </table>

        <p style="margin-top: 30px;">
            Demikian surat keterangan ini dibuat dengan sebenarnya berdasarkan data yang ada di Desa Sidodadi
            dan dapat dipergunakan sebagaimana mestinya.
        </p>
    </div>

    <div class="signature">
        <p>Sidodadi, {{ now()->format('d F Y') }}</p>
        <p>Kepala Desa Sidodadi</p>
        @if($qrCode)
            <div style="margin: 10px 0;">
                <img src="data:image/svg+xml;base64,{{ $qrCode }}" width="80" alt="QR Code">
            </div>
        @endif
        <div class="name">
            [Nama Kepala Desa]
        </div>
    </div>
</body>

</html>