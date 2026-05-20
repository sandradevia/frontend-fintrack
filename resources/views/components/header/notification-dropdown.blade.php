{{-- resources/views/components/notification-dropdown.blade.php --}}
@php
use App\Models\Notification;

$user = auth()->user();

if (!$user) {

    $notifications = collect();
    $unreadCount = 0;

} else {

    // SUPER ADMIN → lihat semua notif
    if ($user->role === 'super_admin') {

        $notifications = Notification::latest()
            ->take(10)
            ->get();

        $unreadCount = Notification::where('is_read', false)
            ->count();

    }

    // ADMIN DAPUR → notif sesuai dapur
    else {

        $notifications = Notification::where('dapur_id', $user->dapur_id)
            ->latest()
            ->take(10)
            ->get();

        $unreadCount = Notification::where('dapur_id', $user->dapur_id)
            ->where('is_read', false)
            ->count();
    }
}
@endphp

<div x-data="{
        dropdownOpen: false,
        toggleDropdown() { this.dropdownOpen = !this.dropdownOpen },
        closeDropdown() { this.dropdownOpen = false },
        handleItemClick(id) {
            fetch('/notifications/read/' + id)
                .then(() => {
                    const badge = document.getElementById('notif-badge');
                    if(badge) badge.classList.add('hidden');
                });
            this.closeDropdown();
        }
    }"
    @click.away="closeDropdown()"
    class="relative"
>

    {{-- Notification Button --}}
    <button @click.stop="toggleDropdown()"
        class="relative flex items-center justify-center h-11 w-11 rounded-full border bg-white text-gray-500">
        🔔

        {{-- Badge --}}
        <span id="notif-badge"
            class="absolute top-0 right-0 h-2 w-2 bg-orange-400 rounded-full {{ $unreadCount == 0 ? 'hidden' : '' }}">
            <span class="absolute w-full h-full bg-orange-400 rounded-full animate-ping"></span>
        </span>
    </button>

    {{-- Dropdown --}}
    <div x-show="dropdownOpen" x-transition
        class="absolute right-0 mt-3 w-80 bg-white border rounded-xl shadow-lg z-50 max-h-96 overflow-y-auto"
        style="display: none;"
    >
        <div class="p-3 border-b font-semibold text-gray-800">Notifications</div>

        <ul>
            @forelse ($notifications as $notif)
                <li class="p-3 hover:bg-gray-100 cursor-pointer"
                    @click="handleItemClick({{ $notif->id }})">
                    <div class="font-semibold text-sm">{{ $notif->title }}</div>
                    <div class="text-xs text-gray-500">{{ $notif->message }}</div>
                    <div class="text-xs text-gray-400">{{ $notif->created_at->diffForHumans() }}</div>
                </li>
            @empty
                <li class="p-3 text-center text-gray-500">Tidak ada notifikasi</li>
            @endforelse
        </ul>

        <a href="{{ route('notifications.index') }}"
            class="block text-center text-blue-600 p-2 border-t hover:bg-gray-50">
            Lihat Semua Notifikasi
        </a>
    </div>
</div>

{{-- Realtime Echo (opsional) --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const dapurId = {{ auth()->user()->dapur_id ?? 0 }};
    if (!dapurId) return;

    window.Echo.private('dapur.' + dapurId)
        .listen('.notification.created', (e) => {
            console.log('🔔 Notif baru:', e.notification);

            // tampilkan badge
            const badge = document.getElementById('notif-badge');
            if (badge) badge.classList.remove('hidden');

            // reload dropdown sementara
            location.reload();
        });
});
</script>