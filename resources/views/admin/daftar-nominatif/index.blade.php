@extends('layouts.app')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

    .nom-wrap * { font-family: 'Plus Jakarta Sans', sans-serif; }

    /* ── Table cells ── */
    .nom-table { border-collapse: collapse; min-width: 1400px; font-size: 0.78rem; }
    .nom-table th, .nom-table td {
        border: 1px solid #e2e8f0;
        padding: 7px 10px;
        white-space: nowrap;
    }
    .dark .nom-table th, .dark .nom-table td { border-color: #334155; }

    .nom-table thead th {
        background: #f8fafc;
        color: #475569;
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: .04em;
        text-transform: uppercase;
        position: sticky;
        top: 0;
        z-index: 10;
    }
    .dark .nom-table thead th { background: #1e293b; color: #94a3b8; }

    .nom-table tbody tr { transition: background .12s; }
    .nom-table tbody tr:hover { background: #f0f7ff; }
    .dark .nom-table tbody tr:hover { background: rgba(59,130,246,.07); }

    /* Category label cell */
    .nom-table td.cat-cell {
        font-weight: 600;
        color: #1e293b;
        background: #f8fafc;
        font-size: 0.75rem;
        letter-spacing: .02em;
    }
    .dark .nom-table td.cat-cell { background: #1e293b; color: #e2e8f0; }

    /* Total row */
    .nom-table tr.total-row td {
        background: #1e40af;
        color: #fff;
        font-weight: 700;
        font-size: 0.75rem;
    }

    /* Number cells */
    .nom-table td.num { text-align: right; font-variant-numeric: tabular-nums; color: #334155; }
    .dark .nom-table td.num { color: #cbd5e1; }
    .nom-table .total-row td.num { color: #bfdbfe; }

    /* Day cells */
    .nom-table td.day-cell { text-align: center; color: #64748b; }
    .nom-table .total-row td.day-cell { text-align: right; }

    /* No cell */
    .nom-table td.no-cell { text-align: center; width: 36px; color: #94a3b8; font-weight: 600; }

    /* ── Modal ── */
    @keyframes backdropIn  { from { opacity:0; } to { opacity:1; } }
    @keyframes cardSlideUp { from { transform:translateY(16px) scale(.97); opacity:0; }
                              to  { transform:translateY(0)     scale(1);   opacity:1; } }
    .nom-backdrop { animation: backdropIn .18s ease; }
    .nom-card     { animation: cardSlideUp .22s cubic-bezier(.32,1,.28,1); }

    /* ── Input / Label ── */
    .nom-label {
        display: block;
        font-size: 0.68rem;
        font-weight: 700;
        letter-spacing: .06em;
        text-transform: uppercase;
        color: #64748b;
        margin-bottom: .3rem;
    }
    .dark .nom-label { color: #94a3b8; }

    .nom-input {
        width: 100%;
        padding: .5rem .8rem;
        border-radius: .6rem;
        border: 1.5px solid #e2e8f0;
        background: #f8fafc;
        font-size: .835rem;
        color: #0f172a;
        transition: border-color .18s, box-shadow .18s;
        outline: none;
    }
    .nom-input:focus {
        border-color: #3b82f6;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(59,130,246,.12);
    }
    .dark .nom-input {
        background: #1e293b;
        border-color: #334155;
        color: #f1f5f9;
    }
    .dark .nom-input:focus { border-color: #60a5fa; background: #0f172a; }

    /* Section divider */
    .nom-section-title {
        font-size: .65rem;
        font-weight: 700;
        letter-spacing: .08em;
        text-transform: uppercase;
        color: #94a3b8;
        display: flex;
        align-items: center;
        gap: .5rem;
        margin-bottom: .75rem;
    }
    .nom-section-title::after { content:''; flex:1; height:1px; background:#e2e8f0; }
    .dark .nom-section-title::after { background:#334155; }

    /* Day columns header highlight */
    .day-header { background: #eff6ff !important; color: #2563eb !important; }
    .dark .day-header { background: rgba(37,99,235,.15) !important; color: #93c5fd !important; }

    /* Badge */
    .nom-badge {
        display: inline-flex; align-items: center; gap: .3rem;
        padding: .2rem .7rem; border-radius: 99px;
        font-size: .68rem; font-weight: 700; letter-spacing: .04em;
    }

    /* Scrollable table container — scroll HANYA di dalam box ini */
    .nom-scroll {
        overflow-x: auto;
        overflow-y: visible;
        max-width: 100%;
        /* Pastikan parent tidak overflow ke halaman */
        display: block;
    }
    .nom-scroll::-webkit-scrollbar { height: 6px; }
    .nom-scroll::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 99px; }
    .nom-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 99px; }
    .nom-scroll::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

    /* Paksa wrapper card tidak meluber */
    .nom-wrap { max-width: 100%; overflow: hidden; }
</style>

<div class="nom-wrap space-y-6 w-full min-w-0">

    {{-- ── HEADER ── --}}
    <div class="flex items-center justify-between flex-wrap gap-3">
        <div>
            <x-common.page-breadcrumb pageTitle="Daftar Nominatif" />
            <p class="text-xs text-gray-400 mt-0.5">Pembayaran upah sukarelawan per periode</p>
        </div>

        <div class="flex items-center gap-2">
            {{-- Export --}}
            <a href="{{ route('admin.daftar-nominatif.export.excel') }}"
            class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 dark:bg-emerald-900/30 dark:text-emerald-400 dark:hover:bg-emerald-900/50 rounded-xl border border-emerald-200 dark:border-emerald-800 transition active:scale-95">

                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>

                Cetak Excel
            </a>

            {{-- Tambah Entri --}}
            <button onclick="openModal()"
                class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-md shadow-blue-200 dark:shadow-none transition active:scale-95">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Entri
            </button>
        </div>
    </div>

    {{-- ── DOCUMENT HEADER CARD ── --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm overflow-hidden w-full min-w-0">

        {{-- Document info bar --}}
        <div class="flex flex-wrap items-center gap-4 px-6 py-4 border-b border-gray-100 dark:border-gray-800 bg-gradient-to-r from-blue-600 to-indigo-600">
            <div class="flex-1 min-w-0">
                <h2 class="text-base font-bold text-white tracking-tight">DAFTAR NOMINATIF</h2>
                <p class="text-blue-100 text-xs font-medium">Pembayaran Upah Sukarelawan</p>
            </div>
            <div class="flex flex-wrap gap-3 text-xs text-white/80">
                <span class="flex items-center gap-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Periode:
                    <strong class="text-white ml-1">
                        @if($periodeAktif)
                            {{ \Carbon\Carbon::parse($periodeAktif->tanggal_mulai)->translatedFormat('d F Y') }}
                            -
                            {{ \Carbon\Carbon::parse($periodeAktif->tanggal_selesai)->translatedFormat('d F Y') }}
                        @else
                            <span>Periode belum tersedia</span>
                        @endif
                    </strong>
                </span>
            </div>
        </div>

        {{-- Summary stat chips --}}
        <div class="flex flex-wrap gap-4 px-6 py-4 border-b border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-800/40">
            <div class="flex items-center gap-2">
                <span class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/40 flex items-center justify-center text-blue-600 dark:text-blue-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"/></svg>
                </span>
                <div>
                    <p class="text-xs text-gray-500">Total Personil</p>
                    <p class="text-sm font-bold text-gray-800 dark:text-gray-100">{{ $nominatifs->count() }} Orang</p>
                </div>
            </div>
            <div class="w-px bg-gray-200 dark:bg-gray-700 self-stretch"></div>
            <div class="flex items-center gap-2">
                <span class="w-8 h-8 rounded-lg bg-emerald-100 dark:bg-emerald-900/40 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </span>
                <div>
                    <p class="text-xs text-gray-500">Total Pembayaran</p>
                    <p class="text-sm font-bold text-gray-800 dark:text-gray-100">Rp {{ number_format($nominatifs->sum('total'),0,',','.') }}</p>
                </div>
            </div>
            <div class="w-px bg-gray-200 dark:bg-gray-700 self-stretch"></div>
            <div class="flex items-center gap-2">
                <span class="w-8 h-8 rounded-lg bg-amber-100 dark:bg-amber-900/40 flex items-center justify-center text-amber-600 dark:text-amber-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </span>
                <div>
                    <p class="text-xs text-gray-500">Hari Kerja</p>
                    <p class="text-sm font-bold text-gray-800 dark:text-gray-100">{{ $nominatifs->sum(fn($n) => $n->kehadiranNominatif->count()) }} Hari</p>
                </div>
            </div>
        </div>

        {{-- ── TABLE ── --}}
        <div class="w-full min-w-0 p-1">
        <div class="nom-scroll">
            <table class="nom-table w-full">

                <thead>
                    <tr>
                        <th rowspan="2">No</th>
                        <th rowspan="2">Jenis</th>
                        <th rowspan="2">Nama</th>

                        <th colspan="{{ count($tanggalKerja) }}" class="day-header">
                            {{ $bulan }} {{ $tahun }}
                        </th>

                        <th rowspan="2">Honor</th>
                        <th rowspan="2">Dana Sehat</th>
                        <th rowspan="2">TK</th>
                        <th rowspan="2">Pajak</th>
                        <th rowspan="2">Total</th>
                        <th rowspan="2">Aksi</th>
                    </tr>

                    <tr>
                        @foreach($tanggalKerja as $tanggal)
                            <th class="text-center">
                                {{ \Carbon\Carbon::parse($tanggal)->format('d') }}
                            </th>
                        @endforeach
                    </tr>
                </thead>

                <tbody>

                @forelse($nominatifs as $item)

                    <tr>

                        <td class="text-center">
                            {{ $loop->iteration }}
                        </td>

                        <td>
                            {{ $item->anggota->pekerjaan->nama_pekerjaan ?? '-' }}
                        </td>

                        <td>
                            {{ $item->anggota->nama ?? '-' }}
                        </td>

                        @foreach($tanggalKerja as $tanggal)

                            @php
                                $kehadiran = $item->kehadiranNominatif
                                    ->where('tanggal', $tanggal)
                                    ->first();
                            @endphp

                            <td class="text-center text-xs">

                                @if($kehadiran)

                                    Rp {{ number_format($kehadiran->honor_harian,0,',','.') }}

                                @else

                                    -

                                @endif

                            </td>

                        @endforeach

                        <td class="text-right">
                            Rp {{ number_format($item->honor,0,',','.') }}
                        </td>

                        <td class="text-right">
                            Rp {{ number_format($item->dana_sehat,0,',','.') }}
                        </td>

                        <td class="text-right">
                            Rp {{ number_format($item->transport,0,',','.') }}
                        </td>

                        <td class="text-right">
                            Rp {{ number_format($item->pajak,0,',','.') }}
                        </td>

                        <td class="text-right font-semibold text-blue-600">
                            Rp {{ number_format($item->total,0,',','.') }}
                        </td>

                        <td>

                            <div class="flex gap-2 justify-center">

                                <button
                                    onclick="editRow({{ $item->id }})"
                                    class="px-2 py-1 text-xs bg-amber-100 text-amber-700 rounded-lg">
                                    Edit
                                </button>

                                <form
                                    action="{{ route('admin.nominatif.destroy',$item->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin hapus data?')">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        class="px-2 py-1 text-xs bg-red-100 text-red-700 rounded-lg">
                                        Hapus
                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="{{ count($tanggalKerja)+8 }}"
                            class="text-center py-6 text-gray-500">

                            Belum ada data nominatif

                        </td>
                    </tr>

                @endforelse

                </tbody>

                <tfoot>

                    <tr class="bg-blue-50 font-semibold">

                        <td colspan="{{ count($tanggalKerja)+4 }}">
                            TOTAL
                        </td>

                        <td class="text-right">
                            Rp {{ number_format($nominatifs->sum('honor'),0,',','.') }}
                        </td>

                        <td class="text-right">
                            Rp {{ number_format($nominatifs->sum('dana_sehat'),0,',','.') }}
                        </td>

                        <td class="text-right">
                            Rp {{ number_format($nominatifs->sum('transport'),0,',','.') }}
                        </td>

                        <td class="text-right">
                            Rp {{ number_format($nominatifs->sum('pajak'),0,',','.') }}
                        </td>

                        <td class="text-right text-blue-700">
                            Rp {{ number_format($nominatifs->sum('total'),0,',','.') }}
                        </td>

                        <td></td>

                    </tr>

                </tfoot>

            </table>
        </div>

        </div>{{-- end nom-scroll --}}
        </div>{{-- end table wrapper --}}

        {{-- Footer note --}}
        <div class="px-6 py-3 border-t border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-800/30">
            <p class="text-xs text-gray-400">
                * TK = Tunjangan Kinerja &nbsp;|&nbsp; PJ = Pajak/Potongan &nbsp;|&nbsp; Nilai dalam Rupiah
            </p>
        </div>
    </div>
</div>


{{-- ═══════════════════════════════════════════
     MODAL: TAMBAH / EDIT ENTRI
═══════════════════════════════════════════ --}}
<div id="nomModal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm nom-backdrop" onclick="closeModal()"></div>

    <div class="relative flex items-center justify-center min-h-screen p-4">
        <div class="nom-card bg-white dark:bg-gray-900 rounded-2xl w-full max-w-2xl shadow-2xl overflow-hidden">

            {{-- Header --}}
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-gray-800">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-blue-600 flex items-center justify-center shadow">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                    <div>
                        <h2 id="modalTitle" class="text-base font-bold text-gray-800 dark:text-gray-100">Tambah Entri</h2>
                        <p class="text-xs text-gray-400">Data pembayaran upah sukarelawan</p>
                    </div>
                </div>
                <button onclick="closeModal()" class="w-8 h-8 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 flex items-center justify-center text-gray-400 hover:text-gray-600 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Form --}}
            <form id="nomForm" method="POST" action="#">
                @csrf
                <input type="hidden" name="id" id="nomId">

                <div class="px-6 py-5 max-h-[72vh] overflow-y-auto space-y-6">

                    {{-- Identitas --}}
                    <div>
                        <p class="nom-section-title">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path stroke-linecap="round" stroke-linejoin="round" d="M4 20c0-4 3.582-7 8-7s8 3 8 7"/></svg>
                            Identitas Personil
                        </p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="sm:col-span-2">
                                <label class="nom-label" for="f_nama">Nama Lengkap <span class="text-red-400">*</span></label>
                                <select name="anggota_id" id="nomMethod" class="nom-input">
                                    <option value="">-- Pilih Anggota --</option>

                                    @foreach($anggotas as $anggota)
                                        <option value="{{ $anggota->id }}">
                                            {{ $anggota->nama }} - {{ $anggota->jabatan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="nom-label" for="f_jenis">
                                    Jenis / Kategori <span class="text-red-400">*</span>
                                </label>

                                <select name="jenis" id="f_jenis" class="nom-input">
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($pekerjaans as $pekerjaan)
                                        <option value="{{ $pekerjaan->pekerjaan_id }}">
                                            {{ $pekerjaan->nama_pekerjaan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="nom-label" for="f_honor_harian">Honor Harian (Rp) <span class="text-red-400">*</span></label>
                                <input type="number" name="honor_harian" id="f_honor_harian" class="nom-input" placeholder="cth. 200000" min="0" oninput="hitungTotal()">
                            </div>
                        </div>
                    </div>

                    {{-- Hari Kerja --}}
                    <div>
                        <p class="nom-section-title">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Kehadiran Harian
                        </p>
                        <p class="text-xs text-gray-400 mb-3">Centang hari yang hadir (otomatis menghitung honor)</p>
                        <div class="grid grid-cols-5 sm:grid-cols-10 gap-2">
                            @for ($i=1; $i<=10; $i++)
                            <label class="flex flex-col items-center gap-1 cursor-pointer group">
                                <span class="text-xs font-semibold text-gray-500 group-has-[:checked]:text-blue-600">{{ $i }}</span>
                                <input type="checkbox" name="hari[]" value="{{ $i }}" class="w-4 h-4 rounded accent-blue-600" onchange="hitungTotal()">
                            </label>
                            @endfor
                        </div>
                    </div>

                    {{-- Tunjangan & Potongan --}}
                    <div>
                        <p class="nom-section-title">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Tunjangan & Potongan
                        </p>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label class="nom-label" for="f_kesehatan">Tunjangan Kesehatan</label>
                                <input type="number" name="kesehatan" id="f_kesehatan" class="nom-input" placeholder="0" min="0" oninput="hitungTotal()">
                            </div>
                            <div>
                                <label class="nom-label" for="f_tk">TK (Tunjangan Kinerja)</label>
                                <input type="number" name="tk" id="f_tk" class="nom-input" placeholder="0" min="0" oninput="hitungTotal()">
                            </div>
                            <div>
                                <label class="nom-label" for="f_pj">PJ (Potongan Pajak)</label>
                                <input type="number" name="pj" id="f_pj" class="nom-input" placeholder="0" min="0" oninput="hitungTotal()">
                            </div>
                        </div>
                    </div>

                    {{-- Preview Total --}}
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl p-4 flex items-center justify-between">
                        <div>
                            <p class="text-xs text-blue-100 font-medium">Estimasi Total Pembayaran</p>
                            <p id="previewTotal" class="text-2xl font-bold text-white mt-0.5">Rp 0</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-blue-100">Hari Hadir</p>
                            <p id="previewHari" class="text-lg font-bold text-white">0 hari</p>
                        </div>
                    </div>

                </div>

                {{-- Footer --}}
                <div class="flex items-center justify-end gap-2.5 px-6 py-4 border-t border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-800/40">
                    <button type="button" onclick="closeModal()"
                        class="px-5 py-2 text-sm font-semibold text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-5 py-2 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-sm shadow-blue-200 dark:shadow-none transition active:scale-95">
                        Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    /* ── Format currency ── */
    function fmt(n) {
        return 'Rp ' + Number(n).toLocaleString('id-ID');
    }

    /* ── Hitung preview total ── */
    function hitungTotal() {
        const harian   = parseFloat(document.getElementById('f_honor_harian').value) || 0;
        const hadir    = document.querySelectorAll('input[name="hari[]"]:checked').length;
        const sehat    = parseFloat(document.getElementById('f_kesehatan').value) || 0;
        const tk       = parseFloat(document.getElementById('f_tk').value) || 0;
        const pj       = parseFloat(document.getElementById('f_pj').value) || 0;
        const honor    = harian * hadir;
        const total    = honor + sehat + tk - pj;

        document.getElementById('previewTotal').innerText = fmt(total < 0 ? 0 : total);
        document.getElementById('previewHari').innerText  = hadir + ' hari';
    }

    /* ── Modal ── */
    function openModal() {
        document.getElementById('modalTitle').innerText = 'Tambah Entri';
        document.getElementById('nomMethod').value = 'POST';
        document.getElementById('nomForm').reset();
        document.getElementById('previewTotal').innerText = 'Rp 0';
        document.getElementById('previewHari').innerText  = '0 hari';
        showModal();
    }

    function editRow(id) {
        document.getElementById('modalTitle').innerText = 'Edit Entri';
        document.getElementById('nomMethod').value = 'PUT';
        // TODO: fetch row data by id and populate fields
        showModal();
    }

    function deleteRow(id) {
        if (confirm('Yakin ingin menghapus data personil ini?')) {
            // TODO: submit delete form
        }
    }

    function showModal() {
        document.getElementById('nomModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        document.getElementById('nomModal').classList.add('hidden');
        document.body.style.overflow = '';
    }

    function exportData() {
        alert('Fitur export akan segera tersedia.');
    }
</script>

@endsection