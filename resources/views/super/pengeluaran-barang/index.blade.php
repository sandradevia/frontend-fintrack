@extends('layouts.app')

@section('content')
<x-common.page-breadcrumb pageTitle="Input Pengeluaran / Pemakaian Barang" />

<div class="space-y-6">

    {{-- 🔷 CARD UTAMA --}}
{{-- FILTER BAR --}}
<div class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">

    {{-- HEADER --}}
    <div class="px-6 pt-5 pb-4 flex items-start justify-between gap-4 flex-wrap">
        <div>
            <h1 class="text-sm font-bold text-gray-800 dark:text-white tracking-wide uppercase">Pemakaian Barang</h1>
            <p class="text-xs text-gray-400 mt-0.5">Daftar pengeluaran barang dari stok</p>
        </div>
    </div>

    {{-- FILTER BAR --}}
    <div class="px-6 py-3 bg-gray-50/70 border-y border-gray-100 flex flex-wrap items-center gap-3">
        <span class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider">Filter:</span>

        {{-- Pilih Dapur --}}
        <div class="relative">
            <select name="dapur_id"
                onchange="this.form.submit()"
                form="filterForm"
                class="appearance-none bg-white border border-gray-200 rounded-lg pl-3 pr-8 py-1.5 text-xs text-gray-700 focus:outline-none focus:ring-2 focus:ring-violet-400 focus:border-transparent cursor-pointer min-w-[170px]">
                <option value="">Semua Dapur</option>
                @foreach ($dapurList as $dapur)
                    <option value="{{ $dapur->id }}" {{ request('dapur_id') == $dapur->id ? 'selected' : '' }}>
                        {{ $dapur->nama_lembaga }}
                    </option>
                @endforeach
            </select>
            <span class="pointer-events-none absolute right-2.5 top-1/2 -translate-y-1/2 text-gray-400">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </span>
        </div>

        {{-- Pilih Bulan --}}
        <div class="relative">
            <select
                name="bulan"
                form="filterForm"
                onchange="this.form.submit()"
                class="appearance-none bg-white border border-gray-200 rounded-lg pl-3 pr-8 py-1.5 text-xs text-gray-700 focus:outline-none focus:ring-2 focus:ring-violet-400 focus:border-transparent cursor-pointer min-w-[140px]"
            >
                <option value="">Semua Bulan</option>

                @foreach(range(1, 12) as $m)
                    <option value="{{ $m }}" {{ request('bulan') == $m ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create(null, $m, 1)->translatedFormat('F') }}
                    </option>
                @endforeach
            </select>

            <span class="pointer-events-none absolute right-2.5 top-1/2 -translate-y-1/2 text-gray-400">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </span>
        </div>

        {{-- Hidden form untuk submit filter --}}
        <form id="filterForm" method="GET" action="{{ route('super.pengeluaran-barang.index') }}"></form>
    </div>

    {{-- TABLE --}}
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead>
                <tr class="bg-gray-50/70 text-[10.5px] font-semibold text-gray-400 uppercase tracking-wider">
                    <th class="px-5 py-3 text-center w-12">No</th>
                    <th class="px-5 py-3">Tanggal</th>
                    <th class="px-5 py-3">Petugas</th>
                    <th class="px-5 py-3">Barang</th>
                    <th class="px-5 py-3 text-center">Volume</th>
                    <th class="px-5 py-3 text-center">Satuan</th>
                    <th class="px-5 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse ($items as $index => $item)
                    <tr class="hover:bg-violet-50/30 transition-colors duration-100">
                        <td class="px-5 py-3.5 text-center text-xs text-gray-400 font-medium">
                            {{ $items->firstItem() + $index }}
                        </td>
                        <td class="px-5 py-3.5 text-xs font-semibold text-gray-800">
                            {{ \Carbon\Carbon::parse($item->tanggal_keluar)->translatedFormat('d M Y') }}
                        </td>
                        <td class="px-5 py-3.5 text-xs text-gray-600">{{ $item->anggota->nama ?? '-' }}</td>
                        <td class="px-5 py-3.5 text-xs text-gray-600">{{ $item->barang->nama_barang ?? '-' }}</td>
                        <td class="px-5 py-3.5 text-center text-xs font-bold text-gray-800">{{ $item->jumlah }}</td>
                        <td class="px-5 py-3.5 text-center text-xs text-gray-400">{{ $item->barang->satuan ?? '-' }}</td>
                        <td class="px-5 py-3.5 text-center">
                            <button onclick="hapusRow({{ $item->id }})"
                                class="text-[11px] font-semibold text-red-500 bg-red-50 hover:bg-red-100 hover:text-red-700 px-3 py-1.5 rounded-md transition-all duration-150">
                                Hapus
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-10 text-center text-gray-300 text-sm italic">
                            Tidak ada data pemakaian
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- PAGINATION --}}
    <div class="px-6 py-3.5 bg-gray-50/50 border-t border-gray-100 flex flex-col md:flex-row items-center justify-between gap-3">
        <div class="text-xs text-gray-400">
            @if ($items->total() > 0)
                Menampilkan
                <span class="font-semibold text-gray-600">{{ $items->firstItem() }}</span> –
                <span class="font-semibold text-gray-600">{{ $items->lastItem() }}</span> dari
                <span class="font-semibold text-gray-600">{{ $items->total() }}</span> data
            @else
                Tidak ada data ditampilkan
            @endif
        </div>
        <div>
            {{ $items->appends(request()->query())->links('pagination::tailwind') }}
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