@extends('layouts.app')

@section('content')
<div class="grid grid-cols-12 gap-4 md:gap-6">

  {{-- ROW 1: CARD STATISTIK --}}
  <div class="col-span-12">
    <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-6">

      <div class="rounded-2xl border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-gray-800">
        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Total Dapur</p>
        <p class="mt-1 text-2xl font-semibold text-gray-800 dark:text-white">{{ $totalDapur }}</p>
      </div>

      <div class="rounded-2xl border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-gray-800">
        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Total Anggota</p>
        <p class="mt-1 text-2xl font-semibold text-gray-800 dark:text-white">{{ $totalanggota }}</p>
      </div>

      <div class="rounded-2xl border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-gray-800">
        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Total Transaksi</p>
        <p class="mt-1 text-2xl font-semibold text-gray-800 dark:text-white">{{ $totalTransaksi }}</p>
      </div>

      <div class="rounded-2xl border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-gray-800">
        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Total Pemasukan</p>
        <p class="mt-1 text-2xl font-semibold text-green-600 dark:text-green-400">
          Rp {{ number_format($totalPemasukan, 0, ',', '.') }}
        </p>
      </div>

      <div class="rounded-2xl border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-gray-800">
        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Total Pengeluaran</p>
        <p class="mt-1 text-2xl font-semibold text-red-500 dark:text-red-400">
          Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}
        </p>
      </div>

      <div class="rounded-2xl border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-gray-800">
        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Saldo</p>
        <p class="mt-1 text-2xl font-semibold {{ $saldo >= 0 ? 'text-blue-600 dark:text-blue-400' : 'text-red-500 dark:text-red-400' }}">
          Rp {{ number_format($saldo, 0, ',', '.') }}
        </p>
      </div>

    </div>
  </div>

  {{-- ROW 2: GRAFIK KEUANGAN --}}
  <div class="col-span-12 xl:col-span-8">
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-700 dark:bg-gray-800">
      <h3 class="mb-4 text-sm font-semibold text-gray-700 dark:text-gray-200">
        Grafik Keuangan – 12 Bulan Terakhir
      </h3>
      <canvas id="grafikKeuangan" height="120"></canvas>
    </div>
  </div>

  {{-- ROW 2 KANAN: USER TERBARU --}}
  <div class="col-span-12 xl:col-span-4">
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-700 dark:bg-gray-800">
      <h3 class="mb-4 text-sm font-semibold text-gray-700 dark:text-gray-200">User Terbaru</h3>
      <ul class="space-y-3">
        @forelse($userTerbaru as $user)
          <li class="flex items-center gap-3">
            <div class="flex h-9 w-9 items-center justify-center rounded-full bg-blue-100 text-xs font-semibold text-blue-700 dark:bg-blue-900 dark:text-blue-300">
              {{ strtoupper(substr($user->name, 0, 2)) }}
            </div>
            <div class="min-w-0 flex-1">
              <p class="truncate text-sm font-medium text-gray-800 dark:text-gray-100">{{ $user->name }}</p>
              <p class="truncate text-xs text-gray-400 dark:text-gray-500">{{ $user->email }}</p>
            </div>
            <span class="text-xs text-gray-400 dark:text-gray-500">
              {{ $user->created_at->diffForHumans() }}
            </span>
          </li>
        @empty
          <li class="text-sm text-gray-400">Tidak ada data.</li>
        @endforelse
      </ul>
    </div>
  </div>

  {{-- ROW 3: TRANSAKSI TERBARU --}}
  <div class="col-span-12">
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-700 dark:bg-gray-800">
      <h3 class="mb-4 text-sm font-semibold text-gray-700 dark:text-gray-200">Transaksi Terbaru</h3>
      <div class="overflow-x-auto">
        <table class="w-full text-sm">
          <thead>
            <tr class="border-b border-gray-100 text-left text-xs font-semibold uppercase tracking-wide text-gray-400 dark:border-gray-700 dark:text-gray-500">
              <th class="pb-2 pr-4">ID</th>
              <th class="pb-2 pr-4">Keterangan</th>
              <th class="pb-2 pr-4">Jumlah</th>
              <th class="pb-2 pr-4">Status</th>
              <th class="pb-2">Tanggal</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-50 dark:divide-gray-700">
            @forelse($transaksiTerbaru as $trx)
              <tr>
                <td class="py-2 pr-4 font-mono text-xs text-gray-400">#{{ $trx->id }}</td>
                <td class="py-2 pr-4 text-gray-700 dark:text-gray-300">{{ $trx->keterangan ?? '-' }}</td>
                <td class="py-2 pr-4 font-medium text-gray-800 dark:text-gray-100">
                  Rp {{ number_format($trx->jumlah ?? 0, 0, ',', '.') }}
                </td>
                <td class="py-2 pr-4">
                  @php
                    $status = $trx->status ?? 'pending';
                    $statusClass = match($status) {
                      'sukses', 'berhasil' => 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300',
                      'gagal'              => 'bg-red-100 text-red-600 dark:bg-red-900 dark:text-red-300',
                      default              => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300',
                    };
                  @endphp
                  <span class="rounded-full px-2 py-0.5 text-xs font-medium {{ $statusClass }}">
                    {{ ucfirst($status) }}
                  </span>
                </td>
                <td class="py-2 text-xs text-gray-400 dark:text-gray-500">
                  {{ \Carbon\Carbon::parse($trx->tanggal)->format('d M Y') }}
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="py-4 text-center text-gray-400">Tidak ada transaksi.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const ctx = document.getElementById('grafikKeuangan').getContext('2d');

  const isDark = document.documentElement.classList.contains('dark');
  const gridColor = isDark ? 'rgba(255,255,255,0.06)' : 'rgba(0,0,0,0.06)';
  const textColor = isDark ? '#9ca3af' : '#6b7280';

  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: @json($bulan),
      datasets: [
        {
          label: 'Pemasukan',
          data: @json($dataPemasukan),
          backgroundColor: 'rgba(34,197,94,0.7)',
          borderRadius: 6,
          borderSkipped: false,
        },
        {
          label: 'Pengeluaran',
          data: @json($dataPengeluaran),
          backgroundColor: 'rgba(239,68,68,0.65)',
          borderRadius: 6,
          borderSkipped: false,
        }
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: true,
      plugins: {
        legend: {
          labels: {
            color: textColor,
            font: { size: 12 },
            boxWidth: 12,
            boxHeight: 12,
          }
        },
        tooltip: {
          callbacks: {
            label: (ctx) => {
              const val = ctx.parsed.y;
              return ` Rp ${val.toLocaleString('id-ID')}`;
            }
          }
        }
      },
      scales: {
        x: {
          grid: { color: gridColor },
          ticks: { color: textColor }
        },
        y: {
          grid: { color: gridColor },
          ticks: {
            color: textColor,
            callback: (val) => 'Rp ' + val.toLocaleString('id-ID')
          }
        }
      }
    }
  });
</script>
@endpush