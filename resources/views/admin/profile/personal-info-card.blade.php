<div class="rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900 overflow-hidden">

  {{-- Header --}}
  <div class="flex items-start justify-between gap-4 px-6 py-5 border-b border-gray-200 dark:border-gray-800">
    <div>
      <div class="flex items-center gap-2 mb-1.5">
        <span class="inline-flex items-center gap-1.5 rounded-full bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-600 dark:bg-blue-900/30 dark:text-blue-400">
          <svg class="h-3 w-3 fill-current" viewBox="0 0 16 16"><path d="M8 1a5 5 0 100 10A5 5 0 008 1zm0 1.5a3.5 3.5 0 110 7 3.5 3.5 0 010-7zM3 13.5a.75.75 0 01.75-.75h8.5a.75.75 0 010 1.5h-8.5A.75.75 0 013 13.5z"/></svg>
          Profil Lembaga
        </span>
      </div>
      <h2 class="text-base font-semibold text-gray-900 dark:text-white">Data Lembaga</h2>
      <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">Ringkasan identitas SPPG untuk pelaporan.</p>
    </div>

    <button type="button" @click="$dispatch('open-profile-info-modal')"
      class="inline-flex items-center gap-2 rounded-lg border border-gray-200 bg-white px-3.5 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:hover:bg-gray-800">
      <svg class="h-3.5 w-3.5 fill-current" viewBox="0 0 18 18">
        <path fill-rule="evenodd" clip-rule="evenodd" d="M15.0911 2.78206C14.2125 1.90338 12.7878 1.90338 11.9092 2.78206L4.57524 10.116C4.26682 10.4244 4.0547 10.8158 3.96468 11.2426L3.31231 14.3352C3.25997 14.5833 3.33653 14.841 3.51583 15.0203C3.69512 15.1996 3.95286 15.2761 4.20096 15.2238L7.29355 14.5714C7.72031 14.4814 8.11172 14.2693 8.42013 13.9609L15.7541 6.62695C16.6327 5.74827 16.6327 4.32365 15.7541 3.44497L15.0911 2.78206ZM12.9698 3.84272C13.2627 3.54982 13.7376 3.54982 14.0305 3.84272L14.6934 4.50563C14.9863 4.79852 14.9863 5.2734 14.6934 5.56629L14.044 6.21573L12.3204 4.49215L12.9698 3.84272ZM11.2597 5.55281L5.6359 11.1766C5.53309 11.2794 5.46238 11.4099 5.43238 11.5522L5.01758 13.5185L6.98394 13.1037C7.1262 13.0737 7.25666 13.003 7.35947 12.9002L12.9833 7.27639L11.2597 5.55281Z"/>
      </svg>
      Edit
    </button>
  </div>

  {{-- Modal tetap sama --}}
  <x-ui.modal ...> ... </x-ui.modal>

  {{-- Tabel --}}
  <table class="w-full table-fixed border-collapse text-sm">
    <tbody>

      {{-- Section: Identitas Lembaga --}}
      <tr class="bg-gray-50 dark:bg-gray-800/50">
        <td colspan="2" class="px-6 py-2 text-[11px] font-semibold uppercase tracking-widest text-gray-400 dark:text-gray-500">
          Identitas Lembaga
        </td>
      </tr>
      @foreach([
        'nama_lembaga'    => 'Nama Lembaga',
        'alamat'          => 'Alamat',
        'nama_kepala_sppg'=> 'Nama Kepala SPPG',
        'nama_akuntan'    => 'Nama Akuntan SPPG',
      ] as $field => $label)
      <tr class="group hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors">
        <td class="w-2/5 border-b border-gray-100 px-6 py-3 dark:border-gray-800">
          <span class="inline-flex items-center gap-2 font-medium text-gray-600 dark:text-gray-400">
            <span class="h-1.5 w-1.5 rounded-full bg-blue-400"></span>
            {{ $label }}
          </span>
        </td>
        <td class="border-b border-gray-100 px-6 py-3 text-gray-800 dark:border-gray-800 dark:text-gray-200">
          {{ $dapur->$field }}
        </td>
      </tr>
      @endforeach

      {{-- Section: Yayasan --}}
      <tr class="bg-gray-50 dark:bg-gray-800/50">
        <td colspan="2" class="px-6 py-2 text-[11px] font-semibold uppercase tracking-widest text-gray-400 dark:text-gray-500">
          Yayasan
        </td>
      </tr>
      @foreach([
        'nama_yayasan' => 'Nama Yayasan',
        'ketua_yayasan'=> 'Ketua Yayasan',
      ] as $field => $label)
      <tr class="group hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors">
        <td class="w-2/5 border-b border-gray-100 px-6 py-3 dark:border-gray-800">
          <span class="inline-flex items-center gap-2 font-medium text-gray-600 dark:text-gray-400">
            <span class="h-1.5 w-1.5 rounded-full bg-blue-400"></span>
            {{ $label }}
          </span>
        </td>
        <td class="border-b border-gray-100 px-6 py-3 text-gray-800 dark:border-gray-800 dark:text-gray-200">
          {{ $dapur->$field }}
        </td>
      </tr>
      @endforeach

      {{-- Section: Keuangan & Pelaporan --}}
      <tr class="bg-gray-50 dark:bg-gray-800/50">
        <td colspan="2" class="px-6 py-2 text-[11px] font-semibold uppercase tracking-widest text-gray-400 dark:text-gray-500">
          Keuangan &amp; Pelaporan
        </td>
      </tr>
      <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors">
        <td class="w-2/5 border-b border-gray-100 px-6 py-3 dark:border-gray-800">
          <span class="inline-flex items-center gap-2 font-medium text-gray-600 dark:text-gray-400">
            <span class="h-1.5 w-1.5 rounded-full bg-blue-400"></span>
            Nomor Rekening / VA
          </span>
        </td>
        <td class="border-b border-gray-100 px-6 py-3 text-gray-800 dark:border-gray-800 dark:text-gray-200">
          {{ $dapur->nomor_rekening }}
        </td>
      </tr>
      <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors">
        <td class="w-2/5 border-b border-gray-100 px-6 py-3 dark:border-gray-800">
          <span class="inline-flex items-center gap-2 font-medium text-gray-600 dark:text-gray-400">
            <span class="h-1.5 w-1.5 rounded-full bg-blue-400"></span>
            Tempat Pelaporan
          </span>
        </td>
        <td class="border-b border-gray-100 px-6 py-3 text-gray-800 dark:border-gray-800 dark:text-gray-200">
          {{ $dapur->tempat_pelaporan }}
        </td>
      </tr>
      <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors">
        <td class="w-2/5 px-6 py-3 dark:border-gray-800">
          <span class="inline-flex items-center gap-2 font-medium text-gray-600 dark:text-gray-400">
            <span class="h-1.5 w-1.5 rounded-full bg-blue-400"></span>
            Tanggal Pelaporan
          </span>
        </td>
        <td class="px-6 py-3 text-gray-800 dark:text-gray-200">
          {{ \Carbon\Carbon::parse($dapur->tanggal_pelaporan)->format('d F Y') }}
        </td>
      </tr>

    </tbody>
  </table>
</div>