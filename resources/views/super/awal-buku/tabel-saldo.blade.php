@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Saldo Awal Buku" />

<div class="rounded-2xl border border-gray-200 bg-white overflow-hidden shadow-sm dark:border-gray-800 dark:bg-gray-900">

    {{-- Header --}}
    <div class="flex items-start justify-between gap-4 px-6 py-5 border-b border-gray-100 dark:border-gray-800">
        <div>
            <span class="inline-flex items-center gap-1.5 rounded-full bg-green-50 px-2.5 py-1 text-xs font-medium text-green-600 dark:bg-green-900/30 dark:text-green-400 mb-2">
                <svg class="h-2.5 w-2.5 fill-current" viewBox="0 0 12 12"><path d="M6 1a5 5 0 100 10A5 5 0 006 1zm0 1.5a3.5 3.5 0 110 7 3.5 3.5 0 010-7z"/></svg>
                Informasi Saldo Periode Aktif
            </span>
            <h2 class="text-base font-semibold text-gray-900 dark:text-white">Buku Kas & Pembantu</h2>
            <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">
                Pencatatan saldo awal berjalan otomatis berdasarkan sistem kunci periode akuntansi 10 harian.
            </p>

            <div class="mt-4 grid grid-cols-[160px_1fr] gap-y-1.5 text-sm">
                <span class="flex items-center gap-1.5 font-medium text-gray-500 dark:text-gray-400">
                    <span class="h-1.5 w-1.5 rounded-full bg-blue-400 shrink-0"></span>
                    Nama Lembaga
                </span>
                <span class="font-medium text-gray-900 dark:text-white">{{ $dapur->nama_lembaga }}</span>

                <span class="flex items-center gap-1.5 font-medium text-gray-500 dark:text-gray-400">
                    <span class="h-1.5 w-1.5 rounded-full bg-blue-400 shrink-0"></span>
                    Alamat
                </span>
                <span class="font-medium text-gray-900 dark:text-white">{{ $dapur->alamat }}</span>

                <span class="flex items-center gap-1.5 font-medium text-gray-500 dark:text-gray-400">
                    <span class="h-1.5 w-1.5 rounded-full bg-amber-400 shrink-0"></span>
                    Rentang Periode
                </span>
                <span class="font-semibold text-amber-600 dark:text-amber-400">
                    {{ \Carbon\Carbon::parse($periode->tanggal_mulai)->translatedFormat('d F Y') }} s/d 
                    {{ \Carbon\Carbon::parse($periode->tanggal_selesai)->translatedFormat('d F Y') }}
                </span>
            </div>
        </div>
    </div>

    {{-- 🔷 TABEL 1: BUKU KAS --}}
    <div class="overflow-x-auto">
        <table class="w-full text-sm border-collapse">
            <thead>
                <tr class="bg-gray-50 dark:bg-gray-800/50">
                    <th class="px-6 py-2.5 text-left text-[11px] font-semibold uppercase tracking-widest text-gray-400 dark:text-gray-500 w-24">Kode</th>
                    <th class="px-6 py-2.5 text-left text-[11px] font-semibold uppercase tracking-widest text-gray-400 dark:text-gray-500">Nama Akun</th>
                    <th class="px-6 py-2.5 text-right text-[11px] font-semibold uppercase tracking-widest text-gray-400 dark:text-gray-500 w-52">Saldo Awal</th>
                    <th class="px-6 py-2.5 text-right text-[11px] font-semibold uppercase tracking-widest text-gray-400 dark:text-gray-500 w-52">Saldo Akhir</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                @foreach ($akun as $item)
                    @if (!empty($item['is_section']))
                        <tr class="bg-gray-50 dark:bg-gray-800/40">
                            <td colspan="4" class="px-6 py-2 text-[11px] font-semibold uppercase tracking-widest text-gray-400 dark:text-gray-500">
                                {{ $item['nama_akun'] }}
                            </td>
                        </tr>
                    @else
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors {{ !empty($item['is_parent']) ? 'font-semibold' : '' }}">
                            <td class="px-6 py-3 {{ !empty($item['is_sub']) ? 'pl-10' : '' }}">
                                <span class="inline-block rounded-md bg-blue-50 px-2 py-0.5 text-xs font-mono font-medium text-blue-600 dark:bg-blue-900/30 dark:text-blue-400">
                                    {{ $item['kode'] }}
                                </span>
                            </td>
                            <td class="px-6 py-3 {{ !empty($item['is_sub']) ? 'pl-10 text-gray-500 dark:text-gray-400' : 'text-gray-800 dark:text-white' }} {{ !empty($item['is_parent']) ? 'text-gray-900 dark:text-white font-semibold' : '' }}">
                                {{ $item['nama_akun'] }}
                            </td>
                            <td class="px-6 py-3 text-right text-gray-700 dark:text-gray-300">
                                @if(!empty($item['saldo_awal']) && $item['saldo_awal'] !== '—')
                                    <div class="flex justify-between items-center w-full font-mono tabular-nums">
                                        <span class="text-xs text-gray-400 dark:text-gray-500">Rp</span>
                                        <span>{{ str_replace('Rp ', '', $item['saldo_awal']) }}</span>
                                    </div>
                                @else
                                    <span class="text-gray-400 dark:text-gray-500 pr-2">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-3 text-right text-gray-700 dark:text-gray-300">
                                @if(!empty($item['saldo_akhir']) && $item['saldo_akhir'] !== '—')
                                    <div class="flex justify-between items-center w-full font-mono tabular-nums">
                                        <span class="text-xs text-gray-400 dark:text-gray-500">Rp</span>
                                        <span>{{ str_replace('Rp ', '', $item['saldo_akhir']) }}</span>
                                    </div>
                                @else
                                    <span class="text-gray-400 dark:text-gray-500 pr-2">—</span>
                                @endif
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Divider --}}
    <div class="border-t border-gray-100 dark:border-gray-800"></div>

    {{-- 🔷 TABEL 2: CEK SALDO --}}
    <div class="bg-gray-50 dark:bg-gray-800/50 px-6 py-2">
        <span class="text-[11px] font-semibold uppercase tracking-widest text-gray-400 dark:text-gray-500">Cek Saldo</span>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm border-collapse">
            <thead>
                <tr class="bg-gray-50 dark:bg-gray-800/50">
                    <th class="px-6 py-2.5 text-left text-[11px] font-semibold uppercase tracking-widest text-gray-400 dark:text-gray-500">Nama Akun</th>
                    <th class="px-6 py-2.5 text-right text-[11px] font-semibold uppercase tracking-widest text-gray-400 dark:text-gray-500 w-52">Saldo Awal</th>
                    <th class="px-6 py-2.5 text-right text-[11px] font-semibold uppercase tracking-widest text-gray-400 dark:text-gray-500 w-52">Saldo Akhir</th>
                    <th class="px-6 py-2.5 text-center text-[11px] font-semibold uppercase tracking-widest text-gray-400 dark:text-gray-500 w-28">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                @foreach ($akun as $item)
                    @if (empty($item['is_section']))
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors">
                            <td class="px-6 py-3 {{ !empty($item['is_sub']) ? 'pl-10 text-gray-500 dark:text-gray-400' : 'font-medium text-gray-800 dark:text-white' }}">
                                {{ $item['nama_akun'] }}
                            </td>
                            <td class="px-6 py-3 text-right text-gray-700 dark:text-gray-300">
                                @if(!empty($item['saldo_awal']) && $item['saldo_awal'] !== '—')
                                    <div class="flex justify-between items-center w-full font-mono tabular-nums">
                                        <span class="text-xs text-gray-400 dark:text-gray-500">Rp</span>
                                        <span>{{ str_replace('Rp ', '', $item['saldo_awal']) }}</span>
                                    </div>
                                @else
                                    <span class="text-gray-400 dark:text-gray-500 pr-2">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-3 text-right text-gray-700 dark:text-gray-300">
                                @if(!empty($item['saldo_akhir']) && $item['saldo_akhir'] !== '—')
                                    <div class="flex justify-between items-center w-full font-mono tabular-nums">
                                        <span class="text-xs text-gray-400 dark:text-gray-500">Rp</span>
                                        <span>{{ str_replace('Rp ', '', $item['saldo_akhir']) }}</span>
                                    </div>
                                @else
                                    <span class="text-gray-400 dark:text-gray-500 pr-2">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-3 text-center">
                                @if (($item['status'] ?? '') === 'Sesuai')
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-green-50 px-2.5 py-1 text-xs font-medium text-green-600 dark:bg-green-900/30 dark:text-green-400">
                                        <span class="h-1.5 w-1.5 rounded-full bg-current"></span>
                                        Sesuai
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-red-50 px-2.5 py-1 text-xs font-medium text-red-600 dark:bg-red-900/30 dark:text-red-400">
                                        <span class="h-1.5 w-1.5 rounded-full bg-current"></span>
                                        {{ $item['status'] ?? 'Tidak Sesuai' }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection