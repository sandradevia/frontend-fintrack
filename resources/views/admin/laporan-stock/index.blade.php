@extends('layouts.app')

@section('content')
<x-common.page-breadcrumb pageTitle="Laporan Stok Barang" />

<div class="space-y-6">
    
    {{-- 🔷 CARD UTAMA --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow border p-6 space-y-6">

        {{-- HEADER --}}
        <div class="text-center">
            <h1 class="text-xl font-bold">LAPORAN STOCK BARANG</h1>
            <p class="text-sm text-gray-500">{{ $dapur->nama_lembaga }}</p>
            <p class="text-sm text-gray-500">Periode : {{ $periodeAwal }} - {{ $periodeAkhir }}</p>
        </div>
        <div class="no-print">
            <a href="{{ route('admin.laporan.stock.export') }}"
            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm inline-block">
                Export Excel
            </a>
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

                @foreach ($items as $i => $item)
                <tr>
                    <td class="border px-3 py-2 text-center">{{ $i + 1 }}</td>

                    <td class="border px-3 py-2">{{ $item['nama_barang'] }}</td>
                    <td class="border px-3 py-2 text-center">{{ $item['satuan'] }}</td>

                    <td class="border px-3 py-2 text-right">{{ $item['saldo_awal'] }}</td>
                    <td class="border px-3 py-2 text-right text-green-600">{{ $item['masuk'] }}</td>
                    <td class="border px-3 py-2 text-right text-red-500">{{ $item['keluar'] }}</td>
                    <td class="border px-3 py-2 text-right">{{ $item['saldo_akhir'] }}</td>

                    <td class="border px-3 py-2 text-right">{{ number_format($item['harga_beli'], 0, ',', '.') }}</td>

                    <td class="border px-3 py-2 text-right text-blue-600">
                        {{ number_format($item['jumlah_nilai'], 0, ',', '.') }}
                    </td>
                </tr>
                @endforeach

                </tbody>

                {{-- 🔷 TOTAL --}}
                {{-- <tfoot>
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
                </tfoot> --}}

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