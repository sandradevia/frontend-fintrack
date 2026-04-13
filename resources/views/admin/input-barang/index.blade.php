@extends('layouts.app')

@section('content')
<x-common.page-breadcrumb pageTitle="Input Nama Barang & Saldo Awal" />

<div class="space-y-6">

    {{-- 🔷 HEADER --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow border p-6 text-center">
        <h1 class="text-xl font-bold">INPUT NAMA BARANG DAN SALDO AWAL</h1>
        <p class="text-sm text-gray-500">Periode : 1 - 13 Desember 2025</p>
    </div>

    {{-- 🔷 FORM INPUT --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow border p-6">

        <h2 class="text-lg font-semibold mb-4">Tambah Data Barang</h2>

        <form action="{{ route('admin.input-barang.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            @csrf
            {{-- Nama Barang --}}
            <div class="col-span-2">
                <label class="text-sm text-gray-600">Nama Barang</label>
                <input type="text" name="nama" placeholder="Contoh: Beras premium"
                    class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200" required>
            </div>

            {{-- Satuan --}}
            <div>
                <label class="text-sm text-gray-600">Satuan</label>
                <select name="satuan" class="w-full border rounded-lg px-3 py-2" required>
                    <option value="kg">kg</option>
                    <option value="liter">liter</option>
                    <option value="pcs">pcs</option>
                </select>
            </div>

            {{-- Saldo --}}
            <div>
                <label class="text-sm text-gray-600">Saldo Awal</label>
                <input type="number" name="stok" placeholder="0"
                    class="w-full border rounded-lg px-3 py-2" min="0" value="0" required>
            </div>

            {{-- Harga --}}
            <div>
                <label class="text-sm text-gray-600">Harga Beli</label>
                <input type="number" name="harga_beli" placeholder="0"
                    class="w-full border rounded-lg px-3 py-2" min="0" value="0" required>
            </div>

            {{-- BUTTON --}}
            <div class="md:col-span-5 flex justify-end gap-2 mt-2">
                <button type="reset"
                    class="px-4 py-2 border rounded-lg text-gray-600">
                    Reset
                </button>

                <button type="submit"
                    class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg">
                    Simpan
                </button>
            </div>

        </form>
    </div>
    <!-- MODAL EDIT -->
    <div id="editModal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
        <!-- overlay -->
        <div class="absolute inset-0 bg-black bg-opacity-50" onclick="closeEditModal()"></div>

        <!-- modal content -->
        <div class="relative bg-white dark:bg-gray-900 rounded-xl shadow-lg w-full max-w-lg p-6 z-10">
            <h2 class="text-lg font-semibold mb-4">Edit Barang</h2>

            <form id="editForm" method="POST">
                @csrf
                @method('PUT') <!-- Untuk update -->

                <input type="hidden" id="edit_id" name="id">

                <div class="mb-4">
                    <label class="block text-sm text-gray-600">Nama Barang</label>
                    <input type="text" name="nama" id="edit_nama"
                        class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200">
                </div>

                <div class="mb-4">
                    <label class="block text-sm text-gray-600">Satuan</label>
                    <select name="satuan" id="edit_satuan" class="w-full border rounded-lg px-3 py-2">
                        <option value="kg">kg</option>
                        <option value="liter">liter</option>
                        <option value="pcs">pcs</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm text-gray-600">Stok</label>
                    <input type="number" name="stok" id="edit_stok"
                        class="w-full border rounded-lg px-3 py-2">
                </div>

                <div class="mb-4">
                    <label class="block text-sm text-gray-600">Harga Beli</label>
                    <input type="number" name="harga_beli" id="edit_harga"
                        class="w-full border rounded-lg px-3 py-2">
                </div>

                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeEditModal()"
                        class="px-4 py-2 border rounded-lg text-gray-600">Batal</button>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg">Simpan</button>
                </div>
            </form>

            <button onclick="closeEditModal()"
                class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">&times;</button>
        </div>
    </div>

    {{-- 🔷 TABEL DATA --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow border p-6">

        <h2 class="text-lg font-semibold mb-4">Daftar Barang</h2>

        <div class="overflow-x-auto">
            <table class="min-w-[700px] w-full border text-sm whitespace-nowrap">

                {{-- HEADER --}}
                <thead class="bg-gray-100 text-xs uppercase">
                    <tr>
                        <th class="border px-3 py-2 text-center">No</th>
                        <th class="border px-3 py-2">Nama Barang</th>
                        <th class="border px-3 py-2 text-center">Satuan</th>
                        <th class="border px-3 py-2 text-center">Saldo Awal</th>
                        <th class="border px-3 py-2 text-right">Harga Beli</th>
                        <th class="border px-3 py-2 text-center">Aksi</th>
                    </tr>
                </thead>

                {{-- BODY --}}
                <tbody>
                    @foreach ($items as $item)
                    <tr>
                        <td class="border px-3 py-2 text-center">{{ $loop->iteration }}</td>
                        <td class="border px-3 py-2">{{ $item->nama }}</td>
                        <td class="border px-3 py-2 text-center">{{ $item->satuan }}</td>
                        <td class="border px-3 py-2 text-center">{{ $item->stok }}</td>
                        <td class="border px-3 py-2 text-right">Rp {{ number_format($item->harga_beli, 0, ',', '.') }}</td>
                        <td class="border px-3 py-2 text-center flex justify-center gap-1">
                            <form action="{{ route('admin.input-barang.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus barang ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-2 py-1 bg-red-500 hover:bg-red-600 text-white rounded">
                                    Hapus
                                </button>
                            </form>
                            <button onclick="openEditModal('{{ $item->id }}', '{{ $item->nama }}', '{{ $item->satuan }}', '{{ $item->stok }}', '{{ $item->harga_beli }}')"
                                class="px-2 py-1 bg-blue-500 hover:bg-blue-600 text-white rounded">
                                Edit
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
function openEditModal(id, nama, satuan, stok, harga) {
    document.getElementById('editModal').classList.remove('hidden');
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_nama').value = nama;
    document.getElementById('edit_satuan').value = satuan;
    document.getElementById('edit_stok').value = stok;
    document.getElementById('edit_harga').value = harga;
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
}

// AJAX submit dengan FormData untuk Laravel
document.getElementById('editForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const id = document.getElementById('edit_id').value;
    const url = `admin/input-barang/${id}`; // pastikan sesuai route

    let formData = new FormData();
    formData.append('nama', document.getElementById('edit_nama').value);
    formData.append('satuan', document.getElementById('edit_satuan').value);
    formData.append('stok', document.getElementById('edit_stok').value);
    formData.append('harga_beli', document.getElementById('edit_harga').value);
    formData.append('_token', '{{ csrf_token() }}');
    formData.append('_method', 'PUT'); // Laravel method spoofing

    fetch(url, {
        method: 'POST', 
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if(data.status === 'success') {
            alert('Barang berhasil diupdate!');
            location.reload(); // refresh tabel
        } else {
            alert('Update gagal: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(err => {
        console.error(err);
        alert('Terjadi kesalahan pada server');
    });
});
</script>
@endsection