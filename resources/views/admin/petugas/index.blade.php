@extends('layouts.app')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}
    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-sm">

        <div class="px-6 py-5 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

            {{-- LEFT --}}
            <div class="flex items-center gap-4">

                <div class="h-14 w-14 rounded-2xl bg-blue-100 flex items-center justify-center">

                    <i class="fa-solid fa-users text-2xl text-blue-700"></i>

                </div>

                <div>

                    <h1 class="text-2xl font-bold text-gray-800 dark:text-white">
                        Data Anggota Dapur
                    </h1>

                    <p class="text-sm text-gray-500 mt-1">
                        Pengelolaan data anggota dan pekerjaan pada sistem pelaporan keuangan gizi
                    </p>

                </div>

            </div>

            {{-- RIGHT --}}
            <div class="flex items-center gap-3">

                <div class="px-4 py-3 rounded-2xl bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600">

                    <p class="text-xs text-gray-500 uppercase tracking-wide">
                        Total Anggota
                    </p>

                    <h3 class="text-xl font-bold text-gray-800 dark:text-white">
                        {{ $anggota->count() }}
                    </h3>

                </div>

                <button
                    onclick="openModal()"
                    class="inline-flex items-center gap-2 px-5 py-3 bg-blue-700 hover:bg-blue-800 text-white rounded-2xl text-sm font-semibold shadow-sm transition-all duration-200"
                >

                    <i class="fa-solid fa-plus"></i>

                    Tambah Anggota

                </button>

            </div>

        </div>

    </div>

    {{-- TABLE --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm overflow-hidden border border-gray-200 dark:border-gray-700">

        {{-- HEADER TABLE --}}
        <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700">

            <h2 class="font-semibold text-gray-800 dark:text-white">
                Daftar Anggota
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Total {{ $anggota->count() }} anggota terdaftar
            </p>

        </div>

        {{-- TABLE CONTENT --}}
        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-gray-100 dark:bg-gray-700">

                    <tr>

                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">
                            No
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">
                            Nama Anggota
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">
                            Pekerjaan
                        </th>

                        <th class="px-6 py-4 text-center text-sm font-semibold text-gray-600 dark:text-gray-300">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($anggota as $i => $item)

                        <tr class="border-t border-gray-200 dark:border-gray-700 hover:bg-blue-50/40 dark:hover:bg-gray-700/30 transition">

                            {{-- NO --}}
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $i + 1 }}
                            </td>

                            {{-- NAMA --}}
                            <td class="px-6 py-4">

                                <div class="flex items-center gap-3">

                                    <div class="h-11 w-11 rounded-xl bg-gray-100 border border-gray-200 flex items-center justify-center text-gray-700 font-bold">

                                        {{ strtoupper(substr($item->nama, 0, 1)) }}

                                    </div>

                                    <div>

                                        <h3 class="font-semibold text-gray-800 dark:text-white">
                                            {{ $item->nama }}
                                        </h3>

                                    </div>

                                </div>

                            </td>

                            {{-- PEKERJAAN --}}
                            <td class="px-6 py-4">

                                <span class="inline-flex items-center px-3 py-1 rounded-xl bg-blue-50 text-blue-700 border border-blue-100 text-xs font-semibold">

                                    {{ $item->pekerjaan->nama_pekerjaan ?? '-' }}

                                </span>

                            </td>

                            {{-- AKSI --}}
                            <td class="px-6 py-4">

                                <div class="flex items-center justify-center gap-2">

                                    {{-- EDIT --}}
                                    <button
                                        onclick="editModal(
                                            '{{ $item->id }}',
                                            '{{ $item->nama }}',
                                            '{{ $item->pekerjaan_id }}'
                                        )"
                                        class="group flex items-center justify-center h-10 w-10 rounded-xl bg-amber-50 border border-amber-200 text-amber-600 hover:bg-amber-500 hover:text-white hover:border-amber-500 transition-all duration-200 shadow-sm"
                                        title="Edit Data"
                                    >

                                        <i class="fa-solid fa-pen-to-square text-sm"></i>

                                    </button>

                                    {{-- DELETE --}}
                                    <form
                                        action="{{ route('admin.petugas.destroy', $item->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus data ini?')"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="group flex items-center justify-center h-10 w-10 rounded-xl bg-red-50 border border-red-200 text-red-600 hover:bg-red-500 hover:text-white hover:border-red-500 transition-all duration-200 shadow-sm"
                                            title="Hapus Data"
                                        >

                                            <i class="fa-solid fa-trash-can text-sm"></i>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="4" class="py-14 text-center text-gray-400">

                                <div class="flex flex-col items-center gap-3">

                                    <i class="fa-solid fa-users text-4xl text-gray-300"></i>

                                    <div>

                                        <p class="font-semibold text-gray-500">
                                            Belum Ada Data Anggota
                                        </p>

                                        <p class="text-sm text-gray-400">
                                            Silakan tambahkan data anggota baru
                                        </p>

                                    </div>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

