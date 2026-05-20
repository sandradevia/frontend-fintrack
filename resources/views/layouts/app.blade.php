<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Dashboard' }} | KAPUAZ</title>

    {{-- Livewire --}}
    @livewireStyles

    {{-- Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- SweetAlert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Font Awesome --}}
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        crossorigin="anonymous"
        referrerpolicy="no-referrer" />

    {{-- Prevent Flash Dark Mode --}}
    <script>
        (function () {

            const saved = localStorage.getItem('theme');

            const system =
                window.matchMedia('(prefers-color-scheme: dark)').matches
                    ? 'dark'
                    : 'light';

            const theme = saved || system;

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

                // init theme
                this.$store.theme.init();

                // init sidebar
                this.$store.sidebar.init();

                // default sidebar desktop
                this.$store.sidebar.isExpanded =
                    window.innerWidth >= 1280;
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

            'xl:ml-[256px]':
                $store.sidebar.isExpanded ||
                $store.sidebar.isHovered,

            'xl:ml-[72px]':
                !$store.sidebar.isExpanded &&
                !$store.sidebar.isHovered
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
    @click="$store.sidebar.closeMobile()"
    x-transition.opacity
    class="fixed inset-0 z-40 bg-black/40 xl:hidden"
>
</div>

{{-- Livewire --}}
@livewireScripts

{{-- Stack Scripts --}}
@stack('scripts')

</body>
</html>