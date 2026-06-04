<div class="rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900 overflow-hidden">

  {{-- Header --}}
  <div class="flex items-start justify-between gap-4 px-6 py-5 border-b border-gray-200 dark:border-gray-800">
    <div>
      <div class="flex items-center gap-2 mb-1.5">
        <span class="inline-flex items-center gap-1.5 rounded-full bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-600 dark:bg-blue-900/30 dark:text-blue-400">
          Profil Lembaga
        </span>
      </div>

      <h2 class="text-base font-semibold text-gray-900 dark:text-white">
        Data Lembaga
      </h2>

      <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">
        Ringkasan identitas SPPG untuk pelaporan.
      </p>
    </div>

    <button
      type="button"
      @click="$dispatch('open-profile-info-modal')"
      class="inline-flex items-center gap-2 rounded-lg border border-gray-200 bg-white px-3.5 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:hover:bg-gray-800"
    >
      Edit
    </button>
  </div>

  @if($dapur)

  <table class="w-full table-fixed border-collapse text-sm">
    <tbody>

      {{-- IDENTITAS --}}
      <tr class="bg-gray-50 dark:bg-gray-800/50">
        <td colspan="2"
            class="px-6 py-2 text-[11px] font-semibold uppercase tracking-widest text-gray-400 dark:text-gray-500">
          Identitas Lembaga
        </td>
      </tr>

      @foreach([
        'nama_lembaga'     => 'Nama Lembaga',
        'alamat'           => 'Alamat',
        'nama_kepala_sppg' => 'Nama Kepala SPPG',
        'nama_akuntan'     => 'Nama Akuntan SPPG',
      ] as $field => $label)

      <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40">
        <td class="w-2/5 border-b border-gray-100 px-6 py-3 dark:border-gray-800">
          {{ $label }}
        </td>
        <td class="border-b border-gray-100 px-6 py-3 dark:border-gray-800">
          {{ $dapur->$field ?? '-' }}
        </td>
      </tr>

      @endforeach

      {{-- YAYASAN --}}
      <tr class="bg-gray-50 dark:bg-gray-800/50">
        <td colspan="2"
            class="px-6 py-2 text-[11px] font-semibold uppercase tracking-widest text-gray-400 dark:text-gray-500">
          Yayasan
        </td>
      </tr>

      @foreach([
        'nama_yayasan' => 'Nama Yayasan',
        'ketua_yayasan' => 'Ketua Yayasan',
      ] as $field => $label)

      <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40">
        <td class="w-2/5 border-b border-gray-100 px-6 py-3 dark:border-gray-800">
          {{ $label }}
        </td>
        <td class="border-b border-gray-100 px-6 py-3 dark:border-gray-800">
          {{ $dapur->$field ?? '-' }}
        </td>
      </tr>

      @endforeach

      {{-- KEUANGAN --}}
      <tr class="bg-gray-50 dark:bg-gray-800/50">
        <td colspan="2"
            class="px-6 py-2 text-[11px] font-semibold uppercase tracking-widest text-gray-400 dark:text-gray-500">
          Keuangan & Pelaporan
        </td>
      </tr>

      <tr>
        <td class="border-b border-gray-100 px-6 py-3 dark:border-gray-800">
          Nomor Rekening / VA
        </td>
        <td class="border-b border-gray-100 px-6 py-3 dark:border-gray-800">
          {{ $dapur->nomor_rekening ?? '-' }}
        </td>
      </tr>

      <tr>
        <td class="border-b border-gray-100 px-6 py-3 dark:border-gray-800">
          Tempat Pelaporan
        </td>
        <td class="border-b border-gray-100 px-6 py-3 dark:border-gray-800">
          {{ $dapur->tempat_pelaporan ?? '-' }}
        </td>
      </tr>

      @if(isset($dapur->tanggal_pelaporan))
      <tr>
        <td class="px-6 py-3">
          Tanggal Pelaporan
        </td>
        <td class="px-6 py-3">
          {{ \Carbon\Carbon::parse($dapur->tanggal_pelaporan)->format('d F Y') }}
        </td>
      </tr>
      @endif

    </tbody>
  </table>

  @else

  <div class="p-8 text-center">
    <p class="text-gray-500">
      Data dapur belum tersedia.
    </p>
  </div>

  @endif

</div>