{{-- MODAL --}}
<div
    id="modal"
    class="fixed inset-0 hidden items-center justify-center bg-black/50 z-50 backdrop-blur-sm"
>

    <div class="bg-white dark:bg-gray-800 w-full max-w-lg rounded-2xl shadow-xl overflow-hidden border border-gray-200 dark:border-gray-700">

        {{-- HEADER --}}
        <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">

            <div>

                <h2
                    id="modalTitle"
                    class="text-xl font-bold text-gray-800 dark:text-white"
                >
                    Tambah Anggota
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Form pengelolaan data anggota
                </p>

            </div>

            <button
                onclick="closeModal()"
                class="h-10 w-10 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-700 transition"
            >

                <i class="fa-solid fa-xmark text-gray-500"></i>

            </button>

        </div>

        {{-- FORM --}}
        <form
            id="form"
            method="POST"
        >

            @csrf

            <input type="hidden" name="_method" id="method">

            <div class="p-6 space-y-5">

                {{-- NAMA --}}
                <div>

                    <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300">
                        Nama Anggota
                    </label>

                    <input
                        type="text"
                        name="nama"
                        id="nama"
                        required
                        class="w-full rounded-xl border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        placeholder="Masukkan nama anggota"
                    >

                </div>

                {{-- PEKERJAAN --}}
                <div>

                    <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300">
                        Pekerjaan
                    </label>

                    <select
                        name="pekerjaan_id"
                        id="pekerjaan_id"
                        required
                        class="w-full rounded-xl border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >

                        <option value="">
                            -- Pilih Pekerjaan --
                        </option>

                        @foreach($pekerjaan as $item)

                            <option value="{{ $item->id }}">
                                {{ $item->nama_pekerjaan }}
                            </option>

                        @endforeach

                    </select>

                </div>

            </div>

            {{-- FOOTER --}}
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 flex justify-end gap-3">

                <button
                    type="button"
                    onclick="closeModal()"
                    class="px-5 py-2.5 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-100 transition"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-blue-700 hover:bg-blue-800 text-white font-semibold transition"
                >

                    <i class="fa-solid fa-floppy-disk"></i>

                    Simpan

                </button>

            </div>

        </form>

    </div>

</div>

<script>

function openModal() {

    document.getElementById('modal').classList.remove('hidden');
    document.getElementById('modal').classList.add('flex');

    document.getElementById('modalTitle').innerText =
        'Tambah Anggota';

    document.getElementById('form').action =
        "{{ route('admin.petugas.store') }}";

    document.getElementById('method').value = 'POST';

    document.getElementById('form').reset();
}

function editModal(id, nama, pekerjaan_id) {

    document.getElementById('modal').classList.remove('hidden');
    document.getElementById('modal').classList.add('flex');

    document.getElementById('modalTitle').innerText =
        'Edit Anggota';

    document.getElementById('form').action =
        `/petugas/update/${id}`;

    document.getElementById('method').value = 'PUT';

    document.getElementById('nama').value = nama;
    document.getElementById('pekerjaan_id').value = pekerjaan_id;
}

function closeModal() {

    document.getElementById('modal').classList.add('hidden');
    document.getElementById('modal').classList.remove('flex');
}

</script>

@endsection