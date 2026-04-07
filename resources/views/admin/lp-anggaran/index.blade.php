@extends('layouts.app')

@section('content')

<style>
    body {
        font-family: 'Times New Roman', serif;
        font-size: 12pt;
        color: #000;
    }

    .page {
        width: 210mm;
        min-height: 297mm;
        margin: auto;
        background: white;
        padding: 30px;
    }

    .kop {
        text-align: center;
        border-bottom: 3px solid black;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }

    .judul {
        text-align: center;
        margin-top: 10px;
        margin-bottom: 10px;
    }

    .judul h2 {
        font-weight: bold;
        text-transform: uppercase;
        margin-bottom: 5px;
    }

    .nomor {
        display: inline-block;
        padding: 3px 10px;
        border: 1px solid black;
        font-size: 11pt;
    }

    .section {
        margin-top: 20px;
    }

    .table-info td {
        padding: 3px 5px;
    }

    table.laporan {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    table.laporan th,
    table.laporan td {
        border: 1px solid black;
        padding: 6px;
    }

    table.laporan th {
        background: #f0f0f0;
        text-align: center;
    }

    .text-right {
        text-align: right;
    }

    .total-row {
        font-weight: bold;
        border-top: 2px solid black;
    }

    .ttd {
        margin-top: 60px;
        width: 100%;
    }

    .ttd td {
        text-align: center;
        vertical-align: top;
        padding-top: 40px;
    }

    .no-print {
        margin-bottom: 15px;
    }

    @media print {
        .no-print {
            display: none;
        }
    }
</style>

<div class="no-print">
    <button onclick="window.print()" class="bg-blue-500 text-white px-4 py-2 rounded">
        Print / Save PDF
    </button>
</div>

<div class="page">

    {{-- 🔷 KOP --}}
    <div class="kop">
        <h3>KOP SURAT SPPG</h3>
        <small>Alamat Instansi / Kontak</small>
    </div>

    {{-- 🔷 JUDUL --}}
    <div class="judul">
        <h2>LAPORAN PENGGUNAAN ANGGARAN</h2>
        <div class="nomor">Nomor : 01/LPA/2025</div>
    </div>

    {{-- 🔷 PERIODE --}}
    <div class="section">
        <strong>Periode :</strong> 1 - 13 Desember 2025
    </div>

    {{-- 🔷 IDENTITAS --}}
    <div class="section">
        <p>Yang bertanda tangan di bawah ini:</p>

        <table class="table-info">
            <tr>
                <td width="150">Nama</td>
                <td>: Sutiono</td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td>: Kepala Satuan Pelayanan Pemenuhan Gizi / Ketua Yayasan</td>
            </tr>
            <tr>
                <td>SPPG</td>
                <td>: SPPG GADOG MEGAMENDUNG</td>
            </tr>
        </table>
    </div>

    {{-- 🔷 DESKRIPSI --}}
    <div class="section">
        Dengan ini menyatakan bahwa laporan penggunaan dana sebagai berikut:
    </div>

    {{-- 🔷 TABEL --}}
    <div class="section">
        <strong>I. RINCIAN KEGIATAN</strong>

        <table class="laporan">
            <thead>
                <tr>
                    <th>Rincian Kegiatan</th>
                    <th>Dana Diajukan (Rp)</th>
                    <th>Dana Terealisasi</th>
                    <th>Sisa Dana (Rp)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Bahan Baku</td>
                    <td class="text-right">331.316.000</td>
                    <td class="text-right">34.800.000</td>
                    <td class="text-right">296.516.000</td>
                </tr>
                <tr>
                    <td>Operasional</td>
                    <td class="text-right">117.092.000</td>
                    <td class="text-right">34.400.000</td>
                    <td class="text-right">82.692.000</td>
                </tr>
                <tr>
                    <td>Sewa</td>
                    <td class="text-right">72.000.000</td>
                    <td class="text-right">72.000.000</td>
                    <td class="text-right">-</td>
                </tr>
                <tr class="total-row">
                    <td>Total</td>
                    <td class="text-right">520.408.000</td>
                    <td class="text-right">141.200.000</td>
                    <td class="text-right">379.208.000</td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- 🔷 KETERANGAN --}}
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
            <tr>
                <td>Nomor Rekening</td>
                <td>: 12345</td>
            </tr>
        </table>

        <p style="margin-top:10px;">
            Sisa dana sebesar <strong>Rp 379.208.000</strong> akan dialihkan ke periode selanjutnya.
        </p>

        <p>
            Pengalihan sisa dana ini bertujuan untuk mendukung kegiatan yang telah direncanakan.
        </p>
    </div>

    {{-- 🔷 TTD --}}
    <table class="ttd">
        <tr>
            <td>
                Pihak Pertama,<br>
                Yayasan Bakti Nusa<br><br><br><br>
                <strong>Bakri</strong><br>
                Ketua / Mewakili
            </td>
            <td>
                Gadog, 13 Desember 2025<br>
                Pihak Kedua,<br>
                Akuntan SPPG<br><br><br><br>
                <strong>Riyanto</strong>
            </td>
        </tr>

        <tr>
            <td colspan="2" style="padding-top:50px;">
                Mengetahui,<br>
                Kepala SPPG GADOG MEGAMENDUNG<br><br><br><br>
                <strong>Sutiono</strong>
            </td>
        </tr>
    </table>

</div>

@endsection