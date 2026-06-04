@extends('layouts.app')

@section('content')
<x-common.page-breadcrumb pageTitle="Catatan Pengeluaran Bulanan" />

<div class="space-y-6">

    {{-- 🔷 HEADER --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow border p-6 space-y-4">

        {{-- JUDUL --}}
        <div class="text-center">
            <h1 class="text-xl font-bold">CATATAN PENGELUARAN BULANAN</h1>
            <p class="text-sm text-gray-500">Periode :  {{ $periodeAwal }} - {{ $periodeAkhir }}</p>
        </div>

        {{-- INFO --}}
        <div class="flex flex-col md:flex-row justify-between gap-4">

            <div class="space-y-2 text-sm">
                <div class="flex gap-2">
                    <span class="w-40 text-gray-500">Nama Lembaga</span>
                    <span>:</span>
                    <span class="font-semibold">{{ $dapur->nama_lembaga }}</span>
                </div>

                <div class="flex gap-2">
                    <span class="w-40 text-gray-500">Alamat</span>
                    <span>:</span>
                    <span>{{ $dapur->alamat }}</span>
                </div>
            </div>

            <div>
                <a href="{{ route('admin.catatan-pengeluaran.export') }}"
                class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg text-sm inline-block">
                    Export Excel
                </a>
            </div>
        </div>
    </div>
    {{-- 🔷 RINGKASAN DANA (VERSI RAPI & MUDAH DIBACA) --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        {{-- 🟢 DANA MASUK --}}
        <div class="bg-white dark:bg-gray-900 p-5 rounded-2xl border shadow-sm space-y-3">
            <h3 class="font-semibold text-green-600">Dana Masuk</h3>

            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Sisa Dana Sebelumnya</span>
                <span class="font-medium">Rp {{ number_format($sisaDana, 0, ',', '.') }}</span>
            </div>

            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Dana Diterima</span>
                <span class="font-medium">Rp {{ number_format($danaMasuk, 0, ',', '.') }}</span>
            </div>

            <hr>

            <div class="flex justify-between font-bold text-green-600">
                <span>Total Dana</span>
                <span>Rp {{ number_format($totalDana, 0, ',', '.') }}</span>
            </div>
        </div>

        {{-- 🔴 PENGELUARAN --}}
        <div class="bg-white dark:bg-gray-900 p-5 rounded-2xl border shadow-sm space-y-3">
            <h3 class="font-semibold text-red-600">Pengeluaran</h3>

            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Bahan Baku</span>
                <span>Rp {{ number_format($bahanBaku, 0, ',', '.') }}</span>
            </div>

            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Operasional</span>
                <span>Rp {{ number_format($operasional, 0, ',', '.') }}
            </div>

            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Insentif Fasilitas</span>
                <span>Rp {{ number_format($insentifFasilitas, 0, ',', '.') }}</span>
            </div>

            <hr>

            <div class="flex justify-between font-bold text-red-600">
                <span>Total Pengeluaran</span>
                <span>Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</span>
            </div>
        </div>

        {{-- 🔵 SISA DANA --}}
        <div class="bg-blue-50 dark:bg-gray-900 p-5 rounded-2xl border shadow-sm flex flex-col justify-center items-center text-center">

            <h3 class="text-sm text-gray-500 mb-2">Sisa Dana Saat Ini</h3>

            <h1 class="text-2xl font-bold text-blue-600">
                Rp {{ number_format($sisaDana, 0, ',', '.') }}
            </h1>

            <p class="text-xs text-gray-400 mt-2">
                Setelah dikurangi seluruh pengeluaran
            </p>
        </div>

    </div>

    {{-- 🔷 TABEL TRANSAKSI --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow border p-6">

        <h2 class="text-lg font-semibold mb-4">Detail Transaksi</h2>

        <div class="overflow-x-auto">
            <table class="min-w-[900px] border text-sm whitespace-nowrap">

                {{-- HEADER --}}
                <thead class="bg-gray-100 text-xs uppercase">
                    <tr>
                        <th class="border px-3 py-2">Bulan</th>
                        <th class="border px-3 py-2">Tgl</th>
                        <th class="border px-3 py-2">No Bukti</th>
                        <th class="border px-3 py-2">Uraian Transaksi</th>
                        <th class="border px-3 py-2 text-right">Jumlah</th>
                    </tr>
                </thead>

                {{-- BODY --}}
                <tbody>

                @forelse($transaksis as $transaksi)
                <tr class="hover:bg-gray-50">

                    <td class="border px-3 py-2 text-center">
                        {{ \Carbon\Carbon::parse($transaksi->tanggal)->translatedFormat('F') }}
                    </td>

                    <td class="border px-3 py-2 text-center">
                        {{ \Carbon\Carbon::parse($transaksi->tanggal)->format('d') }}
                    </td>

                    <td class="border px-3 py-2">
                        {{ $transaksi->no_bukti }}
                    </td>

                    <td class="border px-3 py-2">
                        {{ $transaksi->uraian }}
                    </td>

                    <td class="border px-3 py-2 text-right">
                        Rp {{ number_format($transaksi->kredit, 0, ',', '.') }}
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="5" class="border px-3 py-4 text-center text-gray-500">
                        Tidak ada data transaksi
                    </td>
                </tr>
                @endforelse
                    
                </tbody>

            </table>
        </div>
    </div>

</div>
@endsection