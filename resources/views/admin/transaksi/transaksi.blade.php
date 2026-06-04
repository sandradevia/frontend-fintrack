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

                    @forelse($transaksis as $transaksi)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">

                        <td class="px-3 py-3 text-center">
                            {{ $loop->iteration }}
                        </td>

                        <td class="px-3 py-3">
                            {{ \Carbon\Carbon::parse($transaksi->tanggal)->format('d M Y') }}
                        </td>

                        <td class="px-3 py-3">
                            {{ $transaksi->no_bukti }}
                        </td>

                        <td class="px-3 py-3">
                            {{ $transaksi->uraian }}
                        </td>

                        <td class="px-3 py-3 text-right text-green-600 font-semibold">
                            Rp {{ number_format($transaksi->debet,0,',','.') }}
                        </td>

                        <td class="px-3 py-3 text-right text-red-500">
                            Rp {{ number_format($transaksi->kredit,0,',','.') }}
                        </td>

                        <td class="px-3 py-3">
                            {{ $transaksi->akun->nama_akun ?? '-' }}
                        </td>

                        <td class="px-3 py-3">
                            {{ $transaksi->keterangan }}
                        </td>

                        <td class="px-3 py-3">
                            <div class="flex justify-center gap-2">

                                {{-- EDIT --}}
                                <button
                                    @click='openEdit({
                                        id: {{ $transaksi->id }},
                                        tanggal: "{{ $transaksi->tanggal }}",
                                        no_bukti: "{{ $transaksi->no_bukti }}",
                                        uraian: "{{ $transaksi->uraian }}",
                                        debet: {{ $transaksi->debet }},
                                        kredit: {{ $transaksi->kredit }},
                                        akun_id: {{ $transaksi->akun_id }},
                                        keterangan: "{{ $transaksi->keterangan }}"
                                    })'
                                    class="flex items-center gap-1.5 px-3 py-1.5 rounded-md bg-blue-50 text-blue-600 hover:bg-blue-100 text-xs font-medium">
                                    Edit
                                </button>

                                {{-- HAPUS --}}
                                <button
                                    type="button"
                                    @click="openHapus({{ $transaksi->id }})"
                                    class="flex items-center gap-1.5 px-3 py-1.5 rounded-md bg-red-50 text-red-600 hover:bg-red-100 text-xs font-medium">
                                    Hapus
                                </button>

                            </div>
                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="9" class="text-center py-8 text-gray-500">
                            Belum ada data transaksi
                        </td>
                    </tr>

                    @endforelse

                    </tbody>
            </table>
        </div>
    </div>

    {{-- INCLUDE MODAL --}}
    @include('admin.transaksi.modal-tambah')
    @include('admin.transaksi.modal-edit')
    @include('admin.transaksi.modal-hapus')

</div>
<script>
window.transaksiHandler = function () {
    return {
        showTambah: false,
        showEdit: false,
        showHapus: false,
        selectedId: null,

        form: {
            tanggal: '',
            no_bukti: '',
            uraian: '',
            debet: '',
            kredit: '',
            jenis: '',
            keterangan: ''
        },

        formEdit: {
            tanggal: '',
            no_bukti: '',
            uraian: '',
            debet: '',
            kredit: '',
            jenis: '',
            keterangan: ''
        },

        openTambah() {
            this.resetForm();
            this.generateNoBukti();
            this.form.tanggal = new Date().toISOString().split('T')[0];
            this.showTambah = true;
        },

        openEdit(data) {
            this.formEdit = { ...data };
            this.selectedId = data.id;
            this.showEdit = true;
        },

        openHapus(id) {
            this.selectedId = id;
            this.showHapus = true;
        },

        closeModal() {
            this.showTambah = false;
            this.showEdit = false;
            this.showHapus = false;
        },

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

        generateNoBukti() {
            const now = new Date();
            const random = Math.floor(Math.random() * 1000);
            this.form.no_bukti = 'TRX-' + now.getTime() + '-' + random;
        },

        submitForm() {
            console.log('DATA TAMBAH:', this.form);
            this.closeModal();
        },

        updateData() {
            console.log('DATA EDIT:', this.formEdit);
            this.closeModal();
        }, // <-- koma di sini

        deleteData() {
            console.log('Hapus ID:', this.selectedId);
            this.closeModal();
        }
    }
}
</script>

@endsection