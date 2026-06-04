@extends('layouts.app')

@section('content')
<x-common.page-breadcrumb pageTitle="Input Pembelian / Penerimaan Barang" />

<div class="space-y-6">

    {{-- 🔷 CARD UTAMA (HEADER + INFO + FORM) --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow border p-6 space-y-6">

        {{-- HEADER --}}
        <div class="text-center">
            <h1 class="text-xl font-bold">INPUT PEMBELIAN / PENERIMAAN BARANG</h1>
            <p class="text-sm text-gray-500">{{ $dapur->nama_lembaga }}</p>
            <p class="text-sm text-gray-500">Periode : {{ $periodeAwal }} - {{ $periodeAkhir }}</p>
        </div>

        {{-- INFO --}}
        <div class="bg-blue-50 border border-blue-200 text-blue-800 p-4 rounded-lg text-sm flex gap-2">
            <span>ℹ️</span>
            <p>
                Setelah klik <b>Simpan</b>, data akan otomatis tersimpan.
                Tidak perlu refresh seperti di Excel.
            </p>
        </div>

        <hr>

        {{-- FORM --}}
        <div>
            <h2 class="text-lg font-semibold mb-4">Tambah Data Pembelian</h2>

            <form id="formPenerimaan" class="grid grid-cols-1 md:grid-cols-7 gap-4">
            @csrf
                {{-- Tanggal --}}
                <div>
                    <label class="text-sm text-gray-600">Tanggal</label>
                    <input type="date" name="tanggal_masuk"
                        class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200"
                        value="{{ old('tanggal_masuk', date('Y-m-d')) }}">
                </div>

                {{-- Supplier --}}
                <div class="md:col-span-2">
                    <label class="text-sm text-gray-600">Nama Supplier</label>
                    <input type="text" name="supplier" placeholder="Contoh: Koperasi Utama"
                        class="w-full border rounded-lg px-3 py-2" value="{{ old('supplier') }}">
                </div>

                {{-- Barang --}}
                <div class="md:col-span-2">
                    <label class="text-sm text-gray-600">Nama Barang</label>
                    <input type="text" name="nama_barang" id="namaBarang"
                        class="w-full border rounded-lg px-3 py-2"
                        placeholder="Contoh: Beras">
                </div>

                {{-- Satuan --}}
                <div>
                    <label class="text-sm text-gray-600">Satuan</label>

                    <select name="satuan" id="satuan"
                        class="w-full border rounded-lg px-3 py-2 bg-white focus:ring focus:ring-blue-200">

                        <option value="">-- Pilih Satuan --</option>
                        <option value="kg">Kilogram (kg)</option>
                        <option value="gram">Gram (g)</option>
                        <option value="liter">Liter (L)</option>
                        <option value="ml">Mililiter (ml)</option>
                        <option value="pcs">Pieces (pcs)</option>
                        <option value="pack">Pack</option>
                        <option value="dus">Dus</option>
                        <option value="karung">Karung</option>
                    </select>
                </div>

                {{-- Volume --}}
                <div>
                    <label class="text-sm text-gray-600">Volume</label>
                    <input type="number" name="jumlah" id="volume" class="w-full border rounded-lg px-3 py-2" value="{{ old('jumlah', 1) }}">
                </div>

                {{-- Harga --}}
                <div>
                    <label class="text-sm text-gray-600">Harga Beli</label>
                    <input type="number" name="harga_beli" id="harga" class="w-full border rounded-lg px-3 py-2" value="{{ old('harga_beli', 0) }}">
                </div>

                {{-- Total --}}
                <div>
                    <label class="text-sm text-gray-600">Total</label>
                    <input type="text" name="total_harga" id="total" readonly class="w-full border rounded-lg px-3 py-2 bg-gray-100">
                </div>

                {{-- BUTTON --}}
                <div class="md:col-span-7 flex justify-end gap-2 mt-2">
                    <button type="reset" class="px-4 py-2 border rounded-lg text-gray-600">Reset</button>
                    <button type="submit" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg">Simpan</button>
                </div>

            </form>
        </div>

    </div>

    {{-- 🔷 CARD TABEL --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow border p-6">

        <h2 class="text-lg font-semibold mb-4 border-b pb-2">
            Data Pembelian Barang
        </h2>

        <div class="overflow-x-auto">
            <table class="min-w-[1000px] w-full border text-sm whitespace-nowrap">

                {{-- HEADER --}}
                <thead class="bg-gray-100 text-xs uppercase">
                    <tr>
                        <th class="border px-3 py-2 text-center">No</th>
                        <th class="border px-3 py-2">Tanggal</th>
                        <th class="border px-3 py-2">Supplier</th>
                        <th class="border px-3 py-2">Nama Barang</th>
                        <th class="border px-3 py-2 text-center">Satuan</th>
                        <th class="border px-3 py-2 text-center">Vol</th>
                        <th class="border px-3 py-2 text-right">Harga</th>
                        <th class="border px-3 py-2 text-right">Total</th>
                        <th class="border px-3 py-2 text-center">Aksi</th>
                    </tr>
                </thead>

                {{-- BODY --}}
                <tbody id="tabelPenerimaan">
                    @foreach ($items as $item)
                        <tr id="row-{{ $item->id }}" class="hover:bg-gray-50">

                            <td class="border px-3 py-2 text-center">
                                {{ $loop->iteration }}
                            </td>

                            <td class="border px-3 py-2">
                                {{ $item->tanggal_masuk }}
                            </td>

                            <td class="border px-3 py-2">
                                {{ $item->barang->supplier ?? 'N/A' }}
                            </td>
                            
                            <td class="border px-3 py-2">
                                {{ $item->barang->nama_barang ?? 'N/A' }}
                            </td>

                            <td class="border px-3 py-2 text-center">
                                {{ $item->barang->satuan ?? 'N/A' }}
                            </td>

                            <td class="border px-3 py-2 text-center">
                                {{ $item->jumlah }}
                            </td>

                            <td class="border px-3 py-2 text-right">
                                {{ number_format($item->harga_beli, 0, ',', '.') }}
                            </td>

                            <td class="border px-3 py-2 text-right">
                                {{ number_format($item->jumlah * $item->harga_beli, 0, ',', '.') }}
                            </td>

                            <td class="border px-3 py-2 text-center space-x-2">

                                <button 
                                    onclick="editItem({{ $item->id }})"
                                    class="text-blue-500">
                                    Edit
                                </button>

                                <button 
                                    onclick="deleteItem({{ $item->id }})"
                                    class="text-red-500">
                                    Hapus
                                </button>

                            </td>
                            

                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
</div>
<div id="editModal" class="fixed inset-0 hidden items-center justify-center z-50">

    <div class="absolute inset-0 bg-gradient-to-br from-gray-900/40 to-indigo-900/40"
        onclick="closeEditModal()"></div>

    <div class="relative bg-white dark:bg-gray-900 rounded-xl shadow-lg w-full max-w-lg p-6 z-10">

        <button onclick="closeEditModal()"
            class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-xl">
            &times;
        </button>

        <h2 class="text-lg font-semibold mb-4">Edit Penerimaan Barang</h2>

        <form id="editForm" class="space-y-4">

        @csrf
        @method('PUT')

        <!-- Tanggal -->
        <div>
            <label class="block text-sm text-gray-600 mb-1">Tanggal</label>
            <input type="date" name="tanggal_masuk"
                class="w-full border p-2 rounded focus:ring focus:ring-blue-200">
        </div>

        <!-- Supplier -->
        <div>
            <label class="block text-sm text-gray-600 mb-1">Supplier</label>
            <input type="text" name="supplier"
                class="w-full border p-2 rounded focus:ring focus:ring-blue-200"
                placeholder="Masukkan nama supplier">
        </div>

        <!-- Nama Barang -->
        <div>
            <label class="block text-sm text-gray-600 mb-1">Nama Barang</label>
            <input type="text" name="nama_barang"
                class="w-full border p-2 rounded focus:ring focus:ring-blue-200"
                placeholder="Masukkan nama barang">
        </div>

        <!-- Jumlah -->
        <div>
            <label class="block text-sm text-gray-600 mb-1">Jumlah</label>
            <input type="number" name="jumlah"
                class="w-full border p-2 rounded focus:ring focus:ring-blue-200"
                placeholder="Masukkan jumlah">
        </div>

        <!-- Harga -->
        <div>
            <label class="block text-sm text-gray-600 mb-1">Harga Beli</label>
            <input type="number" name="harga_beli"
                class="w-full border p-2 rounded focus:ring focus:ring-blue-200"
                placeholder="Masukkan harga beli">
        </div>

        <!-- BUTTON -->
        <div class="flex justify-end gap-2 pt-2">
            <button type="button" onclick="closeEditModal()"
                class="px-4 py-2 border rounded text-gray-600">
                Batal
            </button>

            <button type="submit"
                class="px-4 py-2 bg-blue-500 text-white rounded">
                Update
            </button>
        </div>

    </form>
    </div>
</div>

{{-- 🔷 SCRIPT AUTO HITUNG & Satuan --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('formPenerimaan');
    const volume = document.getElementById('volume');
    const harga = document.getElementById('harga');
    const total = document.getElementById('total');
    const tbody = document.getElementById('tabelPenerimaan');

    // =========================
    // HITUNG TOTAL
    // =========================
    function hitungTotal() {
        let v = parseFloat(volume.value) || 0;
        let h = parseFloat(harga.value) || 0;
        total.value = (v * h).toLocaleString('id-ID');
    }

    if (volume && harga && total) {
        volume.addEventListener('input', hitungTotal);
        harga.addEventListener('input', hitungTotal);
    }

    // =========================
    // SUBMIT (CREATE + UPDATE)
    // =========================
    form.addEventListener('submit', function (e) {
        e.preventDefault();

        let id = form.getAttribute('data-id');
        let isEdit = !!id;

        let url = isEdit
            ? `/admin/penerimaan-barang/${id}`
            : `{{ route("admin.penerimaan-barang.store") }}`;

        let data = new FormData(form);

        if (isEdit) {
            data.append('_method', 'PUT');
        }

        fetch(url, {
            method: 'POST',
            body: data,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(res => {

            if (res.status !== 'success') {
                alert(res.message || 'Gagal menyimpan data');
                return;
            }

            let item = res.item;
            let namaBarang = item.barang?.nama_barang ?? '-';
            let satuan = item.barang?.satuan ?? '-';
            let supplier = item.barang?.supplier ?? '-';

            // =========================
            // UPDATE MODE
            // =========================
            if (isEdit) {

                let row = document.getElementById(`row-${id}`);

                row.innerHTML = `
                    <td class="border px-3 py-2 text-center">${row.children[0].innerText}</td>
                    <td class="border px-3 py-2">${item.tanggal_masuk}</td>
                    <td class="border px-3 py-2">${supplier}</td>
                    <td class="border px-3 py-2">${namaBarang}</td>
                    <td class="border px-3 py-2 text-center">${satuan}</td>
                    <td class="border px-3 py-2 text-center">${item.jumlah}</td>
                    <td class="border px-3 py-2 text-right">${Number(item.harga_beli).toLocaleString('id-ID')}</td>
                    <td class="border px-3 py-2 text-right">${Number(item.jumlah * item.harga_beli).toLocaleString('id-ID')}</td>
                    <td class="border px-3 py-2 text-center space-x-2">
                        <button onclick="editItem(${item.id})" class="text-blue-500">Edit</button>
                        <button onclick="deleteItem(${item.id})" class="text-red-500">Hapus</button>
                    </td>
                `;

            }

            // =========================
            // CREATE MODE
            // =========================
            else {

                let row = document.createElement('tr');
                row.id = `row-${item.id}`;

                row.innerHTML = `
                    <td class="border px-3 py-2 text-center">${tbody.children.length + 1}</td>
                    <td class="border px-3 py-2">${item.tanggal_masuk}</td>
                    <td class="border px-3 py-2">${supplier}</td>
                    <td class="border px-3 py-2">${namaBarang}</td>
                    <td class="border px-3 py-2 text-center">${satuan}</td>
                    <td class="border px-3 py-2 text-center">${item.jumlah}</td>
                    <td class="border px-3 py-2 text-right">${Number(item.harga_beli).toLocaleString('id-ID')}</td>
                    <td class="border px-3 py-2 text-right">${Number(item.jumlah * item.harga_beli).toLocaleString('id-ID')}</td>
                    <td class="border px-3 py-2 text-center space-x-2">
                        <button onclick="editItem(${item.id})" class="text-blue-500">Edit</button>
                        <button onclick="deleteItem(${item.id})" class="text-red-500">Hapus</button>
                    </td>
                `;

                tbody.appendChild(row);
            }

            // reset form
            form.reset();
            form.removeAttribute('data-id');
            if (total) total.value = '';

        })
        .catch(err => console.error(err));
    });

});
let editId = null;

/* ================= MODAL ================= */
function openEditModal() {
    document.getElementById('editModal').classList.remove('hidden');
    document.getElementById('editModal').classList.add('flex');
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
    document.getElementById('editModal').classList.remove('flex');
}

/* ================= EDIT ================= */
window.editItem = function (id) {

    fetch(`/admin/penerimaan-barang/${id}/edit`)
        .then(res => res.json())
        .then(res => {

            if (res.status !== 'success') return;

            let item = res.item;
            editId = id;

            const modal = document.getElementById('editModal');
            const form = document.getElementById('editForm');

            // open modal
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            // helper aman
            const setVal = (name, value) => {
                const el = form.querySelector(`[name="${name}"]`);
                if (el) el.value = value ?? '';
            };

            setVal('tanggal_masuk', item.tanggal_masuk);
            setVal('supplier', item.barang?.supplier);
            setVal('nama_barang', item.barang?.nama_barang);
            setVal('jumlah', item.jumlah);
            setVal('harga_beli', item.harga_beli);

            document.getElementById('edit_id').value = id;
        })
        .catch(err => console.error("EDIT ERROR:", err));
};

/* ================= UPDATE ================= */
document.getElementById('editForm').addEventListener('submit', function (e) {
    e.preventDefault();

    let data = new FormData(this);
    data.append('_method', 'PUT');

    fetch(`/admin/penerimaan-barang/${editId}`, {
        method: 'POST',
        body: data,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(res => res.json())
    .then(res => {

        if (res.status !== 'success') return;

        let item = res.item;
        let row = document.getElementById(`row-${editId}`);

        row.children[1].innerText = item.tanggal_masuk;
        row.children[2].innerText = item.barang?.supplier ?? '-';
        row.children[3].innerText = item.barang?.nama_barang ?? '-';
        row.children[4].innerText = item.barang?.satuan ?? '-';
        row.children[5].innerText = item.jumlah;
        row.children[6].innerText = Number(item.harga_beli).toLocaleString('id-ID');
        row.children[7].innerText = Number(item.jumlah * item.harga_beli).toLocaleString('id-ID');

        closeEditModal();

        // 🎉 SWEETALERT SUCCESS EDIT
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: 'Data berhasil diupdate',
            timer: 1500,
            showConfirmButton: false
        });
    });
});

/* ================= DELETE ================= */
window.deleteItem = function (id) {

    Swal.fire({
        title: 'Yakin hapus data?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Hapus'
    }).then((result) => {

        if (!result.isConfirmed) return;

        fetch(`/admin/penerimaan-barang/${id}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: new URLSearchParams({ _method: 'DELETE' })
        })
        .then(res => res.json())
        .then(res => {

            document.getElementById(`row-${id}`).remove();

            Swal.fire({
                icon: 'success',
                title: 'Terhapus!',
                timer: 1200,
                showConfirmButton: false
            });
        });

    });
};
</script>
@endsection