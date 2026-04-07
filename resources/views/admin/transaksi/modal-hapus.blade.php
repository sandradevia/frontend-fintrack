<div x-show="showHapus" x-transition
    class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">

    <div @click.away="closeModal()"
        class="bg-white dark:bg-gray-900 w-full max-w-md rounded-2xl shadow-xl p-6">

        {{-- ICON WARNING --}}
        <div class="flex justify-center mb-4">
            <div class="w-14 h-14 flex items-center justify-center rounded-full bg-red-100 text-red-600">
                <!-- Trash Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        d="M6 7h12M9 7v12m6-12v12M4 7h16l-1 14H5L4 7zm5-3h6"/>
                </svg>
            </div>
        </div>

        {{-- TITLE --}}
        <h2 class="text-center text-lg font-semibold text-gray-800 dark:text-white">
            Hapus Transaksi?
        </h2>

        {{-- DESC --}}
        <p class="text-center text-sm text-gray-500 mt-2">
            Data yang sudah dihapus tidak dapat dikembalikan.
        </p>

        {{-- INFO ID --}}
        <div class="text-center text-xs text-gray-400 mt-2">
            ID: <span x-text="selectedId"></span>
        </div>

        {{-- ACTION --}}
        <div class="flex justify-center gap-3 mt-6">
            <button @click="closeModal()"
                class="px-4 py-2 bg-gray-200 dark:bg-gray-700 rounded-lg text-sm">
                Batal
            </button>

            <button @click="deleteData()"
                class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-medium">
                Hapus
            </button>
        </div>

    </div>
</div>