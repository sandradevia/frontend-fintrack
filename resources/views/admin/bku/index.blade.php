@extends('layouts.app')

@section('content')
<x-common.page-breadcrumb pageTitle="Buku Kas Umum (BKU)" />

<div class="space-y-6">
    

    {{-- FILTER --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm border p-6">
        <form method="GET" action="{{ route('admin.bku.index') }}">
            <div class="flex flex-wrap gap-4 items-end">
            @php
                $namaBulan = [
                    1 => 'Januari',
                    2 => 'Februari',
                    3 => 'Maret',
                    4 => 'April',
                    5 => 'Mei',
                    6 => 'Juni',
                    7 => 'Juli',
                    8 => 'Agustus',
                    9 => 'September',
                    10 => 'Oktober',
                    11 => 'November',
                    12 => 'Desember'
                ];
            @endphp

                <div>
                    <label class="block text-sm mb-1">Bulan</label>

                    <select name="bulan"
                        class="border rounded-lg px-3 py-2">

                        @for($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}"
                                {{ (int)$bulan == $i ? 'selected' : '' }}>
                                {{ $namaBulan[$i] }}
                            </option>
                        @endfor

                    </select>
                </div>

                <div>
                    <label class="block text-sm mb-1">Tahun</label>
                    <select name="tahun"
                        class="border rounded-lg px-3 py-2">
                        @for($i = date('Y') - 5; $i <= date('Y') + 5; $i++)
                            <option value="{{ $i }}"
                                {{ $tahun == $i ? 'selected' : '' }}>
                                {{ $i }}
                            </option>
                        @endfor
                    </select>
                </div>

                <button type="submit"
                    class="bg-brand-500 hover:bg-brand-600 text-white px-4 py-2 rounded-lg">
                    Filter
                </button>

            </div>
        </form>
    </div>

    {{-- INFO --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm border p-6">
        <div class="flex flex-col md:flex-row justify-between gap-4">

            <div class="space-y-3">

                <div class="flex gap-2">
                    <span class="w-40 text-sm text-gray-500">
                        Nama Lembaga
                    </span>
                    <span>:</span>
                    <span class="font-semibold">
                        Yayasan Contoh Indonesia
                    </span>
                </div>

                <div class="flex gap-2">
                    <span class="w-40 text-sm text-gray-500">
                        Periode
                    </span>
                    <span>:</span>
                    <span>
                        {{ \Carbon\Carbon::parse($tahun.'-'.$bulan.'-01')->translatedFormat('F Y') }}
                    </span>
                </div>

            </div>

            <div class="flex items-center gap-2">
            <a href="{{ route('admin.bku.export.excel') }}"
                class="bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-lg text-sm font-medium">
                    Export Excel
                </a>
            </div>

        </div>
    </div>

    {{-- SUMMARY --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        <div class="bg-white dark:bg-gray-900 p-5 rounded-2xl border shadow-sm">
            <p class="text-sm text-gray-500">
                Saldo Awal
            </p>

            <h2 class="text-xl font-bold text-gray-800 dark:text-white mt-1">
                Rp {{ number_format($saldoAwal,0,',','.') }}
            </h2>
        </div>

        <div class="bg-white dark:bg-gray-900 p-5 rounded-2xl border shadow-sm">
            <p class="text-sm text-gray-500">
                Total Debet
            </p>

            <h2 class="text-xl font-bold text-green-600 mt-1">
                Rp {{ number_format($totalDebet,0,',','.') }}
            </h2>
        </div>

        <div class="bg-white dark:bg-gray-900 p-5 rounded-2xl border shadow-sm">
            <p class="text-sm text-gray-500">
                Saldo Akhir
            </p>

            <h2 class="text-xl font-bold text-blue-600 mt-1">
                Rp {{ number_format($saldoAkhir,0,',','.') }}
            </h2>
        </div>

    </div>

    {{-- TABEL BKU --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm border p-6">

        <h2 class="text-lg font-semibold mb-4">
            Data Buku Kas Umum
        </h2>

        <div class="overflow-x-auto">

            <table class="min-w-full border rounded-lg overflow-hidden">

                <thead class="bg-gray-100 dark:bg-gray-800 text-xs uppercase">
                    <tr>
                        <th class="px-3 py-3">No</th>
                        <th class="px-3 py-3">Bulan</th>
                        <th class="px-3 py-3">Tanggal</th>
                        <th class="px-3 py-3">No Bukti</th>
                        <th class="px-3 py-3">Uraian</th>
                        <th class="px-3 py-3 text-right">Debet</th>
                        <th class="px-3 py-3 text-right">Kredit</th>
                        <th class="px-3 py-3 text-right">Saldo</th>
                    </tr>
                </thead>

                <tbody class="text-sm divide-y">

                    {{-- SALDO AWAL --}}
                    <tr class="bg-gray-50 dark:bg-gray-800 font-semibold">
                        <td colspan="7"
                            class="px-3 py-3 text-right">
                            Saldo Awal
                        </td>

                        <td class="px-3 py-3 text-right text-blue-600">
                            Rp {{ number_format($saldoAwal,0,',','.') }}
                        </td>
                    </tr>

                    @forelse($transaksi as $item)

                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">

                        <td class="px-3 py-3 text-center">
                            {{ $loop->iteration }}
                        </td>

                        <td class="px-3 py-3">
                            {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('F') }}
                        </td>

                        <td class="px-3 py-3">
                            {{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}
                        </td>

                        <td class="px-3 py-3">
                            {{ $item->no_bukti }}
                        </td>

                        <td class="px-3 py-3">
                            {{ $item->uraian }}
                        </td>

                        <td class="px-3 py-3 text-right text-green-600">
                            Rp {{ number_format($item->debet,0,',','.') }}
                        </td>

                        <td class="px-3 py-3 text-right text-red-500">
                            Rp {{ number_format($item->kredit,0,',','.') }}
                        </td>

                        <td class="px-3 py-3 text-right font-semibold">
                            Rp {{ number_format($item->saldo,0,',','.') }}
                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="8"
                            class="text-center py-10 text-gray-400">
                            Belum ada data transaksi
                        </td>
                    </tr>

                    @endforelse

                </tbody>

                <tfoot class="bg-gray-100 dark:bg-gray-800 font-semibold">

                    <tr>

                        <td colspan="5"
                            class="px-3 py-3 text-right">
                            Total
                        </td>

                        <td class="px-3 py-3 text-right text-green-600">
                            Rp {{ number_format($totalDebet,0,',','.') }}
                        </td>

                        <td class="px-3 py-3 text-right text-red-500">
                            Rp {{ number_format($totalKredit,0,',','.') }}
                        </td>

                        <td class="px-3 py-3 text-right text-blue-600">
                            Rp {{ number_format($saldoAkhir,0,',','.') }}
                        </td>

                    </tr>

                </tfoot>

            </table>

        </div>

    </div>

</div>
@endsection