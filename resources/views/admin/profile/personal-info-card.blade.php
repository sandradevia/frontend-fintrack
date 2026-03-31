<div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-gray-900 lg:p-6">
  <div class="mb-4 flex items-start justify-between gap-4">
    <div>
      <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Data Lembaga</h2>
      <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
        Ringkasan identitas SPPG untuk pelaporan.
      </p>
    </div>

    <button
      type="button"
      @click="$dispatch('open-profile-info-modal')"
      class="inline-flex items-center gap-2 rounded-xl border border-gray-200 bg-white px-4 py-2.5
             text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50
             focus:outline-none focus:ring-2 focus:ring-indigo-500/40
             dark:border-gray-800 dark:bg-gray-900 dark:text-gray-200 dark:hover:bg-gray-800"
    >
      <svg class="h-4 w-4 fill-current" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" clip-rule="evenodd"
          d="M15.0911 2.78206C14.2125 1.90338 12.7878 1.90338 11.9092 2.78206L4.57524 10.116C4.26682 10.4244 4.0547 10.8158 3.96468 11.2426L3.31231 14.3352C3.25997 14.5833 3.33653 14.841 3.51583 15.0203C3.69512 15.1996 3.95286 15.2761 4.20096 15.2238L7.29355 14.5714C7.72031 14.4814 8.11172 14.2693 8.42013 13.9609L15.7541 6.62695C16.6327 5.74827 16.6327 4.32365 15.7541 3.44497L15.0911 2.78206ZM12.9698 3.84272C13.2627 3.54982 13.7376 3.54982 14.0305 3.84272L14.6934 4.50563C14.9863 4.79852 14.9863 5.2734 14.6934 5.56629L14.044 6.21573L12.3204 4.49215L12.9698 3.84272ZM11.2597 5.55281L5.6359 11.1766C5.53309 11.2794 5.46238 11.4099 5.43238 11.5522L5.01758 13.5185L6.98394 13.1037C7.1262 13.0737 7.25666 13.003 7.35947 12.9002L12.9833 7.27639L11.2597 5.55281Z"/>
      </svg>
      Edit
    </button>
  </div>
  <x-ui.modal x-data="{ open: false }" @open-profile-info-modal.window="open = true" :isOpen="false" class="max-w-[700px]">
        <div
            class="no-scrollbar relative w-full max-w-[700px] overflow-y-auto rounded-3xl bg-white p-4 dark:bg-gray-900 lg:p-11">
            <div class="px-2 pr-14">
                <h4 class="mb-2 text-2xl font-semibold text-gray-800 dark:text-white/90">
                    Edit Data Pengguna
                </h4>
                <p class="mb-6 text-sm text-gray-500 dark:text-gray-400 lg:mb-7">
                    Perbaiki data lembaga untuk memastikan pelaporan yang akurat.
                </p>
            </div>
            <form class="flex flex-col">
                <div class="px-2 overflow-y-auto custom-scrollbar">
                    <div class="grid grid-cols-1 gap-x-6 gap-y-5 lg:grid-cols-2">
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Nama Lembaga
                            </label>
                            <input type="text" value="United States"
                                class="dark:bg-dark-900 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" />
                        </div>

                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Alamat
                            </label>
                            <input type="text" value="Poenix, Arizona, United States"
                                class="dark:bg-dark-900 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" />
                        </div>

                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Nama Kepala SPPG
                            </label>
                            <input type="text" value="ERT 2489"
                                class="dark:bg-dark-900 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" />
                        </div>

                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Nama Akuntan SPPG
                            </label>
                            <input type="text" value="AS4568384"
                                class="dark:bg-dark-900 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" />
                        </div>

                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Nama Yayasan
                            </label>
                            <input type="text" value="AS4568384"
                                class="dark:bg-dark-900 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" />
                        </div>

                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Ketua Yayasan
                            </label>
                            <input type="text" value="AS4568384"
                                class="dark:bg-dark-900 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" />
                        </div>

                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Nomor Rekening/VA
                            </label>
                            <input type="text" value="AS4568384"
                                class="dark:bg-dark-900 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" />
                        </div>

                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Tahun Anggaran
                            </label>
                            <input type="text" value="AS4568384"
                                class="dark:bg-dark-900 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" />
                        </div>

                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Periode saat ini  (2 pekanan)
                            </label>
                            <input type="text" value="AS4568384"
                                class="dark:bg-dark-900 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" />
                        </div>

                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Awal Periode berikutnya
                            </label>
                            <input type="text" value="AS4568384"
                                class="dark:bg-dark-900 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" />
                        </div>

                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Tanggal Pelaporan
                            </label>
                            <input type="text" value="AS4568384"
                                class="dark:bg-dark-900 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" />
                        </div>

                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Tempat Pelaporan
                            </label>
                            <input type="text" value="AS4568384"
                                class="dark:bg-dark-900 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" />
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-3 mt-6 lg:justify-end">
                    <button @click="open = false" type="button"
                        class="flex w-full justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] sm:w-auto">
                        Close
                    </button>
                    <button @click="saveProfile" type="button"
                        class="flex w-full justify-center rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-brand-600 sm:w-auto">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </x-ui.modal>

  <div class="overflow-hidden rounded-xl border border-gray-200 dark:border-gray-800">
    <table class="w-full table-fixed">
      <thead>
        <tr class="bg-gray-200 text-gray-900 dark:bg-gray-800 dark:text-gray-100">
          <th class="w-1/3 border-r border-gray-300 px-4 py-3 text-left text-sm font-bold uppercase tracking-wide dark:border-gray-700">
            ITEM
          </th>
          <th class="px-4 py-3 text-left text-sm font-bold uppercase tracking-wide">
            URAIAN
          </th>
        </tr>
      </thead>

      <tbody class="text-sm">
        <!-- Row helper: kolom kiri putih, kolom kanan kuning -->
        <tr class="border-t border-gray-200 dark:border-gray-800">
          <td class="border-r border-gray-200 bg-white px-4 py-3 font-medium text-gray-800 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-200">
            Nama Lembaga
          </td>
          <td class="bg-yellow-100 px-4 py-3 font-semibold text-gray-900 dark:bg-yellow-500/15 dark:text-yellow-100">
            SPPG GADOG MEGAMENDUNG
          </td>
        </tr>

        <tr class="border-t border-gray-200 dark:border-gray-800">
          <td class="border-r border-gray-200 bg-white px-4 py-3 font-medium text-gray-800 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-200">
            Alamat
          </td>
          <td class="bg-yellow-100 px-4 py-3 font-semibold text-gray-900 dark:bg-yellow-500/15 dark:text-yellow-100">
            Jl. Pasir Angin desa Gadog
          </td>
        </tr>

        <tr class="border-t border-gray-200 dark:border-gray-800">
          <td class="border-r border-gray-200 bg-white px-4 py-3 font-medium text-gray-800 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-200">
            Nama Kepala SPPG
          </td>
          <td class="bg-yellow-100 px-4 py-3 font-semibold text-gray-900 dark:bg-yellow-500/15 dark:text-yellow-100">
            Sutiono
          </td>
        </tr>

        <tr class="border-t border-gray-200 dark:border-gray-800">
          <td class="border-r border-gray-200 bg-white px-4 py-3 font-medium text-gray-800 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-200">
            Nama Akuntan SPPG
          </td>
          <td class="bg-yellow-100 px-4 py-3 font-semibold text-gray-900 dark:bg-yellow-500/15 dark:text-yellow-100">
            Riyanto
          </td>
        </tr>

        <tr class="border-t border-gray-200 dark:border-gray-800">
          <td class="border-r border-gray-200 bg-white px-4 py-3 font-medium text-gray-800 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-200">
            Nama Yayasan
          </td>
          <td class="bg-yellow-100 px-4 py-3 font-semibold text-gray-900 dark:bg-yellow-500/15 dark:text-yellow-100">
            Yayasan Bakti Nusa
          </td>
        </tr>

        <tr class="border-t border-gray-200 dark:border-gray-800">
          <td class="border-r border-gray-200 bg-white px-4 py-3 font-medium text-gray-800 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-200">
            Ketua Yayasan/yang mewakili
          </td>
          <td class="bg-yellow-100 px-4 py-3 font-semibold text-gray-900 dark:bg-yellow-500/15 dark:text-yellow-100">
            Bakri
          </td>
        </tr>

        <tr class="border-t border-gray-200 dark:border-gray-800">
          <td class="border-r border-gray-200 bg-white px-4 py-3 font-medium text-gray-800 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-200">
            Nomor Rekening/VA
          </td>
          <td class="bg-yellow-100 px-4 py-3 font-semibold text-gray-900 dark:bg-yellow-500/15 dark:text-yellow-100">
            12345
          </td>
        </tr>

        <tr class="border-t border-gray-200 dark:border-gray-800">
          <td class="border-r border-gray-200 bg-white px-4 py-3 font-medium text-gray-800 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-200">
            Tahun Anggaran
          </td>
          <td class="bg-yellow-100 px-4 py-3 font-semibold text-gray-900 dark:bg-yellow-500/15 dark:text-yellow-100">
            2025
          </td>
        </tr>

        <tr class="border-t border-gray-200 dark:border-gray-800">
          <td class="border-r border-gray-200 bg-white px-4 py-3 font-medium text-gray-800 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-200">
            Periode saat ini (2 pekanan)
          </td>
          <td class="bg-yellow-100 px-4 py-3 font-semibold text-gray-900 dark:bg-yellow-500/15 dark:text-yellow-100">
            1 - 13 Desember 2025
          </td>
        </tr>

        <tr class="border-t border-gray-200 dark:border-gray-800">
          <td class="border-r border-gray-200 bg-white px-4 py-3 font-medium text-gray-800 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-200">
            Awal periode berikutnya (format text)
          </td>
          <td class="bg-yellow-100 px-4 py-3 font-semibold text-gray-900 dark:bg-yellow-500/15 dark:text-yellow-100">
            15 Desember 2025
          </td>
        </tr>

        <tr class="border-t border-gray-200 dark:border-gray-800">
          <td class="border-r border-gray-200 bg-white px-4 py-3 font-medium text-gray-800 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-200">
            Tanggal Pelaporan (format text)
          </td>
          <td class="bg-yellow-100 px-4 py-3 font-semibold text-gray-900 dark:bg-yellow-500/15 dark:text-yellow-100">
            13 Desember 2025
          </td>
        </tr>

        <tr class="border-t border-gray-200 dark:border-gray-800">
          <td class="border-r border-gray-200 bg-white px-4 py-3 font-medium text-gray-800 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-200">
            Tempat Pelaporan
          </td>
          <td class="bg-yellow-100 px-4 py-3 font-semibold text-gray-900 dark:bg-yellow-500/15 dark:text-yellow-100">
            Gadog
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
