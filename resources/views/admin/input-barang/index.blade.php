@extends('layouts.app')

@section('content')
<x-common.page-breadcrumb pageTitle="Input Nama Barang & Saldo Awal" />

<div class="space-y-6">

    {{-- 🔷 HEADER --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow border p-6 text-center">
        <h1 class="text-xl font-bold">INPUT NAMA BARANG DAN SALDO AWAL</h1>
        <p class="text-sm text-gray-500">Periode : 1 - 13 Desember 2025</p>
    </div>

    {{-- 🔷 FORM INPUT --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow border p-6">

        <h2 class="text-lg font-semibold mb-4">Tambah Data Barang</h2>

        <form class="grid grid-cols-1 md:grid-cols-5 gap-4">

            {{-- Nama Barang --}}
            <div class="col-span-2">
                <label class="text-sm text-gray-600">Nama Barang</label>
                <input type="text" placeholder="Contoh: Beras premium"
                    class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200">
            </div>

            {{-- Satuan --}}
            <div>
                <label class="text-sm text-gray-600">Satuan</label>
                <select class="w-full border rounded-lg px-3 py-2">
                    <option>kg</option>
                    <option>liter</option>
                    <option>pcs</option>
                </select>
            </div>

            {{-- Saldo --}}
            <div>
                <label class="text-sm text-gray-600">Saldo Awal</label>
                <input type="number" placeholder="0"
                    class="w-full border rounded-lg px-3 py-2">
            </div>

            {{-- Harga --}}
            <div>
                <label class="text-sm text-gray-600">Harga Beli</label>
                <input type="number" placeholder="0"
                    class="w-full border rounded-lg px-3 py-2">
            </div>

            {{-- BUTTON --}}
            <div class="md:col-span-5 flex justify-end gap-2 mt-2">
                <button type="reset"
                    class="px-4 py-2 border rounded-lg text-gray-600">
                    Reset
                </button>

                <button type="submit"
                    class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg">
                    Simpan
                </button>
            </div>

        </form>
    </div>

    {{-- 🔷 TABEL DATA --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow border p-6">

        <h2 class="text-lg font-semibold mb-4">Daftar Barang</h2>

        <div class="overflow-x-auto">
            <table class="min-w-[700px] w-full border text-sm whitespace-nowrap">

                {{-- HEADER --}}
                <thead class="bg-gray-100 text-xs uppercase">
                    <tr>
                        <th class="border px-3 py-2 text-center">No</th>
                        <th class="border px-3 py-2">Nama Barang</th>
                        <th class="border px-3 py-2 text-center">Satuan</th>
                        <th class="border px-3 py-2 text-center">Saldo Awal</th>
                        <th class="border px-3 py-2 text-right">Harga Beli</th>
                        <th class="border px-3 py-2 text-center">Aksi</th>
                    </tr>
                </thead>

                {{-- BODY --}}
                <tbody>

                    <tr class="hover:bg-gray-50">
                        <td class="border px-3 py-2 text-center">1</td>
                        <td class="border px-3 py-2">Beras premium</td>
                        <td class="border px-3 py-2 text-center">kg</td>
                        <td class="border px-3 py-2 text-center">12</td>
                        <td class="border px-3 py-2 text-right">15.000</td>
                        <td class="border px-3 py-2 text-center space-x-2">
                            <button class="text-blue-500">Edit</button>
                            <button class="text-red-500">Hapus</button>
                        </td>
                    </tr>

                    <tr class="hover:bg-gray-50">
                        <td class="border px-3 py-2 text-center">2</td>
                        <td class="border px-3 py-2">Beras jagung</td>
                        <td class="border px-3 py-2 text-center">kg</td>
                        <td class="border px-3 py-2 text-center">8</td>
                        <td class="border px-3 py-2 text-right">17.000</td>
                        <td class="border px-3 py-2 text-center space-x-2">
                            <button class="text-blue-500">Edit</button>
                            <button class="text-red-500">Hapus</button>
                        </td>
                    </tr>

                    <tr class="hover:bg-gray-50">
                        <td class="border px-3 py-2 text-center">3</td>
                        <td class="border px-3 py-2">Tepung terigu</td>
                        <td class="border px-3 py-2 text-center">kg</td>
                        <td class="border px-3 py-2 text-center">7</td>
                        <td class="border px-3 py-2 text-right">14.000</td>
                        <td class="border px-3 py-2 text-center space-x-2">
                            <button class="text-blue-500">Edit</button>
                            <button class="text-red-500">Hapus</button>
                        </td>
                    </tr>

                </tbody>

            </table>
        </div>
    </div>

</div>
@endsection