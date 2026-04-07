@extends('layouts.app')

@section('content')
<x-common.page-breadcrumb pageTitle="Input Pembelian / Penerimaan Barang" />

<div class="space-y-6">

    {{-- 🔷 CARD UTAMA (HEADER + INFO + FORM) --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow border p-6 space-y-6">

        {{-- HEADER --}}
        <div class="text-center">
            <h1 class="text-xl font-bold">INPUT PEMBELIAN / PENERIMAAN BARANG</h1>
            <p class="text-sm text-gray-500">SPPG GADOG MEGAMENDUNG</p>
            <p class="text-sm text-gray-500">Periode : 1 - 13 Desember 2025</p>
        </div>

        {{-- INFO --}}
        <div class="bg-blue-50 border border-blue-200 text-blue-800 p-4 rounded-lg text-sm flex gap-2">
            <span>ℹ️</span>
            <p>
                Setelah klik <b>Simpan</b>, data akan otomatis tersimpan.
                Tidak perlu refresh seperti di Excel.
            </p>
        </div>

        <hr>

        {{-- FORM --}}
        <div>
            <h2 class="text-lg font-semibold mb-4">Tambah Data Pembelian</h2>

            <form class="grid grid-cols-1 md:grid-cols-7 gap-4">

                {{-- Tanggal --}}
                <div>
                    <label class="text-sm text-gray-600">Tanggal</label>
                    <input type="date"
                        class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200">
                </div>

                {{-- Supplier --}}
                <div class="md:col-span-2">
                    <label class="text-sm text-gray-600">Nama Supplier</label>
                    <input type="text" placeholder="Contoh: Koperasi Utama"
                        class="w-full border rounded-lg px-3 py-2">
                </div>

                {{-- Barang --}}
                <div class="md:col-span-2">
                    <label class="text-sm text-gray-600">Nama Barang</label>
                    <input type="text" placeholder="Contoh: Beras premium"
                        class="w-full border rounded-lg px-3 py-2">
                </div>

                {{-- Satuan --}}
                <div>
                    <label class="text-sm text-gray-600">Satuan</label>
                    <select class="w-full border rounded-lg px-3 py-2">
                        <option>kg</option>
                        <option>ltr</option>
                        <option>pcs</option>
                    </select>
                </div>

                {{-- Volume --}}
                <div>
                    <label class="text-sm text-gray-600">Volume</label>
                    <input type="number" id="volume"
                        class="w-full border rounded-lg px-3 py-2">
                </div>

                {{-- Harga --}}
                <div>
                    <label class="text-sm text-gray-600">Harga Beli</label>
                    <input type="number" id="harga"
                        class="w-full border rounded-lg px-3 py-2">
                </div>

                {{-- Total --}}
                <div>
                    <label class="text-sm text-gray-600">Total</label>
                    <input type="text" id="total" readonly
                        class="w-full border rounded-lg px-3 py-2 bg-gray-100">
                </div>

                {{-- BUTTON --}}
                <div class="md:col-span-7 flex justify-end gap-2 mt-2">
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

    </div>

    {{-- 🔷 CARD TABEL --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow border p-6">

        <h2 class="text-lg font-semibold mb-4 border-b pb-2">
            Data Pembelian Barang
        </h2>

        <div class="overflow-x-auto">
            <table class="min-w-[1000px] w-full border text-sm whitespace-nowrap">

                {{-- HEADER --}}
                <thead class="bg-gray-100 text-xs uppercase">
                    <tr>
                        <th class="border px-3 py-2 text-center">No</th>
                        <th class="border px-3 py-2">Tanggal</th>
                        <th class="border px-3 py-2">Supplier</th>
                        <th class="border px-3 py-2">Nama Barang</th>
                        <th class="border px-3 py-2 text-center">Satuan</th>
                        <th class="border px-3 py-2 text-center">Vol</th>
                        <th class="border px-3 py-2 text-right">Harga</th>
                        <th class="border px-3 py-2 text-right">Total</th>
                        <th class="border px-3 py-2 text-center">Aksi</th>
                    </tr>
                </thead>

                {{-- BODY --}}
                <tbody>

                    <tr class="hover:bg-gray-50">
                        <td class="border px-3 py-2 text-center">201</td>
                        <td class="border px-3 py-2">1 Desember 2025</td>
                        <td class="border px-3 py-2">Koperasi Utama</td>
                        <td class="border px-3 py-2">Beras premium</td>
                        <td class="border px-3 py-2 text-center">kg</td>
                        <td class="border px-3 py-2 text-center">1000</td>
                        <td class="border px-3 py-2 text-right">15.000</td>
                        <td class="border px-3 py-2 text-right">15.000.000</td>
                        <td class="border px-3 py-2 text-center space-x-2">
                            <button class="text-blue-500">Edit</button>
                            <button class="text-red-500">Hapus</button>
                        </td>
                    </tr>

                    <tr class="hover:bg-gray-50">
                        <td class="border px-3 py-2 text-center">202</td>
                        <td class="border px-3 py-2">1 Desember 2025</td>
                        <td class="border px-3 py-2">Koperasi Utama</td>
                        <td class="border px-3 py-2">Minyak goreng</td>
                        <td class="border px-3 py-2 text-center">ltr</td>
                        <td class="border px-3 py-2 text-center">200</td>
                        <td class="border px-3 py-2 text-right">17.000</td>
                        <td class="border px-3 py-2 text-right">3.400.000</td>
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

{{-- 🔷 SCRIPT AUTO HITUNG --}}
<script>
    const volume = document.getElementById('volume');
    const harga = document.getElementById('harga');
    const total = document.getElementById('total');

    function hitungTotal() {
        let v = parseFloat(volume.value) || 0;
        let h = parseFloat(harga.value) || 0;
        let hasil = v * h;

        total.value = hasil.toLocaleString('id-ID');
    }

    volume.addEventListener('input', hitungTotal);
    harga.addEventListener('input', hitungTotal);
</script>

@endsection