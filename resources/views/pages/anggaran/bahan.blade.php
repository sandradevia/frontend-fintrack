@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Setup Anggaran" />

    <div class="space-y-6">

        <!-- Menu Tabs -->
        <div class="rounded-2xl border border-gray-200 bg-white p-2 shadow-sm dark:border-gray-800 dark:bg-gray-900">
            <div class="grid grid-cols-1 gap-2 md:grid-cols-3">
                <a href="{{ route('anggaran-bahan') }}"
                    class="group flex items-center gap-3 rounded-xl border border-blue-100 bg-blue-50 px-4 py-4 transition hover:shadow-sm dark:border-blue-900/40 dark:bg-blue-900/20">
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-600 text-white shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v10Z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-blue-700 dark:text-blue-300">
                            Anggaran Bahan Makanan
                        </h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            Atur biaya bahan pokok dan kebutuhan pangan.
                        </p>
                    </div>
                </a>

                <a 
                    class="group flex items-center gap-3 rounded-xl border border-gray-200 bg-gray-50 px-4 py-4 transition hover:border-emerald-200 hover:bg-emerald-50 hover:shadow-sm dark:border-gray-700 dark:bg-gray-800 dark:hover:border-emerald-900/40 dark:hover:bg-emerald-900/20">
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-500 text-white shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 10h18M7 15h1m4 0h5M6 5h12a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2Z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-800 dark:text-white">
                            Anggaran Operasional
                        </h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            Kelola biaya listrik, transportasi, dan operasional harian.
                        </p>
                    </div>
                </a>

                <a 
                    class="group flex items-center gap-3 rounded-xl border border-gray-200 bg-gray-50 px-4 py-4 transition hover:border-amber-200 hover:bg-amber-50 hover:shadow-sm dark:border-gray-700 dark:bg-gray-800 dark:hover:border-amber-900/40 dark:hover:bg-amber-900/20">
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-500 text-white shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3Zm0 0V4m0 10v6m8-8h-4M8 12H4m13.657 5.657-2.828-2.828M9.172 9.172 6.343 6.343m11.314 0-2.828 2.829m-5.657 5.656-2.829 2.829" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-800 dark:text-white">
                            Anggaran Insentif & Fasilitas
                        </h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            Atur insentif petugas serta biaya fasilitas pendukung.
                        </p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Content -->
        <div class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-800 dark:bg-gray-900">
            <x-anggaran.bahan />
        </div>
    </div>
@endsection