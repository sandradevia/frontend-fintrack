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
    .filter-card {
    background: #ffffff;
    border-radius: 16px;
    padding: 20px;
    width: 100%;
    max-width: 320px;
    border: 1px solid #eef2f6;
    /* Bayangan lembut untuk kesan "mengambang" */
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.08), 0 4px 6px -2px rgba(0, 0, 0, 0.03);
}

.filter-header {
    margin-bottom: 15px;
    border-bottom: 1px solid #f1f5f9;
    padding-bottom: 10px;
}

.filter-title {
    font-weight: 700;
    color: #334155;
    font-size: 0.9rem;
}

.filter-label {
    display: block;
    font-size: 0.75rem;
    font-weight: 600;
    color: #94a3b8;
    margin-bottom: 6px;
}

.select-container {
    position: relative;
    display: flex;
    align-items: center;
}

.filter-select {
    width: 100%;
    padding: 12px 16px;
    background-color: #f8fafc;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    font-size: 0.95rem;
    font-weight: 500;
    color: #1e293b;
    appearance: none;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Efek saat card atau input disentuh */
.filter-select:hover {
    border-color: #cbd5e1;
    background-color: #ffffff;
}

.filter-select:focus {
    outline: none;
    border-color: #6366f1; /* Warna indigo yang elegan */
    background-color: #ffffff;
    box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
}

.select-arrow {
    position: absolute;
    right: 16px;
    color: #64748b;
    pointer-events: none;
}
</style>

<div class="nom-wrap space-y-6 w-full min-w-0">

    {{-- ── HEADER ── --}}
    <div class="flex items-center justify-between flex-wrap gap-4">
        {{-- Bagian Kiri: Judul --}}
        <div>
            <x-common.page-breadcrumb pageTitle="Daftar Nominatif" />
            <p class="text-xs text-gray-400 mt-0.5">Pembayaran upah sukarelawan per periode</p>
        </div>

        {{-- Bagian Kanan: Aksi (Excel & Filter) --}}
        <div class="flex items-end gap-3">
            
            {{-- Tombol Cetak Excel --}}
            <a href="{{ route('admin.daftar-nominatif.export.excel') }}"
            class="inline-flex items-center h-[42px] gap-2 px-4 text-sm font-semibold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 dark:bg-emerald-900/30 dark:text-emerald-400 dark:hover:bg-emerald-900/50 rounded-xl border border-emerald-200 dark:border-emerald-800 transition active:scale-95">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Cetak Excel
            </a>
            
            {{-- Form Filter Dapur --}}
            <form method="GET" class="dapur-filter-form flex flex-col gap-1">
                <label for="dapur_id" class="text-[10px] font-bold text-gray-500 uppercase tracking-wider ml-1">Pilih Dapur</label>
                <div class="select-container relative flex items-center">
                    <select name="dapur_id" id="dapur_id" class="h-[42px] pl-3 pr-10 bg-white border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none cursor-pointer transition" onchange="this.form.submit()">
                        <option value="">Semua Dapur</option>
                        @foreach($dapurList as $item)
                            <option value="{{ $item->id }}" {{ request('dapur_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->nama_lembaga }}
                            </option>
                        @endforeach
                    </select>
                    <div class="select-arrow absolute right-3 pointer-events-none text-gray-400">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 9l6 6 6-6"/>
                        </svg>
                    </div>
                </div>
            </form>

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
                        <th rowspan="2">Jenis Pekerjaan</th>
                        <th rowspan="2">Nama</th>
                        <th colspan="{{ count($tanggalKerja) }}" class="text-center">
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
                            <th class="text-xs text-center border-b">
                                {{ \Carbon\Carbon::parse($tanggal)->format('d') }}
                            </th>
                        @endforeach
                    </tr>

                                <tbody>
                    @forelse($nominatifs as $item)
                        <tr data-json="{{ json_encode($item) }}">
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $item->anggota->pekerjaan->nama_pekerjaan ?? '-' }}</td>
                            <td>{{ $item->anggota->nama ?? '-' }}</td>
                            
                            {{-- Loop Tanggal (Sesuai dengan colspan di baris kedua header) --}}
                            @foreach($tanggalKerja as $tanggal)
                                @php $kehadiran = $item->kehadiranNominatif->where('tanggal', $tanggal)->first(); @endphp
                                <td class="text-center text-xs">
                                    {{ $kehadiran ? '✓' : '-' }} 
                                </td>
                            @endforeach

                            <td class="text-right">Rp {{ number_format($item->honor,0,',','.') }}</td>
                            <td class="text-right">Rp {{ number_format($item->dana_sehat,0,',','.') }}</td>
                            <td class="text-right">Rp {{ number_format($item->transport,0,',','.') }}</td>
                            <td class="text-right">Rp {{ number_format($item->pajak,0,',','.') }}</td>
                            <td class="text-right font-bold text-blue-600">Rp {{ number_format($item->total,0,',','.') }}</td>
                            <td>
                                <div class="flex gap-1 justify-center">
                                    <button type="button" onclick="editRow(this)" class="px-2 py-1 text-xs bg-amber-100 text-amber-700 rounded">Edit</button>
                                    <form action="{{ route('admin.daftar-nominatif.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="px-2 py-1 text-xs bg-red-100 text-red-700 rounded">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ 9 + count($tanggalKerja) }}" class="text-center py-6">Belum ada data</td>
                        </tr>
                    @endforelse
                    </tbody>
                    <tfoot>
    <tr class="bg-blue-50 font-bold text-sm">
        {{-- 
           colspan 3 berasal dari kolom: No, Jenis, Nama.
           Kemudian ditambah jumlah kolom tanggal yang dinamis.
        --}}
        <td colspan="{{ 3 + count($tanggalKerja) }}" class="text-center">
            TOTAL KESELURUHAN
        </td>

        <td class="text-right">Rp {{ number_format($nominatifs->sum('honor'), 0, ',', '.') }}</td>
        <td class="text-right">Rp {{ number_format($nominatifs->sum('dana_sehat'), 0, ',', '.') }}</td>
        <td class="text-right">Rp {{ number_format($nominatifs->sum('transport'), 0, ',', '.') }}</td>
        <td class="text-right">Rp {{ number_format($nominatifs->sum('pajak'), 0, ',', '.') }}</td>
        <td class="text-right text-blue-700">Rp {{ number_format($nominatifs->sum('total'), 0, ',', '.') }}</td>
        
        {{-- Kolom Aksi di pojok kanan bawah yang kosong --}}
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


<div id="nomModal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm" onclick="closeModal()"></div>
    <div class="relative flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-2xl w-full max-w-lg shadow-2xl overflow-hidden">
            <div class="px-6 py-4 border-b flex justify-between items-center bg-gray-50">
                <h2 id="modalTitle" class="text-lg font-bold text-gray-800">Tambah Entri</h2>
                <button onclick="closeModal()" class="text-gray-500 hover:text-black">✕</button>
            </div>
            
            <form id="nomForm" method="POST" action="">
                @csrf
                <div id="methodContainer"></div>
                
                {{-- No Bukti Hidden (Sesuai Controller) --}}
                <input type="hidden" name="no_bukti" value="NB-{{ date('YmdHis') }}">

                <div class="px-6 py-5 space-y-4 max-h-[70vh] overflow-y-auto">
                    {{-- Anggota --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Anggota</label>
                        <select name="anggota_id" id="f_anggota_id" class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                            @foreach($anggotas as $anggota)
                                <option value="{{ $anggota->id }}">{{ $anggota->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Honor Harian --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Honor Harian</label>
                        <input type="number" name="honor_harian" id="f_honor_harian" class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" placeholder="0" oninput="hitungTotal()">
                    </div>

                    {{-- Checkbox Hari --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Tanggal Hadir (Pilih Hari)</label>
                        <div class="grid grid-cols-5 gap-2">
                            @for ($i=1; $i<=10; $i++)
                                <label class="flex flex-col items-center p-2 border rounded-lg cursor-pointer hover:bg-blue-50">
                                    <input type="checkbox" name="tanggal_hadir[]" value="{{ date('Y-m-') . str_pad($i, 2, '0', STR_PAD_LEFT) }}" onchange="hitungTotal()">
                                    <span class="text-xs mt-1">{{ $i }}</span>
                                </label>
                            @endfor
                        </div>
                    </div>

                    {{-- Grid Input Tunjangan & Potongan --}}
                    <div class="grid grid-cols-3 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Kesehatan</label>
                            <input type="number" name="dana_sehat" id="f_kesehatan" class="w-full p-2 border border-gray-300 rounded-lg" placeholder="0" oninput="hitungTotal()">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Transport</label>
                            <input type="number" name="transport" id="f_tk" class="w-full p-2 border border-gray-300 rounded-lg" placeholder="0" oninput="hitungTotal()">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Pajak (PJ)</label>
                            <input type="number" name="pajak" id="f_pj" class="w-full p-2 border border-gray-300 rounded-lg" placeholder="0" oninput="hitungTotal()">
                        </div>
                    </div>

                    {{-- Total --}}
                    <div class="bg-blue-600 text-white p-3 rounded-lg text-center">
                        <span class="text-xs uppercase opacity-80">Total Estimasi</span>
                        <div id="previewTotal" class="text-lg font-bold">Rp 0</div>
                    </div>
                </div>
                
                <div class="px-6 py-4 border-t bg-gray-50 flex justify-end">
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg font-bold hover:bg-blue-700">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // 1. Format Rupiah
    function fmt(n) { return 'Rp ' + Number(n).toLocaleString('id-ID'); }

    // 2. Logika Hitung Total (Vanilla JS)
    function hitungTotal() {
    // Tambahkan baris ini untuk debug
    console.log("Checkbox diklik, sedang menghitung...");

    const harian = parseFloat(document.getElementById('f_honor_harian').value) || 0;
    
    // Pastikan selector ini sama dengan name di checkbox Anda
    const checks = document.querySelectorAll('input[name="tanggal_hadir[]"]:checked').length;
    
    const sehat  = parseFloat(document.getElementById('f_kesehatan').value) || 0;
    const tk     = parseFloat(document.getElementById('f_tk').value) || 0;
    const pj     = parseFloat(document.getElementById('f_pj').value) || 0;
    
    const total = (harian * checks) + sehat + tk - pj;
    
    console.log("Total yang dihitung: " + total); // Cek apakah total muncul di console
    
    document.getElementById('previewTotal').innerText = 'Rp ' + total.toLocaleString('id-ID');
}   

    // 3. Fungsi Buka Modal (Tambah)
    function openModal() {
        document.getElementById('modalTitle').innerText = 'Tambah Entri';
        document.getElementById('nomForm').action = "{{ route('admin.daftar-nominatif.store') }}";
        document.getElementById('methodContainer').innerHTML = ''; // Pastikan bersih
        document.getElementById('nomForm').reset();
        document.getElementById('nomModal').classList.remove('hidden');
    }

    // 4. Fungsi Edit (Ambil data dari data-json di tr)
    function editRow(btn) {
    const row = btn.closest('tr');
    const data = JSON.parse(row.getAttribute('data-json'));
    
    document.getElementById('modalTitle').innerText = 'Edit Entri';
    document.getElementById('nomForm').action = `/admin/daftar-nominatif/${data.id}`;
    document.getElementById('methodContainer').innerHTML = '@method("PUT")';
    
    document.getElementById('f_anggota_id').value = data.anggota_id;
    document.getElementById('f_honor_harian').value = data.honor_harian;
    document.getElementById('f_kesehatan').value = data.kesehatan;
    document.getElementById('f_tk').value = data.transport; // Sesuaikan dengan key di data-json
    document.getElementById('f_pj').value = data.pajak;     // Sesuaikan dengan key di data-json

    // PERBAIKAN: Gunakan name="tanggal_hadir[]" agar sinkron dengan HTML
    document.querySelectorAll('input[name="tanggal_hadir[]"]').forEach(cb => {
        // Sesuaikan 'h.tanggal' dengan format yang ada di database/data-json Anda
        cb.checked = data.kehadiran_nominatif?.some(h => h.tanggal === cb.value);
    });
    
    hitungTotal();
    document.getElementById('nomModal').classList.remove('hidden');
}
    function closeModal() { document.getElementById('nomModal').classList.add('hidden'); }

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