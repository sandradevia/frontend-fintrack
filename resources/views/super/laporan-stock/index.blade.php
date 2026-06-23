@extends('layouts.app')

@section('content')
<x-common.page-breadcrumb pageTitle="Laporan Stok Barang" />

<div class="space-y-6">
    
    {{-- 🔷 CARD UTAMA --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow border p-6 space-y-6">

        {{-- HEADER --}}
        <div class="text-center">
            <h1 class="text-xl font-bold">LAPORAN STOCK BARANG</h1>
        </div>
        <div class="no-print">
            <a href="{{ route('admin.laporan.stock.export') }}"
            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm inline-block">
                Export Excel
            </a>
        </div>

        <div class="flex flex-wrap items-center justify-between gap-4 mb-4 no-print">
            <form method="GET" action="{{ route('super.laporan-stock.index') }}">
                <select
                    name="dapur_id"
                    onchange="this.form.submit()"
                    class="border rounded-lg px-4 py-2">

                    <option value="">Semua Dapur</option>

                    @foreach($dapurList as $dapur)
                        <option
                            value="{{ $dapur->id }}"
                            {{ request('dapur_id') == $dapur->id ? 'selected' : '' }}>
                            {{ $dapur->nama_lembaga }}
                        </option>
                    @endforeach

                </select>
            </form>
            {{-- <a href="{{ route('super.laporan.stock.export', request()->query()) }}"
                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm">
                Export Excel
            </a> --}}

        </div>

        {{-- TABEL --}}
        <div class="overflow-x-auto">
            <table class="min-w-[1100px] w-full border text-sm whitespace-nowrap">

                {{-- HEADER --}}
                <thead class="bg-gray-100 text-xs uppercase">
                    <tr>
                        <th class="border px-3 py-2 text-center">No</th>
                        <th class="border px-3 py-2">Dapur</th>
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
                <tbody>
                @forelse ($items as $i => $item)

                <tr>
                    <td class="border px-3 py-2 text-center">
                        {{ $items->firstItem() + $i }}
                    </td>

                    <td class="border px-3 py-2">
                        {{ $item['nama_dapur'] }}
                    </td>

                    <td class="border px-3 py-2">
                        {{ $item['nama_barang'] }}
                    </td>

                    <td class="border px-3 py-2 text-center">
                        {{ $item['satuan'] }}
                    </td>

                    <td class="border px-3 py-2 text-right">
                        {{ number_format($item['saldo_awal']) }}
                    </td>

                    <td class="border px-3 py-2 text-right text-green-600">
                        {{ number_format($item['masuk']) }}
                    </td>

                    <td class="border px-3 py-2 text-right text-red-500">
                        {{ number_format($item['keluar']) }}
                    </td>

                    <td class="border px-3 py-2 text-right">
                        {{ number_format($item['saldo_akhir']) }}
                    </td>

                    <td class="border px-3 py-2 text-right">
                        {{ number_format($item['harga_beli'], 0, ',', '.') }}
                    </td>

                    <td class="border px-3 py-2 text-right text-blue-600">
                        {{ number_format($item['jumlah_nilai'], 0, ',', '.') }}
                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="10" class="text-center py-6 text-gray-500">
                        Tidak ada data
                    </td>
                </tr>

                @endforelse
                </tbody>
            </table>
            @if ($items->lastPage() > 1)
            <div class="flex justify-center items-center gap-2 mt-6 text-sm">

                {{-- Sebelumnya --}}
                @if ($items->onFirstPage())
                    <span class="text-gray-400">Sebelumnya</span>
                @else
                    <a href="{{ $items->previousPageUrl() }}"
                    class="text-blue-600 hover:underline">
                        Sebelumnya
                    </a>
                @endif

                {{-- Nomor halaman --}}
                @for ($page = 1; $page <= $items->lastPage(); $page++)
                    @if ($page == $items->currentPage())
                        <span class="px-2 py-1 bg-blue-600 text-white rounded">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $items->url($page) }}"
                        class="px-2 py-1 border rounded hover:bg-gray-100">
                            {{ $page }}
                        </a>
                    @endif
                @endfor

                {{-- Berikutnya --}}
                @if ($items->hasMorePages())
                    <a href="{{ $items->nextPageUrl() }}"
                    class="text-blue-600 hover:underline">
                        Berikutnya
                    </a>
                @else
                    <span class="text-gray-400">Berikutnya</span>
                @endif

            </div>
            @endif
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