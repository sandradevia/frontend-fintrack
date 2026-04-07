@extends('layouts.app')

@section('content')
<x-common.page-breadcrumb pageTitle="Transaksi" />

<div x-data="transaksiHandler()" class="space-y-6">

    {{-- 🔷 INFORMASI --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-800 p-6">
        <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
            
            {{-- KIRI --}}
            <div class="flex flex-col gap-3">
                <div class="flex items-center gap-2">
                    <span class="w-40 text-sm text-gray-500">Nama Lembaga</span>
                    <span>:</span>
                    <span class="font-semibold">Yayasan Contoh Indonesia</span>
                </div>

                <div class="flex items-center gap-2">
                    <span class="w-40 text-sm text-gray-500">Periode</span>
                    <span>:</span>
                    <span>Januari 2026</span>
                </div>
            </div>

            {{-- KANAN --}}
            <button @click="openTambah()"
                class="bg-brand-500 hover:bg-brand-600 text-white px-5 py-2.5 rounded-lg text-sm font-medium">
                + Tambah Transaksi
            </button>
        </div>
    </div>

    {{-- 🔷 TABEL --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-800 p-6">

        <h2 class="text-lg font-semibold mb-4">Data Transaksi</h2>

        <div class="overflow-x-auto">
            <table class="min-w-full border rounded-lg overflow-hidden">
                
                <thead class="bg-gray-100 dark:bg-gray-800 text-xs uppercase">
                    <tr>
                        <th class="px-3 py-3">No</th>
                        <th class="px-3 py-3">Tanggal</th>
                        <th class="px-3 py-3">No Bukti</th>
                        <th class="px-3 py-3">Uraian</th>
                        <th class="px-3 py-3 text-right">Debet</th>
                        <th class="px-3 py-3 text-right">Kredit</th>
                        <th class="px-3 py-3">Jenis</th>
                        <th class="px-3 py-3">Keterangan</th>
                        <th class="px-3 py-3 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="text-sm divide-y">
                    
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                        <td class="px-3 py-3 text-center">1</td>
                        <td class="px-3 py-3">01 Jan 2026</td>
                        <td class="px-3 py-3">TRX-001</td>
                        <td class="px-3 py-3">Pembelian bahan</td>
                        <td class="px-3 py-3 text-right text-green-600 font-semibold">Rp 500.000</td>
                        <td class="px-3 py-3 text-right text-red-500">Rp 0</td>
                        <td class="px-3 py-3">Kas</td>
                        <td class="px-3 py-3">Awal</td>

                        {{-- AKSI --}}
                        <td class="px-3 py-3">
                            <div class="flex justify-center gap-2">

                                {{-- EDIT --}}
                                <button @click="openEdit({
                                        id: 1,
                                        tanggal: '2026-01-01',
                                        no_bukti: 'TRX-001',
                                        uraian: 'Pembelian bahan',
                                        debet: 500000,
                                        kredit: 0,
                                        jenis: 'Kas',
                                        keterangan: 'Awal'
                                    })"
                                    class="flex items-center gap-1.5 px-3 py-1.5 rounded-md bg-blue-50 text-blue-600 hover:bg-blue-100 text-xs font-medium">

                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            d="M15.232 5.232l3.536 3.536M9 11l6-6 3 3-6 6H9v-3z"/>
                                    </svg>
                                    Edit
                                </button>

                                {{-- HAPUS --}}
                                <button @click="openHapus(1)"
                                    class="flex items-center gap-1.5 px-3 py-1.5 rounded-md bg-red-50 text-red-600 hover:bg-red-100 text-xs font-medium">

                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            d="M6 7h12M9 7v12m6-12v12M4 7h16l-1 14H5L4 7zm5-3h6"/>
                                    </svg>
                                    Hapus
                                </button>

                            </div>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>

    {{-- INCLUDE MODAL --}}
    @include('admin.transaksi.modal-tambah')
    @include('admin.transaksi.modal-edit')
    @include('admin.transaksi.modal-hapus')

</div>

{{-- 🔥 ALPINE --}}
<script>
function transaksiHandler() {
    return {
        showTambah: false,
        showEdit: false,
        showHapus: false,
        selectedId: null,

        // 🔵 FORM TAMBAH
        form: {
            tanggal: '',
            no_bukti: '',
            uraian: '',
            debet: '',
            kredit: '',
            jenis: '',
            keterangan: ''
        },

        // 🟢 FORM EDIT
        formEdit: {
            tanggal: '',
            no_bukti: '',
            uraian: '',
            debet: '',
            kredit: '',
            jenis: '',
            keterangan: ''
        },

        // 🔥 OPEN TAMBAH
        openTambah() {
            this.resetForm();
            this.generateNoBukti();
            this.form.tanggal = new Date().toISOString().split('T')[0]; // default hari ini
            this.showTambah = true;
        },

        // 🔥 OPEN EDIT (AUTO ISI)
        openEdit(data) {
            this.formEdit = { ...data };
            this.selectedId = data.id;
            this.showEdit = true;
        },

        // 🔥 OPEN HAPUS
        openHapus(id) {
            this.selectedId = id;
            this.showHapus = true;
        },

        // 🔥 CLOSE SEMUA MODAL
        closeModal() {
            this.showTambah = false;
            this.showEdit = false;
            this.showHapus = false;
        },

        // 🔥 RESET FORM TAMBAH
        resetForm() {
            this.form = {
                tanggal: '',
                no_bukti: '',
                uraian: '',
                debet: '',
                kredit: '',
                jenis: '',
                keterangan: ''
            };
        },

        // 🔥 AUTO GENERATE NO BUKTI
        generateNoBukti() {
            const now = new Date();
            const random = Math.floor(Math.random() * 1000);
            this.form.no_bukti = 'TRX-' + now.getTime() + '-' + random;
        },

        // 🔥 SIMPAN DATA
        submitForm() {
            console.log('DATA TAMBAH:', this.form);

            // nanti bisa kirim ke backend
            this.closeModal();
        },

        // 🔥 UPDATE DATA
        updateData() {
            console.log('DATA EDIT:', this.formEdit);

            // nanti kirim ke backend
            this.closeModal();
        }

        deleteData() {
            console.log('Hapus ID:', this.selectedId);
            this.closeModal();
        }
    }
}
</script>

@endsection