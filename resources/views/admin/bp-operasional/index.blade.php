@extends('layouts.app')

@section('content')
<x-common.page-breadcrumb pageTitle="Buku Pembantu Dana Operasional" />

<div class="space-y-6">

    {{-- 🔷 HEADER --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow border p-6 space-y-4">

        {{-- JUDUL --}}
        <div class="text-center">
            <h1 class="text-xl font-bold">BUKU PEMBANTU DANA OPERASIONAL</h1>
            <p class="text-sm text-gray-500">Periode : 1 - 13 Desember 2025</p>
        </div>

        {{-- INFO --}}
        <div class="flex flex-col md:flex-row justify-between gap-4">

            {{-- KIRI --}}
            <div class="space-y-2 text-sm">
                <div class="flex gap-2">
                    <span class="w-32 text-gray-500">Nama Lembaga</span>
                    <span>:</span>
                    <span class="font-semibold">SPPG GADOG MEGAMENDUNG</span>
                </div>

                <div class="flex gap-2">
                    <span class="w-32 text-gray-500">Alamat</span>
                    <span>:</span>
                    <span>Jl. Pasir Angin desa Gadog</span>
                </div>

                <div class="flex gap-2 mt-2">
                    <span class="w-32 text-gray-500">Jenis Buku</span>
                    <span>:</span>
                    <span class="font-semibold">Operasional</span>
                </div>
            </div>

            {{-- KANAN --}}
            <div class="text-sm border rounded-lg overflow-hidden">
                {{--ACTION --}}
                <div class="flex justify-end">
                    <button 
                        class="bg-brand-500 hover:bg-brand-600 text-white px-5 py-2.5 rounded-lg text-sm font-medium">
                        Eksprot Data
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        <div class="bg-white dark:bg-gray-900 p-5 rounded-2xl border shadow-sm">
            <p class="text-sm text-gray-500">Saldo Awal</p>
            <h2 class="text-xl font-bold text-gray-800 dark:text-white mt-1">
                Rp 1.000.000
            </h2>
        </div>

        <div class="bg-white dark:bg-gray-900 p-5 rounded-2xl border shadow-sm">
            <p class="text-sm text-gray-500">Total Pemasukan</p>
            <h2 class="text-xl font-bold text-green-600 mt-1">
                Rp 2.500.000
            </h2>
        </div>

        <div class="bg-white dark:bg-gray-900 p-5 rounded-2xl border shadow-sm">
            <p class="text-sm text-gray-500">Saldo Akhir</p>
            <h2 class="text-xl font-bold text-blue-600 mt-1">
                Rp 3.500.000
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

                    {{-- SALDO AWAL --}}
                    <tr class="bg-gray-50 font-medium">
                        <td class="border px-2 py-2 text-center"></td>
                        <td class="border"></td>
                        <td class="border"></td>
                        <td class="border px-2 py-2">SALDO AWAL BULAN BERJALAN</td>
                        <td class="border px-2 py-2 text-right text-green-600">6.500.000</td>
                        <td class="border px-2 py-2 text-right">-</td>
                        <td class="border px-2 py-2 text-right">6.500.000</td>
                    </tr>

                    {{-- CONTOH DATA --}}
                    <tr class="hover:bg-gray-50">
                        <td class="border px-2 py-2 text-center">1</td>
                        <td class="border px-2 py-2">02</td>
                        <td class="border px-2 py-2">TRX-001</td>
                        <td class="border px-2 py-2">Pembelian bahan</td>
                        <td class="border px-2 py-2 text-right text-green-600">500.000</td>
                        <td class="border px-2 py-2 text-right">0</td>
                        <td class="border px-2 py-2 text-right">7.000.000</td>
                    </tr>

                    {{-- EMPTY --}}
                    <tr>
                        <td colspan="8" class="text-center py-6 text-gray-400">
                            Belum ada data
                        </td>
                    </tr>

                </tbody>

            </table>
        </div>
    </div>

</div>
@endsection