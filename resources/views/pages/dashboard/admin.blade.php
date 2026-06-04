@extends('layouts.app')

@section('content')
<div class="grid grid-cols-12 gap-4 md:gap-6 
bg-gradient-to-br from-slate-50 via-white to-blue-50 
dark:from-gray-950 dark:via-gray-900 dark:to-gray-950 p-4 rounded-2xl">

    {{-- ================= WELCOME CARD ================= --}}
    <div class="col-span-12 relative overflow-hidden rounded-2xl border border-gray-200 
    bg-white/80 backdrop-blur-xl px-6 py-5 shadow-lg 
    dark:border-gray-800 dark:bg-gray-900/70">

        {{-- Glow --}}
        <div class="absolute -top-10 -right-10 w-40 h-40 bg-blue-500/10 rounded-full blur-3xl"></div>

        <div class="flex items-center justify-between gap-4">
            <div>
                <span class="mb-3 inline-flex items-center gap-2 rounded-full bg-blue-50 px-3 py-1 text-xs font-medium text-blue-700 dark:bg-blue-900/30 dark:text-blue-300">
                    <span class="relative flex h-2 w-2">
                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-green-400 opacity-75"></span>
                        <span class="relative inline-flex h-2 w-2 rounded-full bg-green-500"></span>
                    </span>
                    Sistem aktif
                </span>

                <h1 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Selamat datang kembali, 
                    <span class="text-blue-600 dark:text-blue-400">
                        {{ $dapur->nama_lembaga ?? auth()->user()->username }}
                    </span>
                </h1>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Pantau aktivitas keuangan dapur hari ini dengan mudah dan akurat.
                </p>
            </div>

            {{-- Clock --}}
            <div class="hidden sm:block text-right animate-pulse">
                <div id="js-clock" class="font-mono text-3xl font-semibold text-gray-900 dark:text-white">--:--</div>
                <div id="js-date" class="text-xs text-gray-400">--</div>
            </div>
        </div>
    </div>

    {{-- ================= STAT CARDS ================= --}}
    <div class="col-span-12 grid grid-cols-1 sm:grid-cols-3 gap-4">

        {{-- Transaksi --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 
        transition-all duration-300 hover:shadow-xl hover:-translate-y-1
        dark:border-gray-800 dark:bg-gray-900">

            <p class="text-sm text-gray-500">Total Transaksi</p>
            <h4 class="text-2xl font-semibold js-count" data-target="{{ $totalTransaksi ?? 0 }}">0</h4>

            <div class="mt-3 h-1.5 bg-gray-200 rounded-full overflow-hidden">
                <div class="h-full bg-blue-500" style="width: 80%"></div>
            </div>

            <p class="text-xs text-emerald-600 mt-2">+12% bulan ini</p>
        </div>

        {{-- Anggaran --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 
        transition-all duration-300 hover:shadow-xl hover:-translate-y-1
        dark:border-gray-800 dark:bg-gray-900">

            <p class="text-sm text-gray-500">Total Anggaran</p>
            <h4 class="text-2xl font-semibold">
                Rp {{ number_format($totalAnggaran ?? 0, 0, ',', '.') }}
            </h4>

            <div class="mt-3 h-1.5 bg-gray-200 rounded-full overflow-hidden">
                <div class="h-full bg-emerald-500" style="width: 75%"></div>
            </div>

            <p class="text-xs text-emerald-600 mt-2">+8% dari target</p>
        </div>

        {{-- Karyawan --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 
        transition-all duration-300 hover:shadow-xl hover:-translate-y-1
        dark:border-gray-800 dark:bg-gray-900">

            <p class="text-sm text-gray-500">Jumlah Karyawan</p>
            <h4 class="text-2xl font-semibold js-count" data-target="{{ $totalKaryawan ?? 0 }}">0</h4>

            <div class="mt-3 h-1.5 bg-gray-200 rounded-full overflow-hidden">
                <div class="h-full bg-amber-500" style="width: 60%"></div>
            </div>

            <p class="text-xs text-red-500 mt-2">-1 dari bulan lalu</p>
        </div>

    </div>

    {{-- ================= CHART ================= --}}
    <div class="col-span-12 rounded-2xl border border-gray-200 bg-white shadow-lg 
    hover:shadow-xl transition-all duration-300 
    dark:border-gray-800 dark:bg-gray-900">

        <div class="px-6 py-4 border-b dark:border-gray-800">
            <h3 class="font-semibold text-gray-800 dark:text-white">
                Grafik stok barang
            </h3>
            <p class="text-xs text-gray-400">
                Pergerakan stok minggu ini
            </p>
        </div>

        <div class="p-5">
            <div id="chartStok" class="h-[300px]"></div>

            <p class="text-xs text-gray-400 mt-3">
                📈 Stok masuk meningkat dibanding minggu lalu
            </p>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
{{-- CLOCK --}}
function updateClock() {
    const now = new Date();
    const pad = n => String(n).padStart(2, '0');

    document.getElementById('js-clock').textContent =
        pad(now.getHours()) + ':' + pad(now.getMinutes()) + ':' + pad(now.getSeconds());

    document.getElementById('js-date').textContent =
        now.toLocaleDateString('id-ID', { weekday:'long', day:'numeric', month:'short', year:'numeric' });
}
setInterval(updateClock, 1000);
updateClock();

{{-- COUNT ANIMATION --}}
const duration = 800;
document.querySelectorAll('.js-count').forEach(el => {
    const end = parseInt(el.dataset.target) || 0;
    const startTime = performance.now();

    function animate(time) {
        const progress = Math.min((time - startTime) / duration, 1);
        const value = Math.floor(progress * end);
        el.textContent = value.toLocaleString('id-ID');

        if (progress < 1) requestAnimationFrame(animate);
    }
    requestAnimationFrame(animate);
});

{{-- CHART --}}
new ApexCharts(document.querySelector('#chartStok'), {
    series: [
        { name: 'Masuk', data: @json($dataMasuk) },
        { name: 'Keluar', data: @json($dataKeluar) },
    ],
    chart: {
        type: 'area',
        height: 300,
        animations: {
            enabled: true,
            easing: 'easeinout',
            speed: 800
        },
        toolbar: { show: false }
    },
    stroke: { curve: 'smooth', width: 2 },
    fill: { opacity: 0.1 },
    colors: ['#3B82F6', '#10B981'],
    xaxis: {
        categories: @json($hari)
    },
}).render();
</script>
@endpush