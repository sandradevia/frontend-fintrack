
@php
    $orders = [
        [
            'Kode' => '1000',
            'Nama Akun' => 'BUKU KAS UMUM',
            'Saldo Awal' => '10.000.000',
            'Saldo Akhir' => '379.280.000',
            'Status' => 'Sesuai',
        ],
        [
            'Kode' => '1100',
            'Nama Akun' => 'BUKU PEMBANTU KAS',
            'Saldo Awal' => '',
            'Saldo Akhir' => '',
            'Status' => 'Sesuai',
        ],
        [
            'Kode' => '1101',
            'Nama Akun' => 'Petty Cash/Cash in Hand',
            'Saldo Awal' => '2.000.000',
            'Saldo Akhir' => '2.600.000',
            'Status' => 'Sesuai',
        ],
    ];
@endphp

<div class="mt-6 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-gray-900 lg:p-6">
    <div class="max-w-full overflow-x-auto custom-scrollbar">
        <table class="min-w-full">
            <!-- table header start -->
            <thead>
                <tr class="border-gray-100 border-y dark:border-white/[0.05]">
                    <th class="px-6 py-3">
                        <div class="flex items-center">
                            <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">KODE</p>
                        </div>
                    </th>
                    <th class="px-6 py-3">
                        <div class="flex items-center">
                            <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">NAMA AKUN</p>
                        </div>
                    </th>
                    <th class="px-6 py-3">
                        <div class="flex items-center col-span-2">
                            <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">SALDO AWAL</p>
                        </div>
                    </th>
                    <th class="px-6 py-3">
                        <div class="flex items-center col-span-2">
                            <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">SALDO AKHIR</p>
                        </div>
                    </th>
                </tr>
            </thead>
            <!-- table header end -->

            <!-- table body start -->
            <tbody class="divide-y divide-gray-100 dark:divide-white/[0.05]">
                @foreach ($orders as $order)
                    <tr>
                        <td class="px-6 py-3.5">
                            <div class="flex items-center">
                                <p class="font-medium text-gray-800 text-theme-sm dark:text-white/90">
                                    {{ $order['Kode'] }}
                                </p>
                            </div>
                        </td>
                        <td class="px-6 py-3.5">
                            <div class="flex items-center">
                                <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ $order['Nama Akun'] }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-3.5">
                            <div class="flex items-center">
                                <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ $order['Saldo Awal'] }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-3.5">
                            <div class="flex items-center">
                                <p class="text-gray-500 text-theme-sm dark:text-gray-400">
                                    {{ $order['Saldo Akhir'] }}
                                </p>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="mt-6 flex items-center gap-2">
    <h2 class="text-sm font-bold">CEK SALDO</h2>
</div>
<table class="min-w-full">
    <thead>
        <tr class="border-gray-100 border-y dark:border-white/[0.05]">
            <th class="px-6 py-3">
                <div class="flex items center">
                    <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Cek Saldo</p>
                </div>
            </th>
            <th class="px-6 py-3">
                <div class="flex items center">
                    <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Saldo AwalL</p>
                </div>
            </th>
            <th class="px-6 py-3">
                <div class="flex items center">
                    <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Saldo Akhir</p>
                </div>
            </th>
             <th class="px-6 py-3">
                <div class="flex items center">
                    <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Status</p>
                </div>
            </th>
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-100 dark:divide-white/[0.05]">
        @foreach ($orders as $order)
            <tr>
                <td class="px-6 py-3.5">
                    <div class="flex items-center">
                        <p class="font-medium text-gray-800 text-theme-sm dark:text-white/90">
                            {{ $order['Nama Akun'] }}
                        </p>
                    </div>
                </td>
                <td class="px-6 py-3.5">
                    <div class="flex items-center">
                        <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ $order['Saldo Awal'] }}</p>
                    </div>
                </td>
                <td class="px-6 py-3.5">
                    <div class="flex items-center">
                        <p class="text-gray-500 text-theme-sm dark:text-gray-400">
                            {{ $order['Saldo Akhir'] }}
                        </p>
                    </div>
                </td>
                <td class="px-6 py-3.5">
                    <div class="flex items-center">
                        <p class="text-gray-500 text-theme-sm dark:text-gray-400">
                            {{ $order['Status'] }}
                        </p>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
</div>