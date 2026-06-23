<style>
.dapur-filter-form {
    margin-bottom: 16px;
}

.filter-wrapper {
    display: flex;
    flex-direction: column;
    gap: 6px;
    max-width: 280px;
}

.filter-label {
    font-size: 13px;
    font-weight: 600;
    color: #555;
}

.select-wrapper {
    position: relative;
}

.filter-select {
    width: 100%;
    padding: 10px 36px 10px 12px;
    border: 1px solid #d0d7de;
    border-radius: 8px;
    background: #fff;
    font-size: 14px;
    outline: none;
    appearance: none;
    cursor: pointer;
    transition: 0.2s;
}

.filter-select:hover {
    border-color: #999;
}

.filter-select:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59,130,246,0.15);
}

.select-icon {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    pointer-events: none;
    color: #666;
    font-size: 12px;
}
</style>

@extends('layouts.app')

@section('content')

    <x-common.page-breadcrumb pageTitle="Saldo Awal Buku" />

    {{-- Alert Flash Message --}}
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-800 text-sm rounded-xl font-medium">
            ✅ {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-800 text-sm rounded-xl font-medium">
            ❌ {{ session('error') }}
        </div>
    @endif

    <form method="GET" class="dapur-filter-form">
    <div class="filter-wrapper">

        <label for="dapur_id" class="filter-label">
            Pilih Dapur
        </label>

        <div class="select-wrapper">
            <select
                name="dapur_id"
                id="dapur_id"
                class="filter-select"
                onchange="this.form.submit()"
            >
                <option value="">Semua Dapur</option>

                @foreach($dapurList as $item)
                    <option
                        value="{{ $item->id }}"
                        {{ request('dapur_id') == $item->id ? 'selected' : '' }}
                    >
                        {{ $item->nama_lembaga }}
                    </option>
                @endforeach
            </select>

            <span class="select-icon">⌄</span>
        </div>

    </div>
</form>

    <div class="rounded-2xl border border-gray-200 bg-white overflow-hidden shadow-sm dark:border-gray-800 dark:bg-gray-900">
        {{-- Header --}}
        <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-800 flex justify-between items-center">
            <div>
                <h2 class="text-base font-semibold text-gray-900 dark:text-white">Buku Kas & Pembantu</h2>
                <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">Atur dan sesuaikan saldo awal sub-akun pembantu lewat tombol aksi.</p>
            </div>
        </div>

        {{-- Tabel Utama --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm border-collapse">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-800/50">
                        <th class="px-6 py-2.5 text-left text-[11px] font-semibold uppercase tracking-widest text-gray-400 w-24">Kode</th>
                        <th class="px-6 py-2.5 text-left text-[11px] font-semibold uppercase tracking-widest text-gray-400">Nama Akun</th>
                        <th class="px-6 py-2.5 text-right text-[11px] font-semibold uppercase tracking-widest text-gray-400 w-44">Saldo Awal</th>
                        <th class="px-6 py-2.5 text-right text-[11px] font-semibold uppercase tracking-widest text-gray-400 w-44">Saldo Akhir</th>
                        <th class="px-6 py-2.5 text-center text-[11px] font-semibold uppercase tracking-widest text-gray-400 w-28">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse ($akun as $item)
                        @if (!empty($item['is_section']))
                            <tr class="bg-gray-50 dark:bg-gray-800/40">
                                <td colspan="5" class="px-6 py-2 text-[11px] font-semibold uppercase tracking-widest text-gray-400">
                                    {{ $item['nama_akun'] }}
                                </td>
                            </tr>
                        @else
                            <tr class="hover:bg-gray-50/50 transition-colors {{ !empty($item['is_parent']) ? 'font-semibold' : '' }}">
                                <td class="px-6 py-3 {{ !empty($item['is_sub']) ? 'pl-10' : '' }}">
                                    <span class="inline-block rounded-md bg-blue-50 px-2 py-0.5 text-xs font-mono text-blue-600">
                                        {{ $item['kode'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-3 {{ !empty($item['is_sub']) ? 'pl-10 text-gray-500' : 'text-gray-800 dark:text-white' }}">
                                    {{ $item['nama_akun'] }}
                                </td>
                                <td class="px-6 py-3 text-right font-mono text-gray-700 dark:text-gray-300">
                                    Rp {{ number_format($item['saldo_awal_raw'], 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-3 text-right font-mono text-gray-700 dark:text-gray-300">
                                    Rp {{ number_format($item['saldo_akhir_raw'], 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-2 text-center">
                                    @if(empty($item['is_parent']) && $status_periode === 'aktif')
                                        <button type="button" 
                                                onclick="openModalSaldo('{{ $item['id'] }}', '{{ $item['nama_akun'] }}', '{{ $item['saldo_awal_raw'] }}')"
                                                class="text-xs bg-gray-100 hover:bg-blue-50 text-gray-600 hover:text-blue-600 font-semibold px-2.5 py-1 rounded-lg border border-gray-200 hover:border-blue-200 transition-colors">
                                            ✏️ Atur
                                        </button>
                                    @else
                                        <span class="text-xs text-gray-400">—</span>
                                    @endif
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-400">Data tidak tersedia.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- 🔷 MODAL POP-UP INPUT SALDO (TAILWIND VANILLA) --}}
    <div id="modalSaldoAwal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-black/50 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-900 rounded-2xl max-w-md w-full shadow-xl border border-gray-100 dark:border-gray-800 overflow-hidden transform transition-all">
            <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800 flex justify-between items-center">
                <h3 class="text-sm font-bold text-gray-900 dark:text-white">Input / Penyesuaian Saldo Awal</h3>
                <button type="button" onclick="closeModalSaldo()" class="text-gray-400 hover:text-gray-600 text-lg">&times;</button>
            </div>
            
            <form action="{{ route('admin.awal-buku.update') }}" method="POST">
                @csrf
                <input type="hidden" name="akun_id" id="modal_akun_id">
                
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Nama Akun</label>
                        <input type="text" id="modal_nama_akun" readonly class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3 py-2 text-sm text-gray-600 font-medium outline-none">
                    </div>
                    
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Nominal Saldo Awal Pembuka</label>
                        <div class="relative flex items-center">
                            <span class="absolute left-3 text-sm font-mono text-gray-400">Rp</span>
                            <input type="number" name="saldo_awal" id="modal_saldo_awal" min="0" required
                                   class="w-full text-sm pl-10 pr-3 py-2 border border-gray-200 rounded-xl focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none font-mono">
                        </div>
                    </div>
                </div>

                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-t border-gray-100 dark:border-gray-800 flex justify-end gap-2">
                    <button type="button" onclick="closeModalSaldo()" class="px-4 py-2 text-xs font-semibold text-gray-500 hover:text-gray-700 bg-white border border-gray-200 rounded-xl transition-colors">Batal</button>
                    <button type="submit" class="px-4 py-2 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-sm transition-colors">💾 Simpan Data</button>
                </div>
            </form>
        </div>
    </div>

    {{-- JavaScript Handler Modal --}}
    <script>
        function openModalSaldo(id, nama, saldoSekarang) {
            document.getElementById('modal_akun_id').value = id;
            document.getElementById('modal_nama_akun').value = nama;
            document.getElementById('modal_saldo_awal').value = saldoSekarang;
            
            const modal = document.getElementById('modalSaldoAwal');
            modal.classList.remove('hidden');
        }

        function closeModalSaldo() {
            const modal = document.getElementById('modalSaldoAwal');
            modal.classList.add('hidden');
        }
    </script>
@endsection