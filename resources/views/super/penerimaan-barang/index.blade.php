<style>
    .filter-card {
    background: #ffffff;
    border-radius: 16px;
    padding: 20px;
    width: 100%;
    max-width: 320px;
    border: 1px solid #eef2f6;
    /* Bayangan lembut untuk kesan "mengambang" */
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.08), 0 4px 6px -2px rgba(0, 0, 0, 0.03);
}

.filter-header {
    margin-bottom: 15px;
    border-bottom: 1px solid #f1f5f9;
    padding-bottom: 10px;
}

.filter-title {
    font-weight: 700;
    color: #334155;
    font-size: 0.9rem;
}

.filter-label {
    display: block;
    font-size: 0.75rem;
    font-weight: 600;
    color: #94a3b8;
    margin-bottom: 6px;
}

.select-container {
    position: relative;
    display: flex;
    align-items: center;
}

.filter-select {
    width: 100%;
    padding: 12px 16px;
    background-color: #f8fafc;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    font-size: 0.95rem;
    font-weight: 500;
    color: #1e293b;
    appearance: none;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Efek saat card atau input disentuh */
.filter-select:hover {
    border-color: #cbd5e1;
    background-color: #ffffff;
}

.filter-select:focus {
    outline: none;
    border-color: #6366f1; /* Warna indigo yang elegan */
    background-color: #ffffff;
    box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
}

.select-arrow {
    position: absolute;
    right: 16px;
    color: #64748b;
    pointer-events: none;
}
    </style>
@extends('layouts.app')

@section('content')
<x-common.page-breadcrumb pageTitle="Input Pembelian / Penerimaan Barang" />

<div class="space-y-6">


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

                {{-- Supplier --}}
                <div class="md:col-span-2">
                    <label class="text-sm text-gray-600">Supplier</label>
                    <input type="text"
                        name="supplier"
                        class="w-full border rounded-lg px-3 py-2"
                        placeholder="Nama supplier / toko">
                </div>

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

{{-- 🔷 CARD CONTAINER --}}
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-6">
    
    {{-- HEADER SECTION --}}
    <div class="p-6 flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-gray-100">
        <div>
            <h1 class="text-xl font-bold text-gray-800">PENERIMAAN BARANG</h1>
            <p class="text-sm text-gray-500">Kelola data penerimaan barang per lembaga</p>
        </div>

        <form method="GET" class="dapur-filter-form">
            <div class="flex flex-col gap-1.5">
                <label for="dapur_id" class="text-xs font-bold text-gray-400 uppercase tracking-wider ml-1">Pilih Dapur</label>
                <div class="relative flex items-center min-w-[240px]">
                    <select name="dapur_id" id="dapur_id" class="w-full pl-4 pr-10 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-medium text-gray-700 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 appearance-none cursor-pointer transition-all hover:bg-gray-100" onchange="this.form.submit()">
                        <option value="">Semua Dapur</option>
                        @foreach($dapurList as $item)
                            <option value="{{ $item->id }}" {{ request('dapur_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->nama_lembaga }}
                            </option>
                        @endforeach
                    </select>
                    <div class="absolute right-4 pointer-events-none text-gray-400">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 9l6 6 6-6"/>
                        </svg>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- TABLE SECTION --}}
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="text-xs text-gray-500 uppercase bg-gray-50/50">
                <tr>
                    <th class="px-6 py-4 text-center">No</th>
                    <th class="px-6 py-4">Tanggal</th>
                    <th class="px-6 py-4">Supplier</th>
                    <th class="px-6 py-4">Nama Barang</th>
                    <th class="px-6 py-4 text-center">Satuan</th>
                    <th class="px-6 py-4 text-center">Vol</th>
                    <th class="px-6 py-4 text-right">Harga</th>
                    <th class="px-6 py-4 text-right">Total</th>
                    <th class="px-6 py-4 text-center">Bukti</th>
                    <th class="px-6 py-4 text-center">Status</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($items as $index => $item)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 text-center text-gray-500">{{ $items->firstItem() + $index }}</td>
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $item->tanggal_masuk }}</td>
                        <td class="px-6 py-4">{{ $item->barang->supplier ?? '—' }}</td>
                        <td class="px-6 py-4">{{ $item->barang->nama_barang ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-center">{{ $item->barang->satuan ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-center font-medium">{{ $item->jumlah }}</td>
                        <td class="px-6 py-4 text-right">Rp {{ number_format($item->harga_beli, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-right font-semibold text-gray-900">Rp {{ number_format($item->jumlah * $item->harga_beli, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-center">
                            @if ($item->gambar)
                                <button onclick="lihatFoto('{{ asset('storage/' . $item->gambar) }}')" class="text-indigo-600 hover:text-indigo-900 text-xs font-medium flex items-center gap-1 mx-auto">
                                    Lihat
                                </button>
                            @else
                                <span class="text-gray-300">—</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @php $status = $item->status ?? 'pending'; @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase 
                                {{ $status === 'disetujui' ? 'bg-green-100 text-green-700' : ($status === 'ditolak' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                                {{ $status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex justify-center gap-2">
                                <button onclick="editItem({{ $item->id }})" class="text-indigo-600 hover:text-indigo-900 font-medium text-xs">Edit</button>
                                <button onclick="deleteItem({{ $item->id }})" class="text-red-600 hover:text-red-900 font-medium text-xs">Hapus</button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11" class="px-6 py-8 text-center text-gray-400 italic">Tidak ada data ditemukan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- PAGINATION SECTION --}}
<div class="px-6 py-4 border-t border-gray-100 bg-gray-50/30 flex flex-col md:flex-row items-center justify-between gap-4">
    
    {{-- Info Data --}}
    <div class="text-xs text-gray-500">
        @if ($hal->total() > 0)
            Menampilkan 
            <span class="font-semibold text-gray-700">{{ $hal->firstItem() + $index}}</span> sampai 
            <span class="font-semibold text-gray-700">{{ $hal->lastItem() }}</span> dari 
            <span class="font-semibold text-gray-700">{{ $hal->total() }}</span> data
        @else
            Tidak ada data yang ditampilkan
        @endif
    </div>

    {{-- Tombol Navigasi --}}
    <div class="flex items-center">
        {{ $hal->appends(['dapur_id' => request('dapur_id')])->links('pagination::tailwind') }}
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

        <div>
            <label class="block text-sm text-gray-600 mb-1">Supplier</label>
            <input type="text" name="supplier"
                class="w-full border p-2 rounded focus:ring focus:ring-blue-200">
        </div>

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
    if (volume && harga && total) {
        function hitungTotal() {
            let v = parseFloat(volume.value) || 0;
            let h = parseFloat(harga.value) || 0;
            total.value = (v * h).toLocaleString('id-ID');
        }
        volume.addEventListener('input', hitungTotal);
        harga.addEventListener('input', hitungTotal);
    }

    // ── PREVIEW FOTO (FORM CREATE) ────────────────────────
    if (fotoBukti) {
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
    }

    // ── PREVIEW FOTO (FORM EDIT) ───────────────────────────
    const editFotoBukti = document.getElementById('editFotoBukti');
    if (editFotoBukti) {
        editFotoBukti.addEventListener('change', function () {
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
    }

    // ── SUBMIT FORM CREATE ────────────────────────────────
    if (form) {
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

                // Reset field & view state di dalam modal
                form.reset();
                document.getElementById('previewFoto').classList.add('hidden');
                document.getElementById('previewFoto').src = '#';
                document.getElementById('dropPlaceholder').classList.remove('hidden');
                document.getElementById('namaFileFoto').classList.add('hidden');
                if (total) total.value = '';

                // Tutup modal create langsung
                closeCreateModal();

                // Munculkan notifikasi sukses, lalu reload halaman agar kembali ke blade awal
                Swal.fire({ 
                    icon: 'success', 
                    title: 'Tersimpan!', 
                    text: 'Data pembelian baru berhasil disimpan.',
                    timer: 1500, 
                    showConfirmButton: false 
                }).then(() => {
                    location.reload();
                });
            })
            .catch(err => console.error(err));
        });
    }
});

function openCreateModal() {
    document.getElementById('createModal').classList.remove('hidden');
    document.getElementById('createModal').classList.add('flex');
}

function closeCreateModal() {
    document.getElementById('createModal').classList.add('hidden');
    document.getElementById('createModal').classList.remove('flex');
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
            setVal('supplier',      item.barang?.supplier);
            setVal('nama_barang',   item.barang?.nama_barang);
            setVal('jumlah',        item.jumlah);
            setVal('harga_beli',    item.harga_beli);
            document.getElementById('edit_id').value = id;

            // Tampilkan foto lama kalau ada
            const fotoLamaWrap = document.getElementById('editFotoLama');
            const fotoLamaImg  = document.getElementById('editFotoLamaImg');

            if (item.gambar) {
                fotoLamaImg.src = `/storage/${item.gambar}`;
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

        // Tutup modal edit langsung
        closeEditModal();

        // Munculkan notifikasi sukses, lalu reload halaman agar data tersinkron sempurna
        Swal.fire({ 
            icon: 'success', 
            title: 'Berhasil!', 
            text: 'Data berhasil diupdate', 
            timer: 1500, 
            showConfirmButton: false 
        }).then(() => {
            location.reload();
        });
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