<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Keterangan Ahli Waris</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.6;
            margin: 40px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #000;
            padding-bottom: 10px;
        }
        .header h2 {
            margin: 5px 0;
            font-size: 16pt;
            text-transform: uppercase;
        }
        .header p {
            margin: 3px 0;
            font-size: 10pt;
        }
        .title {
            text-align: center;
            margin: 30px 0 20px 0;
            text-decoration: underline;
            font-weight: bold;
            font-size: 14pt;
        }
        .content {
            text-align: justify;
            margin: 20px 0;
        }
        .data-table {
            margin: 20px 0 20px 40px;
        }
        .data-table tr td:first-child {
            width: 200px;
            vertical-align: top;
        }
        .data-table tr td:nth-child(2) {
            width: 10px;
            vertical-align: top;
        }
        .signature {
            margin-top: 50px;
            float: right;
            text-align: center;
            width: 250px;
        }
        .signature .name {
            margin-top: 70px;
            font-weight: bold;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Pemerintah Desa Sidodadi</h2>
        <h2>Kecamatan Candi</h2>
        <h2>Kabupaten Sidoarjo</h2>
        <p>Alamat: Jalan Raya Sidodadi No.1983, Sidodadi, Candi, Sudio, Sidodadi, Kec. Sidoarjo, Kabupaten Sidoarjo, Jawa Timur 61271</p>
    </div>

    <div class="title">
        SURAT KETERANGAN AHLI WARIS<br>
        Nomor: {{ $pengajuan->id }}/SKAW/{{ date('Y') }}
    </div>

    <div class="content">
        <p>Yang bertanda tangan di bawah ini Kepala Desa Sidodadi, Kecamatan Candi, 
        Kabupaten Sidoarjo, dengan ini menerangkan bahwa:</p>

        <p style="margin-top: 30px; font-weight: bold;">DATA AHLI WARIS (PEMOHON):</p>

        <table class="data-table">
            <tr>
                <td>Nama Lengkap</td>
                <td>:</td>
                <td>{{ $user->name }}</td>
            </tr>
            <tr>
                <td>NIK</td>
                <td>:</td>
                <td>{{ $user->nik }}</td>
            </tr>
            <tr>
                <td>Hubungan dengan Pewaris</td>
                <td>:</td>
                <td>{{ $detail['hubungan_pewaris'] ?? '-' }}</td>
            </tr>
        </table>

        <p style="margin-top: 30px; font-weight: bold;">DATA PEWARIS:</p>

        <table class="data-table">
            <tr>
                <td>Tanggal Meninggal</td>
                <td>:</td>
                <td>{{ $detail['tgl_kematian'] ?? '-' }}</td>
            </tr>
        </table>

        <p style="margin-top: 30px;">
            Adalah benar ahli waris yang sah dari pewaris yang telah meninggal dunia pada tanggal tersebut di atas.
        </p>

        <p>
            Demikian surat keterangan ahli waris ini dibuat dengan sebenarnya berdasarkan keterangan yang dapat 
            dipertanggungjawabkan dan dapat dipergunakan sebagaimana mestinya.
        </p>
    </div>

    <div class="signature">
        <p>Sidodadi, {{ now()->format('d F Y') }}</p>
        <p>Kepala Desa Sidodadi</p>
        <div class="name">
            [Nama Kepala Desa]
        </div>
    </div>
</body>
</html>
