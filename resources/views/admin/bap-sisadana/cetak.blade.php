<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Berita Acara Pengalihan Sisa Dana</title>

    <style>
        body {
            font-family: "Times New Roman", serif;
            font-size: 14px;
            color: #000;
            line-height: 1.8;

            margin-top: 1.5cm;
            margin-bottom: 1.5cm;
            margin-left: 2cm;
            margin-right: 1.5cm;

        }

        .print-area {
            width: 100%;
        }

        .kop {
            text-align: center;
        }

        .kop h2 {
            margin: 0;
            font-size: 18px;
        }

        .kop p {
            margin: 2px 0;
            font-size: 13px;
        }

        .line {
            border-top: 2px solid #000;
            margin: 15px 0 25px;
        }

        .judul {
            text-align: center;
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 5px;
        }

        .nomor {
            text-align: center;
            margin-bottom: 25px;
        }

        .isi {
            text-align: justify;
            text-indent: 40px;
        }

        .ttd {
            width: 100%;
            margin-top: 30px;
        }

        .ttd td {
            vertical-align: top;
            text-align: center;
        }

        .nama-ttd {
            margin-top: 80px;
            font-weight: bold;
            text-decoration: underline;
        }
    </style>
</head>

<body>

@php
    $awal = \Carbon\Carbon::parse($periodeAwal);
    $akhir = \Carbon\Carbon::parse($periodeAkhir);

    if (
        $awal->month == $akhir->month &&
        $awal->year == $akhir->year
    ) {
        $periodeText =
            $awal->format('j') .
            ' - ' .
            $akhir->translatedFormat('j F Y');
    } else {
        $periodeText =
            $awal->translatedFormat('j F Y') .
            ' - ' .
            $akhir->translatedFormat('j F Y');
    }

    $periodeBerikutnya =
        $akhir->copy()->addDay()->translatedFormat('j F Y');
@endphp

<div class="print-area">

    {{-- KOP --}}
    <div class="kop">
        <h2>{{ strtoupper($dapur->nama_lembaga ?? 'SPPG') }}</h2>

        @if(!empty($dapur->alamat))
            <p>{{ $dapur->alamat }}</p>
        @endif
    </div>

    <div class="line"></div>

    {{-- JUDUL --}}
    <div class="judul">
        BERITA ACARA PENGALIHAN SISA DANA
    </div>

    <div class="nomor">
        Nomor:
        {{ $nomor_surat ?? '001/BAPSD/' . now()->format('m') . '/' . now()->year }}
    </div>

    {{-- ISI --}}
    <div class="isi">
        Sehubungan dengan telah berakhirnya periode
        <strong>{{ $periodeText }}</strong>,

        berdasarkan hasil pelaksanaan kegiatan dan realisasi penggunaan anggaran,
        terdapat sisa dana sebesar

        <strong>
            Rp {{ number_format($totalSisa ?? 0, 0, ',', '.') }},-
        </strong>

        yang akan dialihkan ke periode selanjutnya yang dimulai pada tanggal

        <strong>{{ $periodeBerikutnya }}</strong>.

        <br><br>

        Pengalihan sisa dana ini dilakukan untuk mendukung keberlanjutan kegiatan,
        operasional, dan program kerja yang telah direncanakan pada periode
        berikutnya sesuai dengan ketentuan yang berlaku.

        <br><br>

        Demikian Berita Acara Pengalihan Sisa Dana ini dibuat dengan sebenarnya
        untuk dapat dipergunakan sebagaimana mestinya.
    </div>

    {{-- TTD --}}
    <table class="ttd">
        <tr>
            <td width="50%">
                <br>
                Pihak Pertama,<br>
                {{ $dapur->nama_yayasan ?? 'Yayasan' }}

                <div class="nama-ttd">
                    {{ $dapur->ketua_yayasan ?? '__________________' }}
                </div>

                Ketua / Mewakili
            </td>

            <td width="50%">
                {{ $dapur->tempat_pelaporan ?? '-' }},
                {{ now()->translatedFormat('d F Y') }}

                <br>

                Pihak Kedua,<br>
                Akuntan SPPG {{ $dapur->nama_lembaga }}

                <div class="nama-ttd">
                    {{ $dapur->nama_akuntan ?? '__________________' }}
                </div>
            </td>
        </tr>

        <tr>
            <td colspan="2" style="padding-top:50px; text-align:center;">
                Mengetahui,<br>
                Kepala SPPG {{ $dapur->nama_lembaga }}

                <div class="nama-ttd">
                    {{ $dapur->nama_kepala_sppg ?? '__________________' }}
                </div>
            </td>
        </tr>
    </table>

</div>

</body>
</html>