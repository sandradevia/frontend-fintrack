@php
    use App\Helpers\MenuHelper;
    $menuGroups = MenuHelper::getMenu();
    $currentRoute = request()->route()->getName();
@endphp

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

    #sidebar * { font-family: 'Plus Jakarta Sans', sans-serif; }

    /* ── Sidebar base ── */
    #sidebar {
        transition: width 0.26s cubic-bezier(.4,0,.2,1),
                    transform 0.26s cubic-bezier(.4,0,.2,1);
    }

    /* ── Scrollbar ── */
    #sidebar .sb-scroll::-webkit-scrollbar { width: 3px; }
    #sidebar .sb-scroll::-webkit-scrollbar-track { background: transparent; }
    #sidebar .sb-scroll::-webkit-scrollbar-thumb {
        background: rgba(148,163,184,.3);
        border-radius: 99px;
    }
    #sidebar .sb-scroll::-webkit-scrollbar-thumb:hover {
        background: rgba(148,163,184,.6);
    }

    /* ── Menu item base ── */
    .sb-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 9px 12px;
        border-radius: 12px;
        font-size: 0.82rem;
        font-weight: 500;
        width: 100%;
        transition: background .15s, color .15s, box-shadow .15s;
        white-space: nowrap;
        position: relative;
        cursor: pointer;
        border: none;
        background: transparent;
        text-align: left;
    }

    /* Inactive */
    .sb-item-off {
        color: #64748b;
    }
    .sb-item-off:hover {
        background: #f1f5f9;
        color: #1e293b;
    }
    .dark .sb-item-off { color: #94a3b8; }
    .dark .sb-item-off:hover { background: rgba(255,255,255,.06); color: #e2e8f0; }

    /* Active */
    .sb-item-on {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: #fff;
        box-shadow: 0 4px 12px rgba(59,130,246,.35);
    }
    .dark .sb-item-on {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        box-shadow: 0 4px 14px rgba(37,99,235,.4);
    }

    /* Active indicator dot */
    .sb-item-on::before {
        content: '';
        position: absolute;
        right: 10px;
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: rgba(255,255,255,.7);
    }

    /* Icon wrapper */
    .sb-icon {
        width: 20px;
        height: 20px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: color .15s;
    }
    .sb-item-off .sb-icon { color: #94a3b8; }
    .sb-item-off:hover .sb-icon { color: #475569; }
    .dark .sb-item-off .sb-icon { color: #64748b; }
    .dark .sb-item-off:hover .sb-icon { color: #cbd5e1; }
    .sb-item-on .sb-icon { color: rgba(255,255,255,.9); }

    /* Submenu item */
    .sb-sub-item {
        display: block;
        font-size: 0.795rem;
        padding: 7px 10px;
        border-radius: 9px;
        font-weight: 500;
        transition: background .13s, color .13s;
        white-space: nowrap;
    }
    .sb-sub-item-off {
        color: #64748b;
    }
    .sb-sub-item-off:hover {
        background: #f1f5f9;
        color: #1e293b;
    }
    .dark .sb-sub-item-off { color: #94a3b8; }
    .dark .sb-sub-item-off:hover { background: rgba(255,255,255,.06); color: #e2e8f0; }

    .sb-sub-item-on {
        background: #eff6ff;
        color: #2563eb;
        font-weight: 600;
    }
    .dark .sb-sub-item-on { background: rgba(37,99,235,.15); color: #93c5fd; }

    /* Group label */
    .sb-group-label {
        font-size: 0.65rem;
        font-weight: 700;
        letter-spacing: 0.09em;
        text-transform: uppercase;
        color: #cbd5e1;
        padding: 0 4px;
        margin-bottom: 6px;
    }
    .dark .sb-group-label { color: #475569; }

    /* Collapsed: icon-only tooltip */
    .sb-tooltip {
        position: absolute;
        left: calc(100% + 12px);
        top: 50%;
        transform: translateY(-50%);
        background: #1e293b;
        color: #f8fafc;
        font-size: 0.75rem;
        font-weight: 600;
        padding: 5px 10px;
        border-radius: 8px;
        white-space: nowrap;
        pointer-events: none;
        opacity: 0;
        transition: opacity .15s;
        z-index: 100;
        box-shadow: 0 4px 12px rgba(0,0,0,.2);
    }
    .sb-tooltip::before {
        content: '';
        position: absolute;
        right: 100%;
        top: 50%;
        transform: translateY(-50%);
        border: 5px solid transparent;
        border-right-color: #1e293b;
    }
    .sb-item:hover .sb-tooltip { opacity: 1; }

    /* Logo area */
    .sb-logo-wrap {
        padding: 20px 12px 16px;
        border-bottom: 1px solid #f1f5f9;
        margin-bottom: 4px;
        flex-shrink: 0;
    }
    .dark .sb-logo-wrap { border-color: rgba(255,255,255,.06); }

    /* Divider between groups */
    .sb-group + .sb-group { margin-top: 20px; }

    /* Arrow chevron */
    .sb-arrow {
        margin-left: auto;
        flex-shrink: 0;
        width: 14px;
        height: 14px;
        transition: transform .2s;
    }
    .sb-arrow-open { transform: rotate(180deg); }

    /* Submenu connector */
    .sb-submenu-wrap {
        margin-top: 4px;
        margin-left: 15px;
        padding-left: 14px;
        border-left: 1.5px solid #e2e8f0;
        overflow: hidden;
    }
    .dark .sb-submenu-wrap { border-color: rgba(255,255,255,.08); }

    /* collapsed icon centering */
    .sb-collapsed .sb-item {
        justify-content: center;
        padding: 10px;
    }
</style>

<aside id="sidebar"
    class="fixed flex flex-col top-0 left-0 bg-white dark:bg-gray-950 border-r border-slate-100 dark:border-white/[.06] h-screen z-50 shadow-sm"
    x-data="{
        openSubmenus: {},
        init() { this.initializeActiveMenus(); },
        initializeActiveMenus() {
            const currentRoute = '{{ $currentRoute }}';
            @foreach ($menuGroups as $groupIndex => $menuGroup)
                @foreach ($menuGroup['items'] as $itemIndex => $item)
                    @if (isset($item['subItems']))
                        @foreach ($item['subItems'] as $subItem)
                            if (currentRoute === '{{ $subItem['route'] ?? '' }}') {
                                this.openSubmenus['{{ $groupIndex }}-{{ $itemIndex }}'] = true;
                            }
                        @endforeach
                    @endif
                @endforeach
            @endforeach
        },
        toggleSubmenu(g, i) {
            const key = g + '-' + i;
            const next = !this.openSubmenus[key];
            if (next) this.openSubmenus = {};
            this.openSubmenus[key] = next;
        },
        isSubmenuOpen(g, i) { return this.openSubmenus[g + '-' + i] || false; },
        isActive(route) { return route === '{{ $currentRoute }}'; },
        get isOpen() {
            return this.$store.sidebar.isExpanded || this.$store.sidebar.isMobileOpen || this.$store.sidebar.isHovered;
        }
    }"
    :class="{
        'w-[256px]':  $store.sidebar.isExpanded || $store.sidebar.isMobileOpen || $store.sidebar.isHovered,
        'w-[72px]':  !$store.sidebar.isExpanded && !$store.sidebar.isHovered && !$store.sidebar.isMobileOpen,
        'translate-x-0':      $store.sidebar.isMobileOpen,
        '-translate-x-full xl:translate-x-0': !$store.sidebar.isMobileOpen
    }"
    @mouseenter="if (!$store.sidebar.isExpanded) $store.sidebar.setHovered(true)"
    @mouseleave="$store.sidebar.setHovered(false)"
>

    {{-- ── LOGO ── --}}
    <div class="sb-logo-wrap flex items-center"
        :class="isOpen ? 'justify-start' : 'justify-center'">
        <a href="/" class="flex items-center gap-2.5 min-w-0">
            <img src="{{ asset('images/logo/kapuazz.png') }}"
                class="h-9 w-auto object-contain flex-shrink-0 transition-all duration-300">
            <span x-show="isOpen" x-transition:enter="transition-opacity duration-200"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                class="font-bold text-sm text-slate-800 dark:text-slate-100 tracking-tight truncate">
                KAPUAZ
            </span>
        </a>
    </div>
    {{-- ── MENU ── --}}
    <div class="flex-1 overflow-y-auto sb-scroll px-3 py-3">
        
        <nav class="flex flex-col gap-0">

            @foreach ($menuGroups as $groupIndex => $menuGroup)
            <div class="sb-group">

                {{-- Group label --}}
                <div x-show="isOpen" x-transition class="sb-group-label mb-2 mt-1">
                    {{ $menuGroup['title'] }}
                </div>
                <div x-show="!isOpen" class="w-full flex justify-center mb-2">
                    <div class="h-px w-8 bg-slate-200 dark:bg-white/10"></div>
                </div>

                {{-- Items --}}
                <ul class="flex flex-col gap-0.5">
                    @foreach ($menuGroup['items'] as $itemIndex => $item)
                    <li>

                        @if (isset($item['subItems']))
                        {{-- WITH SUBMENU --}}
                        <button
                            @click="toggleSubmenu({{ $groupIndex }}, {{ $itemIndex }})"
                            class="sb-item"
                            :class="isSubmenuOpen({{ $groupIndex }}, {{ $itemIndex }}) ? 'sb-item-on' : 'sb-item-off'">

                            <span class="sb-icon">
                                {!! MenuHelper::getIconSvg($item['icon']) !!}
                            </span>

                            <span x-show="isOpen" class="flex-1 text-left">
                                {{ $item['name'] }}
                            </span>

                            <svg x-show="isOpen"
                                class="sb-arrow"
                                :class="{ 'sb-arrow-open': isSubmenuOpen({{ $groupIndex }}, {{ $itemIndex }}) }"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                            </svg>

                            {{-- Tooltip (collapsed only) --}}
                            <span x-show="!isOpen" class="sb-tooltip">{{ $item['name'] }}</span>
                        </button>

                        {{-- Submenu --}}
                        <div x-show="isSubmenuOpen({{ $groupIndex }}, {{ $itemIndex }}) && isOpen"
                            x-transition:enter="transition ease-out duration-150"
                            x-transition:enter-start="opacity-0 -translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            class="sb-submenu-wrap">
                            <ul class="py-1 flex flex-col gap-0.5">
                                @foreach ($item['subItems'] as $subItem)
                                <li>
                                    <a href="{{ route($subItem['route']) }}"
                                        class="sb-sub-item"
                                        :class="isActive('{{ $subItem['route'] }}') ? 'sb-sub-item-on' : 'sb-sub-item-off'">
                                        <span class="flex items-center gap-2">
                                            <span class="w-1.5 h-1.5 rounded-full flex-shrink-0 transition-colors"
                                                :class="isActive('{{ $subItem['route'] }}') ? 'bg-blue-500' : 'bg-slate-300 dark:bg-slate-600'">
                                            </span>
                                            {{ $subItem['name'] }}
                                        </span>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>

                        @else
                        {{-- SINGLE ITEM --}}
                        <a href="{{ route($item['route']) }}"
                            class="sb-item"
                            :class="isActive('{{ $item['route'] }}') ? 'sb-item-on' : 'sb-item-off'">

                            <span class="sb-icon">
                                {!! MenuHelper::getIconSvg($item['icon']) !!}
                            </span>

                            <span x-show="isOpen" class="flex-1 truncate">
                                {{ $item['name'] }}
                            </span>

                            {{-- Tooltip (collapsed only) --}}
                            <span x-show="!isOpen" class="sb-tooltip">{{ $item['name'] }}</span>
                        </a>
                        @endif

                    </li>
                    @endforeach
                </ul>
            </div>
            @endforeach

        </nav>
    </div>

    {{-- ── FOOTER USER AREA ── --}}
    <div class="border-t border-slate-100 dark:border-white/[.06] px-3 py-3 flex-shrink-0">
        <div class="sb-item sb-item-off" style="cursor:default;">
            <div class="sb-icon">
                <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                </div>
            </div>
            <div x-show="isOpen" class="min-w-0">
                <p class="text-xs font-semibold text-slate-700 dark:text-slate-200 truncate">
                    {{ auth()->user()->name ?? 'User' }}
                </p>
                <p class="text-[10px] text-slate-400 truncate">
                    {{ auth()->user()->email ?? '' }}
                </p>
            </div>
        </div>
    </div>

</aside>

{{-- ── MOBILE OVERLAY ── --}}
<div x-show="$store.sidebar.isMobileOpen"
    x-transition:enter="transition-opacity duration-200"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition-opacity duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    @click="$store.sidebar.setMobileOpen(false)"
    class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-40 xl:hidden">
</div>