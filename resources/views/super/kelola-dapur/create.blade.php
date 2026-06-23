@extends('layouts.app')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

    .dapur-wrap * {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .dapur-label {
        display: block;
        font-size: 0.72rem;
        font-weight: 600;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        color: #6b7280;
        margin-bottom: 0.35rem;
    }

    .dapur-input {
        width: 100%;
        padding: 0.55rem 0.85rem;
        border-radius: 0.6rem;
        border: 1.5px solid #e5e7eb;
        background: #f9fafb;
        font-size: 0.875rem;
        outline: none;
    }

    .dapur-input:focus {
        border-color: #3b82f6;
        background: #fff;
    }

    .section-title {
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

    .section-title::after {
        content: '';
        flex: 1;
        height: 1px;
        background: #e5e7eb;
    }
</style>

   <form action="{{ route('super.kelola-dapur.store') }}" method="POST" id="dapurForm">
    @csrf

        <div class="bg-white rounded-2xl border p-6 space-y-6">
            @if($errors->any())
                <div class="p-3 bg-red-50 text-red-600 rounded-lg text-sm">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            {{-- LEMBAGA --}}
            <div>
                <p class="section-title">Informasi Lembaga</p>
                <div class="space-y-4">
                    <input name="nama_lembaga" value="{{ old('nama_lembaga') }}" class="dapur-input" placeholder="Nama Lembaga *" required>
                    <textarea name="alamat" class="dapur-input" placeholder="Alamat *" required>{{ old('alamat') }}</textarea>
                    <div class="grid grid-cols-2 gap-4">
                        <input name="nama_yayasan" value="{{ old('nama_yayasan') }}" class="dapur-input" placeholder="Nama Yayasan">
                        <input name="ketua_yayasan" value="{{ old('ketua_yayasan') }}" class="dapur-input" placeholder="Ketua Yayasan">
                    </div>
                </div>
            </div>

            {{-- PENGELOLA --}}
            <div>
                <p class="section-title">Pengelola</p>
                <div class="grid grid-cols-2 gap-4">
                    <input name="nama_kepala_sppg" value="{{ old('nama_kepala_sppg') }}" class="dapur-input" placeholder="Kepala SPPG *" required>
                    <input name="nama_akuntan" value="{{ old('nama_akuntan') }}" class="dapur-input" placeholder="Akuntan">
                    <input name="nomor_rekening" value="{{ old('nomor_rekening') }}" class="dapur-input" placeholder="Nomor Rekening">
                    <input name="tempat_pelaporan" value="{{ old('tempat_pelaporan') }}" class="dapur-input" placeholder="Tempat Pelaporan">
                </div>
            </div>

            {{-- AKUN (WAJIB LOGIN) --}}
            <div>
                <p class="section-title">Akun Login</p>
                <div class="grid grid-cols-2 gap-4">
                    <input name="username" value="{{ old('username') }}" class="dapur-input" placeholder="Username *" required>
                    <input type="password" name="password" class="dapur-input" placeholder="Password (Min. 8 karakter) *" required>
                </div>
            </div>

            {{-- BUTTON --}}
            <div class="flex justify-end pt-4 border-t">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Simpan Data
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    document.getElementById('dapurForm').addEventListener('submit', function(e) {
        // Hapus baris di bawah ini jika Anda ingin form tetap berjalan normal
        // e.preventDefault(); 
        
        console.log('Form sedang dikirim...');
    });
</script>
@endsection