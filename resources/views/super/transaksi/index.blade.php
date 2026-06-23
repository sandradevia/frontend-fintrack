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
                    <span class="w-40 text-sm text-gray-500">Nama Yayasan</span>
                    <span>:</span>
                    <span class="font-semibold">{{ $dapur->nama_yayasan }}</span>
                </div>
            </div>
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

                    {{-- Perbaikan: Mengubah penampung loop menjadi $item agar tidak menimpa variabel utama --}}
                    @forelse($transaksi as $item)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">

                        <td class="px-3 py-3 text-center">
                            {{ $loop->iteration }}
                        </td>

                        <td class="px-3 py-3">
                            {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                        </td>

                        <td class="px-3 py-3">
                            {{ $item->no_bukti }}
                        </td>

                        <td class="px-3 py-3">
                            {{ $item->uraian }}
                        </td>

                        <td class="px-3 py-3 text-right text-green-600 font-semibold">
                            Rp {{ number_format($item->debet,0,',','.') }}
                        </td>

                        <td class="px-3 py-3 text-right text-red-500">
                            Rp {{ number_format($item->kredit,0,',','.') }}
                        </td>

                        <td class="px-3 py-3">
                            {{ $item->akun->nama_akun ?? '-' }}
                        </td>

                        <td class="px-3 py-3">
                            {{ $item->keterangan }}
                        </td>

                        <td class="px-3 py-3">
                            <div class="flex justify-center gap-2">

                                {{-- EDIT --}}
                                <button
                                    @click='openEdit({
                                        id: {{ $item->id }},
                                        tanggal: "{{ $item->tanggal }}",
                                        no_bukti: "{{ $item->no_bukti }}",
                                        uraian: "{{ addslashes($item->uraian) }}",
                                        debet: {{ $item->debet }},
                                        kredit: {{ $item->kredit }},
                                        akun_id: "{{ $item->akun_id }}",
                                        keterangan: "{{ $item->keterangan }}"
                                    })'
                                    class="flex items-center gap-1.5 px-3 py-1.5 rounded-md bg-blue-50 text-blue-600 hover:bg-blue-100 text-xs font-medium">
                                    Edit
                                </button>

                                {{-- HAPUS --}}
                                <button
                                    type="button"
                                    @click="openHapus({{ $item->id }})"
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
            akun_id: '',
            keterangan: ''
        },

        formEdit: {
            id: null,
            tanggal: '',
            no_bukti: '',
            uraian: '',
            debet: '',
            kredit: '',
            akun_id: '',
            keterangan: ''
        },

        openTambah() {
            this.resetForm();
            // Menaruh nomor bukti otomatis dari backend controller
            this.form.no_bukti = "{{ $nextKwt ?? '' }}"; 
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
                akun_id: '',
                keterangan: ''
            };
        }
    }
}
</script>
@endsection