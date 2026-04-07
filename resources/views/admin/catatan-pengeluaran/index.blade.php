@extends('layouts.app')

@section('content')
<x-common.page-breadcrumb pageTitle="Catatan Pengeluaran Bulanan" />

<div class="space-y-6">

    {{-- 🔷 HEADER --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow border p-6 space-y-4">

        {{-- JUDUL --}}
        <div class="text-center">
            <h1 class="text-xl font-bold">CATATAN PENGELUARAN BULANAN</h1>
            <p class="text-sm text-gray-500">Periode : 1 - 13 Desember 2025</p>
        </div>

        {{-- INFO --}}
        <div class="flex flex-col md:flex-row justify-between gap-4">

            <div class="space-y-2 text-sm">
                <div class="flex gap-2">
                    <span class="w-40 text-gray-500">Nama Lembaga</span>
                    <span>:</span>
                    <span class="font-semibold">SPPG GADOG MEGAMENDUNG</span>
                </div>

                <div class="flex gap-2">
                    <span class="w-40 text-gray-500">Alamat</span>
                    <span>:</span>
                    <span>Jl. Pasir Angin desa Gadog</span>
                </div>
            </div>

            <div>
                <button onclick="window.print()"
                    class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg text-sm">
                    Print
                </button>
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
                <span class="font-medium">10.000.000</span>
            </div>

            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Dana Diterima</span>
                <span class="font-medium">510.408.000</span>
            </div>

            <hr>

            <div class="flex justify-between font-bold text-green-600">
                <span>Total Dana</span>
                <span>520.408.000</span>
            </div>
        </div>

        {{-- 🔴 PENGELUARAN --}}
        <div class="bg-white dark:bg-gray-900 p-5 rounded-2xl border shadow-sm space-y-3">
            <h3 class="font-semibold text-red-600">Pengeluaran</h3>

            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Bahan Baku</span>
                <span>34.800.000</span>
            </div>

            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Operasional</span>
                <span>34.400.000</span>
            </div>

            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Insentif Fasilitas</span>
                <span>72.000.000</span>
            </div>

            <hr>

            <div class="flex justify-between font-bold text-red-600">
                <span>Total Pengeluaran</span>
                <span>141.200.000</span>
            </div>
        </div>

        {{-- 🔵 SISA DANA --}}
        <div class="bg-blue-50 dark:bg-gray-900 p-5 rounded-2xl border shadow-sm flex flex-col justify-center items-center text-center">

            <h3 class="text-sm text-gray-500 mb-2">Sisa Dana Saat Ini</h3>

            <h1 class="text-2xl font-bold text-blue-600">
                379.208.000
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

                    <tr class="hover:bg-gray-50">
                        <td class="border px-3 py-2 text-center">Desember</td>
                        <td class="border px-3 py-2 text-center">1</td>
                        <td class="border px-3 py-2">35/Kwt/2025</td>
                        <td class="border px-3 py-2">Membayar belanja beras dan minyak goreng</td>
                        <td class="border px-3 py-2 text-right">26.500.000</td>
                    </tr>

                    <tr class="hover:bg-gray-50">
                        <td class="border px-3 py-2 text-center">Desember</td>
                        <td class="border px-3 py-2 text-center">4</td>
                        <td class="border px-3 py-2">37/Kwt/2025</td>
                        <td class="border px-3 py-2">Membayar belanja minuman dalam kemasan</td>
                        <td class="border px-3 py-2 text-right">6.150.000</td>
                    </tr>

                    <tr class="hover:bg-gray-50">
                        <td class="border px-3 py-2 text-center">Desember</td>
                        <td class="border px-3 py-2 text-center">6</td>
                        <td class="border px-3 py-2">38/Kwt/2025</td>
                        <td class="border px-3 py-2">Membayar tagihan listrik</td>
                        <td class="border px-3 py-2 text-right">1.500.000</td>
                    </tr>

                    <tr class="hover:bg-gray-50">
                        <td class="border px-3 py-2 text-center">Desember</td>
                        <td class="border px-3 py-2 text-center">7</td>
                        <td class="border px-3 py-2">39/Kwt/2025</td>
                        <td class="border px-3 py-2">Membayar belanja buah-buahan</td>
                        <td class="border px-3 py-2 text-right">2.150.000</td>
                    </tr>

                    <tr class="hover:bg-gray-50">
                        <td class="border px-3 py-2 text-center">Desember</td>
                        <td class="border px-3 py-2 text-center">8</td>
                        <td class="border px-3 py-2">40/Kwt/2025</td>
                        <td class="border px-3 py-2">Membayar air tangki</td>
                        <td class="border px-3 py-2 text-right">2.000.000</td>
                    </tr>

                    <tr class="hover:bg-gray-50">
                        <td class="border px-3 py-2 text-center">Desember</td>
                        <td class="border px-3 py-2 text-center">8</td>
                        <td class="border px-3 py-2">41/Kwt/2025</td>
                        <td class="border px-3 py-2">Membayar BBM kendaraan operasional</td>
                        <td class="border px-3 py-2 text-right">500.000</td>
                    </tr>

                    <tr class="hover:bg-gray-50">
                        <td class="border px-3 py-2 text-center">Desember</td>
                        <td class="border px-3 py-2 text-center">10</td>
                        <td class="border px-3 py-2">42/Kwt/2025</td>
                        <td class="border px-3 py-2">Membayar kantong plastik, mika, kertas nasi</td>
                        <td class="border px-3 py-2 text-right">400.000</td>
                    </tr>

                    <tr class="hover:bg-gray-50">
                        <td class="border px-3 py-2 text-center">Desember</td>
                        <td class="border px-3 py-2 text-center">13</td>
                        <td class="border px-3 py-2">43/Kwt/2025</td>
                        <td class="border px-3 py-2">Membayar insentif fasilitas 2 pekan</td>
                        <td class="border px-3 py-2 text-right">72.000.000</td>
                    </tr>

                    <tr class="hover:bg-gray-50">
                        <td class="border px-3 py-2 text-center">Desember</td>
                        <td class="border px-3 py-2 text-center">13</td>
                        <td class="border px-3 py-2">44/Kwt/2025</td>
                        <td class="border px-3 py-2">Membayar honor relawan</td>
                        <td class="border px-3 py-2 text-right">30.000.000</td>
                    </tr>

                </tbody>

            </table>
        </div>
    </div>

</div>
@endsection