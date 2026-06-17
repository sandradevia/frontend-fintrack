@extends('layouts.app')

@section('content')
<x-common.page-breadcrumb pageTitle="Manajemen Periode Akuntansi" />

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    {{-- Form Buka Periode Baru --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900 h-fit">
        <h3 class="text-base font-semibold text-gray-900 dark:text-white mb-1">Buka Periode Baru</h3>
        <p class="text-xs text-gray-500 dark:text-gray-400 mb-4">Membuka periode baru akan otomatis mengunci (tutup buku) periode aktif saat ini.</p>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-50 text-green-700 text-xs rounded-lg font-medium">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-4 p-3 bg-red-50 text-red-700 text-xs rounded-lg font-medium">{{ session('error') }}</div>
        @endif

        <form action="{{ route('admin.periode.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Tahun Anggaran</label>
                <input type="number" name="tahun_anggaran" value="{{ date('Y') }}" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-white" required>
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Mulai (Hari ke-1)</label>
                <input type="date" name="tanggal_mulai" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-white" required>
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Selesai (Hari ke-10)</label>
                <input type="date" name="tanggal_selesai" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-white" required>
            </div>

            <button type="submit" class="w-full rounded-lg bg-blue-600 px-4 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-700 transition-colors">
                Buka Periode & Kunci Saldo
            </button>
        </form>
    </div>

    {{-- Tabel Riwayat History Periode --}}
    <div class="lg:col-span-2 rounded-2xl border border-gray-200 bg-white overflow-hidden shadow-sm dark:border-gray-800 dark:bg-gray-900">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Riwayat Rentang Waktu Buku</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 dark:bg-gray-800/50 text-[11px] font-semibold uppercase tracking-wider text-gray-400">
                    <tr>
                        <th class="px-6 py-3">Tahun</th>
                        <th class="px-6 py-3">Rentang Tanggal</th>
                        <th class="px-6 py-3 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($allPeriode as $p)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $p->tahun_anggaran }}</td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-400">
                                {{ \Carbon\Carbon::parse($p->tanggal_mulai)->translatedFormat('d M Y') }} 
                                <span class="mx-1 text-gray-400">s/d</span> 
                                {{ \Carbon\Carbon::parse($p->tanggal_selesai)->translatedFormat('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($p->is_active)
                                    <span class="inline-flex items-center gap-1 rounded-full bg-green-50 px-2.5 py-1 text-xs font-medium text-green-700 dark:bg-green-900/30 dark:text-green-400">
                                        <span class="h-1.5 w-1.5 rounded-full bg-green-500"></span> Aktif Berjalan
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-600 dark:bg-gray-800 dark:text-gray-400">
                                        Terkuci / Ditutup
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-gray-400">Belum ada periode yang dibuat. Silakan tambahkan di form sebelah kiri.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection