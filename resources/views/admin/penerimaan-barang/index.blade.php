@extends('layouts.app')

@section('content')
<x-common.page-breadcrumb pageTitle="Input Pembelian / Penerimaan Barang" />

<div class="space-y-6">

    {{-- 🔷 CARD UTAMA --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow border p-6 space-y-6">

        {{-- HEADER --}}
        <div class="text-center">
            <h1 class="text-xl font-bold">INPUT PEMBELIAN / PENERIMAAN BARANG</h1>
            <p class="text-sm text-gray-500">{{ $dapur->nama_lembaga }}</p>
            <p class="text-sm text-gray-500">Periode : {{ $periodeAwal }} - {{ $periodeAkhir }}</p>
        </div>

        <div class="flex justify-between items-center">
        <div>
            <h2 class="text-lg font-semibold">
                Data Pembelian Barang
            </h2>
            <p class="text-sm text-gray-500">
                Klik tombol tambah untuk input pembelian baru
            </p>
        </div>

        <button
            onclick="openCreateModal()"
            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow">
            + Tambah Pembelian
        </button>
    </div>

    {{-- ===================== MODAL TAMBAH ===================== --}}
    <div id="createModal"
        class="fixed inset-0 hidden items-center justify-center z-50">

        <div class="absolute inset-0 bg-black/40"
            onclick="closeCreateModal()"></div>

        <div class="relative bg-white dark:bg-gray-900 rounded-xl shadow-xl w-full max-w-4xl p-6 z-10 max-h-[90vh] overflow-y-auto">

            <button
                onclick="closeCreateModal()"
                class="absolute top-3 right-4 text-2xl text-gray-500">
                ×
            </button>

            <h2 class="text-xl font-semibold mb-6">
                Tambah Data Pembelian
            </h2>

            <form id="formPenerimaan"
                class="grid grid-cols-1 md:grid-cols-7 gap-4"
                enctype="multipart/form-data">

                @csrf

                {{-- Tanggal --}}
                <div>
                    <label class="text-sm text-gray-600">Tanggal</label>
                    <input type="date"
                        name="tanggal_masuk"
                        class="w-full border rounded-lg px-3 py-2"
                        value="{{ date('Y-m-d') }}">
                </div>

                {{-- Supplier
                <div class="md:col-span-2">
                    <label class="text-sm text-gray-600">Supplier</label>
                    <input type="text"
                        name="supplier"
                        class="w-full border rounded-lg px-3 py-2">
                </div> --}}

                {{-- Barang --}}
                <div class="md:col-span-2">
                    <label class="text-sm text-gray-600">Nama Barang</label>
                    <input type="text"
                        name="nama_barang"
                        id="namaBarang"
                        class="w-full border rounded-lg px-3 py-2">
                </div>

                {{-- Satuan --}}
                <div>
                    <label class="text-sm text-gray-600">Satuan</label>
                    <select name="satuan"
                        id="satuan"
                        class="w-full border rounded-lg px-3 py-2">
                        <option value="">-- Pilih --</option>
                        <option value="kg">kg</option>
                        <option value="gram">gram</option>
                        <option value="liter">liter</option>
                        <option value="ml">ml</option>
                        <option value="pcs">pcs</option>
                        <option value="pack">pack</option>
                        <option value="dus">dus</option>
                        <option value="karung">karung</option>
                    </select>
                </div>

                {{-- Volume --}}
                <div>
                    <label class="text-sm text-gray-600">Volume</label>
                    <input type="number"
                        name="jumlah"
                        id="volume"
                        class="w-full border rounded-lg px-3 py-2">
                </div>

                {{-- Harga --}}
                <div>
                    <label class="text-sm text-gray-600">Harga</label>
                    <input type="number"
                        name="harga_beli"
                        id="harga"
                        class="w-full border rounded-lg px-3 py-2">
                </div>

                {{-- Total --}}
                <div>
                    <label class="text-sm text-gray-600">Total</label>
                    <input type="text"
                        id="total"
                        readonly
                        class="w-full border rounded-lg px-3 py-2 bg-gray-100">
                </div>

                {{-- Upload Foto --}}
                <div class="md:col-span-7">
                    <label class="text-sm text-gray-600">Foto Bukti / Nota Pembelian <span class="text-gray-400">(opsional)</span></label>
                    <div id="dropZone"
                        class="mt-1 flex flex-col items-center justify-center w-full border-2 border-dashed border-gray-300 rounded-xl px-6 py-6 cursor-pointer hover:border-blue-400 hover:bg-blue-50 transition-colors"
                        onclick="document.getElementById('fotoBukti').click()">
 
                        <div id="dropPlaceholder" class="flex flex-col items-center gap-2 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="text-sm font-medium">Klik atau seret foto ke sini</p>
                            <p class="text-xs">PNG, JPG, JPEG hingga 5MB</p>
                        </div>
 
                        <img id="previewFoto" src="#" alt="Preview"
                            class="hidden max-h-40 rounded-lg object-contain mt-2">
 
                        <p id="namaFileFoto" class="hidden text-xs text-blue-600 mt-2 font-medium"></p>
                    </div>
                    <input type="file" id="fotoBukti" name="gambar" accept="image/*" class="hidden">
                </div>

                <div class="md:col-span-7 flex justify-end gap-2 pt-4">
                    <button type="button"
                        onclick="closeCreateModal()"
                        class="px-4 py-2 border rounded-lg">
                        Batal
                    </button>

                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg">
                        Simpan
                    </button>
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
            <table class="min-w-[1100px] w-full border text-sm whitespace-nowrap">

                {{-- HEADER --}}
                <thead class="bg-gray-100 text-xs uppercase">
                    <tr>
                        <th class="border px-3 py-2 text-center">No</th>
                        <th class="border px-3 py-2">Tanggal</th>
                        {{-- <th class="border px-3 py-2">Supplier</th> --}}
                        <th class="border px-3 py-2">Nama Barang</th>
                        <th class="border px-3 py-2 text-center">Satuan</th>
                        <th class="border px-3 py-2 text-center">Vol</th>
                        <th class="border px-3 py-2 text-right">Harga</th>
                        <th class="border px-3 py-2 text-right">Total</th>
                        <th class="border px-3 py-2 text-center">Bukti</th>
                        <th class="border px-3 py-2 text-center">Status</th>
                        <th class="border px-3 py-2 text-center">Aksi</th>
                    </tr>
                </thead>

                {{-- BODY --}}
                <tbody id="tabelPenerimaan">
                    @foreach ($items as $item)
                        <tr id="row-{{ $item->id }}" class="hover:bg-gray-50">

                            <td class="border px-3 py-2 text-center">{{ $loop->iteration }}</td>

                            <td class="border px-3 py-2">{{ $item->tanggal_masuk }}</td>

                            {{-- <td class="border px-3 py-2">{{ $item->barang->supplier ?? 'N/A' }}</td> --}}

                            <td class="border px-3 py-2">{{ $item->barang->nama_barang ?? 'N/A' }}</td>

                            <td class="border px-3 py-2 text-center">{{ $item->barang->satuan ?? 'N/A' }}</td>

                            <td class="border px-3 py-2 text-center">{{ $item->jumlah }}</td>
                            

                            <td class="border px-3 py-2 text-right">
                                {{ number_format($item->harga_beli, 0, ',', '.') }}
                            </td>

                            <td class="border px-3 py-2 text-right">
                                {{ number_format($item->jumlah * $item->harga_beli, 0, ',', '.') }}
                            </td>

                            {{-- Kolom Bukti Foto --}}
                            <td class="border px-3 py-2 text-center">
                                @if ($item->gambar)
                                    <button onclick="lihatFoto('{{ $item->gambar_url }}')"
                                        class="text-blue-500 hover:underline text-xs flex items-center gap-1 mx-auto">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        Lihat
                                    </button>
                                @else
                                    <span class="text-gray-400 text-xs">—</span>
                                @endif
                            </td>

                            {{-- Kolom Status --}}
                            <td class="border px-3 py-2 text-center">
                                @php
                                    $status = $item->status_acc ?? 'menunggu';
                                @endphp
                                <span id="status-{{ $item->id }}"
                                    class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium
                                    {{ $status === 'disetujui' ? 'bg-green-100 text-green-700' :
                                      ($status === 'ditolak'  ? 'bg-red-100 text-red-700' :
                                                                 'bg-yellow-100 text-yellow-700') }}">
                                    @if ($status === 'disetujui')
                                        ✅ Disetujui
                                    @elseif ($status === 'ditolak')
                                        ❌ Ditolak
                                    @else
                                        ⏳ Menunggu
                                    @endif
                                </span>
                            </td>

                            <td class="border px-3 py-2 text-center space-x-1">
                                <button onclick="editItem({{ $item->id }})"
                                    class="text-blue-500 hover:underline text-xs">Edit</button>
                                <span class="text-gray-300">|</span>
                                <button onclick="deleteItem({{ $item->id }})"
                                    class="text-red-500 hover:underline text-xs">Hapus</button>
                            </td>

                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
</div>

{{-- ===================== MODAL EDIT ===================== --}}
<div id="editModal" class="fixed inset-0 hidden items-center justify-center z-50">

    <div class="absolute inset-0 bg-gradient-to-br from-gray-900/40 to-indigo-900/40"
        onclick="closeEditModal()"></div>

    <div class="relative bg-white dark:bg-gray-900 rounded-xl shadow-lg w-full max-w-lg p-6 z-10 max-h-[90vh] overflow-y-auto">

        <button onclick="closeEditModal()"
            class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-xl">&times;</button>

        <h2 class="text-lg font-semibold mb-4">Edit Penerimaan Barang</h2>

        <form id="editForm" class="space-y-4" enctype="multipart/form-data">
        @csrf
        <input type="hidden" id="edit_id" name="edit_id">

        <div>
            <label class="block text-sm text-gray-600 mb-1">Tanggal</label>
            <input type="date" name="tanggal_masuk"
                class="w-full border p-2 rounded focus:ring focus:ring-blue-200">
        </div>

        {{-- <div>
            <label class="block text-sm text-gray-600 mb-1">Supplier</label>
            <input type="text" name="supplier"
                class="w-full border p-2 rounded focus:ring focus:ring-blue-200">
        </div> --}}

        <div>
            <label class="block text-sm text-gray-600 mb-1">Nama Barang</label>
            <input type="text" name="nama_barang"
                class="w-full border p-2 rounded focus:ring focus:ring-blue-200">
        </div>

        <div>
            <label class="block text-sm text-gray-600 mb-1">Jumlah</label>
            <input type="number" name="jumlah"
                class="w-full border p-2 rounded focus:ring focus:ring-blue-200">
        </div>

        <div>
            <label class="block text-sm text-gray-600 mb-1">Harga Beli</label>
            <input type="number" name="harga_beli"
                class="w-full border p-2 rounded focus:ring focus:ring-blue-200">
        </div>

        {{-- Upload / Ganti Foto --}}
        <div>
            <label class="block text-sm text-gray-600 mb-1">
                Foto Bukti / Nota
                <span class="text-gray-400">(kosongkan jika tidak ingin mengubah)</span>
            </label>

            {{-- Preview foto lama --}}
            <div id="editFotoLama" class="mb-2 hidden">
                <p class="text-xs text-gray-500 mb-1">Foto saat ini:</p>
                <img id="editFotoLamaImg" src="#" alt="Foto lama"
                    class="h-24 rounded border object-contain">
            </div>

            <div id="editDropZone"
                class="flex flex-col items-center justify-center w-full border-2 border-dashed border-gray-300 rounded-xl px-4 py-4 cursor-pointer hover:border-blue-400 hover:bg-blue-50 transition-colors"
                onclick="document.getElementById('editFotoBukti').click()">

                <div id="editDropPlaceholder" class="flex flex-col items-center gap-1 text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p class="text-xs">Klik untuk ganti foto</p>
                </div>

                <img id="editPreviewFoto" src="#" alt="Preview baru"
                    class="hidden max-h-28 rounded object-contain mt-1">

                <p id="editNamaFile" class="hidden text-xs text-blue-600 mt-1 font-medium"></p>
            </div>
            <input type="file" id="editFotoBukti" name="gambar" accept="image/*" class="hidden">
        </div>

        <div class="flex justify-end gap-2 pt-2">
            <button type="button" onclick="closeEditModal()"
                class="px-4 py-2 border rounded text-gray-600">Batal</button>
            <button type="submit"
                class="px-4 py-2 bg-blue-500 text-white rounded">Update</button>
        </div>

    </form>
    </div>
</div>

{{-- ===================== MODAL LIHAT FOTO ===================== --}}
<div id="fotoModal" class="fixed inset-0 hidden items-center justify-center z-50">
    <div class="absolute inset-0 bg-black/70" onclick="closeFotoModal()"></div>
    <div class="relative z-10 max-w-2xl w-full mx-4">
        <button onclick="closeFotoModal()"
            class="absolute -top-8 right-0 text-white text-2xl">&times;</button>
        <img id="fotoModalImg" src="#" alt="Bukti Pembelian"
            class="w-full rounded-xl object-contain max-h-[80vh]">
    </div>
</div>

{{-- ===================== SCRIPT ===================== --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const form     = document.getElementById('formPenerimaan');
    const volume   = document.getElementById('volume');
    const harga    = document.getElementById('harga');
    const total    = document.getElementById('total');
    const tbody    = document.getElementById('tabelPenerimaan');
    const fotoBukti = document.getElementById('fotoBukti');

    // ── HITUNG TOTAL ──────────────────────────────────────
    function hitungTotal() {
        let v = parseFloat(volume.value) || 0;
        let h = parseFloat(harga.value) || 0;
        total.value = (v * h).toLocaleString('id-ID');
    }

    volume.addEventListener('input', hitungTotal);
    harga.addEventListener('input', hitungTotal);

    // ── PREVIEW FOTO (FORM CREATE) ────────────────────────
    fotoBukti.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;

        const preview   = document.getElementById('previewFoto');
        const placeholder = document.getElementById('dropPlaceholder');
        const namaFile  = document.getElementById('namaFileFoto');

        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            placeholder.classList.add('hidden');
            namaFile.textContent = file.name;
            namaFile.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    });

    // ── RESET FOTO PREVIEW saat form di-reset ─────────────
    document.getElementById('btnReset').addEventListener('click', function () {
        document.getElementById('previewFoto').classList.add('hidden');
        document.getElementById('previewFoto').src = '#';
        document.getElementById('dropPlaceholder').classList.remove('hidden');
        document.getElementById('namaFileFoto').classList.add('hidden');
    });

    // ── PREVIEW FOTO (FORM EDIT) ───────────────────────────
    document.getElementById('editFotoBukti').addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;

        const preview     = document.getElementById('editPreviewFoto');
        const placeholder = document.getElementById('editDropPlaceholder');
        const namaFile    = document.getElementById('editNamaFile');

        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            placeholder.classList.add('hidden');
            namaFile.textContent = file.name;
            namaFile.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    });

    // ── SUBMIT FORM CREATE ────────────────────────────────
    form.addEventListener('submit', function (e) {
        e.preventDefault();

        let data = new FormData(form);

        fetch(`{{ route('admin.penerimaan-barang.store') }}`, {
            method: 'POST',
            body: data,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.json())
        .then(res => {

            if (res.status !== 'success') {
                Swal.fire({ icon: 'error', title: 'Gagal!', text: res.message || 'Gagal menyimpan data' });
                return;
            }

            let item     = res.item;
            let namaBarang = item.barang?.nama_barang ?? '-';
            let satuan   = item.barang?.satuan ?? '-';
            // let supplier = item.barang?.supplier ?? '-';
            let fotoUrl  = item.gambar_url ?? null;
            let status   = item.status_acc ?? 'menunggu';

            let row = document.createElement('tr');
            row.id = `row-${item.id}`;
            row.className = 'hover:bg-gray-50';

            row.innerHTML = `
                <td class="border px-3 py-2 text-center">${tbody.children.length + 1}</td>
                <td class="border px-3 py-2">${item.tanggal_masuk}</td>
                
                <td class="border px-3 py-2">${namaBarang}</td>
                <td class="border px-3 py-2 text-center">${satuan}</td>
                <td class="border px-3 py-2 text-center">${item.jumlah}</td>
                <td class="border px-3 py-2 text-right">${Number(item.harga_beli).toLocaleString('id-ID')}</td>
                <td class="border px-3 py-2 text-right">${Number(item.jumlah * item.harga_beli).toLocaleString('id-ID')}</td>
                <td class="border px-3 py-2 text-center">${renderFotoBtn(fotoUrl, item.id)}</td>
                <td class="border px-3 py-2 text-center">${renderStatusBadge(status, item.id)}</td>
                <td class="border px-3 py-2 text-center space-x-1">
                    <button onclick="editItem(${item.id})" class="text-blue-500 hover:underline text-xs">Edit</button>
                    <span class="text-gray-300">|</span>
                    <button onclick="deleteItem(${item.id})" class="text-red-500 hover:underline text-xs">Hapus</button>
                </td>
            `;

            tbody.appendChild(row);

            form.reset();
            document.getElementById('previewFoto').classList.add('hidden');
            document.getElementById('previewFoto').src = '#';
            document.getElementById('dropPlaceholder').classList.remove('hidden');
            document.getElementById('namaFileFoto').classList.add('hidden');
            if (total) total.value = '';

            Swal.fire({ icon: 'success', title: 'Tersimpan!', timer: 1200, showConfirmButton: false });
        })
        .catch(err => console.error(err));
    });

});

function openCreateModal() {
    document.getElementById('createModal')
        .classList.remove('hidden');

    document.getElementById('createModal')
        .classList.add('flex');
}

function closeCreateModal() {
    document.getElementById('createModal')
        .classList.add('hidden');

    document.getElementById('createModal')
        .classList.remove('flex');
}

// ── HELPER: render badge status ──────────────────────────────
function renderStatusBadge(status, id) {
    let cls, label;
    if (status === 'disetujui') {
        cls   = 'bg-green-100 text-green-700';
        label = '✅ Disetujui';
    } else if (status === 'ditolak') {
        cls   = 'bg-red-100 text-red-700';
        label = '❌ Ditolak';
    } else {
        cls   = 'bg-yellow-100 text-yellow-700';
        label = '⏳ Menunggu';
    }
    return `<span id="status-${id}" class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium ${cls}">${label}</span>`;
}

// ── HELPER: render tombol lihat foto ─────────────────────────
function renderFotoBtn(url, id) {
    if (!url) return '<span class="text-gray-400 text-xs">—</span>';
    return `
        <button onclick="lihatFoto('${url}')"
            class="text-blue-500 hover:underline text-xs flex items-center gap-1 mx-auto">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
            Lihat
        </button>`;
}

// ── MODAL FOTO ───────────────────────────────────────────────
function lihatFoto(url) {
    document.getElementById('fotoModalImg').src = url;
    document.getElementById('fotoModal').classList.remove('hidden');
    document.getElementById('fotoModal').classList.add('flex');
}
function closeFotoModal() {
    document.getElementById('fotoModal').classList.add('hidden');
    document.getElementById('fotoModal').classList.remove('flex');
}

// ── MODAL EDIT ───────────────────────────────────────────────
let editId = null;

function openEditModal() {
    document.getElementById('editModal').classList.remove('hidden');
    document.getElementById('editModal').classList.add('flex');
}
function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
    document.getElementById('editModal').classList.remove('flex');
}

window.editItem = function (id) {
    fetch(`/admin/penerimaan-barang/${id}/edit`)
        .then(res => res.json())
        .then(res => {
            if (res.status !== 'success') return;

            let item = res.item;
            editId = id;

            const modal = document.getElementById('editModal');
            const form  = document.getElementById('editForm');

            modal.classList.remove('hidden');
            modal.classList.add('flex');

            const setVal = (name, value) => {
                const el = form.querySelector(`[name="${name}"]`);
                if (el) el.value = value ?? '';
            };

            setVal('tanggal_masuk', item.tanggal_masuk);
            // setVal('supplier',      item.barang?.supplier);
            setVal('nama_barang',   item.barang?.nama_barang);
            setVal('jumlah',        item.jumlah);
            setVal('harga_beli',    item.harga_beli);
            document.getElementById('edit_id').value = id;

            // Tampilkan foto lama kalau ada
            const fotoLamaWrap = document.getElementById('editFotoLama');
            const fotoLamaImg  = document.getElementById('editFotoLamaImg');

            if (item.gambar_url) {
                fotoLamaImg.src = item.gambar_url;
                fotoLamaWrap.classList.remove('hidden');
            } else {
                fotoLamaWrap.classList.add('hidden');
            }

            // Reset preview edit
            document.getElementById('editPreviewFoto').classList.add('hidden');
            document.getElementById('editPreviewFoto').src = '#';
            document.getElementById('editDropPlaceholder').classList.remove('hidden');
            document.getElementById('editNamaFile').classList.add('hidden');
        })
        .catch(err => console.error("EDIT ERROR:", err));
};

// ── SUBMIT EDIT ──────────────────────────────────────────────
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
        if (res.status !== 'success') {
            Swal.fire({ icon: 'error', title: 'Gagal!', text: res.message || 'Gagal mengupdate data' });
            return;
        }

        let item = res.item;
        let row  = document.getElementById(`row-${editId}`);

        if (!row) return;

        row.children[1].innerText = item.tanggal_masuk;
        // row.children[2].innerText = item.barang?.supplier  ?? '-';
        row.children[3].innerText = item.barang?.nama_barang ?? '-';
        row.children[4].innerText = item.barang?.satuan    ?? '-';
        row.children[5].innerText = item.jumlah;
        row.children[6].innerText = Number(item.harga_beli).toLocaleString('id-ID');
        row.children[7].innerText = Number(item.jumlah * item.harga_beli).toLocaleString('id-ID');
        row.children[8].innerHTML = renderFotoBtn(item.gambar_url ?? null, item.id);

        closeEditModal();

        Swal.fire({ icon: 'success', title: 'Berhasil!', text: 'Data berhasil diupdate', timer: 1500, showConfirmButton: false });
    });
});

// ── DELETE ───────────────────────────────────────────────────
window.deleteItem = function (id) {
    Swal.fire({
        title: 'Yakin hapus data?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonText: 'Batal',
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
            Swal.fire({ icon: 'success', title: 'Terhapus!', timer: 1200, showConfirmButton: false });
        });
    });
};
</script>
@endsection