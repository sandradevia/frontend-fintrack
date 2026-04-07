<div> {{-- SATU DIV UTAMA SEBAGAI PEMBUNGKUS (ROOT) --}}
    <div class="space-y-6">
        {{-- Tab Navigation --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-2 shadow-sm dark:border-gray-800 dark:bg-gray-900">
            <div class="grid grid-cols-1 gap-2 md:grid-cols-3">
                
                <button type="button" wire:click="setTab('bahan')" 
                    class="flex items-center gap-3 rounded-xl border {{ $activeTab == 'bahan' ? 'border-blue-100 bg-blue-50 dark:border-blue-900/40 dark:bg-blue-900/20' : 'border-transparent bg-white' }} px-4 py-4 transition">
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl {{ $activeTab == 'bahan' ? 'bg-blue-600' : 'bg-gray-400' }} text-white">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v10Z" /></svg>
                    </div>
                    <div class="text-left font-semibold {{ $activeTab == 'bahan' ? 'text-blue-700' : 'text-gray-700' }}">ANGGARAN BAHAN MAKANAN</div>
                </button>

                <button type="button" wire:click="setTab('operasional')" 
                    class="flex items-center gap-3 rounded-xl border {{ $activeTab == 'operasional' ? 'border-emerald-100 bg-emerald-50 dark:border-emerald-900/40 dark:bg-emerald-900/20' : 'border-transparent bg-white' }} px-4 py-4 transition">
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl {{ $activeTab == 'operasional' ? 'bg-emerald-500' : 'bg-gray-400' }} text-white">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M3 10h18M7 15h1m4 0h5M6 5h12a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2Z" /></svg>
                    </div>
                    <div class="text-left font-semibold {{ $activeTab == 'operasional' ? 'text-emerald-700' : 'text-gray-700' }}">ANGGARAN OPERASIONAL</div>
                </button>

                <button type="button" wire:click="setTab('insentif')" 
                    class="flex items-center gap-3 rounded-xl border {{ $activeTab == 'insentif' ? 'border-amber-100 bg-amber-50 dark:border-amber-900/40 dark:bg-amber-900/20' : 'border-transparent bg-white' }} px-4 py-4 transition">
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl {{ $activeTab == 'insentif' ? 'bg-amber-500' : 'bg-gray-400' }} text-white">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3Z" /></svg>
                    </div>
                    <div class="text-left font-semibold {{ $activeTab == 'insentif' ? 'text-amber-700' : 'text-gray-700' }}">ANGGARAN INSENTIF FASILITAS</div>
                </button>

            </div>
        </div>

        {{-- Tabel --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-gray-900">
            <h2 class="mb-4 text-lg font-bold uppercase"> {{ $activeTab }}</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-100 dark:bg-gray-800 border-b-2 border-blue-600">
                        <tr class="divide-x divide-gray-200 dark:divide-white/[0.05]">
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">NO</th>
                            @if($activeTab == 'bahan')
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">HARI/TANGGAL</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">JUMLAH PAKET MBG</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">KB & TK</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">SD 1-3</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">SD 4-6</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">SMP</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">SMA</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">BALITA</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">BUMIL</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">BUSUI</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">HARGA SATUAN PAKET MBG</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">HARGA SATUAN PAKET MBG2</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">RENCANA ANGGARAN BIAYA (RAB)</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">AKSI</th>
                            @elseif($activeTab == 'operasional')
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">HARI/TANGGAL</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">RENCANA ANGGARAN BIAYA (RAB)</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">KETERANGAN</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">AKSI</th>
                            @elseif($activeTab == 'insentif')
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">HARI/TANGGAL</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">JUMLAH PAKET MBG</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">HARGA SATUAN PAKET MBG</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">RENCANA ANGGARAN BIAYA (RAB)</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">AKSI</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-white/[0.05]">
                        @forelse ($items as $index => $item)
                            <tr wire:key="row-{{ $activeTab }}-{{ $index }}"> {{-- CRITICAL: wire:key harus unik per baris dan per tab --}}
                                <td class="px-4 py-3 text-sm text-gray-500">{{ $loop->iteration }}</td>
                                @if($activeTab == 'bahan')
                                    {{-- <td class="px-4 py-3 text-sm font-medium">{{ $item['tanggal'] }}</td> --}}
                                    {{-- <td class="px-4 py-3 text-sm">{{ $item['jumlah'] }}</td>
                                    <td class="px-4 py-3 text-sm">Rp {{ number_format($item['harga'], 0, ',', '.') }}</td> --}}
                                @elseif($activeTab == 'operasional')
                                    {{-- <td class="px-4 py-3 text-sm font-medium">{{ $item['nama'] }}</td>
                                    <td class="px-4 py-3 text-sm">{{ $item['kategori'] }}</td>
                                    <td class="px-4 py-3 text-sm">Rp {{ number_format($item['nominal'], 0, ',', '.') }}</td> --}}
                                @elseif($activeTab == 'insentif')
                                    {{-- <td class="px-4 py-3 text-sm font-medium">{{ $item['petugas'] }}</td>
                                    <td class="px-4 py-3 text-sm">{{ $item['jabatan'] }}</td>
                                    <td class="px-4 py-3 text-sm">Rp {{ number_format($item['jumlah'], 0, ',', '.') }}</td> --}}
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="px-4 py-10 text-center text-gray-400">Data {{ $activeTab }} belum tersedia.</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot class="bg-gray-100/80 dark:bg-gray-800/90 border-t-2 border-gray-200 dark:border-white/[0.05] backdrop-blur-sm">
                        <tr class="divide-x divide-gray-200/50 dark:divide-white/[0.03]">
                            {{-- Label Total (Menggabungkan kolom No dan Hari/Tanggal) --}}
                            <td colspan="2" class="px-4 py-4 text-center">
                                <span class="text-xs font-black uppercase tracking-widest text-gray-700 dark:text-gray-200">TOTAL</span>
                            </td>

                            @if($activeTab == 'bahan')
                                {{-- Total Jumlah Paket MBG (Berwarna Biru Tipis) --}}
                                <td class="px-4 py-4 text-center bg-blue-100/50 dark:bg-blue-900/30">
                                    <span class="text-sm font-black text-blue-800 dark:text-blue-400">36864</span>
                                </td>

                                {{-- Total Kolom Kategori (Looping agar presisi) --}}
                                @php
                                    // Contoh data statis, nanti ganti dengan $totalKbTk, dsb dari Livewire
                                    $totals = [0, 8508, 8184, 13128, 0, 4404, 648, 1992];
                                @endphp
                                @foreach($totals as $total)
                                    <td class="px-3 py-4 text-center">
                                        <span class="text-xs font-bold text-gray-800 dark:text-gray-200">{{ number_format($total, 0, ',', '.') }}</span>
                                    </td>
                                @endforeach

                                {{-- Kolom Kosong (Satuan 1 & 2 biasanya tidak ditotal) --}}
                                <td class="px-4 py-4 bg-gray-50/50 dark:bg-gray-900/50"></td>
                                <td class="px-4 py-4 bg-gray-50/50 dark:bg-gray-900/50"></td>

                                {{-- Grand Total RAB (Berwarna Hijau & Sticky Right) --}}
                                <td class="px-4 py-4 text-right bg-emerald-100/50 dark:bg-emerald-900/40 sticky right-0 z-20 shadow-[-4px_0_10px_rgba(0,0,0,0.05)]">
                                    <div class="flex flex-col">
                                        <span class="text-[10px] font-black text-emerald-800 dark:text-emerald-500 uppercase leading-none">Grand Total</span>
                                        <span class="text-sm font-black text-emerald-700 dark:text-emerald-400">Rp 342.816.000</span>
                                    </div>
                                </td>

                            @elseif($activeTab == 'operasional')
                                {{-- Sesuaikan jumlah colspan untuk tab lain --}}
                                <td class="px-4 py-4 text-right bg-emerald-100/50 dark:bg-emerald-900/40 font-black text-emerald-700 uppercase">Rp 10.000.000</td>
                                <td class="bg-gray-50/50 dark:bg-gray-900/50"></td>
                            @endif
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>