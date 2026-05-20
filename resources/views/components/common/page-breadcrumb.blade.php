@props([
    'pageTitle' => 'Page',
    'parentTitle' => null,
    'parentUrl' => null
])

<div class="flex flex-col gap-2 mb-6">

    {{-- BREADCRUMB --}}
    <nav>
        <ol class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400">

            {{-- Home --}}
            <li>
                <a href="{{ url('/') }}" class="hover:text-blue-600 transition">
                    Home
                </a>
            </li>

            {{-- Parent (optional) --}}
            @if($parentTitle)
                <li>/</li>
                <li>
                    <a href="{{ $parentUrl ?? '#' }}" class="hover:text-blue-600 transition">
                        {{ $parentTitle }}
                    </a>
                </li>
            @endif

            {{-- Current Page --}}
            <li>/</li>
            <li class="text-gray-800 dark:text-white font-medium">
                {{ $pageTitle }}
            </li>

        </ol>
    </nav>

    {{-- TITLE --}}
    <h2 class="text-lg font-bold text-gray-800 dark:text-white">
        {{ $pageTitle }}
    </h2>

</div>