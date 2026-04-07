@extends('layouts.app')

@section('content')
<x-common.page-breadcrumb pageTitle="Buku Kas Umum (BKU)" />

<div class="space-y-6">

    {{-- 🔷 INFO --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm border p-6">
        <div class="flex flex-col md:flex-row justify-between gap-4">

            {{-- KIRI --}}
            <div class="space-y-3">
                <div class="flex gap-2">
                    <span class="w-40 text-sm text-gray-500">Nama Lembaga</span>
                    <span>:</span>
                    <span class="font-semibold">Yayasan Contoh Indonesia</span>
                </div>

                <div class="flex gap-2">
                    <span class="w-40 text-sm text-gray-500">Alamat</span>
                    <span>:</span>
                    <span>Jl.jjj</span>
                </div>
                <div class="flex gap-2">
                    <span class="w-40 text-sm text-gray-500">Periode</span>
                    <span>:</span>
                    <span>Januari 2026</span>
                </div>
            </div>

            {{-- KANAN --}}
            <div class="flex items-center gap-2">
                <button
                    class="bg-brand-500 hover:bg-brand-600 text-white px-5 py-2.5 rounded-lg text-sm font-medium">
                    Export Excel
                </button>
            </div>

        </div>
    </div>

    {{-- 🔷 SUMMARY --}}
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

    {{-- 🔷 TABEL BKU --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm border p-6">

        <h2 class="text-lg font-semibold mb-4">Data Buku Kas Umum</h2>

        <div class="overflow-x-auto">
            <table class="min-w-full border rounded-lg overflow-hidden">

                {{-- HEADER --}}
                <thead class="bg-gray-100 dark:bg-gray-800 text-xs uppercase">
                    <tr>
                        <th class="px-3 py-3">No</th>
                        <th class="px-3 py-3">Bulan</th>
                        <th class="px-3 py-3">Tanggal</th>
                        <th class="px-3 py-3">No Bukti</th>
                        <th class="px-3 py-3">Uraian Transaksi</th>
                        <th class="px-3 py-3 text-right">Debet</th>
                        <th class="px-3 py-3 text-right">Kredit</th>
                        <th class="px-3 py-3 text-right">Saldo</th>
                    </tr>
                </thead>

                {{-- BODY --}}
                <tbody class="text-sm divide-y">

                    {{-- Saldo Awal --}}
                    <tr class="bg-gray-50 dark:bg-gray-800 font-semibold">
                        <td colspan="6" class="px-3 py-3 text-right">
                            Saldo Awal
                        </td>
                        <td class="px-3 py-3 text-right text-blue-600">
                            Rp 1.000.000
                        </td>
                    </tr>

                    {{-- DATA --}}
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                        <td class="px-3 py-3 text-center">1</td>
                        <td class="px-3 py-3">Januari</td>
                        <td class="px-3 py-3">01 Jan 2026</td>
                        <td class="px-3 py-3">TRX-001</td>
                        <td class="px-3 py-3">Pemasukan donasi</td>
                        <td class="px-3 py-3 text-right text-green-600">Rp 2.000.000</td>
                        <td class="px-3 py-3 text-right">Rp 0</td>
                        <td class="px-3 py-3 text-right font-semibold">Rp 3.000.000</td>
                    </tr>

                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                        <td class="px-3 py-3 text-center">2</td>
                        <td class="px-3 py-3">02 Jan 2026</td>
                        <td class="px-3 py-3">TRX-002</td>
                        <td class="px-3 py-3">Pembelian bahan</td>
                        <td class="px-3 py-3 text-right">Rp 0</td>
                        <td class="px-3 py-3 text-right text-red-500">Rp 500.000</td>
                        <td class="px-3 py-3 text-right font-semibold">Rp 2.500.000</td>
                    </tr>

                    {{-- EMPTY --}}
                    <tr>
                        <td colspan="7" class="text-center py-10 text-gray-400">
                            Belum ada data
                        </td>
                    </tr>

                </tbody>

                {{-- FOOTER --}}
                <tfoot class="bg-gray-100 dark:bg-gray-800 font-semibold">
                    <tr>
                        <td colspan="4" class="px-3 py-3 text-right">
                            Total
                        </td>
                        <td class="px-3 py-3 text-right text-green-600">
                            Rp 2.000.000
                        </td>
                        <td class="px-3 py-3 text-right text-red-500">
                            Rp 500.000
                        </td>
                        <td class="px-3 py-3 text-right text-blue-600">
                            Rp 2.500.000
                        </td>
                    </tr>
                </tfoot>

            </table>
        </div>
    </div>

</div>
@endsection