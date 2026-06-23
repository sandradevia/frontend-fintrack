<div
    x-show="showHapus"
    x-transition
    x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
>

    <div
        @click.away="closeModal()"
        class="w-full max-w-md rounded-2xl bg-white p-6 shadow-xl dark:bg-gray-900"
    >

        {{-- ICON --}}
        <div class="mb-4 flex justify-center">
            <div class="flex h-14 w-14 items-center justify-center rounded-full bg-red-100 text-red-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        d="M6 7h12M9 7v12m6-12v12M4 7h16l-1 14H5L4 7zm5-3h6"/>
                </svg>
            </div>
        </div>

        <h2 class="text-center text-lg font-semibold">
            Hapus Transaksi?
        </h2>

        <p class="mt-2 text-center text-sm text-gray-500">
            Data yang sudah dihapus tidak dapat dikembalikan.
        </p>

        <div class="mt-2 text-center text-xs text-gray-400">
            ID: <span x-text="selectedId"></span>
        </div>

        <form
            :action="`{{ url('admin/transaksi') }}/${selectedId}`"
            method="POST"
        >
            @csrf
            @method('DELETE')

            <div class="mt-6 flex justify-center gap-3">

                <button
                    type="button"
                    @click="closeModal()"
                    class="rounded-lg bg-gray-200 px-4 py-2 text-sm dark:bg-gray-700"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    class="rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700"
                >
                    Hapus
                </button>

            </div>

        </form>

    </div>

</div>