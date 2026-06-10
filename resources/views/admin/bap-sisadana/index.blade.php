@extends('layouts.app')

@section('content')

<style>
    body {
        font-family: "Times New Roman", serif;
        font-size: 14px;
        color: #000;
    }

    .print-area {
        width: 210mm;
        min-height: 297mm;
        margin: auto;
        background: white;
        padding: 40px;
    }

    .kop {
        text-align: center;
        font-weight: bold;
        font-size: 16px;
        margin-bottom: 10px;
    }

    .line {
        border-top: 2px solid black;
        margin-bottom: 20px;
    }

    .judul {
        text-align: center;
        font-weight: bold;
        font-size: 18px;
        margin-top: 10px;
    }

    .nomor {
        text-align: center;
        margin-bottom: 20px;
    }

    .isi {
        text-align: justify;
        line-height: 1.8;
    }

    .ttd {
        margin-top: 50px;
        width: 100%;
    }

    .ttd td {
        vertical-align: top;
        text-align: center;
        padding: 20px;
    }

    .nama {
        margin-top: 80px;
        font-weight: bold;
    }

    @media print {
        body {
            margin: 0;
        }
    }
</style>
<div class="relative inline-block text-left">
        <button type="button"
            onclick="toggleExportMenu()"
            class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg shadow-sm transition">
            Cetak Surat
            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M19 9l-7 7-7-7"/>
            </svg>
        </button>

        <div id="exportMenu"
            class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border z-50">

            <a href="{{ route('admin.bp-sisadana.pdf') }}"
                class="flex items-center gap-2 px-4 py-3 text-sm hover:bg-gray-100">
                Cetak PDF
            </a>

            <a href="{{ route('admin.bp-sisadana.word') }}"
                class="flex items-center gap-2 px-4 py-3 text-sm hover:bg-gray-100">
                Cetak Word
            </a>
        </div>
    </div>

<div class="print-area">

    {{-- KOP --}}
    <div class="kop">
        KOP SURAT SPPG
    </div>
    <div class="line"></div>

    {{-- JUDUL --}}
    <div class="judul">
        BERITA ACARA PENGALIHAN SISA DANA
    </div>

    <div class="nomor">
        Nomor: {{ $nomor_surat ?? '/BAPSD/' . now()->format('m') . '/' . now()->year }}
    </div>

    {{-- ISI --}}
    <div class="isi">
        Sehubungan dengan telah berakhirnya periode 
        <b>
        {{ \Carbon\Carbon::parse($periodeAwal)->translatedFormat('j') }}
        -
        {{ \Carbon\Carbon::parse($periodeAkhir)->translatedFormat('j F Y') }}
        </b>, 
        sisa dana sebesar <b>Rp Rp {{ number_format($totalSisa, 0, ',', '.') }},-</b> akan dialihkan ke periode selanjutnya 
        yang dimulai pada tanggal <b>{{ \Carbon\Carbon::parse($periodeAkhir)->addDay()->translatedFormat('j F Y') }}</b>.

        <br><br>

        Pengalihan sisa dana ini bertujuan untuk mendukung kegiatan yang direncanakan 
        pada periode berikutnya.
    </div>

    {{-- TTD --}}
    <table class="ttd" width="100%">
        <tr>
            <td width="50%" style="text-align:center; vertical-align:top;">
                <br>Pihak Pertama,<br>
                {{ $dapur->nama_yayasan }}

                <div style="height:80px;"></div>

                <div style="font-weight:bold; text-decoration:underline;">
                    {{ $dapur->ketua_yayasan }}
                </div>

                Ketua / Mewakili
            </td>

            <td width="50%" style="text-align:center; vertical-align:top;">
                {{ $dapur->tempat_pelaporan }},
                {{ now()->translatedFormat('d F Y') }}<br>

                Pihak Kedua,<br>
                Akuntan SPPG {{ $dapur->nama_lembaga }}

                <div style="height:80px;"></div>

                <div style="font-weight:bold; text-decoration:underline;">
                    {{ $dapur->nama_akuntan }}
                </div>
            </td>
        </tr>

        <tr>
            <td colspan="2" style="text-align:center; padding-top:50px;">
                Mengetahui,<br>
                Kepala SPPG {{ $dapur->nama_lembaga }}

                <div style="height:80px;"></div>

                <div style="font-weight:bold; text-decoration:underline;">
                    {{ $dapur->nama_kepala_sppg }}
                </div>
            </td>
        </tr>
    </table>

</div>

@endsection

<script>
function toggleExportMenu() {
    document.getElementById('exportMenu')
        .classList.toggle('hidden');
}

document.addEventListener('click', function(e) {
    const menu = document.getElementById('exportMenu');

    if (!e.target.closest('.relative')) {
        menu.classList.add('hidden');
    }
});
</script>