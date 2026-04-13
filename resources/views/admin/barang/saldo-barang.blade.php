@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Saldo Barang" />

    <div class="grid grid-cols-1 gap-6">
<div class="mt-6 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-gray-900 lg:p-6">
    <div class="mb-4">
        <h2 class="text-lg font-bold text-gray-800 dark:text-white">TABEL BARANG & SALDO AWAL</h2>
    </div>
    <div class="max-w-full overflow-x-auto custom-scrollbar">
        <table class="min-w-full">
            <thead>
                <tr class="border-gray-100 border-y dark:border-white/[0.05]">
                    <th class="px-6 py-3 text-left">
                        <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">NO</p>
                    </th>
                    <th class="px-6 py-3 text-left">
                        <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">NAMA BARANG</p>
                    </th>
                    <th class="px-6 py-3 text-left">
                        <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">SATUAN</p>
                    </th>
                    <th class="px-6 py-3 text-left">
                        <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">SALDO AWAL</p>
                    </th>
                    <th class="px-6 py-3 text-left">
                        <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">HARGA BELI AWAL</p>
                    </th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100 dark:divide-white/[0.05]">
                @foreach ($items as $item)
                    <tr>
                        <td class="px-6 py-3.5">
                            <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ $loop->iteration }}</p>
                        </td>
                        <td class="px-6 py-3.5">
                            <p class="font-medium text-gray-800 text-theme-sm dark:text-white/90">
                                {{ $item['nama_barang'] }}
                            </p>
                        </td>
                        <td class="px-6 py-3.5">
                            <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ $item['satuan'] }}</p>
                        </td>
                        <td class="px-6 py-3.5">
                            {{-- <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ $item['saldo_awal'] }}</p> --}}
                        </td>
                        <td class="px-6 py-3.5">
                            <p class="text-gray-500 text-theme-sm dark:text-gray-400">
                                Rp {{ $item['harga_beli'] }}
                            </p>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
    </div>
@endsection