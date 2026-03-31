@props(['dapurs' => []])

@php
    $defaultDapurs = [
        [
            'name' => 'Dapur Utama',
            'icon' => '🍳',
            'total' => '120 Transaksi',
            'percentage' => 80
        ],
        [
            'name' => 'Dapur Cabang 1',
            'icon' => '🍲',
            'total' => '45 Transaksi',
            'percentage' => 30
        ],
    ];
    
    $dapurList = !empty($dapurs) ? $dapurs : $defaultDapurs;
@endphp

<div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] sm:p-6">
    <div class="flex justify-between">
        <div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                Distribusi Dapur MBG
            </h3>
            <p class="mt-1 text-theme-sm text-gray-500 dark:text-gray-400">
                Aktivitas transaksi per dapur
            </p>
        </div>

        <x-common.dropdown-menu />
    </div>

    <!-- Grafik / Map bisa kamu ganti nanti -->
    <div class="my-6 rounded-2xl border bg-gray-50 px-4 py-6 dark:border-gray-800 dark:bg-gray-900">
        <div class="text-center text-gray-400 text-sm">
            Grafik distribusi dapur (opsional)
        </div>
    </div>

    <div class="space-y-5">
        @foreach($dapurList as $dapur)
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800">
                        <span>{{ $dapur['icon'] }}</span>
                    </div>
                    <div>
                        <p class="text-theme-sm font-semibold text-gray-800 dark:text-white/90">
                            {{ $dapur['name'] }}
                        </p>
                        <span class="block text-theme-xs text-gray-500 dark:text-gray-400">
                            {{ $dapur['total'] }}
                        </span>
                    </div>
                </div>

                <div class="flex w-full max-w-[140px] items-center gap-3">
                    <div class="relative block h-2 w-full max-w-[100px] rounded-sm bg-gray-200 dark:bg-gray-800">
                        <div 
                            class="absolute left-0 top-0 h-full rounded-sm bg-green-500"
                            style="width: {{ $dapur['percentage'] }}%"
                        ></div>
                    </div>
                    <p class="text-theme-sm font-medium text-gray-800 dark:text-white/90">
                        {{ $dapur['percentage'] }}%
                    </p>
                </div>
            </div>
        @endforeach
    </div>
</div>