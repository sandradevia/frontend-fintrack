@extends('layouts.app')

@section('content')
<x-common.page-breadcrumb pageTitle="BP Kas" />

<div class="space-y-6">

    {{-- 🔷 INFORMASI --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-800 p-6">
        <div class="flex flex-col md:flex-row md:justify-between gap-4">
            <div class="flex flex-col gap-1">
                <div class="flex gap-2">
                    <span class="w-40 text-sm text-gray-500">Nama Lembaga</span>
                    <span>:</span>
                    <span class="font-semibold">{{ $data['lembaga'] }}</span>
                </div>
                <div class="flex gap-2">
                    <span class="w-40 text-sm text-gray-500">Periode</span>
                    <span>:</span>
                    <span>{{ $data['periode'] }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- 🔷 TABEL CETAK --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-800 p-6">
        <h2 class="text-lg font-semibold mb-4">Buku Pembantu Kas</h2>

        <div class="overflow-x-auto">
            <table class="min-w-full border-collapse border border-gray-300">
                <thead class="bg-gray-100 dark:bg-gray-800 text-sm uppercase text-gray-600 dark:text-gray-300">
                    <tr>
                        <th class="border px-3 py-2">No</th>
                        <th class="border px-3 py-2">Tanggal</th>
                        <th class="border px-3 py-2">No Bukti</th>
                        <th class="border px-3 py-2">Uraian</th>
                        <th class="border px-3 py-2 text-right">Debet</th>
                        <th class="border px-3 py-2 text-right">Kredit</th>
                        <th class="border px-3 py-2 text-right">Saldo</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-200">
                    @php $saldo = 0; @endphp
                    @forelse($data['transaksi'] as $i => $trx)
                        @php
                            $saldo = $saldo + $trx['debet'] - $trx['kredit'];
                        @endphp
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                            <td class="border px-3 py-2 text-center">{{ $i + 1 }}</td>
                            <td class="border px-3 py-2">{{ date('d-m-Y', strtotime($trx['tanggal'])) }}</td>
                            <td class="border px-3 py-2">{{ $trx['no_bukti'] }}</td>
                            <td class="border px-3 py-2">{{ $trx['uraian'] }}</td>
                            <td class="border px-3 py-2 text-right">Rp {{ number_format($trx['debet'],0,',','.') }}</td>
                            <td class="border px-3 py-2 text-right">Rp {{ number_format($trx['kredit'],0,',','.') }}</td>
                            <td class="border px-3 py-2 text-right font-semibold">Rp {{ number_format($saldo,0,',','.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-10 text-gray-400">Belum ada transaksi</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection