@php
    $ordersActive =
        request()->routeIs('admin.orders.index')
        || request()->routeIs('admin.orders.show')
        || request()->routeIs('admin.orders.update-status');

    $historyActive =
        request()->routeIs('admin.orders.history');
@endphp

<script>
    window.orderNotificationNav = function (config) {
        return {
            open: false,
            unreadCount: 0,
            latestOrder: null,
            showToast: false,
            loadingNotification: false,
            poller: null,
            toastTimer: null,
            audioContext: null,
            audioUnlocked: false,
            lastNotifiedOrderId: 0,
            storageKey: 'maloppo_last_notified_order_id',

            async init() {
                this.lastNotifiedOrderId = this.getStoredOrderId();

                this.prepareNotificationSound();

                await this.checkNotifications(true);

                this.poller = window.setInterval(() => {
                    this.checkNotifications(false);
                }, 15000);

                window.addEventListener('focus', () => {
                    this.checkNotifications(false);
                });

                document.addEventListener('visibilitychange', () => {
                    if (!document.hidden) {
                        this.checkNotifications(false);
                    }
                });
            },

            getStoredOrderId() {
                try {
                    return Number(
                        window.localStorage.getItem(this.storageKey) || 0
                    );
                } catch (error) {
                    return 0;
                }
            },

            saveStoredOrderId(orderId) {
                this.lastNotifiedOrderId = Number(orderId || 0);

                try {
                    window.localStorage.setItem(
                        this.storageKey,
                        String(this.lastNotifiedOrderId)
                    );
                } catch (error) {
                    //
                }
            },

            prepareNotificationSound() {
                const unlockAudio = () => {
                    try {
                        const AudioContextClass =
                            window.AudioContext
                            || window.webkitAudioContext;

                        if (!AudioContextClass) {
                            return;
                        }

                        if (!this.audioContext) {
                            this.audioContext = new AudioContextClass();
                        }

                        if (this.audioContext.state === 'suspended') {
                            this.audioContext.resume();
                        }

                        this.audioUnlocked = true;
                    } catch (error) {
                        this.audioUnlocked = false;
                    }
                };

                document.addEventListener('click', unlockAudio, {
                    once: true,
                });

                document.addEventListener('keydown', unlockAudio, {
                    once: true,
                });

                document.addEventListener('touchstart', unlockAudio, {
                    once: true,
                });
            },

            playNotificationSound() {
                if (!this.audioUnlocked || !this.audioContext) {
                    return;
                }

                try {
                    if (this.audioContext.state === 'suspended') {
                        this.audioContext.resume();
                    }

                    const startTime = this.audioContext.currentTime;

                    const oscillator =
                        this.audioContext.createOscillator();

                    const gain =
                        this.audioContext.createGain();

                    oscillator.type = 'sine';

                    oscillator.frequency.setValueAtTime(
                        880,
                        startTime
                    );

                    oscillator.frequency.setValueAtTime(
                        1050,
                        startTime + 0.16
                    );

                    gain.gain.setValueAtTime(
                        0.0001,
                        startTime
                    );

                    gain.gain.exponentialRampToValueAtTime(
                        0.12,
                        startTime + 0.02
                    );

                    gain.gain.exponentialRampToValueAtTime(
                        0.0001,
                        startTime + 0.35
                    );

                    oscillator.connect(gain);

                    gain.connect(
                        this.audioContext.destination
                    );

                    oscillator.start(startTime);
                    oscillator.stop(startTime + 0.36);
                } catch (error) {
                    //
                }
            },

            async checkNotifications(initialLoad = false) {
                if (this.loadingNotification) {
                    return;
                }

                this.loadingNotification = true;

                try {
                    const response = await fetch(config.endpoint, {
                        method: 'GET',
                        credentials: 'same-origin',
                        cache: 'no-store',
                        headers: {
                            Accept: 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                    });

                    if (!response.ok) {
                        return;
                    }

                    const data = await response.json();

                    this.unreadCount = Number(
                        data.unread_count || 0
                    );

                    this.latestOrder =
                        data.latest_order || null;

                    const latestOrderId = Number(
                        this.latestOrder?.id || 0
                    );

                    if (!latestOrderId) {
                        return;
                    }

                    const firstUnreadOrder =
                        this.lastNotifiedOrderId === 0
                        && this.unreadCount > 0;

                    const newOrder =
                        latestOrderId > this.lastNotifiedOrderId;

                    if (firstUnreadOrder || newOrder) {
                        this.openNotificationToast();

                        if (!initialLoad || this.audioUnlocked) {
                            this.playNotificationSound();
                        }

                        this.saveStoredOrderId(latestOrderId);
                    }
                } catch (error) {
                    console.warn(
                        'Notifikasi pesanan belum dapat diperiksa.',
                        error
                    );
                } finally {
                    this.loadingNotification = false;
                }
            },

            openNotificationToast() {
                this.showToast = true;

                if (this.toastTimer) {
                    window.clearTimeout(this.toastTimer);
                }

                this.toastTimer = window.setTimeout(() => {
                    this.showToast = false;
                }, 8000);
            },

            closeNotificationToast() {
                this.showToast = false;

                if (this.toastTimer) {
                    window.clearTimeout(this.toastTimer);
                }
            },

            badgeText() {
                return this.unreadCount > 99
                    ? '99+'
                    : String(this.unreadCount);
            },

            notificationUrl() {
                return this.latestOrder?.url
                    || config.ordersUrl;
            },
        };
    };
</script>

<nav
    x-data="orderNotificationNav({
        endpoint: @js(route('admin.orders.notifications.summary')),
        ordersUrl: @js(route('admin.orders.index'))
    })"
    x-init="init()"
    x-on:keydown.escape.window="
        open = false;
        closeNotificationToast();
    "
    class="sticky top-0 z-50 border-b border-gray-200 bg-white"
>
    <div class="maloppo-brand-line"></div>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="flex h-16 items-center justify-between">

            {{-- Bagian kiri --}}
            <div class="flex min-w-0 items-center">

                {{-- Logo --}}
                <a
                    href="{{ route('dashboard') }}"
                    class="flex shrink-0 items-center gap-3"
                >
                    <div
                        class="flex h-10 w-16 items-center justify-center overflow-hidden rounded-lg border border-gray-200 bg-white"
                    >
                        <img
                            src="{{ asset('images/brand/logo-maloppo-wordmark.jpg') }}"
                            alt="UMKM Maloppo"
                            class="h-full w-full object-contain"
                        >
                    </div>

                    <div class="hidden sm:block">
                        <p class="text-sm font-bold text-gray-900">
                            Maloppo
                        </p>

                        <p class="text-xs text-gray-500">
                            Admin
                        </p>
                    </div>
                </a>

                {{-- Menu desktop --}}
                <div class="ml-8 hidden items-center gap-1 lg:flex">

                    <a
                        href="{{ route('dashboard') }}"
                        class="rounded-lg px-3 py-2 text-sm font-medium transition
                            {{ request()->routeIs('dashboard')
                                ? 'bg-red-50 text-red-700'
                                : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
                    >
                        Dashboard
                    </a>

                    <a
                        href="{{ route('admin.products.index') }}"
                        class="rounded-lg px-3 py-2 text-sm font-medium transition
                            {{ request()->routeIs('admin.products.*')
                                ? 'bg-red-50 text-red-700'
                                : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
                    >
                        Produk
                    </a>

                    <a
                        href="{{ route('admin.posts.index') }}"
                        class="rounded-lg px-3 py-2 text-sm font-medium transition
                            {{ request()->routeIs('admin.posts.*')
                                ? 'bg-red-50 text-red-700'
                                : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
                    >
                        Kegiatan
                    </a>

                    <a
                        href="{{ route('admin.orders.index') }}"
                        class="inline-flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium transition
                            {{ $ordersActive
                                ? 'bg-red-50 text-red-700'
                                : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
                    >
                        <span>
                            Pesanan
                        </span>

                        <span
                            x-show="unreadCount > 0"
                            x-cloak
                            x-text="badgeText()"
                            class="inline-flex h-5 min-w-5 items-center justify-center rounded-full bg-red-600 px-1 text-[10px] font-bold text-white"
                        ></span>
                    </a>

                    <a
                        href="{{ route('admin.orders.history') }}"
                        class="rounded-lg px-3 py-2 text-sm font-medium transition
                            {{ $historyActive
                                ? 'bg-red-50 text-red-700'
                                : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
                    >
                        Riwayat
                    </a>

                </div>

            </div>

            {{-- Bagian kanan desktop --}}
            <div class="hidden items-center gap-2 lg:flex">

                {{-- Notifikasi --}}
                <a
                    href="{{ route('admin.orders.index') }}"
                    class="relative inline-flex h-10 w-10 items-center justify-center rounded-lg text-gray-500 transition hover:bg-gray-100 hover:text-gray-900"
                    :title="unreadCount > 0
                        ? unreadCount + ' pesanan belum dibaca'
                        : 'Tidak ada pesanan baru'"
                    aria-label="Notifikasi pesanan"
                >
                    <svg
                        class="h-5 w-5"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.08 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"
                        />
                    </svg>

                    <span
                        x-show="unreadCount > 0"
                        x-cloak
                        x-text="badgeText()"
                        class="absolute -right-1 -top-1 inline-flex h-5 min-w-5 items-center justify-center rounded-full border-2 border-white bg-red-600 px-1 text-[9px] font-bold text-white"
                    ></span>
                </a>

                {{-- Lihat website --}}
                <a
                    href="{{ route('home') }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50"
                >
                    Lihat Website
                </a>

                {{-- Akun --}}
                <x-dropdown align="right" width="48">

                    <x-slot name="trigger">

                        <button
                            type="button"
                            class="inline-flex items-center gap-2 rounded-lg px-2 py-1.5 text-left transition hover:bg-gray-100"
                        >
                            <div
                                class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-red-700 text-xs font-bold text-white"
                            >
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>

                            <div class="hidden xl:block">
                                <p class="max-w-32 truncate text-sm font-medium text-gray-800">
                                    {{ Auth::user()->name }}
                                </p>
                            </div>

                            <svg
                                class="h-4 w-4 text-gray-400"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                        </button>

                    </x-slot>

                    <x-slot name="content">

                        <div class="border-b border-gray-100 px-4 py-3">
                            <p class="truncate text-sm font-medium text-gray-800">
                                {{ Auth::user()->name }}
                            </p>

                            <p class="mt-1 truncate text-xs text-gray-500">
                                {{ Auth::user()->email }}
                            </p>
                        </div>

                        <a
                            href="{{ route('profile.edit') }}"
                            class="block px-4 py-2.5 text-sm text-gray-700 transition hover:bg-gray-50"
                        >
                            Profil Akun
                        </a>

                        <form
                            method="POST"
                            action="{{ route('logout') }}"
                        >
                            @csrf

                            <button
                                type="submit"
                                class="block w-full px-4 py-2.5 text-left text-sm text-red-700 transition hover:bg-red-50"
                            >
                                Keluar
                            </button>
                        </form>

                    </x-slot>

                </x-dropdown>

            </div>

            {{-- Bagian kanan HP --}}
            <div class="flex items-center gap-1 lg:hidden">

                <a
                    href="{{ route('admin.orders.index') }}"
                    class="relative inline-flex h-10 w-10 items-center justify-center rounded-lg text-gray-600 transition hover:bg-gray-100"
                    aria-label="Notifikasi pesanan"
                >
                    <svg
                        class="h-5 w-5"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.08 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"
                        />
                    </svg>

                    <span
                        x-show="unreadCount > 0"
                        x-cloak
                        x-text="badgeText()"
                        class="absolute -right-1 -top-1 inline-flex h-5 min-w-5 items-center justify-center rounded-full border-2 border-white bg-red-600 px-1 text-[9px] font-bold text-white"
                    ></span>
                </a>

                <button
                    type="button"
                    @click="open = !open"
                    class="inline-flex h-10 w-10 items-center justify-center rounded-lg text-gray-600 transition hover:bg-gray-100"
                    aria-label="Buka menu"
                >
                    <svg
                        x-show="!open"
                        class="h-6 w-6"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M4 6h16M4 12h16M4 18h16"
                        />
                    </svg>

                    <svg
                        x-show="open"
                        x-cloak
                        class="h-6 w-6"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M6 18L18 6M6 6l12 12"
                        />
                    </svg>
                </button>

            </div>

        </div>

    </div>

    {{-- Menu HP --}}
    <div
        x-show="open"
        x-cloak
        x-transition
        class="border-t border-gray-200 bg-white lg:hidden"
    >
        <div class="space-y-1 px-4 py-3">

            <a
                href="{{ route('dashboard') }}"
                class="block rounded-lg px-3 py-2.5 text-sm font-medium
                    {{ request()->routeIs('dashboard')
                        ? 'bg-red-50 text-red-700'
                        : 'text-gray-700 hover:bg-gray-50' }}"
            >
                Dashboard
            </a>

            <a
                href="{{ route('admin.products.index') }}"
                class="block rounded-lg px-3 py-2.5 text-sm font-medium
                    {{ request()->routeIs('admin.products.*')
                        ? 'bg-red-50 text-red-700'
                        : 'text-gray-700 hover:bg-gray-50' }}"
            >
                Produk
            </a>

            <a
                href="{{ route('admin.posts.index') }}"
                class="block rounded-lg px-3 py-2.5 text-sm font-medium
                    {{ request()->routeIs('admin.posts.*')
                        ? 'bg-red-50 text-red-700'
                        : 'text-gray-700 hover:bg-gray-50' }}"
            >
                Kegiatan
            </a>

            <a
                href="{{ route('admin.orders.index') }}"
                class="flex items-center justify-between rounded-lg px-3 py-2.5 text-sm font-medium
                    {{ $ordersActive
                        ? 'bg-red-50 text-red-700'
                        : 'text-gray-700 hover:bg-gray-50' }}"
            >
                <span>
                    Pesanan
                </span>

                <span
                    x-show="unreadCount > 0"
                    x-cloak
                    x-text="badgeText()"
                    class="inline-flex h-5 min-w-5 items-center justify-center rounded-full bg-red-600 px-1 text-[10px] font-bold text-white"
                ></span>
            </a>

            <a
                href="{{ route('admin.orders.history') }}"
                class="block rounded-lg px-3 py-2.5 text-sm font-medium
                    {{ $historyActive
                        ? 'bg-red-50 text-red-700'
                        : 'text-gray-700 hover:bg-gray-50' }}"
            >
                Riwayat
            </a>

            <a
                href="{{ route('home') }}"
                target="_blank"
                rel="noopener noreferrer"
                class="block rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50"
            >
                Lihat Website
            </a>

        </div>

        <div class="border-t border-gray-200 px-4 py-4">

            <div class="flex items-center gap-3">

                <div
                    class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-red-700 text-xs font-bold text-white"
                >
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>

                <div class="min-w-0">
                    <p class="truncate text-sm font-medium text-gray-900">
                        {{ Auth::user()->name }}
                    </p>

                    <p class="truncate text-xs text-gray-500">
                        {{ Auth::user()->email }}
                    </p>
                </div>

            </div>

            <div class="mt-3 flex gap-2">

                <a
                    href="{{ route('profile.edit') }}"
                    class="flex-1 rounded-lg border border-gray-300 px-3 py-2 text-center text-sm font-medium text-gray-700"
                >
                    Profil
                </a>

                <form
                    method="POST"
                    action="{{ route('logout') }}"
                    class="flex-1"
                >
                    @csrf

                    <button
                        type="submit"
                        class="w-full rounded-lg bg-red-700 px-3 py-2 text-sm font-medium text-white"
                    >
                        Keluar
                    </button>
                </form>

            </div>

        </div>

    </div>

    {{-- Toast notifikasi --}}
    <div
        x-show="showToast && latestOrder"
        x-cloak
        x-transition:enter="transition duration-200 ease-out"
        x-transition:enter-start="translate-y-2 opacity-0"
        x-transition:enter-end="translate-y-0 opacity-100"
        x-transition:leave="transition duration-150 ease-in"
        x-transition:leave-start="translate-y-0 opacity-100"
        x-transition:leave-end="translate-y-2 opacity-0"
        class="fixed bottom-4 right-4 z-[70] w-[calc(100%-2rem)] max-w-sm rounded-xl border border-gray-200 bg-white p-4 shadow-lg sm:bottom-6 sm:right-6"
        role="alert"
        aria-live="polite"
    >
        <div class="flex items-start gap-3">

            <div
                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-red-50 text-red-700"
            >
                <svg
                    class="h-5 w-5"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.8"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"
                    />
                </svg>
            </div>

            <div class="min-w-0 flex-1">

                <div class="flex items-start justify-between gap-3">

                    <div>
                        <p class="text-sm font-semibold text-gray-900">
                            Pesanan baru
                        </p>

                        <p class="mt-1 text-sm leading-5 text-gray-600">
                            <span
                                class="font-medium text-gray-900"
                                x-text="latestOrder?.customer_name"
                            ></span>

                            melakukan pesanan senilai

                            <span
                                class="font-semibold text-red-700"
                                x-text="latestOrder?.total_formatted"
                            ></span>.
                        </p>
                    </div>

                    <button
                        type="button"
                        @click="closeNotificationToast()"
                        class="shrink-0 text-gray-400 transition hover:text-gray-700"
                        aria-label="Tutup notifikasi"
                    >
                        <svg
                            class="h-5 w-5"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.8"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M6 18L18 6M6 6l12 12"
                            />
                        </svg>
                    </button>

                </div>

                <div class="mt-3 flex items-center justify-between gap-3">

                    <span
                        class="truncate text-xs text-gray-500"
                        x-text="latestOrder?.order_code"
                    ></span>

                    <a
                        :href="notificationUrl()"
                        class="text-sm font-semibold text-red-700 transition hover:text-red-900"
                    >
                        Lihat pesanan
                    </a>

                </div>

            </div>

        </div>

    </div>

</nav>