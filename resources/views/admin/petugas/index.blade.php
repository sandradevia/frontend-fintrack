@extends('layouts.app')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

    .petugas-wrap * {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .petugas-row:hover {
        background: #f0f7ff;
    }

    .badge {
        padding: .2rem .7rem;
        border-radius: 99px;
        font-size: .7rem;
        font-weight: 600;
    }
</style>

<div class="petugas-wrap space-y-6">

    {{-- HEADER --}}
    <x-common.page-breadcrumb pageTitle="Petugas" />

    <div class="flex justify-between items-center">
        <p class="text-xs text-gray-400">Manajemen data pengguna sistem</p>

        <button onclick="openModal()"
            class="px-5 py-2.5 bg-blue-600 text-white text-sm rounded-xl shadow hover:bg-blue-700">
            + Tambah Petugas
        </button>
    </div>

    {{-- STAT
    <div class="grid grid-cols-2 gap-4">
        <div class="bg-white p-5 rounded-xl border">
            <p class="text-xs text-gray-500">Total Petugas</p>
            <p class="text-2xl font-bold">{{ count($data) }}</p>
        </div>
        <div class="bg-white p-5 rounded-xl border">
            <p class="text-xs text-gray-500">Admin</p>
            <p class="text-2xl font-bold">
                {{ $data->where('role','admin')->count() }}
            </p>
        </div>
    </div> --}}

    {{-- TABLE --}}
    <div class="bg-white rounded-xl border overflow-hidden">

        {{-- <div class="px-6 py-4 border-b flex justify-between">
            <h2 class="font-bold text-sm">Daftar Petugas</h2>
            <span class="badge bg-blue-100 text-blue-700">
                {{ count($data) }} Data
            </span>
        </div> --}}

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="p-3 text-left">No</th>
                        <th class="p-3 text-left">Nama</th>
                        <th class="p-3 text-left">Jabatan</th>
                        <th class="p-3 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($petugas as $i => $item)
                    <tr class="petugas-row border-t">
                        <td class="p-3">{{ $i+1 }}</td>

                        <td class="p-3 font-semibold">
                            {{ $item->name }}
                        </td>

                        <td class="p-3">
                            {{ $item->jabatan }}
                        </td>


                        <td class="p-3 text-center space-x-2">

                            <button onclick="editModal({{ $item->id }}, '{{ $item->name }}', '{{ $item->username }}', '{{ $item->role }}')"
                                class="px-3 py-1 bg-amber-100 text-amber-700 rounded">
                                Edit
                            </button>

                            <form action="{{ route('petugas.destroy',$item->id) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button class="px-3 py-1 bg-red-100 text-red-600 rounded"
                                    onclick="return confirm('Hapus data?')">
                                    Hapus
                                </button>
                            </form>

                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-10 text-gray-400">
                            Belum ada data
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- MODAL --}}
<div id="modal" class="fixed inset-0 hidden bg-black/50 flex items-center justify-center">

    <div class="bg-white p-6 rounded-xl w-full max-w-md">

        <h2 id="modalTitle" class="font-bold mb-4">Tambah Petugas</h2>

        <form id="form" method="POST">
            @csrf
            <input type="hidden" name="_method" id="method">

            <div class="space-y-3">

                <input type="text" name="name" id="name"
                    placeholder="Nama"
                    class="w-full border p-2 rounded">

                <input type="text" name="username" id="username"
                    placeholder="Username"
                    class="w-full border p-2 rounded">

                <input type="password" name="password" id="password"
                    placeholder="Password"
                    class="w-full border p-2 rounded">

                <select name="role" id="role" class="w-full border p-2 rounded">
                    <option value="admin">Admin</option>
                    <option value="petugas">Petugas</option>
                </select>

            </div>

            <div class="mt-4 flex justify-end gap-2">
                <button type="button" onclick="closeModal()">Batal</button>
                <button class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
            </div>
        </form>

    </div>
</div>

<script>
function openModal() {
    document.getElementById('modal').classList.remove('hidden');

    document.getElementById('form').action = "{{ route('admin.petugas.store') }}";
    document.getElementById('method').value = 'POST';

    document.getElementById('form').reset();
}

function editModal(id, name, username, role) {
    document.getElementById('modal').classList.remove('hidden');
    document.getElementById('form').action = `/petugas/update/${id}`;
    document.getElementById('method').value = 'PUT';

    document.getElementById('name').value = name;
    document.getElementById('username').value = username;
    document.getElementById('role').value = role;
}

function closeModal() {
    document.getElementById('modal').classList.add('hidden');
}
</script>

@endsection