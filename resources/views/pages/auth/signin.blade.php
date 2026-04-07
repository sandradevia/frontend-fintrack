@extends('layouts.fullscreen-layout')

@section('content')
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .animate-fade-up { animation: fadeInUp 0.8s ease-out forwards; }

    [x-cloak] { display: none !important; }
</style>

<div x-data="loginFlow()" x-cloak class="relative z-1 bg-white p-6 sm:p-0 dark:bg-gray-900 overflow-hidden">
    <div class="relative flex h-screen w-full flex-col justify-center sm:p-0 lg:flex-row dark:bg-gray-900">

        <!-- LEFT -->
        <div class="flex w-full flex-1 flex-col lg:w-1/2">

            <!-- BACK -->
            <div class="mx-auto w-full max-w-md pt-10">
                <a href="/"
                    class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700">
                    ← Kembali
                </a>
            </div>

            <!-- 🔥 LOGIN -->
            <div x-show="step === 'login'"
                x-transition:enter="transition ease-out duration-500"
                x-transition:enter-start="opacity-0 -translate-x-10"
                x-transition:enter-end="opacity-100 translate-x-0"
                x-transition:leave="transition ease-in duration-400"
                x-transition:leave-end="opacity-0 -translate-x-10"
                class="mx-auto flex w-full max-w-md flex-1 flex-col justify-center">

                <div class="mb-6">
                    <h1 class="text-xl font-semibold">Masuk</h1>
                    <p class="text-sm text-gray-500">
                        Masuk untuk mengelola data keuangan
                    </p>
                </div>

                <form @submit.prevent="handleLogin()" class="space-y-5">

                    <!-- Username -->
                    <div>
                        <label class="text-sm">Username</label>
                        <input type="text" x-model="form.username"
                            class="w-full border rounded-lg px-4 py-2">
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="text-sm">Password</label>
                        <input type="password" x-model="form.password"
                            class="w-full border rounded-lg px-4 py-2">
                    </div>

                    <button type="submit"
                        class="w-full bg-brand-500 text-white py-2.5 rounded-lg">
                        Masuk
                    </button>
                </form>
            </div>

            <!-- 🔥 PILIH DAPUR -->
            <div x-show="step === 'dapur'"
                x-transition:enter="transition ease-out duration-500"
                x-transition:enter-start="opacity-0 translate-x-10"
                x-transition:enter-end="opacity-100 translate-x-0"
                class="mx-auto flex w-full max-w-md flex-1 flex-col justify-center">

                <div class="text-center mb-6">
                    <h2 class="text-xl font-semibold">Pilih Dapur</h2>
                    <p class="text-sm text-gray-500">
                        Pilih dapur untuk melanjutkan
                    </p>
                </div>

                <div class="space-y-3">

                    <div @click="selectDapur('Dapur 1')"
                        class="p-4 border rounded-xl hover:shadow cursor-pointer transition">
                        <h3 class="font-semibold">Dapur 1</h3>
                        <p class="text-sm text-gray-500">Kecamatan A</p>
                    </div>

                    <div @click="selectDapur('Dapur 2')"
                        class="p-4 border rounded-xl hover:shadow cursor-pointer transition">
                        <h3 class="font-semibold">Dapur 2</h3>
                        <p class="text-sm text-gray-500">Kecamatan B</p>
                    </div>

                    <div @click="selectDapur('Dapur 3')"
                        class="p-4 border rounded-xl hover:shadow cursor-pointer transition">
                        <h3 class="font-semibold">Dapur 3</h3>
                        <p class="text-sm text-gray-500">Kecamatan C</p>
                    </div>

                </div>

                <button @click="step='login'"
                    class="mt-6 text-sm text-gray-500 hover:underline">
                    ← Kembali ke login
                </button>
            </div>

        </div>

        <!-- RIGHT -->
        <div class="hidden lg:flex w-1/2 items-center justify-center bg-gray-900 text-white">
            <div class="text-center max-w-xs">
                <img src="/images/logo/kapuaz.png" class="mx-auto mb-4" />
                <p class="text-gray-400">
                    Aplikasi Pelaporan Keuangan Gizi
                </p>
            </div>
        </div>

    </div>
</div>

<script>
function loginFlow() {
    return {
        step: 'login',
        isSuperAdmin: true, 

        form: {
            username: '',
            password: ''
        },

        handleLogin() {
            // simulasi login sukses

            if (this.isSuperAdmin) {
                this.step = 'dapur';
            } else {
                window.location.href = '/dashboard';
            }
        },

        selectDapur(nama) {
            console.log('Pilih:', nama);
            window.location.href = '/admin/dashboard';
        }
    }
}
</script>
@endsection