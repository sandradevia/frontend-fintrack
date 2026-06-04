<div>
<div class="space-y-5">

    

    {{-- ── TAB NAVIGATION ── --}}
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">

        {{-- Tab: Bahan --}}
        <button type="button" wire:click="setTab('bahan')"
            class="group flex items-center gap-3 rounded-2xl border p-4 text-left transition-all duration-200
            {{ $activeTab == 'bahan'
                ? 'border-blue-300 bg-blue-50 shadow-sm dark:border-blue-700 dark:bg-blue-900/20'
                : 'border-gray-100 bg-white hover:border-blue-100 hover:bg-blue-50/50 dark:border-gray-800 dark:bg-gray-900' }}">

            <div class="flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-xl transition-colors duration-200
                {{ $activeTab == 'bahan' ? 'bg-blue-600' : 'bg-gray-100 group-hover:bg-blue-100 dark:bg-gray-800' }}">
                <svg class="h-5 w-5 {{ $activeTab == 'bahan' ? 'text-white' : 'text-gray-400 group-hover:text-blue-500' }}"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.3 2.3c-.6.6-.2 1.7.7 1.7H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>

            <div class="min-w-0 flex-1">
                <p class="text-[11px] font-bold uppercase tracking-wide
                    {{ $activeTab == 'bahan' ? 'text-blue-700 dark:text-blue-300' : 'text-gray-600 dark:text-gray-300' }}">
                    Bahan Makanan
                </p>
                {{-- <p class="mt-0.5 text-xs text-gray-400"> 
                    Rp {{ number_format($totalGlobalRab ?? 0,0,',','.') }}
                </p> --}}
            </div>

            @if($activeTab == 'bahan')
            <span class="flex-shrink-0 rounded-full bg-blue-600 px-2 py-0.5 text-[10px] font-bold text-white">Aktif</span>
            @endif
        </button>

        {{-- Tab: Operasional --}}
        <button type="button" wire:click="setTab('operasional')"
            class="group flex items-center gap-3 rounded-2xl border p-4 text-left transition-all duration-200
            {{ $activeTab == 'operasional'
                ? 'border-emerald-300 bg-emerald-50 shadow-sm dark:border-emerald-700 dark:bg-emerald-900/20'
                : 'border-gray-100 bg-white hover:border-emerald-100 hover:bg-emerald-50/50 dark:border-gray-800 dark:bg-gray-900' }}">

            <div class="flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-xl transition-colors duration-200
                {{ $activeTab == 'operasional' ? 'bg-emerald-600' : 'bg-gray-100 group-hover:bg-emerald-100 dark:bg-gray-800' }}">
                <svg class="h-5 w-5 {{ $activeTab == 'operasional' ? 'text-white' : 'text-gray-400 group-hover:text-emerald-500' }}"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 11h.01M12 11h.01M15 11h.01M4 19h16a2 2 0 002-2V7a2 2 0 00-2-2H4a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>

            <div class="min-w-0 flex-1">
                <p class="text-[11px] font-bold uppercase tracking-wide
                    {{ $activeTab == 'operasional' ? 'text-emerald-700 dark:text-emerald-300' : 'text-gray-600 dark:text-gray-300' }}">
                    Operasional
                </p>
                {{-- <p class="mt-0.5 text-xs text-gray-400">5 entri · Rp 10,0 jt</p> --}}
            </div>

            @if($activeTab == 'operasional')
            <span class="flex-shrink-0 rounded-full bg-emerald-600 px-2 py-0.5 text-[10px] font-bold text-white">Aktif</span>
            @endif
        </button>

        {{-- Tab: Insentif --}}
        <button type="button" wire:click="setTab('insentif')"
            class="group flex items-center gap-3 rounded-2xl border p-4 text-left transition-all duration-200
            {{ $activeTab == 'insentif'
                ? 'border-amber-300 bg-amber-50 shadow-sm dark:border-amber-700 dark:bg-amber-900/20'
                : 'border-gray-100 bg-white hover:border-amber-100 hover:bg-amber-50/50 dark:border-gray-800 dark:bg-gray-900' }}">

            <div class="flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-xl transition-colors duration-200
                {{ $activeTab == 'insentif' ? 'bg-amber-500' : 'bg-gray-100 group-hover:bg-amber-100 dark:bg-gray-800' }}">
                <svg class="h-5 w-5 {{ $activeTab == 'insentif' ? 'text-white' : 'text-gray-400 group-hover:text-amber-500' }}"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3zM12 2a10 10 0 100 20A10 10 0 0012 2z" />
                </svg>
            </div>

            <div class="min-w-0 flex-1">
                <p class="text-[11px] font-bold uppercase tracking-wide
                    {{ $activeTab == 'insentif' ? 'text-amber-700 dark:text-amber-300' : 'text-gray-600 dark:text-gray-300' }}">
                    Insentif Fasilitas
                </p>
                {{-- <p class="mt-0.5 text-xs text-gray-400">4 entri · Rp 18,5 jt</p> --}}
            </div>

            @if($activeTab == 'insentif')
            <span class="flex-shrink-0 rounded-full bg-amber-500 px-2 py-0.5 text-[10px] font-bold text-white">Aktif</span>
            @endif
        </button>

    </div>

    {{-- ── TABLE CARD ── --}}
    <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">

        {{-- Table header --}}
        <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4 dark:border-gray-800">
            <div>
                <h2 class="text-sm font-bold uppercase tracking-wide text-gray-800 dark:text-white">
                    @if($activeTab == 'bahan') Anggaran Bahan Makanan
                    @elseif($activeTab == 'operasional') Anggaran Operasional
                    @else Anggaran Insentif Fasilitas
                    @endif
                </h2>
                <p class="mt-0.5 text-xs text-gray-400">
                    @if($activeTab == 'bahan') Data distribusi harian per kategori penerima
                    @elseif($activeTab == 'operasional') Rincian pengeluaran operasional dapur
                    @else Rincian insentif per fasilitas
                    @endif
                </p>
            </div>
            <span class="inline-flex items-center rounded-full px-3 py-1 text-[11px] font-semibold
                {{ $activeTab == 'bahan' ? 'bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300' :
                   ($activeTab == 'operasional' ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300' :
                   'bg-amber-50 text-amber-700 dark:bg-amber-900/30 dark:text-amber-300') }}">
                {{ count($items) }} entri
            </span>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="min-w-full">

                {{-- THEAD --}}
                <thead>
                    <tr class="border-b-2
                        {{ $activeTab == 'bahan' ? 'border-blue-500' :
                           ($activeTab == 'operasional' ? 'border-emerald-500' : 'border-amber-500') }}">

                        <th class="bg-gray-50 px-4 py-3 text-left text-[10px] font-semibold uppercase tracking-wider text-gray-400 dark:bg-gray-800/60 dark:text-gray-500">No</th>

                        @if($activeTab == 'bahan')
                            <th class="bg-gray-50 px-4 py-3 text-left text-[10px] font-semibold uppercase tracking-wider text-gray-400 dark:bg-gray-800/60">Hari / Tanggal</th>
                            <th class="bg-gray-50 px-4 py-3 text-right text-[10px] font-semibold uppercase tracking-wider text-gray-400 dark:bg-gray-800/60">Jml Paket</th>
                            <th class="bg-gray-50 px-4 py-3 text-right text-[10px] font-semibold uppercase tracking-wider text-gray-400 dark:bg-gray-800/60">KB & TK</th>
                            <th class="bg-gray-50 px-4 py-3 text-right text-[10px] font-semibold uppercase tracking-wider text-gray-400 dark:bg-gray-800/60">SD 1-3</th>
                            <th class="bg-gray-50 px-4 py-3 text-right text-[10px] font-semibold uppercase tracking-wider text-gray-400 dark:bg-gray-800/60">SD 4-6</th>
                            <th class="bg-gray-50 px-4 py-3 text-right text-[10px] font-semibold uppercase tracking-wider text-gray-400 dark:bg-gray-800/60">SMP</th>
                            <th class="bg-gray-50 px-4 py-3 text-right text-[10px] font-semibold uppercase tracking-wider text-gray-400 dark:bg-gray-800/60">SMA</th>
                            <th class="bg-gray-50 px-4 py-3 text-right text-[10px] font-semibold uppercase tracking-wider text-gray-400 dark:bg-gray-800/60">Balita</th>
                            <th class="bg-gray-50 px-4 py-3 text-right text-[10px] font-semibold uppercase tracking-wider text-gray-400 dark:bg-gray-800/60">Bumil</th>
                            <th class="bg-gray-50 px-4 py-3 text-right text-[10px] font-semibold uppercase tracking-wider text-gray-400 dark:bg-gray-800/60">Busui</th>
                            <th class="bg-gray-50 px-4 py-3 text-right text-[10px] font-semibold uppercase tracking-wider text-gray-400 dark:bg-gray-800/60">Harga Satuan</th>
                            <th class="bg-gray-50 px-4 py-3 text-right text-[10px] font-semibold uppercase tracking-wider text-gray-400 dark:bg-gray-800/60">RAB</th>
                            <th class="bg-gray-50 px-4 py-3 text-center text-[10px] font-semibold uppercase tracking-wider text-gray-400 dark:bg-gray-800/60">Aksi</th>

                        @elseif($activeTab == 'operasional')
                            <th class="bg-gray-50 px-4 py-3 text-left text-[10px] font-semibold uppercase tracking-wider text-gray-400 dark:bg-gray-800/60">Hari / Tanggal</th>
                            <th class="bg-gray-50 px-4 py-3 text-right text-[10px] font-semibold uppercase tracking-wider text-gray-400 dark:bg-gray-800/60">RAB</th>
                            <th class="bg-gray-50 px-4 py-3 text-left text-[10px] font-semibold uppercase tracking-wider text-gray-400 dark:bg-gray-800/60">Keterangan</th>
                            <th class="bg-gray-50 px-4 py-3 text-center text-[10px] font-semibold uppercase tracking-wider text-gray-400 dark:bg-gray-800/60">Aksi</th>

                        @elseif($activeTab == 'insentif')
                            <th class="bg-gray-50 px-4 py-3 text-left text-[10px] font-semibold uppercase tracking-wider text-gray-400 dark:bg-gray-800/60">Hari / Tanggal</th>
                            <th class="bg-gray-50 px-4 py-3 text-right text-[10px] font-semibold uppercase tracking-wider text-gray-400 dark:bg-gray-800/60">Jml Paket</th>
                            <th class="bg-gray-50 px-4 py-3 text-right text-[10px] font-semibold uppercase tracking-wider text-gray-400 dark:bg-gray-800/60">Harga Satuan</th>
                            <th class="bg-gray-50 px-4 py-3 text-right text-[10px] font-semibold uppercase tracking-wider text-gray-400 dark:bg-gray-800/60">RAB</th>
                            <th class="bg-gray-50 px-4 py-3 text-center text-[10px] font-semibold uppercase tracking-wider text-gray-400 dark:bg-gray-800/60">Aksi</th>
                        @endif

                    </tr>
                </thead>

                {{-- TBODY --}}
                <tbody class="divide-y divide-gray-50 dark:divide-gray-800/60">
                    @forelse ($items as $index => $item)
                        <tr wire:key="row-{{ $activeTab }}-{{ $index }}"
                            class="transition-colors hover:bg-gray-50/70 dark:hover:bg-gray-800/30">

                            <td class="px-4 py-3 text-xs text-gray-400">{{ $loop->iteration }}</td>

                            @if($activeTab == 'bahan')
                                <td class="px-4 py-3 text-sm font-medium text-gray-700 dark:text-gray-300 whitespace-nowrap">{{ $item->tanggal ?? '-' }}</td>
                                <td class="px-4 py-3 text-right">
                                    <span class="inline-flex items-center rounded-lg bg-blue-50 px-2.5 py-0.5 text-xs font-semibold text-blue-700 dark:bg-blue-900/30 dark:text-blue-300">
                                        {{ number_format($item->jumlah_paket ?? 0, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td>
                                    {{ $item->details->where('kategori', 'kb_tk')->sum('jumlah') }}
                                </td>

                                <td>
                                    {{ $item->details->where('kategori', 'sd_1_3')->sum('jumlah') }}
                                </td>

                                <td>
                                    {{ $item->details->where('kategori', 'sd_4_6')->sum('jumlah') }}
                                </td>

                                <td>
                                    {{ $item->details->where('kategori', 'smp')->sum('jumlah') }}
                                </td>

                                <td>
                                    {{ $item->details->where('kategori', 'sma')->sum('jumlah') }}
                                </td>

                                <td>
                                    {{ $item->details->where('kategori', 'balita')->sum('jumlah') }}
                                </td>

                                <td>
                                    {{ $item->details->where('kategori', 'bumil')->sum('jumlah') }}
                                </td>

                                <td>
                                    {{ $item->details->where('kategori', 'busui')->sum('jumlah') }}
                                </td>
                                <td class="px-4 py-3 text-right text-sm text-gray-500 dark:text-gray-500">Rp {{ number_format($item->harga_satuan ?? 0, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 text-right text-sm font-semibold text-blue-700 dark:text-blue-400">Rp {{ number_format($item->total_rab ?? 0, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 text-center">
                                    <button class="rounded-lg bg-gray-100 px-3 py-1.5 text-xs font-medium text-gray-600 transition hover:bg-blue-50 hover:text-blue-600 dark:bg-gray-800 dark:text-gray-300">Edit</button>
                                </td>

                            @elseif($activeTab == 'operasional')
                                <td class="px-4 py-3 text-sm font-medium text-gray-700 dark:text-gray-300 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}
                                </td>

                                <td class="px-4 py-3 text-right text-sm font-semibold text-emerald-700 dark:text-emerald-400">
                                    Rp {{ number_format($item->total_rab, 0, ',', '.') }}
                                </td>

                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400">
                                    {{ $item->keterangan ?? '-' }}
                                </td>

                                <td class="px-4 py-3 text-center">
                                    <button
                                        class="rounded-lg bg-gray-100 px-3 py-1.5 text-xs font-medium text-gray-600 transition hover:bg-emerald-50 hover:text-emerald-600 dark:bg-gray-800 dark:text-gray-300">
                                        Edit
                                    </button>
                                </td>

                            @elseif($activeTab == 'insentif')
                                <td class="px-4 py-3 text-sm font-medium text-gray-700 dark:text-gray-300 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}
                                </td>

                                <td class="px-4 py-3 text-right text-sm text-gray-600 dark:text-gray-400">
                                    {{ number_format($item->bahan?->jumlah_paket ?? 0, 0, ',', '.') }}
                                </td>

                                <td class="px-4 py-3 text-right text-sm text-gray-500">
                                    Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}
                                </td>

                                <td class="px-4 py-3 text-right text-sm font-semibold text-amber-700 dark:text-amber-400">
                                    Rp {{ number_format($item->total_rab, 0, ',', '.') }}
                                </td>

                                <td class="px-4 py-3 text-center">
                                    <button
                                        class="rounded-lg bg-gray-100 px-3 py-1.5 text-xs font-medium text-gray-600 transition hover:bg-amber-50 hover:text-amber-600 dark:bg-gray-800 dark:text-gray-300">
                                        Edit
                                    </button>
                                </td>

                            @endif

                        </tr>
                    @empty
                        <tr>
                            <td colspan="15" class="px-4 py-14 text-center">
                                <div class="flex flex-col items-center gap-2">
                                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gray-100 dark:bg-gray-800">
                                        <svg class="h-6 w-6 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                    </div>
                                    <p class="text-sm text-gray-400">Data <span class="font-medium">{{ $activeTab }}</span> belum tersedia.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>

                {{-- TFOOT --}}
                <tfoot>
                    <tr class="border-t-2
                        {{ $activeTab == 'bahan' ? 'border-blue-200 dark:border-blue-800' :
                           ($activeTab == 'operasional' ? 'border-emerald-200 dark:border-emerald-800' :
                           'border-amber-200 dark:border-amber-800') }}">

                        @if($activeTab == 'bahan')
                        @php
                            $totalPaket = $items->sum('jumlah_paket');

                            $kbTk = $items->sum(function($item){
                                return $item->details->where('kategori', 'kb_tk')->sum('jumlah');
                            });

                            $sd13 = $items->sum(function($item){
                                return $item->details->where('kategori', 'sd_1_3')->sum('jumlah');
                            });

                            $sd46 = $items->sum(function($item){
                                return $item->details->where('kategori', 'sd_4_6')->sum('jumlah');
                            });

                            $smp = $items->sum(function($item){
                                return $item->details->where('kategori', 'smp')->sum('jumlah');
                            });

                            $sma = $items->sum(function($item){
                                return $item->details->where('kategori', 'sma')->sum('jumlah');
                            });

                            $balita = $items->sum(function($item){
                                return $item->details->where('kategori', 'balita')->sum('jumlah');
                            });

                            $bumil = $items->sum(function($item){
                                return $item->details->where('kategori', 'bumil')->sum('jumlah');
                            });

                            $busui = $items->sum(function($item){
                                return $item->details->where('kategori', 'busui')->sum('jumlah');
                            });

                            $grandTotal = $items->sum('total_rab');
                        @endphp
                        <td colspan="2"
                            class="bg-gray-50 px-4 py-4 text-center text-[10px] font-black uppercase tracking-widest text-gray-500 dark:bg-gray-800/50">
                            Total
                        </td>

                        <td class="bg-blue-50/60 px-4 py-4 text-right dark:bg-blue-900/20">
                            <span class="text-sm font-black text-blue-700 dark:text-blue-400">
                                {{ number_format($totalPaket, 0, ',', '.') }}
                            </span>
                        </td>

                        <td class="bg-gray-50/60 px-3 py-4 text-right text-xs font-bold">
                            {{ number_format($kbTk, 0, ',', '.') }}
                        </td>

                        <td class="bg-gray-50/60 px-3 py-4 text-right text-xs font-bold">
                            {{ number_format($sd13, 0, ',', '.') }}
                        </td>

                        <td class="bg-gray-50/60 px-3 py-4 text-right text-xs font-bold">
                            {{ number_format($sd46, 0, ',', '.') }}
                        </td>

                        <td class="bg-gray-50/60 px-3 py-4 text-right text-xs font-bold">
                            {{ number_format($smp, 0, ',', '.') }}
                        </td>

                        <td class="bg-gray-50/60 px-3 py-4 text-right text-xs font-bold">
                            {{ number_format($sma, 0, ',', '.') }}
                        </td>

                        <td class="bg-gray-50/60 px-3 py-4 text-right text-xs font-bold">
                            {{ number_format($balita, 0, ',', '.') }}
                        </td>

                        <td class="bg-gray-50/60 px-3 py-4 text-right text-xs font-bold">
                            {{ number_format($bumil, 0, ',', '.') }}
                        </td>

                        <td class="bg-gray-50/60 px-3 py-4 text-right text-xs font-bold">
                            {{ number_format($busui, 0, ',', '.') }}
                        </td>

                        <td class="bg-gray-50/60 px-4 py-4"></td>

                        <td class="bg-emerald-50/60 px-4 py-4 text-right dark:bg-emerald-900/20">
                            <div class="flex flex-col items-end">
                                <span class="text-[9px] font-black uppercase tracking-widest text-emerald-600">
                                    Grand Total
                                </span>
                                <span class="text-sm font-black text-emerald-700 dark:text-emerald-400">
                                    Rp {{ number_format($grandTotal, 0, ',', '.') }}
                                </span>
                            </div>
                        </td>

                        <td class="bg-gray-50/60 px-4 py-4"></td>


                        @elseif($activeTab == 'operasional')
                            <td colspan="2" class="bg-gray-50 px-4 py-4 text-center text-[10px] font-black uppercase tracking-widest text-gray-500 dark:bg-gray-800/50">Total</td>
                            <td class="bg-emerald-50/60 px-4 py-4 text-right dark:bg-emerald-900/20">
                                <span class="text-sm font-black text-emerald-700 dark:text-emerald-400">
                                    @php
                                        $totalOperasional = $items->sum('total_rab');
                                    @endphp
                                    Rp {{ number_format($totalOperasional, 0, ',', '.') }}
                                </span>
                            </td>
                            <td class="bg-gray-50/60 px-4 py-4 dark:bg-gray-800/30"></td>
                            <td class="bg-gray-50/60 px-4 py-4 dark:bg-gray-800/30"></td>

                        @elseif($activeTab == 'insentif')
                        @php
                            $totalPaketInsentif = $items->sum(function ($item) {
                                return $item->bahan?->jumlah_paket ?? 0;
                            });

                            $totalRabInsentif = $items->sum('total_rab');
                        @endphp
                            <td colspan="4" class="bg-gray-50 px-4 py-4 text-center text-[10px] font-black uppercase tracking-widest text-gray-500 dark:bg-gray-800/50">Total</td>
                            <td class="bg-amber-50/60 px-4 py-4 text-right dark:bg-amber-900/20">
                                <span class="text-sm font-black text-amber-700 dark:text-amber-400">Rp {{ number_format($totalRabInsentif, 0, ',', '.') }}</span>
                            </td>
                            <td class="bg-gray-50/60 px-4 py-4 dark:bg-gray-800/30"></td>
                        @endif

                    </tr>
                </tfoot>

            </table>
        </div>
    </div>

</div>
</div>