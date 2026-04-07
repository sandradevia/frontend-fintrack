@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Daftar Nominatif" />

    <div class="grid grid-cols-1 gap-6">

        <div class="bg-white p-4 rounded shadow">

            <h3 class="text-center font-bold text-lg">DAFTAR NOMINATIF</h3>
            <h4 class="text-center font-semibold">PEMBAYARAN UPAH SUKARELAWAN</h4>
            <p class="text-center text-sm mb-4">
                SESUAI SURAT KEPUTUSAN/TUGAS NOMOR ... TANGGAL ...
            </p>

            {{-- tombol future (CRUD nanti) --}}
            <div class="mb-3 flex gap-2">
                <button class="bg-blue-500 text-white px-3 py-1 rounded">Export Data</button>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-[1200px] border border-black text-sm whitespace-nowrap">
                    <thead class="sticky top-0 bg-gray-200 z-10">
                        <tr class="bg-gray-200">
                            <th rowspan="2" class="border p-1">No</th>
                            <th rowspan="2" class="border p-1">Jenis</th>
                            <th rowspan="2" class="border p-1">Nama</th>
                            <th colspan="10" class="border p-1">Oktober</th>
                            <th rowspan="2" class="border p-1">Honor</th>
                            <th rowspan="2" class="border p-1">Kesehatan</th>
                            <th rowspan="2" class="border p-1">TK</th>
                            <th rowspan="2" class="border p-1">PJ</th>
                            <th rowspan="2" class="border p-1">Total</th>
                        </tr>
                        <tr class="bg-gray-200">
                            @for ($i=1; $i<=10; $i++)
                                <th class="border p-1">{{ $i }}</th>
                            @endfor
                        </tr>
                    </thead>

                    <tbody>

                        {{-- ASISTEN LAPANGAN --}}
                        <tr>
                            <td class="border text-center">1</td>
                            <td class="border">Asisten Lapangan</td>
                            <td class="border"></td>

                            @for ($i=1; $i<=10; $i++)
                                <td class="border text-center">200.000</td>
                            @endfor

                            <td class="border text-center">2.000.000</td>
                            <td class="border text-center">68.000</td>
                            <td class="border"></td>
                            <td class="border"></td>
                            <td class="border text-center">2.068.000</td>
                        </tr>

                        {{-- PERSIAPAN --}}
                        @for ($i=2; $i<=6; $i++)
                        <tr>
                            @if($i==2)
                                <td class="border text-center">{{ $i }}</td>
                                <td rowspan="5" class="border">Persiapan Bahan</td>
                            @else
                                <td class="border text-center">{{ $i }}</td>
                            @endif

                            <td class="border"></td>

                            @for ($j=1; $j<=10; $j++)
                                <td class="border text-center">100.000</td>
                            @endfor

                            <td class="border text-center">1.000.000</td>
                            <td class="border text-center">68.000</td>

                            @if($i==2)
                                <td class="border"></td>
                                <td class="border text-center">125.000</td>
                                <td class="border text-center">1.193.000</td>
                            @else
                                <td class="border"></td>
                                <td class="border"></td>
                                <td class="border text-center">1.068.000</td>
                            @endif
                        </tr>
                        @endfor

                        {{-- KEAMANAN --}}
                        @for ($i=7; $i<=9; $i++)
                        <tr>
                            @if($i==7)
                                <td class="border text-center">{{ $i }}</td>
                                <td rowspan="3" class="border">Keamanan</td>
                            @else
                                <td class="border text-center">{{ $i }}</td>
                            @endif

                            <td class="border"></td>

                            @for ($j=1; $j<=10; $j++)
                                <td class="border text-center">50.000</td>
                            @endfor

                            <td class="border text-center">500.000</td>
                            <td class="border"></td>
                            <td class="border"></td>
                            <td class="border"></td>
                            <td class="border text-center">500.000</td>
                        </tr>
                        @endfor

                        {{-- TOTAL --}}
                        <tr class="bg-gray-200 font-bold">
                            <td colspan="3" class="border text-center">TOTAL</td>

                            @for ($i=1; $i<=10; $i++)
                                <td class="border text-center">4.250.000</td>
                            @endfor

                            <td class="border text-center">34.500.000</td>
                            <td class="border text-center">2.584.000</td>
                            <td class="border text-center">850.000</td>
                            <td class="border text-center">750.000</td>
                            <td class="border text-center">81.184.000</td>
                        </tr>

                    </tbody>
                </table>
            </div>

        </div>

    </div>
@endsection