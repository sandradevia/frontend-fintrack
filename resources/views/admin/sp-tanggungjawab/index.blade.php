@extends('layouts.app')

@section('content')

<style>
    body {
        font-family: 'Times New Roman', serif;
        font-size: 12pt;
        color: #000;
        line-height: 1.6;
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
        margin-bottom: 25px;
    }

    .judul {
        text-align: center;
        font-weight: bold;
        font-size: 16pt;
        margin-bottom: 25px;
        text-transform: uppercase;
    }

    .table-identitas td {
        padding: 3px 5px;
        vertical-align: top;
    }

    .text-justify {
        text-align: justify;
    }

    .section {
        margin-top: 15px;
    }

    .rincian td {
        padding: 5px 5px;
    }

    .rincian .nomor {
        width: 30px;
    }

    .rincian .label {
        width: 250px;
    }

    .rincian .value {
        text-align: right;
        width: 200px;
    }

    .bold {
        font-weight: bold;
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

{{-- 🔘 BUTTON PRINT --}}
<div class="no-print">
    <button onclick="window.print()" class="bg-blue-500 text-white px-4 py-2 rounded">
        Print / Save PDF
    </button>
</div>

<div class="page">

    {{-- 🔷 KOP --}}
    <div class="kop">
        <h3>KOP SURAT SPPG</h3>
    </div>

    {{-- 🔷 JUDUL --}}
    <div class="judul">
        SURAT PERNYATAAN TANGGUNG JAWAB
    </div>

    {{-- 🔷 PEMBUKA --}}
    <div class="section">
        Saya yang bertanda tangan di bawah ini:
    </div>

    {{-- 🔷 IDENTITAS --}}
    <div class="section">
        <table class="table-identitas">
            <tr>
                <td width="120">Nama</td>
                <td>: {{ $dapur->nama_kepala_sppg }}</td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td>: Kepala SPPG {{ $dapur->nama_lembaga }}</td>
            </tr>
        </table>
    </div>

    {{-- 🔷 ISI --}}
    <div class="section text-justify">
        menyatakan bertanggung jawab secara formal dan material atas penerimaan dan pengeluaran dana yang 
        dilaksanakan dengan menggunakan dana APBN TA {{ now()->year }} melalui DIPA Badan Gizi Nasional TA {{ now()->year }}, 
        dengan mata anggaran sebagai Bantuan Pemerintah untuk Program Makan Bergizi Gratis. 
        Sebagaimana Surat Pernyataan Tanggung Jawab penggunaan anggaran 
        <strong>Bahan Baku / Operasional / Insentif Fasilitas</strong> 
        beserta bukti-bukti pengeluaran yang sah dengan rincian:
    </div>

    {{-- 🔷 RINCIAN --}}
    <div class="section">
        <table class="rincian">
            <tr>
                <td class="nomor">1.</td>
                <td class="label">Jumlah Penerimaan</td>
                <td>:</td>
                <td class="value">{{ $danaMasuk }}</td>
            </tr>
            <tr>
                <td class="nomor">2.</td>
                <td class="label">Jumlah Pengeluaran</td>
                <td>:</td>
                <td class="value">{{ $totalPengeluaran }}</td>
            </tr>
            <tr class="bold">
                <td class="nomor">3.</td>
                <td class="label">Sisa Dana</td>
                <td>:</td>
                <td class="value">{{ $sisaDana }}</td>
            </tr>
        </table>
    </div>

    {{-- 🔷 PENUTUP --}}
    <div class="section text-justify">
        Demikian surat ini saya buat untuk dapat dipergunakan sebagaimana mestinya dan untuk dapat 
        dipertanggungjawabkan.
    </div>

    {{-- 🔷 TTD --}}
    <table class="ttd">
        <tr>
            <td></td>
            <td>
                {{ $dapur->tempat_pelaporan }}, {{ now()->translatedFormat('d F Y') }}<br>
                Mengetahui,<br>
                Kepala SPPG {{ $dapur->nama_lembaga }}<br><br><br><br>
                <strong>{{ $dapur->nama_kepala_sppg }}</strong>
            </td>
        </tr>
    </table>

</div>

@endsection