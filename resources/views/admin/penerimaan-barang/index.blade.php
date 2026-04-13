@extends('layouts.app')

@section('content')
<x-common.page-breadcrumb pageTitle="Input Pembelian / Penerimaan Barang" />

<div class="space-y-6">

    {{-- 🔷 CARD UTAMA (HEADER + INFO + FORM) --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow border p-6 space-y-6">

        {{-- HEADER --}}
        <div class="text-center">
            <h1 class="text-xl font-bold">INPUT PEMBELIAN / PENERIMAAN BARANG</h1>
            <p class="text-sm text-gray-500">SPPG GADOG MEGAMENDUNG</p>
            <p class="text-sm text-gray-500">Periode : 1 - 13 Desember 2025</p>
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
                    <input type="date" name="tanggal_terima"
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
                    <select name="barang_id" id="barangSelect" class="w-full border rounded-lg px-3 py-2" required>
                    <option value="">-- Pilih Barang --</option>
                    @foreach($barangs as $b)
                        <option value="{{ $b->id }}" data-satuan="{{ $b->satuan }}">
                            {{ $b->nama }}
                        </option>
                    @endforeach
                </select>

                {{-- Satuan --}}
                <div>
                    <label class="text-sm text-gray-600">Satuan</label>
                    <input type="text" name="satuan" id="satuan" class="w-full border rounded-lg px-3 py-2" readonly>
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
            <table class="min-w-[1000px] w-full border text-sm whitespace-nowrap" id="formPenerimaan">

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
                <tbody>
                    @foreach ($items as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="border px-3 py-2 text-center">{{ $loop->iteration }}</td>
                            <td class="border px-3 py-2">{{ $item->tanggal_masuk }}</td>
                            <td class="border px-3 py-2">{{ $item->supplier }}</td>
                            <td class="border px-3 py-2">{{ $item->barang->nama ?? 'N/A' }}</td>
                            <td class="border px-3 py-2 text-center">{{ $item->barang->satuan ?? 'N/A' }}</td>
                            <td class="border px-3 py-2 text-center">{{ $item->jumlah }}</td>
                            <td class="border px-3 py-2 text-right">{{ number_format($item->harga_beli, 0, ',', '.') }}</td>
                            <td class="border px-3 py-2 text-right">{{ $item->total_harga }}</td>
                            <td class="border px-3 py-2 text-center space-x-2">
                                <button class="text-blue-500">Edit</button>
                                <button class="text-red-500">Hapus</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>

</div>

{{-- 🔷 SCRIPT AUTO HITUNG & Satuan --}}
<script>
document.getElementById('formPenerimaan').addEventListener('submit', function(e){
    e.preventDefault();
    let form = e.target;
    let data = new FormData(form);

    fetch('{{ route("admin.penerimaan-barang.store") }}', {
        method: 'POST',
        body: data,
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(res => res.json())
    .then(res => {
        if(res.status === 'success'){
            let item = res.item;
            let tbody = document.querySelector('#tabelPenerimaan tbody');
            let row = document.createElement('tr');
            row.innerHTML = `
                <td>${tbody.children.length + 1}</td>
                <td>${item.tanggal_masuk}</td>
                <td>${item.supplier}</td>
                <td>${item.barang.nama}</td>
                <td>${item.barang.satuan}</td>
                <td>${item.jumlah}</td>
                <td>${Number(item.harga_beli).toLocaleString('id-ID')}</td>
                <td>${item.total}</td>
            `;
            tbody.appendChild(row);
            form.reset();
        } else {
            alert('Gagal menyimpan data');
        }
    })
    .catch(err => console.error(err));
});
    const volume = document.getElementById('volume');
    const harga = document.getElementById('harga');
    const total = document.getElementById('total');
    const satuanInput = document.getElementById('satuan');
    const barangSelect = document.querySelector('barangSelect');

    function hitungTotal() {
        let v = parseFloat(volume.value) || 0;
        let h = parseFloat(harga.value) || 0;
        let hasil = v * h;
        total.value = hasil.toLocaleString('id-ID');
    }

    volume.addEventListener('input', hitungTotal);
    harga.addEventListener('input', hitungTotal);

    // Auto update satuan berdasarkan barang
    barangSelect.addEventListener('change', function() {
        const selectedOption = barangSelect.options[barangSelect.selectedIndex];
        const satuan = selectedOption.getAttribute('data-satuan') || '';
        satuanInput.value = satuan;
    });
</script>

@endsection