@extends('layouts.app')

@section('content')
<x-common.page-breadcrumb pageTitle="Buku Pembantu Dana Insentif Fasilitas" />

<div class="space-y-6">

    {{-- 🔷 HEADER --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow border p-6 space-y-4">

        {{-- JUDUL --}}
        <div class="text-center">
            <h1 class="text-xl font-bold">BUKU PEMBANTU DANA INSENTIF FASILITAS</h1>
            <p class="text-sm text-gray-500">Periode : 
                @if($periode)
                    {{ \Carbon\Carbon::parse($periode->tanggal_mulai)->format('j') }}
                    -
                    {{ \Carbon\Carbon::parse($periode->tanggal_selesai)->translatedFormat('j F Y') }}
                @else
                    -
                @endif
            </p>
        </div>

        {{-- INFO --}}
        <div class="flex flex-col md:flex-row justify-between gap-4">

            {{-- KIRI --}}
            <div class="space-y-2 text-sm">
                <div class="flex gap-2">
                    <span class="w-32 text-gray-500">Nama Lembaga</span>
                    <span>:</span>
                    <span class="font-semibold">{{  $dapur->nama_lembaga }}</span>
                </div>

                <div class="flex gap-2">
                    <span class="w-32 text-gray-500">Alamat</span>
                    <span>:</span>
                    <span>{{  $dapur->alamat }}</span>
                </div>

                <div class="flex gap-2 mt-2">
                    <span class="w-32 text-gray-500">Jenis Buku</span>
                    <span>:</span>
                    <span class="font-semibold">Insentif Fasilitas</span>
                </div>
            </div>

            {{-- KANAN --}}
            <div class="text-sm border rounded-lg overflow-hidden p-3">
                <a href="{{ route('admin.bp-insentif.export') }}"
                    target="_blank"
                    class="bg-brand-500 hover:bg-brand-600 text-white px-5 py-2.5 rounded-lg text-sm font-medium">
                    Export Data
                </a>
            </div>
        </div>
    </div>

    {{-- 🔷 RINGKASAN --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        <div class="bg-white dark:bg-gray-900 p-5 rounded-2xl border shadow-sm">
            <p class="text-sm text-gray-500">Saldo Awal</p>
            <h2 class="text-xl font-bold text-gray-800 dark:text-white mt-1">
                Rp {{ number_format($saldoAwal, 0, ',', '.') }}
            </h2>
        </div>

        <div class="bg-white dark:bg-gray-900 p-5 rounded-2xl border shadow-sm">
            <p class="text-sm text-gray-500">Saldo Akhir</p>
            <h2 class="text-xl font-bold text-blue-600 mt-1">
                Rp {{ number_format($saldoAkhir, 0, ',', '.') }}
            </h2>
        </div>
    </div>

    {{-- 🔷 TABEL --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow border p-6">
        <h2 class="text-lg font-semibold mb-4">Data Buku Pembantu Dana Insentif Fasilitas</h2>

        <div class="overflow-x-auto">
            <table class="min-w-full border text-sm">

                {{-- HEADER --}}
                <thead class="bg-gray-100 text-xs uppercase">
                    <tr>
                        <th class="border px-2 py-2">Bulan</th>
                        <th class="border px-2 py-2">Tgl</th>
                        <th class="border px-2 py-2">No Bukti</th>
                        <th class="border px-2 py-2">Uraian Transaksi</th>
                        <th class="border px-2 py-2 text-right">Debet</th>
                        <th class="border px-2 py-2 text-right">Kredit</th>
                        <th class="border px-2 py-2 text-right">Saldo</th>
                    </tr>
                </thead>

                {{-- BODY --}}
                <tbody>

                    {{-- SALDO AWAL --}}
                    <tr class="bg-gray-50 font-medium">
                        <td class="border px-2 py-2 text-center"></td>
                        <td class="border"></td>
                        <td class="border"></td>
                        <td class="border px-2 py-2">SALDO AWAL BULAN BERJALAN</td>
                        <td class="border px-2 py-2 text-right">Rp {{ number_format($saldoAwal,0,',','.') }}</td>
                        <td class="border px-2 py-2 text-right">-</td>
                        <td class="border px-2 py-2 text-right">Rp {{ number_format($saldoAwal,0,',','.') }}</td>
                    </tr>

                    {{-- DATA 1 --}}
                    @forelse($transaksis as $trx)
                    <tr class="hover:bg-gray-50">

                        <td class="border px-2 py-2 text-center">
                            {{ \Carbon\Carbon::parse($trx['tanggal'])->translatedFormat('F') }}
                        </td>

                        <td class="border px-2 py-2 text-center">
                            {{ \Carbon\Carbon::parse($trx['tanggal'])->format('d') }}
                        </td>

                        <td class="border px-2 py-2">
                            {{ $trx['no_bukti'] }}
                        </td>

                        <td class="border px-2 py-2">
                            {{ $trx['uraian'] }}
                        </td>

                        <td class="border px-2 py-2 text-right text-green-600">
                            {{ $trx['debet'] > 0
                                ? 'Rp '.number_format($trx['debet'],0,',','.')
                                : '-' }}
                        </td>

                        <td class="border px-2 py-2 text-right text-red-500">
                            {{ $trx['kredit'] > 0
                                ? 'Rp '.number_format($trx['kredit'],0,',','.')
                                : '-' }}
                        </td>

                        <td class="border px-2 py-2 text-right">
                            Rp {{ number_format($trx['saldo'],0,',','.') }}
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-6 text-gray-400">
                            Belum ada data transaksi insentif fasilitas
                        </td>
                    </tr>
                    @endforelse

                </tbody>

            </table>
        </div>
    </div>

</div>
@endsection