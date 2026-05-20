@extends('layouts.app')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

    .dapur-wrap * {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* ── Label & Input global ── */
    .dapur-label {
        display: block;
        font-size: 0.72rem;
        font-weight: 600;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        color: #6b7280;
        margin-bottom: 0.35rem;
    }
    .dark .dapur-label { color: #9ca3af; }

    .dapur-input {
        width: 100%;
        padding: 0.55rem 0.85rem;
        border-radius: 0.6rem;
        border: 1.5px solid #e5e7eb;
        background: #f9fafb;
        font-size: 0.875rem;
        color: #111827;
        transition: border-color .2s, box-shadow .2s;
        outline: none;
    }
    .dapur-input:focus {
        border-color: #3b82f6;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(59,130,246,.12);
    }
    .dark .dapur-input {
        background: #1f2937;
        border-color: #374151;
        color: #f3f4f6;
    }
    .dark .dapur-input:focus {
        border-color: #60a5fa;
        background: #111827;
        box-shadow: 0 0 0 3px rgba(96,165,250,.15);
    }

    /* ── Modal animations ── */
    @keyframes backdropIn  { from { opacity: 0; } to { opacity: 1; } }
    @keyframes cardSlideUp { from { transform: translateY(18px) scale(.97); opacity: 0; }
                              to  { transform: translateY(0)      scale(1);   opacity: 1; } }

    .modal-backdrop { animation: backdropIn .18s ease; }
    .modal-card     { animation: cardSlideUp .22s cubic-bezier(.32,1,.28,1); }

    /* ── Badge pill ── */
    .badge {
        display: inline-flex;
        align-items: center;
        gap: .3rem;
        padding: .2rem .7rem;
        border-radius: 99px;
        font-size: .7rem;
        font-weight: 600;
        letter-spacing: .04em;
    }

    /* ── Section divider in modal ── */
    .modal-section-title {
        font-size: .7rem;
        font-weight: 700;
        letter-spacing: .08em;
        text-transform: uppercase;
        color: #9ca3af;
        margin-bottom: .75rem;
        display: flex;
        align-items: center;
        gap: .5rem;
    }
    .modal-section-title::after {
        content: '';
        flex: 1;
        height: 1px;
        background: #e5e7eb;
    }
    .dark .modal-section-title::after { background: #374151; }

    /* ── Table row hover ── */
    .dapur-row { transition: background .15s; }
    .dapur-row:hover { background: #f0f7ff; }
    .dark .dapur-row:hover { background: rgba(59,130,246,.07); }

    /* Detail grid */
    .detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: .85rem;
    }
    .detail-box {
        background: #f8fafc;
        border: 1px solid #e9eef5;
        border-radius: .75rem;
        padding: .85rem 1rem;
    }
    .dark .detail-box { background: #1e2736; border-color: #2e3a4e; }
    .detail-box-full { grid-column: 1 / -1; }
    .detail-box .lbl { font-size: .65rem; font-weight: 700; letter-spacing: .07em; text-transform: uppercase; color: #94a3b8; margin-bottom: .25rem; }
    .detail-box .val { font-size: .875rem; font-weight: 600; color: #1e293b; }
    .dark .detail-box .val { color: #f1f5f9; }
</style>

<div class="dapur-wrap space-y-6">

    {{-- ── BREADCRUMB + CTA ── --}}
    <x-common.page-breadcrumb pageTitle="Kelola Dapur" />
    <div class="flex items-center justify-between flex-wrap gap-3">
        <div>
            <p class="text-xs text-gray-400 mt-0.5">Manajemen data satuan pelayanan pemenuhan gizi (SPPG)</p>
        </div>

        <a href="{{ route('super.kelola-dapur.create') }}"
   class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 active:scale-95
          text-white text-sm font-semibold rounded-xl shadow-md shadow-blue-200
          dark:shadow-none transition-all duration-150">

    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
    </svg>

    Tambah Dapur
</a>
    </div>

    {{-- ── STAT CARDS ── --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 p-5 flex items-center gap-4 shadow-sm">
            <div class="w-11 h-11 rounded-xl bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 22V12h6v10"/>
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-500 font-medium">Total Dapur</p>
                <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ count($dapur) }}</p>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 p-5 flex items-center gap-4 shadow-sm">
            <div class="w-11 h-11 rounded-xl bg-green-50 dark:bg-green-900/30 flex items-center justify-center text-green-600 dark:text-green-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-500 font-medium">Dapur Aktif</p>
                <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ count($dapur) }}</p>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 p-5 flex items-center gap-4 shadow-sm">
            <div class="w-11 h-11 rounded-xl bg-purple-50 dark:bg-purple-900/30 flex items-center justify-center text-purple-600 dark:text-purple-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"/>
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-500 font-medium">Total Pengelola</p>
                <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ count($dapur) }}</p>
            </div>
        </div>
    </div>

    {{-- ── TABLE CARD ── --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden">

        {{-- Card header --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-gray-800">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h7"/>
                    </svg>
                </div>
                <h2 class="text-sm font-bold text-gray-800 dark:text-gray-100 tracking-tight">Daftar Dapur SPPG</h2>
            </div>
            <span class="badge bg-blue-50 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300">
                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 inline-block"></span>
                {{ count($dapur) }} Data
            </span>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-800/60">
                        <th class="py-3 px-5 text-left text-xs font-700 text-gray-500 dark:text-gray-400 uppercase tracking-wider w-10">No</th>
                        <th class="px-4 py-3 text-left text-xs font-700 text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nama Lembaga</th>
                        <th class="px-4 py-3 text-left text-xs font-700 text-gray-500 dark:text-gray-400 uppercase tracking-wider">Alamat</th>
                        <th class="px-4 py-3 text-left text-xs font-700 text-gray-500 dark:text-gray-400 uppercase tracking-wider">Kepala SPPG</th>
                        <th class="px-4 py-3 text-center text-xs font-700 text-gray-500 dark:text-gray-400 uppercase tracking-wider w-40">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($dapur as $index => $item)
                    <tr class="dapur-row">
                        <td class="py-3.5 px-5">
                            <span class="inline-flex items-center justify-center w-6 h-6 rounded-md bg-gray-100 dark:bg-gray-800 text-xs font-semibold text-gray-500">
                                {{ $index + 1 }}
                            </span>
                        </td>
                        <td class="px-4 py-3.5">
                            <div class="flex items-center gap-3">
                                </div>
                                <span class="font-semibold text-gray-800 dark:text-gray-100 text-sm">{{ $item->nama_lembaga }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-3.5 text-gray-500 dark:text-gray-400 text-sm max-w-xs truncate">
                            <span class="inline-flex items-center gap-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                {{ $item->alamat }}
                            </span>
                        </td>
                        <td class="px-4 py-3.5 text-gray-700 dark:text-gray-300 text-sm font-medium">
                            {{ $item->nama_kepala_sppg }}
                        </td>
                        <td class="px-4 py-3.5">
                            <div class="flex items-center justify-center gap-1.5">

                                {{-- DETAIL (HALAMAN) --}}
                                <a href="{{ route('super.kelola-dapur.show', $item->id) }}"
                                    title="Lihat Detail"
                                    class="inline-flex items-center gap-1 px-2.5 py-1.5 text-xs font-semibold bg-blue-50 text-blue-700 hover:bg-blue-100 dark:bg-blue-900/30 dark:text-blue-300 dark:hover:bg-blue-900/50 rounded-lg transition">

                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>

                                    Detail
                                </a>

                                {{-- EDIT (HALAMAN) --}}
                                <a href="{{ route('super.kelola-dapur.edit', $item->id) }}"
                                    title="Edit Data"
                                    class="inline-flex items-center gap-1 px-2.5 py-1.5 text-xs font-semibold bg-amber-50 text-amber-700 hover:bg-amber-100 dark:bg-amber-900/30 dark:text-amber-300 dark:hover:bg-amber-900/50 rounded-lg transition">

                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>

                                    Edit
                                </a>

                                {{-- HAPUS --}}
                                <form action="{{ route('super.kelola-dapur.destroy', $item->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        onclick="return confirm('Yakin ingin menghapus data \"{{ $item->nama_lembaga }}\"?')"
                                        title="Hapus Data"
                                        class="inline-flex items-center gap-1 px-2.5 py-1.5 text-xs font-semibold bg-red-50 text-red-600 hover:bg-red-100 dark:bg-red-900/30 dark:text-red-400 dark:hover:bg-red-900/50 rounded-lg transition">

                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>

                                        Hapus
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-16 text-center">
                            <div class="flex flex-col items-center gap-3 text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 opacity-30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 22V12h6v10"/>
                                </svg>
                                <p class="text-sm font-medium">Belum ada data dapur</p>
                                <p class="text-xs">Klik tombol <span class="font-semibold text-blue-500">+ Tambah Dapur</span> untuk memulai</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>



{{-- ─── JAVASCRIPT ─── --}}
<script>
    /* ── Helpers ── */
    function val(v) { return (v && v.trim()) ? v : '–'; }
    function fmtDate(d) {
        if (!d) return '–';
        const dt = new Date(d);
        return isNaN(dt) ? d : dt.toLocaleDateString('id-ID', { day:'numeric', month:'long', year:'numeric' });
    }

    /* ── Modal Tambah ── */
    function openModal() {
        document.getElementById('modalTitle').innerText    = 'Tambah Dapur';
        document.getElementById('modalSubtitle').innerText = 'Isi seluruh informasi dapur SPPG';
        document.getElementById('form').action             = "{{ route('super.kelola-dapur.store') }}";
        document.getElementById('method').value            = 'POST';
        // clear all inputs
        document.getElementById('form').querySelectorAll('input').forEach(i => { if(i.name !== '_token' && i.name !== '_method') i.value = ''; });
        showModal('modal');
    }

    /* ── Modal Edit ── */
    function editModal(id, nama_lembaga, alamat, kepala, akuntan, yayasan, ketua_yayasan, pengelola, rekening, tgl_pelaporan, tempat, tahun, periode, awal_periode) {
        document.getElementById('modalTitle').innerText    = 'Edit Dapur';
        document.getElementById('modalSubtitle').innerText = 'Perbarui informasi dapur SPPG';
        document.getElementById('form').action             = `/super/kelola-dapur/${id}`;
        document.getElementById('method').value            = 'PUT';

        document.getElementById('nama').value                   = nama_lembaga;
        document.getElementById('alamat').value                 = alamat;
        document.getElementById('nama_kepala_sppg').value       = kepala;
        document.getElementById('nama_akuntan').value           = akuntan;
        document.getElementById('nama_yayasan').value           = yayasan;
        document.getElementById('ketua_yayasan').value          = ketua_yayasan;
        document.getElementById('nama_pengelola').value         = pengelola;
        document.getElementById('nomor_rekening').value         = rekening;
        document.getElementById('tanggal_pelaporan').value      = tgl_pelaporan;
        document.getElementById('tempat_pelaporan').value       = tempat;
        document.getElementById('tahun_anggaran').value         = tahun;
        document.getElementById('periode_saat_ini').value       = periode;
        document.getElementById('awal_periode_berikutnya').value = awal_periode;

        showModal('modal');
    }

    function closeModal() { hideModal('modal'); }

    /* ── Modal Detail ── */
    function detailModal(id, nama, alamat, kepala, akuntan, yayasan, ketua_yayasan, pengelola, rekening, tgl_pelaporan, tempat, tahun, periode, awal_periode) {
        // Avatar initials
        const initials = nama.trim().split(' ').slice(0,2).map(w => w[0]).join('').toUpperCase();
        document.getElementById('detailAvatar').innerText    = initials;
        document.getElementById('detailNama').innerText      = val(nama);

        document.getElementById('d_nama_lembaga').innerText  = val(nama);
        document.getElementById('d_alamat').innerText        = val(alamat);
        document.getElementById('d_kepala').innerText        = val(kepala);
        document.getElementById('d_akuntan').innerText       = val(akuntan);
        document.getElementById('d_yayasan').innerText       = val(yayasan);
        document.getElementById('d_ketua_yayasan').innerText = val(ketua_yayasan);
        document.getElementById('d_pengelola').innerText     = val(pengelola);
        document.getElementById('d_rekening').innerText      = val(rekening);
        document.getElementById('d_tgl_pelaporan').innerText = fmtDate(tgl_pelaporan);
        document.getElementById('d_tempat_pelaporan').innerText = val(tempat);
        document.getElementById('d_tahun_anggaran').innerText   = val(tahun);
        document.getElementById('d_periode').innerText          = val(periode);
        document.getElementById('d_awal_periode').innerText     = fmtDate(awal_periode);

        showModal('detailModal');
    }

    function closeDetailModal() { hideModal('detailModal'); }

    /* ── Generic show/hide ── */
    function showModal(id) {
        const m = document.getElementById(id);
        m.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    function hideModal(id) {
        const m = document.getElementById(id);
        m.classList.add('hidden');
        document.body.style.overflow = '';
    }
</script>

@endsection