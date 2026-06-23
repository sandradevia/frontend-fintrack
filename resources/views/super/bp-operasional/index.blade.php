<style>
    .filter-card {
    background: #ffffff;
    border-radius: 16px;
    padding: 20px;
    width: 100%;
    max-width: 320px;
    border: 0.2px solid #eef2f6;
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

@extends('layouts.app')

@section('content')
<x-common.page-breadcrumb pageTitle="Buku Pembantu Dana Operasional" />

<div class="space-y-6">

    {{-- 🔷 HEADER --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow border p-6 space-y-4">

        {{-- JUDUL --}}
        <div class="text-center">
            <h1 class="text-xl font-bold">BUKU PEMBANTU DANA OPERASIONAL</h1>
            {{--ACTION --}}
                <div class="flex justify-end">
                    <a href="{{ route('admin.bp-operasional.export') }}"
                        class="bg-brand-500 hover:bg-brand-600 text-white px-5 py-2.5 rounded-lg text-sm font-medium">
                        Export Data
                    </a>
                </div>
        </div>
        <div class="filter-card">
            <div class="filter-header">
                <span class="filter-title">Filter Data</span>
            </div>
            
            <form method="GET" class="dapur-filter-form">
                <label for="dapur_id" class="filter-label">Pilih Dapur</label>
                
                <div class="select-container">
                    <select name="dapur_id" id="dapur_id" class="filter-select" onchange="this.form.submit()">
                        <option value="">Semua Dapur</option>
                        @foreach($dapurList as $item)
                            <option value="{{ $item->id }}" {{ request('dapur_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->nama_lembaga }}
                            </option>
                        @endforeach
                    </select>
                    <div class="select-arrow">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 9l6 6 6-6"/>
                        </svg>
                    </div>
                </div>
            </form>
        </div>
    </div>

        {{-- INFO
        <div class="flex flex-col md:flex-row justify-between gap-4">

            {{-- KIRI --}}
            {{-- <div class="space-y-2 text-sm">
                <div class="flex gap-2">
                    <span class="w-32 text-gray-500">Nama Lembaga</span>
                    <span>:</span>
                    <span class="font-semibold">{{ $dapur->nama_lembaga }}</span>
                </div>

                <div class="flex gap-2">
                    <span class="w-32 text-gray-500">Alamat</span>
                    <span>:</span>
                    <span>{{ $dapur->alamat }}</span>
                </div>

                <div class="flex gap-2 mt-2">
                    <span class="w-32 text-gray-500">Jenis Buku</span>
                    <span>:</span>
                    <span class="font-semibold">Operasional</span>
                </div>
            </div> --}}

            {{-- KANAN --}}

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        <div class="bg-white dark:bg-gray-900 p-5 rounded-2xl border shadow-sm">
            <p class="text-sm text-gray-500">Saldo Awal</p>
            <h2 class="text-xl font-bold text-gray-800 dark:text-white mt-1">
                Rp {{ number_format($saldoAwal, 0, ',', '.') }}
            </h2>
        </div>

        <div class="bg-white dark:bg-gray-900 p-5 rounded-2xl border shadow-sm">
            <p class="text-sm text-gray-500">Saldo Akhir</p>
            <h2 class="text-xl font-bold text-blue-600 mt-1">
                Rp {{ number_format($saldoAkhir,0,',','.') }}
            </h2>
        </div>
    </div>

    {{--TABEL --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow border p-6">
        <h2 class="text-lg font-semibold mb-4">Data Buku Pembantu Dana Operasional</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full border text-sm">

                {{-- HEADER --}}
                <thead class="bg-gray-100 text-xs uppercase">
                    <tr>
                        <th class="border px-2 py-2">Bulan</th>
                        <th class="border px-2 py-2">Tgl</th>
                        <th class="border px-2 py-2">No Bukti</th>
                        <th class="border px-2 py-2">Uraian Transaksi</th>
                        <th class="border px-2 py-2 text-right">Debet</th>
                        <th class="border px-2 py-2 text-right">Kredit</th>
                        <th class="border px-2 py-2 text-right">Saldo</th>
                    </tr>
                </thead>

                {{-- BODY --}}
                <tbody>

                    <tr class="bg-gray-50 font-medium">
                        <td class="border px-2 py-2 text-center"></td>
                        <td class="border"></td>
                        <td class="border"></td>
                        <td class="border px-2 py-2">SALDO AWAL BULAN BERJALAN</td>
                        <td class="border px-2 py-2 text-right text-green-600">Rp {{ number_format($saldoAwal, 0, ',', '.') }}</td>
                        <td class="border px-2 py-2 text-right">-</td>
                        <td class="border px-2 py-2 text-right">Rp {{ number_format($saldoAwal, 0, ',', '.') }}</td>
                    </tr>

                    @forelse($transaksis as $trx)
                    <tr>
                        <td class="border px-2 py-2 text-center">
                            {{ \Carbon\Carbon::parse($trx['tanggal'])->translatedFormat('M') }}
                        </td>

                        <td class="border px-2 py-2 text-center">
                            {{ \Carbon\Carbon::parse($trx['tanggal'])->format('d') }}
                        </td>

                        <td class="border px-2 py-2">
                            {{ $trx['no_bukti'] }}
                        </td>

                        <td class="border px-2 py-2">
                            {{ $trx['uraian'] }}
                        </td>

                        <td class="border px-2 py-2 text-right">
                            {{ $trx['debet'] ? number_format($trx['debet'],0,',','.') : '-' }}
                        </td>

                        <td class="border px-2 py-2 text-right">
                            {{ $trx['kredit'] ? number_format($trx['kredit'],0,',','.') : '-' }}
                        </td>

                        <td class="border px-2 py-2 text-right">
                            {{ number_format($trx['saldo'],0,',','.') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-6 text-gray-400">
                            Belum ada data
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection