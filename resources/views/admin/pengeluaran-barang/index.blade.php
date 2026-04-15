@extends('layouts.app')

@section('content')
<x-common.page-breadcrumb pageTitle="Input Pengeluaran / Pemakaian Barang" />

<div class="space-y-6">

    {{-- 🔷 CARD UTAMA --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow border p-6 space-y-6">

        {{-- HEADER --}}
        <div class="text-center">
            <h1 class="text-xl font-bold">INPUT PENGELUARAN / PEMAKAIAN BARANG</h1>
            <p class="text-sm text-gray-500">SPPG GADOG MEGAMENDUNG</p>
            <p class="text-sm text-gray-500">Periode : 1 - 13 Desember 2025</p>
        </div>

        {{-- INFO --}}
        <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-lg text-sm">
            ⚠️ Pengeluaran akan mengurangi stok. Pastikan jumlah tidak melebihi stok.
        </div>

        <hr>

        {{-- FORM --}}
        <div>
            <h2 class="text-lg font-semibold mb-4">Tambah Data Pengeluaran</h2>
        <form id="formPengeluaran" class="grid grid-cols-1 md:grid-cols-6 gap-4">

        @csrf

        {{-- Tanggal --}}
        <div>
            <label class="text-sm text-gray-600">Tanggal</label>
            <input type="date" name="tanggal_keluar"
                class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200"
                        value="{{ old('tanggal_masuk', date('Y-m-d')) }}">
        </div>

        {{-- Petugas --}}
        <div>
            <label class="text-sm text-gray-600">Petugas</label>
            <select name="anggota_id"
                class="w-full border rounded-lg px-3 py-2">
                <option value="">-- Pilih Petugas --</option>
                @foreach($anggota as $a)
                    <option value="{{ $a->id }}">{{ $a->nama }}</option>
                @endforeach
            </select>
        </div>

        {{-- Barang --}}
        <div>
            <label class="text-sm text-gray-600">Barang</label>
            <select id="barang" onchange="pilihBarang()" class="w-full border rounded-lg px-3 py-2">
                <option value="">-- Pilih Barang --</option>

                @foreach ($barang as $b)
                    <option
                        value="{{ $b->id }}"
                        data-satuan="{{ $b->satuan }}"
                        data-stok="{{ optional($b->stok)->stok ?? 0 }}">
                        {{ $b->nama_barang }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Volume --}}
        <div>
            <label class="text-sm text-gray-600">Volume</label>
            <input type="number" name="jumlah" id="jumlah"
                class="w-full border rounded-lg px-3 py-2">
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

        {{-- STOK INFO --}}
        <div class="md:col-span-6 flex justify-between items-center mt-2">

            {{-- <div class="text-sm text-gray-500">
                Stok tersedia:
                <span id="stok" class="font-semibold">-</span>
            </div> --}}
        </div>
        <div class="md:col-span-7 flex justify-end gap-2 mt-2">
                    <button type="reset" class="px-4 py-2 border rounded-lg text-gray-600">Reset</button>
                    <button type="submit" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg">Simpan</button>
                </div>

    </form>
        </div>
    </div>

    {{-- 🔷 TABEL --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow border p-6">

        <h2 class="text-lg font-semibold mb-4 border-b pb-2">
            Data Pengeluaran Barang
        </h2>

        <div class="overflow-x-auto">
            <table class="min-w-[800px] w-full border text-sm whitespace-nowrap">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border px-3 py-2">No</th>
                        <th class="border px-3 py-2">Tanggal</th>
                        <th class="border px-3 py-2">Petugas</th>
                        <th class="border px-3 py-2">Barang</th>
                        <th class="border px-3 py-2">Volume</th>
                        <th class="border px-3 py-2">Satuan</th>
                        <th class="border px-3 py-2">Aksi</th>
                    </tr>
                </thead>

                <tbody id="tableBody">
                    @foreach ($items as $item)
                        <tr id="row-{{ $item->id }}" class="hover:bg-gray-50">
                            <td class="border px-3 py-2 text-center">{{ $loop->iteration }}</td>
                            <td class="border px-3 py-2">{{ $item->tanggal_keluar }}</td>
                            <td class="border px-3 py-2">{{ $item->anggota->nama ?? '-' }}</td>
                            <td class="border px-3 py-2">{{ $item->barang->nama_barang ?? '-' }}</td>
                            <td class="border px-3 py-2 text-center">{{ $item->jumlah }}</td>
                            <td class="border px-3 py-2 text-center">{{ $item->barang->satuan ?? '-' }}</td>

                            <td class="border px-3 py-2 text-center">
                                <button onclick="hapusRow({{ $item->id }})" class="text-red-500">Hapus</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

</div>

{{-- 🔷 SCRIPT --}}
<script>
let stokAktif = 0;
let no = 1;

/* =========================
   PILIH BARANG (GET STOK REALTIME)
========================= */
// 
function pilihBarang() {
    let select = document.getElementById('barang');
    let selected = select.options[select.selectedIndex];

    if (!selected.value) return;

    let satuan = selected.getAttribute('data-satuan');
    let stok = selected.getAttribute('data-stok');

    stokAktif = parseFloat(stok) || 0;

    console.log("STOK:", stokAktif);

    // kalau kamu tidak pakai tampilan stok, STOP di sini
}


/* =========================
   TAMBAH DATA (CREATE PENGELUARAN)
========================= */
function tambahData() {

    const tanggal = document.querySelector('input[name="tanggal_keluar"]').value;
    const anggota = document.querySelector('select[name="anggota_id"]').value;
    const barang = document.getElementById('barang').value;
    const jumlah = document.getElementById('jumlah').value;

    // VALIDASI FIELD
    if (!tanggal || !anggota || !barang || !jumlah) {
        alert('❌ Lengkapi semua data');
        return;
    }

    // VALIDASI STOK
    if (parseInt(jumlah) > stokAktif) {
        alert('❌ Stok tidak cukup!');
        return;
    }

    fetch('/admin/pengeluaran-barang', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'X-Requested-With': 'XMLHttpRequest',
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({
            tanggal_keluar: tanggal,
            anggota_id: anggota,
            barang_id: barang,
            jumlah: jumlah
        })
    })
    .then(res => res.json())
    .then(res => {

        if (res.status !== 'success') {
            alert(res.message || 'Gagal menyimpan data');
            return;
        }

        let item = res.item;

        let row = `
            <tr id="row-${item.id}" class="hover:bg-gray-50">
                <td class="border px-3 py-2 text-center">${no++}</td>
                <td class="border px-3 py-2">${item.tanggal_keluar}</td>
                <td class="border px-3 py-2">${item.anggota?.nama ?? '-'}</td>
                <td class="border px-3 py-2">${item.barang?.nama_barang ?? '-'}</td>
                <td class="border px-3 py-2 text-center">${item.jumlah}</td>
                <td class="border px-3 py-2 text-center">${item.barang?.satuan ?? '-'}</td>
                <td class="border px-3 py-2 text-center space-x-2">
                    <button onclick="hapusRow(${item.id})" class="text-red-500">Hapus</button>
                </td>
            </tr>
        `;

        document.getElementById('tableBody')
            .insertAdjacentHTML('beforeend', row);

        // 🔥 refresh stok setelah insert
        pilihBarang();

        // reset form
        document.querySelector('input[name="tanggal_keluar"]').value = '';
        document.getElementById('jumlah').value = '';
    })
    .catch(err => console.error("CREATE ERROR:", err));
}


/* =========================
   DELETE DATA (BACKEND)
========================= */
function hapusRow(id) {

    if (!confirm('Yakin hapus data ini?')) return;

    fetch(`/admin/pengeluaran-barang/${id}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: new URLSearchParams({
            _method: 'DELETE'
        })
    })
    .then(res => res.json())
    .then(res => {

        if (res.status === 'success') {
            document.getElementById(`row-${id}`).remove();

            // update stok realtime
            pilihBarang();
        }
    })
    .catch(err => console.error("DELETE ERROR:", err));
}
document.getElementById('formPengeluaran').addEventListener('submit', function (e) {
    e.preventDefault();
    tambahData();
});
</script>

@endsection