<div
    x-show="showTambah"
    x-transition
    x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
>

    <div
        @click.away="closeModal()"
        class="w-full max-w-2xl rounded-2xl bg-white p-6 shadow-xl dark:bg-gray-900"
    >

        {{-- Header --}}
        <div class="mb-5 flex items-center justify-between">
            <h2 class="text-lg font-semibold">
                Tambah Transaksi
            </h2>

            <button
                @click="closeModal()"
                class="text-gray-500 hover:text-red-500"
            >
                ✕
            </button>
        </div>

        <form action="{{ route('admin.transaksi.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-2 gap-4">

                <div>
                    <label class="text-sm">Tanggal</label>
                    <input
                        type="date"
                        name="tanggal"
                        value="{{ date('Y-m-d') }}"
                        class="w-full border rounded px-3 py-2"
                        required
                    >
                </div>

                <div>
                    <label class="text-sm">No Bukti</label>
                    <input
                        type="text"
                        name="no_bukti"
                        value="{{ $nextKwt }}" {{-- Jika ini modal khusus pengeluaran/Kwitansi --}}
                        readonly
                        class="w-full border rounded px-3 py-2 bg-gray-100"
                    >
                </div>

                <div class="col-span-2">
                    <label class="text-sm">Uraian</label>
                    <input
                        type="text"
                        name="uraian"
                        class="w-full border rounded px-3 py-2"
                        required
                    >
                </div>

                <div>
                    <label class="text-sm">Debet</label>
                    <input
                        type="number"
                        name="debet"
                        value="0"
                        class="w-full border rounded px-3 py-2"
                    >
                </div>

                <div>
                    <label class="text-sm">Kredit</label>
                    <input
                        type="number"
                        name="kredit"
                        value="0"
                        class="w-full border rounded px-3 py-2"
                    >
                </div>

                <div>
                    <label class="text-sm">Jenis</label>
                    <select
                        name="akun_id"
                        x-model="formEdit.akun_id"
                        class="w-full border rounded px-3 py-2"
                        required
                    >
                        <option value="">-- Pilih Akun --</option>

                        @foreach($akun as $akun)
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
                        <option value="Kas di Bank">Kas di Bank</option>
                        <option value="Petty Cash/Cash in Hand">Petty Cash/Cash in Hand</option>
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
                    Simpan
                </button>

            </div>

        </form>

    </div>

</div>
<script>
$(document).ready(function () {

    $('#akun_id').select2({
        placeholder: 'Cari akun...',
        width: '100%',
        minimumInputLength: 1,

        ajax: {
            url: "{{ route('admin.transaksi.search-akun') }}",
            dataType: 'json',
            delay: 300,

            data: function(params) {
                return {
                    q: params.term
                };
            },

            processResults: function(data) {
                return {
                    results: data
                };
            },

            cache: true
        }
    });

});
</script>