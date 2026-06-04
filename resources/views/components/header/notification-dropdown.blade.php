{{-- resources/views/components/notification-dropdown.blade.php --}}

@php

use App\Models\Notification;
use App\Models\Dapur;

$user = auth()->user();

if (!$user) {

    $notifications = collect();
    $unreadCount = 0;
    $dapurId = 0;

} else {

    // SUPER ADMIN
    if ($user->role === 'super_admin') {

        $notifications = Notification::latest()
            ->take(10)
            ->get();

        $unreadCount = Notification::where('is_read', false)
            ->count();

        $dapurId = 0;

    }

    // ADMIN DAPUR
    else {

        $dapurId = $user->dapur_id ?? 0;

        $notifications = Notification::where('dapur_id', $dapurId)
            ->latest()
            ->take(10)
            ->get();

        $unreadCount = Notification::where('dapur_id', $dapurId)
            ->where('is_read', false)
            ->count();
    }
}

@endphp

<div
    x-data="{
        dropdownOpen: false,

        toggleDropdown() {
            this.dropdownOpen = !this.dropdownOpen
        },

        closeDropdown() {
            this.dropdownOpen = false
        },

        handleItemClick(id) {

            fetch('/notifications/read/' + id)
                .then(() => {

                    const badge = document.getElementById('notif-badge');

                    if (badge) {
                        badge.classList.add('hidden');
                    }
                });

            this.closeDropdown();
        }
    }"
    @click.away="closeDropdown()"
    class="relative"
>

    {{-- BUTTON --}}
    <button
        @click.stop="toggleDropdown()"
        class="relative flex items-center justify-center h-11 w-11 rounded-2xl border border-gray-200 bg-white shadow-sm hover:bg-gray-50 hover:shadow-md transition-all duration-200 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700"
    >

        <i class="fa-regular fa-bell text-gray-600 dark:text-gray-200 text-lg"></i>

        {{-- BADGE --}}
        @if($unreadCount > 0)
            <span
                id="notif-badge"
                class="absolute -top-1 -right-1 min-w-[20px] h-5 px-1.5 flex items-center justify-center rounded-full bg-red-500 text-white text-[10px] font-bold shadow"
            >
                {{ $unreadCount > 9 ? '9+' : $unreadCount }}
            </span>
        @endif

    </button>

    {{-- DROPDOWN --}}
    <div
        x-show="dropdownOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95 translate-y-1"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 scale-95 translate-y-1"
        class="absolute right-0 mt-3 w-[370px] bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-3xl shadow-2xl z-50 overflow-hidden"
        style="display: none;"
    >

        {{-- HEADER --}}
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 dark:border-gray-700">

            <div>
                <h3 class="text-sm font-semibold text-gray-800 dark:text-white">
                    Notifications
                </h3>

                <p class="text-xs text-gray-500 dark:text-gray-400">
                    {{ $unreadCount }} unread notification
                </p>
            </div>

            <div class="h-10 w-10 rounded-2xl bg-blue-50 flex items-center justify-center dark:bg-blue-900/30">
                <i class="fa-regular fa-bell text-blue-600 dark:text-blue-400"></i>
            </div>

        </div>

        {{-- LIST --}}
        <div class="max-h-[400px] overflow-y-auto">

            @forelse ($notifications as $notif)

                <div
                    @click="handleItemClick({{ $notif->id }})"
                    class="group px-5 py-4 border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/40 transition-all duration-200 cursor-pointer"
                >

                    <div class="flex items-start gap-3">

                        {{-- ICON --}}
                        <div class="flex-shrink-0 h-11 w-11 rounded-2xl bg-orange-100 dark:bg-orange-900/30 flex items-center justify-center">

                            <i class="fa-solid fa-bell text-orange-500"></i>

                        </div>

                        {{-- CONTENT --}}
                        <div class="flex-1 min-w-0">

                            <div class="flex items-start justify-between gap-2">

                                <h4 class="text-sm font-semibold text-gray-800 dark:text-white leading-5">
                                    {{ $notif->title }}
                                </h4>

                                @if(!$notif->is_read)
                                    <span class="mt-1 h-2 w-2 rounded-full bg-blue-500 flex-shrink-0"></span>
                                @endif

                            </div>

                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400 leading-5 line-clamp-2">
                                {{ $notif->message }}
                            </p>

                            <div class="mt-2 flex items-center gap-2 text-[11px] text-gray-400 dark:text-gray-500">

                                <i class="fa-regular fa-clock"></i>

                                <span>
                                    {{ $notif->created_at->diffForHumans() }}
                                </span>

                            </div>

                        </div>

                    </div>

                </div>

            @empty

                <div class="flex flex-col items-center justify-center py-14 px-6">

                    <div class="h-20 w-20 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center mb-4">

                        <i class="fa-regular fa-bell-slash text-3xl text-gray-400"></i>

                    </div>

                    <h3 class="text-sm font-semibold text-gray-700 dark:text-white">
                        Tidak ada notifikasi
                    </h3>

                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 text-center">
                        Semua notifikasi terbaru akan muncul di sini
                    </p>

                </div>

            @endforelse

        </div>

        {{-- FOOTER --}}
        {{-- <div class="p-3 border-t border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">

            <a
                href="{{ route('notifications.index') }}"
                class="flex items-center justify-center gap-2 w-full py-3 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium transition-all duration-200"
            >

                <i class="fa-solid fa-eye"></i>

                <span>Lihat Semua Notifikasi</span>

            </a>

        </div> --}}

    </div>

</div>

{{-- REALTIME --}}
<script>

document.addEventListener('DOMContentLoaded', function () {

    @if(auth()->check())

        @if(auth()->user()->role === 'super_admin')

            window.Echo.channel('superadmin.notifications')
                .listen('.notification.created', (e) => {

                    console.log('🔔 Super Admin:', e.notification);

                    location.reload();
                });

        @else

            const dapurId = {{ $dapurId }};

            if (dapurId) {

                window.Echo.private('dapur.' + dapurId)
                    .listen('.notification.created', (e) => {

                        console.log('🔔 Admin Dapur:', e.notification);

                        location.reload();
                    });
            }

        @endif

    @endif

});

</script>