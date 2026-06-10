<div
    x-show="showEdit"
    x-transition
    x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
>

    <div
        @click.away="closeModal()"
        class="w-full max-w-2xl rounded-2xl bg-white p-6 shadow-xl dark:bg-gray-900"
    >

        <div class="mb-5 flex items-center justify-between">
            <h2 class="text-lg font-semibold">
                Edit Transaksi
            </h2>

            <button
                type="button"
                @click="closeModal()"
                class="text-gray-500 hover:text-red-500"
            >
                ✕
            </button>
        </div>

        <form
            :action="`{{ url('admin/transaksi') }}/${selectedId}`"
            method="POST"
        >
            @csrf
            @method('PUT')

            <div class="grid grid-cols-2 gap-4">

                <div>
                    <label class="text-sm">Tanggal</label>
                    <input
                        type="date"
                        name="tanggal"
                        x-model="formEdit.tanggal"
                        class="w-full border rounded px-3 py-2"
                        required
                    >
                </div>

                <div>
                    <label class="text-sm">No Bukti</label>
                    <input
                        type="text"
                        name="no_bukti"
                        x-model="formEdit.no_bukti"
                        readonly
                        class="w-full border rounded px-3 py-2 bg-gray-100"
                    >
                </div>

                <div class="col-span-2">
                    <label class="text-sm">Uraian</label>
                    <input
                        type="text"
                        name="uraian"
                        x-model="formEdit.uraian"
                        class="w-full border rounded px-3 py-2"
                        required
                    >
                </div>

                <div>
                    <label class="text-sm">Debet</label>
                    <input
                        type="number"
                        name="debet"
                        x-model="formEdit.debet"
                        class="w-full border rounded px-3 py-2"
                    >
                </div>

                <div>
                    <label class="text-sm">Kredit</label>
                    <input
                        type="number"
                        name="kredit"
                        x-model="formEdit.kredit"
                        class="w-full border rounded px-3 py-2"
                    >
                </div>

                {{-- Akun --}}
                <div>
                    <label class="text-sm">Akun</label>

                    <select
                        name="akun_id"
                        x-model="formEdit.akun_id"
                        class="w-full border rounded px-3 py-2"
                        required
                    >
                        <option value="">-- Pilih Akun --</option>

                        @foreach($akuns as $akun)
                            <option value="{{ $akun->id }}">
                                {{ $akun->kode }} - {{ $akun->nama_akun }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="text-sm">Keterangan</label>
                    <select
                        name="keterangan"
                        class="w-full border rounded px-3 py-2">
                        <option value="">-- Pilih Keterangan --</option>
                        <option value="Kas di Bank"
                            {{ old('keterangan', $data->keterangan ?? '') == 'Kas di Bank' ? 'selected' : '' }}>
                            Kas di Bank
                        </option>
                        <option value="Petty Cash/Cash in Hand"
                            {{ old('keterangan', $data->keterangan ?? '') == 'Petty Cash/Cash in Hand' ? 'selected' : '' }}>
                            Petty Cash/Cash in Hand
                        </option>
                    </select>
                </div>

            </div>

            <div class="mt-6 flex justify-end gap-2">

                <button
                    type="button"
                    @click="closeModal()"
                    class="rounded bg-gray-200 px-4 py-2"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    class="rounded bg-brand-500 px-4 py-2 text-white"
                >
                    Update
                </button>

            </div>

        </form>

    </div>
</div>