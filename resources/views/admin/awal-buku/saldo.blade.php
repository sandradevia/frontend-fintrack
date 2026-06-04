@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Saldo Awal Buku" />

<div class="rounded-2xl border border-gray-200 bg-white overflow-hidden shadow-sm dark:border-gray-800 dark:bg-gray-900">

    {{-- Header --}}
    <div class="flex items-start justify-between gap-4 px-6 py-5 border-b border-gray-100 dark:border-gray-800">
        <div>
            <span class="inline-flex items-center gap-1.5 rounded-full bg-green-50 px-2.5 py-1 text-xs font-medium text-green-600 dark:bg-green-900/30 dark:text-green-400 mb-2">
                <svg class="h-2.5 w-2.5 fill-current" viewBox="0 0 12 12"><path d="M6 1a5 5 0 100 10A5 5 0 006 1zm0 1.5a3.5 3.5 0 110 7 3.5 3.5 0 010-7z"/></svg>
                Informasi Saldo
            </span>
            <h2 class="text-base font-semibold text-gray-900 dark:text-white">Buku Kas & Pembantu</h2>
            <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">
                Atur saldo awal buku untuk memulai pencatatan keuangan secara akurat.
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
            </div>
        </div>
    </div>

    {{-- Tabel Buku Kas --}}
    <div class="overflow-x-auto">
        <table class="w-full text-sm border-collapse">
            <thead>
                <tr class="bg-gray-50 dark:bg-gray-800/50">
                    <th class="px-6 py-2.5 text-left text-[11px] font-semibold uppercase tracking-widest text-gray-400 dark:text-gray-500 w-24">Kode</th>
                    <th class="px-6 py-2.5 text-left text-[11px] font-semibold uppercase tracking-widest text-gray-400 dark:text-gray-500">Nama Akun</th>
                    <th class="px-6 py-2.5 text-right text-[11px] font-semibold uppercase tracking-widest text-gray-400 dark:text-gray-500 w-40">Saldo Awal</th>
                    <th class="px-6 py-2.5 text-right text-[11px] font-semibold uppercase tracking-widest text-gray-400 dark:text-gray-500 w-40">Saldo Akhir</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                @foreach ($akuns as $akun)
                    @if (!empty($akun['is_section']))
                        {{-- Section divider row --}}
                        <tr class="bg-gray-50 dark:bg-gray-800/40">
                            <td colspan="4" class="px-6 py-2 text-[11px] font-semibold uppercase tracking-widest text-gray-400 dark:text-gray-500">
                                {{ $akun['nama_akun'] }}
                            </td>
                        </tr>
                    @else
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors {{ !empty($akun['is_parent']) ? 'font-semibold' : '' }}">
                            <td class="px-6 py-3 {{ !empty($akun['is_sub']) ? 'pl-10' : '' }}">
                                <span class="inline-block rounded-md bg-blue-50 px-2 py-0.5 text-xs font-mono font-medium text-blue-600 dark:bg-blue-900/30 dark:text-blue-400">
                                    {{ $akun['kode'] }}
                                </span>
                            </td>
                            <td class="px-6 py-3 {{ !empty($akun['is_sub']) ? 'pl-10 text-gray-500 dark:text-gray-400' : 'text-gray-800 dark:text-white' }} {{ !empty($akun['is_parent']) ? 'text-gray-900 dark:text-white font-semibold' : '' }}">
                                {{ $akun['nama_akun'] }}
                            </td>
                            <td class="px-6 py-3 text-right tabular-nums text-gray-700 dark:text-gray-300">
                                {{ $akun['saldo_awal'] ?: '—' }}
                            </td>
                            <td class="px-6 py-3 text-right tabular-nums text-gray-700 dark:text-gray-300">
                                {{ $akun['saldo_akhir'] ?: '—' }}
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Divider --}}
    <div class="border-t border-gray-100 dark:border-gray-800"></div>

    {{-- Tabel Cek Saldo --}}
    <div class="bg-gray-50 dark:bg-gray-800/50 px-6 py-2">
        <span class="text-[11px] font-semibold uppercase tracking-widest text-gray-400 dark:text-gray-500">Cek Saldo</span>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm border-collapse">
            <thead>
                <tr class="bg-gray-50 dark:bg-gray-800/50">
                    <th class="px-6 py-2.5 text-left text-[11px] font-semibold uppercase tracking-widest text-gray-400 dark:text-gray-500">Nama Akun</th>
                    <th class="px-6 py-2.5 text-right text-[11px] font-semibold uppercase tracking-widest text-gray-400 dark:text-gray-500 w-40">Saldo Awal</th>
                    <th class="px-6 py-2.5 text-right text-[11px] font-semibold uppercase tracking-widest text-gray-400 dark:text-gray-500 w-40">Saldo Akhir</th>
                    <th class="px-6 py-2.5 text-center text-[11px] font-semibold uppercase tracking-widest text-gray-400 dark:text-gray-500 w-28">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                @foreach ($akuns as $akun)
                    @if (empty($akun['is_section']))
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors">
                            <td class="px-6 py-3 {{ !empty($akun['is_sub']) ? 'pl-10 text-gray-500 dark:text-gray-400' : 'font-medium text-gray-800 dark:text-white' }}">
                                {{ $akun['nama_akun'] }}
                            </td>
                            <td class="px-6 py-3 text-right tabular-nums text-gray-700 dark:text-gray-300">
                                {{ $akun['saldo_awal'] ?: '—' }}
                            </td>
                            <td class="px-6 py-3 text-right tabular-nums text-gray-700 dark:text-gray-300">
                                {{ $akun['saldo_akhir'] ?: '—' }}
                            </td>
                            <td class="px-6 py-3 text-center">
                                @if ($akun['status'] === 'Sesuai')
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-green-50 px-2.5 py-1 text-xs font-medium text-green-600 dark:bg-green-900/30 dark:text-green-400">
                                        <span class="h-1.5 w-1.5 rounded-full bg-current"></span>
                                        Sesuai
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-red-50 px-2.5 py-1 text-xs font-medium text-red-600 dark:bg-red-900/30 dark:text-red-400">
                                        <span class="h-1.5 w-1.5 rounded-full bg-current"></span>
                                        {{ $akun['status'] }}
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