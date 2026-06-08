@extends('layouts.app')

@section('content')
<x-common.page-breadcrumb pageTitle="Input Nama Barang & Saldo Awal" />

<div class="space-y-6">

    {{-- HEADER --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow border p-6 text-center">
        <h1 class="text-xl font-bold">INPUT NAMA BARANG DAN SALDO AWAL</h1>
        <p class="text-sm text-gray-500">Periode : {{ $periodeAwal }} - {{ $periodeAkhir }}</p>
    </div>

    {{-- FORM INPUT --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow border p-6">

        <h2 class="text-lg font-semibold mb-4">Tambah Data Barang</h2>

        <form action="{{ route('admin.input-barang.store') }}" method="POST"
              class="grid grid-cols-1 md:grid-cols-5 gap-4">
            @csrf

            {{-- Nama Barang --}}
            <div class="col-span-2">
                <label class="text-sm text-gray-600">Nama Barang</label>
                <input type="text" name="nama_barang"
                    class="w-full border rounded-lg px-3 py-2"
                    required>
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
                <input type="number" name="stok"
                    class="w-full border rounded-lg px-3 py-2"
                    min="0" value="0" required>
            </div>

            {{-- Supplier --}}
            <div>
                <label class="text-sm text-gray-600">Supplier</label>
                <input type="text" name="supplier"
                    class="w-full border rounded-lg px-3 py-2"
                    required>
            </div>

            {{-- BUTTON --}}
            <div class="md:col-span-5 flex justify-end gap-2 mt-2">
                <button type="reset"
                    class="px-4 py-2 border rounded-lg text-gray-600">
                    Reset
                </button>

                <button type="submit"
                    class="px-4 py-2 bg-blue-500 text-white rounded-lg">
                    Simpan
                </button>
            </div>

        </form>
    </div>

    {{-- MODAL EDIT --}}
    <div id="editModal" class="fixed inset-0 flex items-center justify-center z-50 hidden">

        <div class="absolute inset-0 bg-black/40" onclick="closeEditModal()"></div>

        <div class="relative bg-white dark:bg-gray-900 rounded-xl shadow-lg w-full max-w-lg p-6">

            <h2 class="text-lg font-semibold mb-4">Edit Barang</h2>

            <form id="editForm">

                @csrf
                @method('PUT')

                <input type="hidden" id="edit_id">

                <div class="mb-4">
                    <label class="text-sm">Nama Barang</label>
                    <input type="text" id="edit_nama"
                        class="w-full border rounded-lg px-3 py-2">
                </div>

                <div class="mb-4">
                    <label class="text-sm">Satuan</label>
                    <select id="edit_satuan" class="w-full border rounded-lg px-3 py-2">
                        <option value="kg">kg</option>
                        <option value="liter">liter</option>
                        <option value="pcs">pcs</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="text-sm">Stok</label>
                    <input type="number" id="edit_stok"
                        class="w-full border rounded-lg px-3 py-2">
                </div>

                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeEditModal()"
                        class="px-4 py-2 border rounded-lg">
                        Batal
                    </button>

                    <button type="submit"
                        class="px-4 py-2 bg-blue-500 text-white rounded-lg">
                        Simpan
                    </button>
                </div>

            </form>

        </div>
    </div>

    {{-- TABEL --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow border p-6">

        <h2 class="text-lg font-semibold mb-4">Daftar Barang</h2>

        <div class="overflow-x-auto">
            <table class="w-full text-sm border">

                <thead class="bg-gray-100">
                    <tr>
                        <th class="border px-3 py-2">No</th>
                        <th class="border px-3 py-2">Nama</th>
                        <th class="border px-3 py-2">Satuan</th>
                        <th class="border px-3 py-2">Saldo</th>
                        <th class="border px-3 py-2">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($barang as $item)
                    <tr>
                        <td class="border px-3 py-2 text-center">
                            {{ $loop->iteration }}
                        </td>

                        <td class="border px-3 py-2">
                            {{ $item->nama_barang }}
                        </td>

                        <td class="border px-3 py-2 text-center">
                            {{ $item->satuan }}
                        </td>

                        <td class="border px-3 py-2 text-center">
                            {{ $item->stokAwal->jumlah ?? 0 }}
                        </td>

                        <td class="border px-3 py-2 text-center flex gap-1 justify-center">

                            <form action="{{ route('admin.input-barang.destroy', $item->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Hapus barang?')">
                                @csrf
                                @method('DELETE')
                                <button class="px-2 py-1 bg-red-500 text-white rounded">
                                    Hapus
                                </button>
                            </form>

                            <button
                                class="px-2 py-1 bg-blue-500 text-white rounded"
                                onclick="openEditModal(@json($item))">
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
function openEditModal(item) {
    document.getElementById('editModal').classList.remove('hidden');

    document.getElementById('edit_id').value = item.id;
    document.getElementById('edit_nama').value = item.nama_barang;
    document.getElementById('edit_satuan').value = item.satuan;
    document.getElementById('edit_stok').value =
        item.stok_awal ? item.stok_awal.jumlah : 0;
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
}

document.getElementById('editForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const id = document.getElementById('edit_id').value;

    const url = "{{ url('/admin/input-barang') }}/" + id;

    let formData = new FormData();
    formData.append('nama_barang', document.getElementById('edit_nama').value);
    formData.append('satuan', document.getElementById('edit_satuan').value);
    formData.append('stok', document.getElementById('edit_stok').value);
    formData.append('_token', '{{ csrf_token() }}');
    formData.append('_method', 'PUT');

    fetch(url, {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(res => {
        if (res.status === 'success') {
            location.reload();
        } else {
            alert(res.message);
        }
    })
    .catch(() => alert('Server error'));
});
</script>

@endsection