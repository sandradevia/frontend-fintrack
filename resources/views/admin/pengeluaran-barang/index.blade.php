@extends('layouts.app')

@section('content')
<x-common.page-breadcrumb pageTitle="Input Pengeluaran / Pemakaian Barang" />

<div class="space-y-6">

    {{-- 🔷 CARD UTAMA --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow border p-6 space-y-6">

        {{-- HEADER --}}
        <div class="text-center">
            <h1 class="text-xl font-bold">INPUT PENGELUARAN / PEMAKAIAN BARANG</h1>
            <p class="text-sm text-gray-500">SPPG GADOG MEGAMENDUNG</p>
            <p class="text-sm text-gray-500">Periode : 1 - 13 Desember 2025</p>
        </div>

        {{-- INFO --}}
        <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-lg text-sm">
            ⚠️ Pengeluaran akan mengurangi stok. Pastikan jumlah tidak melebihi stok.
        </div>

        <hr>

        {{-- FORM --}}
        <form class="grid grid-cols-1 md:grid-cols-6 gap-4" onsubmit="return false;">

            {{-- Tanggal --}}
            <div>
                <label class="text-sm text-gray-600">Tanggal</label>
                <input type="date"
                    class="w-full border rounded-lg px-3 py-2">
            </div>

            {{-- Petugas --}}
            <div>
                <label class="text-sm text-gray-600">Petugas</label>
                <input type="text" placeholder="Contoh: Budi"
                    class="w-full border rounded-lg px-3 py-2">
            </div>

            {{-- Barang --}}
            <div>
                <label class="text-sm text-gray-600">Barang</label>
                <select id="barang" onchange="pilihBarang()"
                    class="w-full border rounded-lg px-3 py-2">
                    <option value="">-- Pilih Barang --</option>

                    <option data-satuan="kg" data-stok="50">
                        Beras premium (Stok: 50)
                    </option>

                    <option data-satuan="ltr" data-stok="30">
                        Minyak goreng (Stok: 30)
                    </option>

                    <option data-satuan="kg" data-stok="20">
                        Telur ayam (Stok: 20)
                    </option>
                </select>
            </div>

            {{-- Volume --}}
            <div>
                <label class="text-sm text-gray-600">Volume</label>
                <input type="number" id="volume"
                    class="w-full border rounded-lg px-3 py-2">
            </div>

            {{-- Satuan --}}
            <div>
                <label class="text-sm text-gray-600">Satuan</label>
                <select id="satuan"
                    class="w-full border rounded-lg px-3 py-2">
                    <option>kg</option>
                    <option>ltr</option>
                    <option>pcs</option>
                    <option>pak</option>
                    <option>papan</option>
                </select>
            </div>
            {{-- BARIS STOK + BUTTON --}}
            <div class="md:col-span-6 flex justify-between items-center mt-2">

                {{-- INFO STOK --}}
                <div class="text-sm text-gray-500">
                    Stok tersedia: 
                    <span id="stok" class="font-semibold">-</span>
                </div>

                {{-- BUTTON --}}
                <div class="flex gap-2">
                    <button type="reset"
                        class="px-4 py-2 border rounded-lg text-gray-600">
                        Reset
                    </button>

                    <button type="button" onclick="tambahData()"
                        class="px-5 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg">
                        Simpan
                    </button>
                </div>

            </div>
        </form>

    </div>

    {{-- 🔷 TABEL --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow border p-6">

        <h2 class="text-lg font-semibold mb-4 border-b pb-2">
            Data Pengeluaran Barang
        </h2>

        <div class="overflow-x-auto">
            <table class="min-w-[800px] w-full border text-sm whitespace-nowrap">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border px-3 py-2">No</th>
                        <th class="border px-3 py-2">Tanggal</th>
                        <th class="border px-3 py-2">Petugas</th>
                        <th class="border px-3 py-2">Barang</th>
                        <th class="border px-3 py-2">Volume</th>
                        <th class="border px-3 py-2">Satuan</th>
                        <th class="border px-3 py-2">Aksi</th>
                    </tr>
                </thead>

                <tbody id="tableBody">
                    {{-- Data akan masuk via JS --}}
                </tbody>
            </table>
        </div>

    </div>

</div>

{{-- 🔷 SCRIPT --}}
<script>
let stokAktif = 0;
let no = 1;

function pilihBarang() {
    let select = document.getElementById('barang');
    let selected = select.options[select.selectedIndex];

    let satuan = selected.getAttribute('data-satuan');
    let stok = selected.getAttribute('data-stok');

    document.getElementById('satuan').value = satuan || '';
    document.getElementById('stok').innerText = stok || '-';

    stokAktif = parseFloat(stok) || 0;
}

function tambahData() {

    let tanggal = document.querySelector('input[type="date"]').value;
    let petugas = document.querySelector('input[type="text"]').value;
    let barang = document.getElementById('barang').value;
    let volume = document.getElementById('volume').value;
    let satuan = document.getElementById('satuan').value;

    if (volume > stokAktif) {
        alert('❌ Stok tidak cukup!');
        return;
    }

    let table = document.getElementById('tableBody');

    let row = `
        <tr class="hover:bg-gray-50">
            <td class="border px-3 py-2 text-center">${no++}</td>
            <td class="border px-3 py-2">${tanggal}</td>
            <td class="border px-3 py-2">${petugas}</td>
            <td class="border px-3 py-2">${barang}</td>
            <td class="border px-3 py-2 text-center">${volume}</td>
            <td class="border px-3 py-2 text-center">${satuan}</td>
            <td class="border px-3 py-2 text-center">
                <button onclick="hapusRow(this)" class="text-red-500">Hapus</button>
            </td>
        </tr>
    `;

    table.innerHTML += row;
}

function hapusRow(btn) {
    btn.closest('tr').remove();
}
</script>

@endsection