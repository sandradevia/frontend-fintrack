<div x-data="{ openProfileModal: false }" class="rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900 overflow-hidden">

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
            @click="openProfileModal = true"
            class="inline-flex items-center gap-2 rounded-lg border border-gray-200 bg-white px-3.5 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:hover:bg-gray-800"
        >
            Edit
        </button>
    </div>

    {{-- Body/Table Content --}}
    @if($dapur)
        <table class="w-full table-fixed border-collapse text-sm">
            <tbody>
                {{-- IDENTITAS --}}
                <tr class="bg-gray-50 dark:bg-gray-800/50">
                    <td colspan="2" class="px-6 py-2 text-[11px] font-semibold uppercase tracking-widest text-gray-400 dark:text-gray-500">
                        Identitas Lembaga SPPG
                    </td>
                </tr>

                @foreach([
                    'nama_lembaga' => 'Nama Lembaga',
                    'alamat' => 'Alamat',
                    'nama_kepala_sppg' => 'Nama Kepala SPPG',
                    'nama_akuntan' => 'Nama Akuntan SPPG',
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
                    <td colspan="2" class="px-6 py-2 text-[11px] font-semibold uppercase tracking-widest text-gray-400 dark:text-gray-500">
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
                    <td colspan="2" class="px-6 py-2 text-[11px] font-semibold uppercase tracking-widest text-gray-400 dark:text-gray-500">
                        Keuangan & Pelaporan
                    </td>
                </tr>

                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40">
                    <td class="w-2/5 border-b border-gray-100 px-6 py-3 dark:border-gray-800">
                        Nomor Rekening / VA
                    </td>
                    <td class="border-b border-gray-100 px-6 py-3 dark:border-gray-800">
                        {{ $dapur->nomor_rekening ?? '-' }}
                    </td>
                </tr>

                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40">
                    <td class="w-2/5 border-b border-gray-100 px-6 py-3 dark:border-gray-800">
                        Tempat Pelaporan
                    </td>
                    <td class="border-b border-gray-100 px-6 py-3 dark:border-gray-800">
                        {{ $dapur->tempat_pelaporan ?? '-' }}
                    </td>
                </tr>
            </tbody>
        </table>
    @else
        <div class="p-8 text-center">
            <p class="text-gray-500 dark:text-gray-400">
                Data dapur belum tersedia.
            </p>
        </div>
    @endif

    {{-- MODAL EDIT --}}
    <div 
        x-show="openProfileModal" 
        x-transition.opacity 
        x-cloak 
        class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/50 p-4"
    >
        <div 
            @click.away="openProfileModal = false" 
            class="w-full max-w-3xl rounded-2xl bg-white p-6 shadow-xl dark:bg-gray-900"
        >
            {{-- Modal Header --}}
            <div class="mb-6 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Edit Data Lembaga
                </h3>
                <button 
                    type="button" 
                    @click="openProfileModal = false" 
                    class="text-2xl font-light text-gray-400 hover:text-red-500 transition"
                >
                    &times;
                </button>
            </div>

            {{-- Modal Form --}}
            <form method="POST" action="{{ route('admin.profile.update', $dapur->id) }}">
                @csrf
                @method('PUT')

                <div class="space-y-6 max-h-[65vh] overflow-y-auto pr-2">
                    {{-- IDENTITAS --}}
                    <div>
                        <h4 class="mb-3 text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Identitas Lembaga
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Lembaga</label>
                                <input 
                                    type="text" 
                                    name="nama_lembaga" 
                                    value="{{ old('nama_lembaga', $dapur->nama_lembaga) }}" 
                                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white" 
                                    required
                                >
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Kepala SPPG</label>
                                <input 
                                    type="text" 
                                    name="nama_kepala_sppg" 
                                    value="{{ old('nama_kepala_sppg', $dapur->nama_kepala_sppg) }}" 
                                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                                >
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Akuntan SPPG</label>
                                <input 
                                    type="text" 
                                    name="nama_akuntan" 
                                    value="{{ old('nama_akuntan', $dapur->nama_akuntan) }}" 
                                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                                >
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Alamat</label>
                                <textarea 
                                    name="alamat" 
                                    rows="3" 
                                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                                >{{ old('alamat', $dapur->alamat) }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- YAYASAN --}}
                    <div>
                        <h4 class="mb-3 text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Yayasan
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Yayasan</label>
                                <input 
                                    type="text" 
                                    name="nama_yayasan" 
                                    value="{{ old('nama_yayasan', $dapur->nama_yayasan) }}" 
                                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                                >
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Ketua Yayasan</label>
                                <input 
                                    type="text" 
                                    name="ketua_yayasan" 
                                    value="{{ old('ketua_yayasan', $dapur->ketua_yayasan) }}" 
                                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                                >
                            </div>
                        </div>
                    </div>

                    {{-- KEUANGAN --}}
                    <div>
                        <h4 class="mb-3 text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Keuangan & Pelaporan
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nomor Rekening / VA</label>
                                <input 
                                    type="text" 
                                    name="nomor_rekening" 
                                    value="{{ old('nomor_rekening', $dapur->nomor_rekening) }}" 
                                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                                >
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tempat Pelaporan</label>
                                <input 
                                    type="text" 
                                    name="tempat_pelaporan" 
                                    value="{{ old('tempat_pelaporan', $dapur->tempat_pelaporan) }}" 
                                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                                >
                            </div>
                        </div>
                    </div>

                    {{-- AKUN LOGIN --}}
                    <div>
                        <h4 class="mb-3 text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Akun Login
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Username</label>
                                <input 
                                    type="text" 
                                    name="username" 
                                    value="{{ old('username', optional($dapur->user)->username) }}" 
                                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                                >
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Password Baru</label>
                                <input 
                                    type="password" 
                                    name="password" 
                                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                                >
                                <small class="text-xs text-gray-400 mt-1 block">
                                    Kosongkan jika tidak ingin mengganti password.
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Modal Footer --}}
                <div class="mt-6 flex justify-end gap-3 border-t border-gray-100 dark:border-gray-800 pt-4">
                    <button 
                        type="button" 
                        @click="openProfileModal = false" 
                        class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800"
                    >
                        Batal
                    </button>
                    <button 
                        type="submit" 
                        class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-700"
                    >
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>