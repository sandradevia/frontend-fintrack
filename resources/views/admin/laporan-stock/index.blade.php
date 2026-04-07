@extends('layouts.app')

@section('content')
<x-common.page-breadcrumb pageTitle="Laporan Stok Barang" />

<div class="space-y-6">
    
    {{-- 🔷 CARD UTAMA --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow border p-6 space-y-6">

        {{-- HEADER --}}
        <div class="text-center">
            <h1 class="text-xl font-bold">LAPORAN STOCK BARANG</h1>
            <p class="text-sm text-gray-500">SPPG GADOG MEGAMENDUNG</p>
            <p class="text-sm text-gray-500">Periode : 1 - 13 Desember 2025</p>
        </div>
        <div class="no-print">
            <button onclick="printLaporan()"
                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm">
                Export Data
            </button>
        </div>

        <hr>

        {{-- TABEL --}}
        <div class="overflow-x-auto">
            <table class="min-w-[1100px] w-full border text-sm whitespace-nowrap">

                {{-- HEADER --}}
                <thead class="bg-gray-100 text-xs uppercase">
                    <tr>
                        <th class="border px-3 py-2 text-center">No</th>
                        <th class="border px-3 py-2">Nama Barang</th>
                        <th class="border px-3 py-2 text-center">Satuan</th>
                        <th class="border px-3 py-2 text-right">Saldo Awal</th>
                        <th class="border px-3 py-2 text-right">Masuk</th>
                        <th class="border px-3 py-2 text-right">Keluar</th>
                        <th class="border px-3 py-2 text-right">Saldo Akhir</th>
                        <th class="border px-3 py-2 text-right">Harga Beli</th>
                        <th class="border px-3 py-2 text-right">Jumlah</th>
                    </tr>
                </thead>

                {{-- BODY --}}
                <tbody id="tableBody">

                    {{-- CONTOH DATA --}}
                    <tr>
                        <td class="border px-3 py-2 text-center">1</td>
                        <td class="border px-3 py-2">Beras premium</td>
                        <td class="border px-3 py-2 text-center">kg</td>
                        <td class="border px-3 py-2 text-right">12</td>
                        <td class="border px-3 py-2 text-right text-green-600">1000</td>
                        <td class="border px-3 py-2 text-right text-red-500">10</td>
                        <td class="border px-3 py-2 text-right">1002</td>
                        <td class="border px-3 py-2 text-right">15000</td>
                        <td class="border px-3 py-2 text-right jumlah">15030000</td>
                    </tr>

                    <tr>
                        <td class="border px-3 py-2 text-center">2</td>
                        <td class="border px-3 py-2">Beras jagung</td>
                        <td class="border px-3 py-2 text-center">kg</td>
                        <td class="border px-3 py-2 text-right">8</td>
                        <td class="border px-3 py-2 text-right">0</td>
                        <td class="border px-3 py-2 text-right">0</td>
                        <td class="border px-3 py-2 text-right">8</td>
                        <td class="border px-3 py-2 text-right">17000</td>
                        <td class="border px-3 py-2 text-right jumlah">136000</td>
                    </tr>

                </tbody>

                {{-- 🔷 TOTAL --}}
                <tfoot>
                    <tr class="bg-gray-100 font-semibold">
                        <td colspan="3" class="border px-3 py-2 text-center">
                            TOTAL
                        </td>
                        <td class="border px-3 py-2 text-right" id="totalAwal">0</td>
                        <td class="border px-3 py-2 text-right" id="totalMasuk">0</td>
                        <td class="border px-3 py-2 text-right" id="totalKeluar">0</td>
                        <td class="border px-3 py-2 text-right" id="totalAkhir">0</td>
                        <td class="border px-3 py-2"></td>
                        <td class="border px-3 py-2 text-right text-blue-600" id="totalJumlah">0</td>
                    </tr>
                </tfoot>

            </table>
        </div>

        {{-- EMPTY STATE --}}
        <div id="emptyState" class="hidden text-center py-6 text-gray-500">
            📭 Data belum tersedia
        </div>

    </div>

</div>

{{-- 🔷 SCRIPT --}}
<script>
function formatRupiah(angka) {
    return angka.toLocaleString('id-ID');
}

function hitungTotal() {
    let rows = document.querySelectorAll("#tableBody tr");

    let totalAwal = 0;
    let totalMasuk = 0;
    let totalKeluar = 0;
    let totalAkhir = 0;
    let totalJumlah = 0;

    if (rows.length === 0) {
        document.getElementById('emptyState').classList.remove('hidden');
        return;
    }

    rows.forEach(row => {
        let cells = row.children;

        let awal = parseFloat(cells[3].innerText) || 0;
        let masuk = parseFloat(cells[4].innerText) || 0;
        let keluar = parseFloat(cells[5].innerText) || 0;
        let akhir = parseFloat(cells[6].innerText) || 0;
        let jumlah = parseFloat(cells[8].innerText) || 0;

        totalAwal += awal;
        totalMasuk += masuk;
        totalKeluar += keluar;
        totalAkhir += akhir;
        totalJumlah += jumlah;
    });

    document.getElementById('totalAwal').innerText = formatRupiah(totalAwal);
    document.getElementById('totalMasuk').innerText = formatRupiah(totalMasuk);
    document.getElementById('totalKeluar').innerText = formatRupiah(totalKeluar);
    document.getElementById('totalAkhir').innerText = formatRupiah(totalAkhir);
    document.getElementById('totalJumlah').innerText = formatRupiah(totalJumlah);
}

hitungTotal();
</script>

@endsection