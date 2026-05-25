<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Dashboard' }} | KAPUAZ - Aplikasi Pelaporan Keuangan Gizi</title>

    {{-- Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Livewire --}}
    @livewireStyles

    {{-- Apply dark mode immediately --}}
    <script>
        (function () {

            const savedTheme = localStorage.getItem('theme');

            const systemTheme =
                window.matchMedia('(prefers-color-scheme: dark)').matches
                    ? 'dark'
                    : 'light';

            const theme = savedTheme || systemTheme;

            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }

        })();
    </script>
</head>

<body
    x-data="layout()"
    x-init="init()"
    class="h-full antialiased bg-gray-50 dark:bg-gray-900"
>

<script>
    function layout() {

        return {

            init() {

                this.$store.theme.init();
            }
        }
    }
</script>

{{-- PRELOADER --}}
<x-common.preloader />

{{-- FULLSCREEN CONTENT --}}
<div class="min-h-screen">

    <main class="w-full">
        @yield('content')
    </main>

</div>

{{-- Livewire --}}
@livewireScripts

@stack('scripts')

</body>
</html>