<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Penggunaan Anggaran</title>

    <style>
        body{
            font-family: "Times New Roman", serif;
            font-size: 12pt;
            line-height: 1.5;
            margin: 30px;
        }

        .kop{
            text-align:center;
            border-bottom:3px solid black;
            padding-bottom:10px;
            margin-bottom:20px;
        }

        .kop h2{
            margin:0;
            font-size:18pt;
        }

        .kop p{
            margin:2px 0;
            font-size:11pt;
        }

        .judul{
            text-align:center;
            margin:20px 0;
        }

        .judul h3{
            margin:0;
            text-decoration:underline;
        }

        .info{
            margin-bottom:20px;
        }

        .info table{
            border:none;
        }

        .info td{
            padding:3px;
        }

        .laporan{
            width:100%;
            margin-top:10px;
        }

        .laporan th,
        .laporan td{
            padding:8px;
        }

        .laporan th{
        }

        .text-right{
            text-align:right;
        }

        .kesimpulan{
            margin-top:20px;
            text-align:justify;
        }

        .ttd{
            margin-top:50px;
            width:100%;
        }

        .ttd td{
            width:50%;
            text-align:center;
            vertical-align:top;
        }

        .nama{
            margin-top:70px;
            font-weight:bold;
            text-decoration:underline;
        }
    </style>
</head>

<body>

    {{-- KOP --}}
    <div class="kop">
        <h3 style="margin:0; font-size:14pt;">{{ strtoupper($dapur->nama_lembaga ?? 'SPPG') }}</h3>
        <small>{{ $dapur->alamat ?? 'Alamat Instansi' }}</small>
        @if($dapur->telepon ?? null)
            <br><small>Telp: {{ $dapur->telepon }}</small>
        @endif
    </div>

    {{-- JUDUL --}}
    <div class="judul">
        <h2>LAPORAN PENGGUNAAN ANGGARAN</h2>
        <div class="nomor">Nomor : {{ $dapur->kode_dapur ?? '—' }}/LPA/{{ date('Y') }}</div>
    </div>

    {{-- PERIODE --}}
    <div class="section">
        <strong>Periode :</strong> {{ $periodeAwal }} &ndash; {{ $periodeAkhir }}
    </div>

    {{-- IDENTITAS --}}
    <div class="section">
        <p>Yang bertanda tangan di bawah ini:</p>

        <table class="table-info">
            <tr>
                <td width="160">Nama</td>
                <td>: {{ $dapur->nama_kepala_sppg ?? '-' }}</td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td>: Kepala Satuan Pelayanan Pemenuhan Gizi / Ketua Yayasan</td>
            </tr>
            <tr>
                <td>SPPG</td>
                <td>: {{ strtoupper($dapur->nama_lembaga ?? '—') }}</td>
            </tr>
        </table>
    </div>

    {{-- DESKRIPSI --}}
    <div class="section">
        Dengan ini menyatakan bahwa laporan penggunaan dana adalah sebagai berikut:
    </div>

    {{-- TABEL RINCIAN --}}
    <div class="section">
        <strong>I. RINCIAN KEGIATAN</strong>

        <table class="laporan">
            <thead>
                <tr>
                    <th>Rincian Kegiatan</th>
                    <th>Dana Diajukan (Rp)</th>
                    <th>Dana Terealisasi (Rp)</th>
                    <th>Sisa Dana (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rincian as $row)
                    <tr>
                        <td>{{ $row['label'] }}</td>
                        <td class="text-right">
                            {{ number_format($row['diajukan'], 0, ',', '.') }}
                        </td>
                        <td class="text-right">
                            {{ number_format($row['terealisasi'], 0, ',', '.') }}
                        </td>
                        <td class="text-right">
                            @if ($row['sisa'] < 0)
                                <span style="color:red;">({{ number_format(abs($row['sisa']), 0, ',', '.') }})</span>
                            @elseif ($row['sisa'] == 0)
                                —
                            @else
                                {{ number_format($row['sisa'], 0, ',', '.') }}
                            @endif
                        </td>
                    </tr>
                @endforeach

                {{-- TOTAL --}}
                <tr class="total-row">
                    <td>Total</td>
                    <td class="text-right">{{ number_format($totalDiajukan, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($totalTerealisasi, 0, ',', '.') }}</td>
                    <td class="text-right">
                        @if ($totalSisa < 0)
                            <span style="color:red;">({{ number_format(abs($totalSisa), 0, ',', '.') }})</span>
                        @else
                            {{ number_format($totalSisa, 0, ',', '.') }}
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- KETERANGAN --}}
    <div class="section">
        <strong>II. KETERANGAN</strong>
        <p>
            Dana yang telah digunakan sesuai dengan kebutuhan kegiatan yang telah direncanakan,
            dengan rincian sebagai berikut:
        </p>

        <table class="table-info">
            <tr>
                <td width="200">Bahan Baku</td>
                <td>: Pengadaan bahan baku utama untuk pelaksanaan kegiatan</td>
            </tr>
            <tr>
                <td>Operasional</td>
                <td>: Biaya transportasi, ATK, konsumsi, dan keperluan teknis lainnya</td>
            </tr>
            <tr>
                <td>Insentif Fasilitas</td>
                <td>: Bangunan, mobil, dll</td>
            </tr>
            @if ($dapur->no_rekening ?? null)
            <tr>
                <td>Nomor Rekening</td>
                <td>: {{ $dapur->no_rekening }}</td>
            </tr>
            @endif
        </table>

        <p style="margin-top:10px;">
            Sisa dana sebesar <strong>Rp {{ number_format($totalSisa, 0, ',', '.') }}</strong>
            akan dialihkan ke periode selanjutnya.
        </p>
        <p>
            Pengalihan sisa dana ini bertujuan untuk mendukung kegiatan yang telah direncanakan.
        </p>
    </div>

    {{-- TTD --}}
    <table class="ttd">
        <tr>
            <td><br>
                Pihak Pertama,<br>
                {{ $dapur->nama_yayasan ?? 'Yayasan' }}<br><br><br><br>
                <strong>{{ $dapur->ketua_yayasan ?? '____________________' }}</strong><br>
                Ketua / Mewakili
            </td>
            <td>
                {{ $dapur->tempat_pelaporan ?? 'Kota' }},
                {{ \Carbon\Carbon::parse($periodeAkhirRaw)->translatedFormat('j F Y') }}<br>
                Pihak Kedua,<br>
                Akuntan SPPG<br><br><br><br>
                <strong>{{ $dapur->nama_akuntan ?? '____________________' }}</strong>
            </td>
        </tr>

        <tr>
            <td colspan="2" style="padding-top:50px; text-align:center;">
                Mengetahui,<br>
                Kepala {{ strtoupper($dapur->nama_lembaga ?? 'SPPG') }}<br><br><br><br>
                <strong>{{ $dapur->nama_kepala_sppg ?? '____________________' }}</strong>
            </td>
        </tr>
    </table>
    </body>
</html>