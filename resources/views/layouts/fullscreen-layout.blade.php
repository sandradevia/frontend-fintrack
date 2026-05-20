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

                // sidebar desktop/mobile
                this.$store.sidebar.isExpanded =
                    window.innerWidth >= 1280;

                const checkMobile = () => {

                    if (window.innerWidth < 1280) {

                        this.$store.sidebar.isExpanded = false;
                        this.$store.sidebar.isMobileOpen = false;

                    } else {

                        this.$store.sidebar.isExpanded = true;
                        this.$store.sidebar.isMobileOpen = false;
                    }
                };

                window.addEventListener('resize', checkMobile);
            }
        }
    }
</script>

{{-- PRELOADER --}}
<x-common.preloader />

<div class="flex min-h-screen overflow-hidden">

    {{-- SIDEBAR --}}
    @include('layouts.sidebar')

    {{-- MAIN CONTENT --}}
    <div
        class="flex-1 min-w-0 transition-all duration-300"
        :class="{
            'xl:ml-[260px]':
                $store.sidebar.isExpanded ||
                $store.sidebar.isHovered,

            'xl:ml-[78px]':
                !$store.sidebar.isExpanded &&
                !$store.sidebar.isHovered,

            'ml-0': window.innerWidth < 1280
        }"
    >

        {{-- HEADER --}}
        @include('layouts.app-header')

        {{-- PAGE CONTENT --}}
        <main class="p-4 md:p-6 max-w-[1600px] mx-auto">
            @yield('content')
        </main>

    </div>

</div>

{{-- MOBILE OVERLAY --}}
<div
    x-show="$store.sidebar.isMobileOpen"
    @click="$store.sidebar.toggleMobileOpen()"
    x-transition.opacity
    class="fixed inset-0 bg-black/40 z-40 xl:hidden"
>
</div>

{{-- Livewire --}}
@livewireScripts

@stack('scripts')

</body>
</html>