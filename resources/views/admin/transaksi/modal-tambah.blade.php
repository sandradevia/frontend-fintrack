<div x-show="showTambah" x-transition
    class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">

    <div @click.away="closeModal()"
        class="bg-white dark:bg-gray-900 w-full max-w-2xl rounded-2xl shadow-xl p-6">

        {{-- HEADER --}}
        <div class="flex justify-between mb-5">
            <h2 class="font-semibold text-lg">Tambah Transaksi</h2>
        </div>

        {{-- FORM --}}
        <div class="grid grid-cols-2 gap-4">

            <div>
                <label class="text-sm">Tanggal</label>
                <input type="date" x-model="form.tanggal"
                    class="w-full border rounded px-3 py-2">
            </div>

            <div>
                <label class="text-sm">No Bukti</label>
                <input type="text" x-model="form.no_bukti" readonly
                    class="w-full border rounded px-3 py-2 bg-gray-100">
            </div>

            <div class="col-span-2">
                <label class="text-sm">Uraian</label>
                <input type="text" x-model="form.uraian"
                    class="w-full border rounded px-3 py-2">
            </div>

            <div>
                <label class="text-sm">Debet</label>
                <input type="number" x-model="form.debet"
                    class="w-full border rounded px-3 py-2">
            </div>

            <div>
                <label class="text-sm">Kredit</label>
                <input type="number" x-model="form.kredit"
                    class="w-full border rounded px-3 py-2">
            </div>

            <div>
                <label class="text-sm">Jenis</label>
                <select x-model="form.jenis"
                    class="w-full border rounded px-3 py-2">
                    <option value="">-- Pilih --</option>
                    <option>Kas</option>
                    <option>Bank</option>
                    <option>Piutang</option>
                </select>
            </div>

            <div>
                <label class="text-sm">Keterangan</label>
                <input type="text" x-model="form.keterangan"
                    class="w-full border rounded px-3 py-2">
            </div>

        </div>

        {{-- FOOTER --}}
        <div class="flex justify-end gap-2 mt-6">
            <button @click="closeModal()" class="px-4 py-2 bg-gray-200 rounded">
                Batal
            </button>
            <button @click="submitForm()" class="px-4 py-2 bg-brand-500 text-white rounded">
                Simpan
            </button>
        </div>
    </div>
</div>