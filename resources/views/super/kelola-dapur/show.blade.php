@extends('layouts.app')

@section('content')

<!-- Menambahkan Heroicons untuk visual yang lebih baik -->
<script src="https://unpkg.com/@phosphor-icons/web"></script>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

    .detail-wrap * {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .card {
        border: 1px solid #e5e7eb;
        border-radius: 20px;
        background: white;
        transition: all 0.3s ease;
    }

    .card:hover {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }

    .dark .card {
        background: #111827;
        border-color: #1f2937;
    }

    .label {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: .05em;
        color: #6b7280;
        margin-bottom: 2px;
    }

    .value {
        font-size: 15px;
        font-weight: 600;
        color: #111827;
    }

    .dark .value {
        color: #f3f4f6;
    }

    .section-header {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 16px;
        padding-bottom: 12px;
        border-bottom: 1px dashed #e5e7eb;
    }

    .dark .section-header {
        border-bottom-color: #374151;
    }

    .section-title {
        font-size: 13px;
        font-weight: 800;
        color: #374151;
        text-transform: uppercase;
    }

    .dark .section-title {
        color: #d1d5db;
    }

    .icon-box {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        background: #eff6ff;
        color: #2563eb;
    }

    .credential-box {
        background: #f9fafb;
        border: 1px solid #f3f4f6;
        border-radius: 12px;
        padding: 12px;
    }

    .dark .credential-box {
        background: #1f2937;
        border-color: #374151;
    }
</style>

<div class="detail-wrap space-y-6 pb-10">

    {{-- BREADCRUMB --}}
    <x-common.page-breadcrumb 
        pageTitle="Detail Dapur"
        parentTitle="Dapur"
        :parentUrl="route('super.kelola-dapur.index')"
    />

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700">
        <div class="flex items-center gap-4">
            <div class="h-14 w-14 bg-blue-600 rounded-2xl flex items-center justify-center text-white text-2xl shadow-lg shadow-blue-200">
                <i class="ph-fill ph-storefront"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ $dapur->nama_lembaga }}
                </h1>
                <div class="flex items-center gap-2 text-sm text-gray-500">
                    <i class="ph ph-map-pin"></i>
                    <span>{{ $dapur->tempat_pelaporan }}</span>
                    <span class="mx-1">•</span>
                    <span class="bg-blue-100 text-blue-700 px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider">ID: {{ $dapur->id }}</span>
                </div>
            </div>
        </div>

        <div class="flex gap-3 w-full md:w-auto">
            <a href="{{ route('super.kelola-dapur.index') }}"
               class="flex-1 md:flex-none text-center px-5 py-2.5 text-sm font-semibold text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors">
               Kembali
            </a>
            <a href="#" {{-- Update route edit anda --}}
               class="flex-1 md:flex-none text-center px-5 py-2.5 text-sm font-semibold text-white bg-blue-600 rounded-xl hover:bg-blue-700 shadow-md shadow-blue-100 transition-all">
               Edit Data
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- LEFT COLUMN: INFO UTAMA & CREDENTIALS --}}
        <div class="lg:col-span-1 space-y-6">
            {{-- AKSES LOGIN --}}
            <div class="card p-6 border-t-4 border-t-indigo-500">
                <div class="section-header">
                    <div class="icon-box !background-indigo-50 !text-indigo-600">
                        <i class="ph-bold ph-lock-key"></i>
                    </div>
                    <p class="section-title">Akses Akun</p>
                </div>
                
                <div class="space-y-3">
                    <div class="credential-box">
                        <div class="label">Username</div>
                        <div class="value flex items-center justify-between">
                            <span>{{ $dapur->user->username ?? 'belum diatur' }}</span>
                            <button class="text-gray-400 hover:text-blue-600"><i class="ph ph-copy"></i></button>
                        </div>
                    </div>
                    <div class="credential-box">
                        <div class="label">Password</div>
                        <div class="value flex items-center justify-between">
                            <span class="font-mono text-xs text-gray-400">••••••••••••</span>
                            <button class="text-blue-600 text-xs font-bold hover:underline">Reset</button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- INFORMASI LEMBAGA --}}
            <div class="card p-6">
                <div class="section-header">
                    <div class="icon-box">
                        <i class="ph-bold ph-buildings"></i>
                    </div>
                    <p class="section-title">Informasi Lembaga</p>
                </div>

                <div class="space-y-4">
                    <div>
                        <div class="label">Alamat Lengkap</div>
                        <div class="value leading-relaxed">{{ $dapur->alamat }}</div>
                    </div>
                    <div class="grid grid-cols-2 gap-4 pt-2">
                        <div>
                            <div class="label">Yayasan</div>
                            <div class="value">{{ $dapur->nama_yayasan ?? '-' }}</div>
                        </div>
                        <div>
                            <div class="label">Ketua</div>
                            <div class="value">{{ $dapur->ketua_yayasan ?? '-' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- MIDDLE COLUMN: PENGELOLA --}}
        <div class="card p-6">
            <div class="section-header">
                <div class="icon-box !bg-green-50 !text-green-600">
                    <i class="ph-bold ph-users-three"></i>
                </div>
                <p class="section-title">Struktur Pengelola</p>
            </div>

            <div class="space-y-5">
                <div class="flex items-start gap-3">
                    <div class="mt-1 text-gray-400"><i class="ph ph-user-circle-gear text-xl"></i></div>
                    <div>
                        <div class="label">Kepala SPPG</div>
                        <div class="value text-lg text-blue-700 dark:text-blue-400">{{ $dapur->nama_kepala_sppg }}</div>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <div class="mt-1 text-gray-400"><i class="ph ph-user text-xl"></i></div>
                    <div>
                        <div class="label">Nama Pengelola</div>
                        <div class="value">{{ $dapur->nama_pengelola ?? '-' }}</div>
                    </div>
                </div>

                <div class="flex items-start gap-3 border-t border-gray-50 dark:border-gray-800 pt-4">
                    <div class="mt-1 text-gray-400"><i class="ph ph-calculator text-xl"></i></div>
                    <div>
                        <div class="label">Akuntan</div>
                        <div class="value">{{ $dapur->nama_akuntan ?? '-' }}</div>
                    </div>
                </div>

                <div class="flex items-start gap-3 bg-blue-50 dark:bg-gray-800 p-3 rounded-xl">
                    <div class="mt-1 text-blue-600"><i class="ph-bold ph-credit-card text-xl"></i></div>
                    <div>
                        <div class="label">No. Rekening Operasional</div>
                        <div class="value font-mono">{{ $dapur->nomor_rekening ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT COLUMN: PELAPORAN --}}
        <div class="card p-6">
            <div class="section-header">
                <div class="icon-box !bg-orange-50 !text-orange-600">
                    <i class="ph-bold ph-calendar-check"></i>
                </div>
                <p class="section-title">Status Pelaporan</p>
            </div>

            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <div class="label">Tahun Anggaran</div>
                        <div class="value">{{ $dapur->tahun_anggaran ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="label">Tanggal Lapor</div>
                        <div class="value">{{ $dapur->tanggal_pelaporan ?? '-' }}</div>
                    </div>
                </div>

                <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-xl space-y-3">
                    <div>
                        <div class="label text-blue-600 font-bold">Periode Saat Ini</div>
                        <div class="value">{{ $dapur->periode_saat_ini ?? '-' }}</div>
                    </div>
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-2">
                        <div class="label">Awal Periode Berikutnya</div>
                        <div class="value text-orange-600">{{ $dapur->awal_periode_berikutnya ?? '-' }}</div>
                    </div>
                </div>
                
                <div class="flex items-center gap-2 text-[10px] text-gray-400 italic mt-4">
                    <i class="ph ph-info"></i>
                    Data diperbarui secara otomatis oleh sistem
                </div>
            </div>
        </div>

    </div>
</div>

@endsection