<div x-show="showEdit" x-transition.scale
    class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">

    <div @click.away="closeModal()"
        class="bg-white dark:bg-gray-900 w-full max-w-2xl rounded-2xl shadow-xl p-6">

        {{-- HEADER --}}
        <div class="flex justify-between mb-5">
            <h2 class="font-semibold text-lg">Edit Transaksi</h2>
        </div>

        {{-- FORM --}}
        <div class="grid grid-cols-2 gap-4">

            {{-- Tanggal --}}
            <div>
                <label class="text-sm">Tanggal</label>
                <input type="date" x-model="formEdit.tanggal"
                    class="w-full border rounded px-3 py-2">
            </div>

            {{-- No Bukti --}}
            <div>
                <label class="text-sm">No Bukti</label>
                <input type="text" x-model="formEdit.no_bukti" readonly
                    class="w-full border rounded px-3 py-2 bg-gray-100">
            </div>

            {{-- Uraian --}}
            <div class="col-span-2">
                <label class="text-sm">Uraian</label>
                <input type="text" x-model="formEdit.uraian"
                    class="w-full border rounded px-3 py-2">
            </div>

            {{-- Debet --}}
            <div>
                <label class="text-sm">Debet</label>
                <input type="number" x-model="formEdit.debet"
                    class="w-full border rounded px-3 py-2">
            </div>

            {{-- Kredit --}}
            <div>
                <label class="text-sm">Kredit</label>
                <input type="number" x-model="formEdit.kredit"
                    class="w-full border rounded px-3 py-2">
            </div>

            {{-- Jenis --}}
            <div>
                <label class="text-sm">Jenis</label>
                <select x-model="formEdit.jenis"
                    class="w-full border rounded px-3 py-2">
                    <option value="">-- Pilih --</option>
                    <option>Kas</option>
                    <option>Bank</option>
                    <option>Piutang</option>
                </select>
            </div>

            {{-- Keterangan --}}
            <div>
                <label class="text-sm">Keterangan</label>
                <input type="text" x-model="formEdit.keterangan"
                    class="w-full border rounded px-3 py-2">
            </div>

        </div>

        {{-- FOOTER --}}
        <div class="flex justify-end gap-2 mt-6">
            <button @click="closeModal()" 
                class="px-4 py-2 bg-gray-200 rounded">
                Batal
            </button>

            <button @click="updateData()" 
                class="px-4 py-2 bg-brand-500 text-white rounded">
                Simpan
            </button>
        </div>

    </div>
</div>