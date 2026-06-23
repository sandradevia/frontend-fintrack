@extends('layouts.app')

@section('content')

<!-- Phosphor Icons for Visual Consistency -->
<script src="https://unpkg.com/@phosphor-icons/web"></script>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

    .dapur-wrap * {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* Input Styling */
    .dapur-label {
        display: block;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.025em;
        text-transform: uppercase;
        color: #4b5563;
        margin-bottom: 0.5rem;
    }
    .dark .dapur-label { color: #9ca3af; }

    .dapur-input {
        width: 100%;
        padding: 0.65rem 1rem;
        border-radius: 12px;
        border: 1.5px solid #e5e7eb;
        background: #ffffff;
        font-size: 0.9rem;
        color: #111827;
        transition: all 0.2s ease;
        outline: none;
    }
    
    .dapur-input:focus {
        border-color: #2563eb;
        background: #fff;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
    }

    .dark .dapur-input {
        background: #111827;
        border-color: #374151;
        color: #f3f4f6;
    }

    /* Section Title Styling */
    .section-header-form {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 1.5rem;
    }

    .section-title-text {
        font-size: 0.85rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #374151;
        white-space: nowrap;
    }
    .dark .section-title-text { color: #d1d5db; }

    .section-line {
        flex-grow: 1;
        height: 1px;
        background: #e5e7eb;
    }
    .dark .section-line { background: #374151; }

    .icon-wrapper {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        background: #f3f4f6;
        color: #4b5563;
    }
    .dark .icon-wrapper { background: #374151; color: #d1d5db; }
</style>

<div class="dapur-wrap space-y-6 pb-12">

    {{-- BREADCRUMB --}}
    <x-common.page-breadcrumb 
        pageTitle="Edit Data Dapur"
        parentTitle="Dapur"
        :parentUrl="route('super.kelola-dapur.index')"
    />

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white dark:bg-gray-900 p-6 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="h-12 w-12 bg-orange-100 text-orange-600 rounded-xl flex items-center justify-center text-xl">
                <i class="ph-bold ph-pencil-line"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-900 dark:text-white">
                    Edit {{ $dapur->nama_lembaga }}
                </h1>
                <p class="text-xs text-gray-500">Pastikan data yang diinputkan sudah sesuai dengan berkas terbaru.</p>
            </div>
        </div>
        <a href="{{ route('super.kelola-dapur.index') }}"
           class="px-4 py-2 text-sm font-semibold text-gray-600 bg-gray-50 border border-gray-200 rounded-xl hover:bg-gray-100 transition-all">
           Batal & Kembali
        </a>
    </div>

    {{-- FORM --}}
    <form action="{{ route('super.kelola-dapur.update', $dapur->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            
            {{-- KIRI: DATA UTAMA --}}
            <div class="lg:col-span-8 space-y-6">
                <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 p-6 shadow-sm">
                    
                    {{-- INFORMASI LEMBAGA --}}
                    <div class="section-header-form">
                        <div class="icon-wrapper"><i class="ph-bold ph-buildings"></i></div>
                        <span class="section-title-text">Informasi Lembaga</span>
                        <div class="section-line"></div>
                    </div>

                    <div class="grid grid-cols-1 gap-5">
                        <div>
                            <label class="dapur-label">Nama Lembaga / SPPG</label>
                            <input name="nama_lembaga" value="{{ old('nama_lembaga', $dapur->nama_lembaga) }}" class="dapur-input" required placeholder="Contoh: SPPG Mentari Pagi">
                        </div>

                        <div>
                            <label class="dapur-label">Alamat Lengkap</label>
                            <textarea name="alamat" class="dapur-input" rows="3" required placeholder="Masukkan alamat lengkap...">{{ old('alamat', $dapur->alamat) }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="dapur-label">Nama Yayasan</label>
                                <input name="nama_yayasan" value="{{ old('nama_yayasan', $dapur->nama_yayasan) }}" class="dapur-input" placeholder="Nama yayasan (opsional)">
                            </div>
                            <div>
                                <label class="dapur-label">Ketua Yayasan</label>
                                <input name="ketua_yayasan" value="{{ old('ketua_yayasan', $dapur->ketua_yayasan) }}" class="dapur-input" placeholder="Nama ketua">
                            </div>
                        </div>
                    </div>

                    {{-- PENGELOLA --}}
                    <div class="section-header-form mt-10">
                        <div class="icon-wrapper"><i class="ph-bold ph-users"></i></div>
                        <span class="section-title-text">Pengelola & Keuangan</span>
                        <div class="section-line"></div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="dapur-label">Kepala SPPG</label>
                            <input name="nama_kepala_sppg" value="{{ old('nama_kepala_sppg', $dapur->nama_kepala_sppg) }}" class="dapur-input" required>
                        </div>
                        <div>
                            <label class="dapur-label">Nama Akuntan</label>
                            <input name="nama_akuntan" value="{{ old('nama_akuntan', $dapur->nama_akuntan) }}" class="dapur-input">
                        </div>
                        <div>
                            <label class="dapur-label">Nomor Rekening</label>
                            <input name="nomor_rekening" value="{{ old('nomor_rekening', $dapur->nomor_rekening) }}" class="dapur-input" placeholder="0000-0000-0000">
                        </div>
                    </div>
                </div>
            </div>

            {{-- KANAN: PELAPORAN & AKUN --}}
            <div class="lg:col-span-4 space-y-6">
                
                
                {{-- AKUN PENGGUNA --}}
<div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 p-6 shadow-sm border-t-4 border-t-indigo-500">
    <div class="section-header-form">
        <div class="icon-wrapper !text-indigo-600"><i class="ph-bold ph-lock-key"></i></div>
        <span class="section-title-text">Akses Pengelola</span>
        <div class="section-line"></div>
    </div>
    
    <div class="space-y-4">
        <div>
            <label class="dapur-label">Username Pengelola</label>
            <input name="username" value="{{ old('username', $user->username ?? '') }}" class="dapur-input bg-gray-50" placeholder="Masukkan username pengelola">
        </div>
        <div>
            <label class="dapur-label">Password Akun</label>
            <input type="password" name="password" class="dapur-input" placeholder="Masukkan password baru untuk pengelola">
            <p class="text-[10px] text-gray-400 mt-1 italic">*Biarkan kosong jika tidak ingin mengubah password</p>
        </div>
    </div>
</div>

                {{-- PELAPORAN
                <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 p-6 shadow-sm">
                    <div class="section-header-form">
                        <div class="icon-wrapper !text-orange-600"><i class="ph-bold ph-calendar"></i></div>
                        <span class="section-title-text">Periode</span>
                        <div class="section-line"></div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="dapur-label">Tempat Pelaporan</label>
                            <input name="tempat_pelaporan" value="{{ old('tempat_pelaporan', $dapur->tempat_pelaporan) }}" class="dapur-input">
                        </div>
                        <div>
    <label class="dapur-label">Tanggal Pelaporan</label>
    <input
        type="date"
        name="tanggal_pelaporan"
        value="{{ old('tanggal_pelaporan', isset($periode) ? $periode->tanggal_pelaporan?->format('Y-m-d') : '') }}"
        class="dapur-input">
</div> --}}

{{-- <div>
    <label class="dapur-label">Tahun Anggaran</label>
    <input
        type="number"
        name="tahun_anggaran"
        value="{{ old('tahun_anggaran', $periode->tahun_anggaran ?? '') }}"
        class="dapur-input"
        placeholder="2026">
</div>

<div>
    <label class="dapur-label">Tanggal Mulai</label>
    <input
        type="date"
        name="tanggal_mulai"
        value="{{ old('tanggal_mulai', isset($periode) ? $periode->tanggal_mulai?->format('Y-m-d') : '') }}"
        class="dapur-input">
</div>

<div>
    <label class="dapur-label">Tanggal Selesai</label>
    <input
        type="date"
        name="tanggal_selesai"
        value="{{ old('tanggal_selesai', isset($periode) ? $periode->tanggal_selesai?->format('Y-m-d') : '') }}"
        class="dapur-input">
</div> --}}
                    </div>
                </div>

                {{-- BUTTON ACTION --}}
                <div class="pt-2">
                    <button type="submit" class="w-full py-4 bg-blue-600 hover:bg-blue-700 text-white rounded-2xl font-bold text-sm shadow-lg shadow-blue-200 dark:shadow-none transition-all flex items-center justify-center gap-2">
                        <i class="ph-bold ph-floppy-disk text-lg"></i>
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection