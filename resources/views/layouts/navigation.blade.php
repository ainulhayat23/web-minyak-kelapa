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

            destroy() {
                if (this.poller) {
                    window.clearInterval(this.poller);
                }

                if (this.toastTimer) {
                    window.clearTimeout(this.toastTimer);
                }
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
                    // Aplikasi tetap berjalan jika localStorage tidak tersedia.
                }
            },

            prepareNotificationSound() {
                const unlockAudio = () => {
                    try {
                        const AudioContextClass =
                            window.AudioContext || window.webkitAudioContext;

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

                    const currentTime = this.audioContext.currentTime;

                    const firstTone = this.audioContext.createOscillator();
                    const firstGain = this.audioContext.createGain();

                    firstTone.type = 'sine';
                    firstTone.frequency.setValueAtTime(880, currentTime);

                    firstGain.gain.setValueAtTime(0.0001, currentTime);
                    firstGain.gain.exponentialRampToValueAtTime(
                        0.18,
                        currentTime + 0.02
                    );
                    firstGain.gain.exponentialRampToValueAtTime(
                        0.0001,
                        currentTime + 0.18
                    );

                    firstTone.connect(firstGain);
                    firstGain.connect(this.audioContext.destination);

                    firstTone.start(currentTime);
                    firstTone.stop(currentTime + 0.2);

                    const secondTone = this.audioContext.createOscillator();
                    const secondGain = this.audioContext.createGain();

                    secondTone.type = 'sine';
                    secondTone.frequency.setValueAtTime(
                        1100,
                        currentTime + 0.2
                    );

                    secondGain.gain.setValueAtTime(
                        0.0001,
                        currentTime + 0.2
                    );
                    secondGain.gain.exponentialRampToValueAtTime(
                        0.18,
                        currentTime + 0.22
                    );
                    secondGain.gain.exponentialRampToValueAtTime(
                        0.0001,
                        currentTime + 0.42
                    );

                    secondTone.connect(secondGain);
                    secondGain.connect(this.audioContext.destination);

                    secondTone.start(currentTime + 0.2);
                    secondTone.stop(currentTime + 0.44);
                } catch (error) {
                    // Bunyi tidak memengaruhi fungsi notifikasi utama.
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

                    this.unreadCount = Number(data.unread_count || 0);
                    this.latestOrder = data.latest_order || null;

                    const latestOrderId = Number(
                        this.latestOrder?.id || 0
                    );

                    if (!latestOrderId) {
                        return;
                    }

                    const isFirstUnreadOrder =
                        this.lastNotifiedOrderId === 0
                        && this.unreadCount > 0;

                    const isNewOrder =
                        latestOrderId > this.lastNotifiedOrderId;

                    if (isFirstUnreadOrder || isNewOrder) {
                        this.openNotificationToast();

                        /*
                         * Browser biasanya baru mengizinkan bunyi setelah
                         * admin mengeklik atau menekan tombol pada halaman.
                         */
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
                }, 10000);
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
                return this.latestOrder?.url || config.ordersUrl;
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
    x-on:keydown.escape.window="closeNotificationToast()"
    class="sticky top-0 z-50 border-b bg-white shadow-sm"
    style="border-color: #f1e7a4;"
>
    {{-- Garis identitas Maloppo --}}
    <div class="maloppo-brand-line"></div>

    {{-- Navigasi utama --}}
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="flex h-20 items-center justify-between">

            {{-- Logo dan menu desktop --}}
            <div class="flex min-w-0 items-center">

                {{-- Identitas Maloppo --}}
                <a
                    href="{{ route('dashboard') }}"
                    class="flex shrink-0 items-center gap-3"
                >
                    <div
                        class="flex h-14 w-24 items-center justify-center overflow-hidden rounded-xl border"
                        style="
                            background-color: #f7e900;
                            border-color: #f1e7a4;
                        "
                    >
                        <img
                            src="{{ asset('images/brand/logo-maloppo-wordmark.jpg') }}"
                            alt="Logo UMKM Maloppo"
                            class="h-full w-full object-contain"
                        >
                    </div>

                    <div class="hidden xl:block">

                        <p
                            class="text-sm font-extrabold"
                            style="color: #be0000;"
                        >
                            Admin Maloppo
                        </p>

                        <p class="mt-0.5 text-xs text-gray-500">
                            Sistem Pengelolaan UMKM
                        </p>

                    </div>
                </a>

                {{-- Menu desktop --}}
                <div class="ml-7 hidden items-center gap-1 lg:flex">

                    {{-- Dashboard --}}
                    <a
                        href="{{ route('dashboard') }}"
                        class="inline-flex items-center gap-2 rounded-xl px-3 py-2.5 text-sm font-semibold transition"
                        style="{{ request()->routeIs('dashboard')
                            ? 'background-color: #fff9b0; color: #be0000;'
                            : 'color: #4b5563;' }}"
                    >
                        <span>📊</span>
                        Dashboard
                    </a>

                    {{-- Produk --}}
                    <a
                        href="{{ route('admin.products.index') }}"
                        class="inline-flex items-center gap-2 rounded-xl px-3 py-2.5 text-sm font-semibold transition"
                        style="{{ request()->routeIs('admin.products.*')
                            ? 'background-color: #fff9b0; color: #be0000;'
                            : 'color: #4b5563;' }}"
                    >
                        <span>🥥</span>
                        Produk
                    </a>

                    {{-- Kegiatan --}}
                    <a
                        href="{{ route('admin.posts.index') }}"
                        class="inline-flex items-center gap-2 rounded-xl px-3 py-2.5 text-sm font-semibold transition"
                        style="{{ request()->routeIs('admin.posts.*')
                            ? 'background-color: #fff9b0; color: #be0000;'
                            : 'color: #4b5563;' }}"
                    >
                        <span>📰</span>
                        Kegiatan
                    </a>

                    {{-- Pesanan aktif --}}
                    <a
                        href="{{ route('admin.orders.index') }}"
                        class="relative inline-flex items-center gap-2 rounded-xl px-3 py-2.5 text-sm font-semibold transition"
                        style="{{ $ordersActive
                            ? 'background-color: #fff9b0; color: #be0000;'
                            : 'color: #4b5563;' }}"
                    >
                        <span>📦</span>

                        <span>
                            Pesanan
                        </span>

                        {{-- Badge notifikasi desktop --}}
                        <span
                            x-show="unreadCount > 0"
                            x-cloak
                            class="relative ml-0.5 inline-flex h-6 min-w-6 items-center justify-center rounded-full px-1.5 text-xs font-extrabold text-white shadow-sm"
                            style="background-color: #be0000;"
                            :title="unreadCount + ' pesanan belum dibaca'"
                        >
                            <span
                                class="absolute inset-0 animate-ping rounded-full opacity-30"
                                style="background-color: #be0000;"
                            ></span>

                            <span
                                class="relative"
                                x-text="badgeText()"
                            ></span>
                        </span>
                    </a>

                    {{-- Riwayat pesanan --}}
                    <a
                        href="{{ route('admin.orders.history') }}"
                        class="inline-flex items-center gap-2 rounded-xl px-3 py-2.5 text-sm font-semibold transition"
                        style="{{ $historyActive
                            ? 'background-color: #fff9b0; color: #be0000;'
                            : 'color: #4b5563;' }}"
                    >
                        <span>🕘</span>
                        Riwayat
                    </a>

                </div>

            </div>

            {{-- Bagian kanan desktop --}}
            <div class="hidden items-center gap-3 lg:flex">

                {{-- Lonceng notifikasi --}}
                <a
                    href="{{ route('admin.orders.index') }}"
                    class="relative inline-flex h-11 w-11 items-center justify-center rounded-xl border text-lg transition hover:bg-yellow-50"
                    style="
                        background-color: #fffdf0;
                        border-color: #f1e7a4;
                    "
                    :title="unreadCount > 0
                        ? unreadCount + ' pesanan belum dibaca'
                        : 'Tidak ada pesanan baru'"
                    aria-label="Notifikasi pesanan"
                >
                    <span
                        :class="unreadCount > 0 ? 'animate-bounce' : ''"
                    >
                        🔔
                    </span>

                    <span
                        x-show="unreadCount > 0"
                        x-cloak
                        class="absolute -right-2 -top-2 inline-flex h-6 min-w-6 items-center justify-center rounded-full border-2 border-white px-1 text-xs font-extrabold text-white shadow-md"
                        style="background-color: #be0000;"
                        x-text="badgeText()"
                    ></span>
                </a>

                {{-- Lihat website --}}
                <a
                    href="{{ route('home') }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="inline-flex items-center gap-2 rounded-xl border px-4 py-2.5 text-sm font-bold transition"
                    style="
                        border-color: #be0000;
                        color: #be0000;
                        background-color: white;
                    "
                >
                    <span>🌐</span>
                    Lihat Website
                </a>

                {{-- Dropdown akun --}}
                <x-dropdown align="right" width="48">

                    <x-slot name="trigger">

                        <button
                            type="button"
                            class="inline-flex items-center gap-3 rounded-xl border px-3 py-2 text-left transition"
                            style="
                                background-color: #fffdf0;
                                border-color: #f1e7a4;
                            "
                        >
                            <div
                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full text-sm font-extrabold text-white"
                                style="background-color: #be0000;"
                            >
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>

                            <div class="hidden xl:block">

                                <p class="max-w-32 truncate text-sm font-bold text-gray-800">
                                    {{ Auth::user()->name }}
                                </p>

                                <p class="mt-0.5 text-xs text-gray-500">
                                    Administrator
                                </p>

                            </div>

                            <svg
                                class="h-4 w-4 text-gray-500"
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

                        <div
                            class="border-b px-4 py-3"
                            style="border-color: #f1e7a4;"
                        >
                            <p class="truncate text-sm font-bold text-gray-800">
                                {{ Auth::user()->name }}
                            </p>

                            <p class="mt-1 truncate text-xs text-gray-500">
                                {{ Auth::user()->email }}
                            </p>
                        </div>

                        <a
                            href="{{ route('profile.edit') }}"
                            class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-gray-700 transition hover:bg-yellow-50"
                        >
                            <span>👤</span>
                            Profil Akun
                        </a>

                        <form
                            method="POST"
                            action="{{ route('logout') }}"
                        >
                            @csrf

                            <button
                                type="submit"
                                class="flex w-full items-center gap-3 px-4 py-3 text-left text-sm font-semibold transition hover:bg-red-50"
                                style="color: #b91c1c;"
                            >
                                <span>🚪</span>
                                Keluar
                            </button>
                        </form>

                    </x-slot>

                </x-dropdown>

            </div>

            {{-- Tombol menu HP dan tablet --}}
            <div class="flex items-center gap-3 lg:hidden">

                {{-- Lonceng mobile --}}
                <a
                    href="{{ route('admin.orders.index') }}"
                    class="relative inline-flex h-11 w-11 items-center justify-center rounded-xl border text-lg"
                    style="
                        border-color: #be0000;
                        color: #be0000;
                        background-color: #fffdf0;
                    "
                    aria-label="Notifikasi pesanan"
                >
                    🔔

                    <span
                        x-show="unreadCount > 0"
                        x-cloak
                        class="absolute -right-2 -top-2 inline-flex h-6 min-w-6 items-center justify-center rounded-full border-2 border-white px-1 text-xs font-extrabold text-white"
                        style="background-color: #be0000;"
                        x-text="badgeText()"
                    ></span>
                </a>

                <button
                    type="button"
                    @click="open = ! open"
                    class="inline-flex h-11 w-11 items-center justify-center rounded-xl border transition"
                    style="
                        border-color: #be0000;
                        color: #be0000;
                        background-color: #fffdf0;
                    "
                    aria-label="Buka menu navigasi"
                >
                    <svg
                        x-show="! open"
                        class="h-6 w-6"
                        stroke="currentColor"
                        fill="none"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"
                        />
                    </svg>

                    <svg
                        x-show="open"
                        x-cloak
                        class="h-6 w-6"
                        stroke="currentColor"
                        fill="none"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"
                        />
                    </svg>
                </button>

            </div>

        </div>

    </div>

    {{-- Navigasi versi HP dan tablet --}}
    <div
        x-show="open"
        x-transition
        x-cloak
        class="border-t bg-white lg:hidden"
        style="border-color: #f1e7a4;"
    >
        <div class="space-y-2 px-4 py-4">

            <a
                href="{{ route('dashboard') }}"
                class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold"
                style="{{ request()->routeIs('dashboard')
                    ? 'background-color: #fff9b0; color: #be0000;'
                    : 'color: #4b5563;' }}"
            >
                <span>📊</span>
                Dashboard
            </a>

            <a
                href="{{ route('admin.products.index') }}"
                class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold"
                style="{{ request()->routeIs('admin.products.*')
                    ? 'background-color: #fff9b0; color: #be0000;'
                    : 'color: #4b5563;' }}"
            >
                <span>🥥</span>
                Produk
            </a>

            <a
                href="{{ route('admin.posts.index') }}"
                class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold"
                style="{{ request()->routeIs('admin.posts.*')
                    ? 'background-color: #fff9b0; color: #be0000;'
                    : 'color: #4b5563;' }}"
            >
                <span>📰</span>
                Kegiatan
            </a>

            {{-- Pesanan mobile --}}
            <a
                href="{{ route('admin.orders.index') }}"
                class="flex items-center justify-between gap-3 rounded-xl px-4 py-3 text-sm font-semibold"
                style="{{ $ordersActive
                    ? 'background-color: #fff9b0; color: #be0000;'
                    : 'color: #4b5563;' }}"
            >
                <span class="flex items-center gap-3">
                    <span>📦</span>
                    Pesanan Aktif
                </span>

                <span
                    x-show="unreadCount > 0"
                    x-cloak
                    class="inline-flex h-6 min-w-6 items-center justify-center rounded-full px-1.5 text-xs font-extrabold text-white"
                    style="background-color: #be0000;"
                    x-text="badgeText()"
                ></span>
            </a>

            <a
                href="{{ route('admin.orders.history') }}"
                class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold"
                style="{{ $historyActive
                    ? 'background-color: #fff9b0; color: #be0000;'
                    : 'color: #4b5563;' }}"
            >
                <span>🕘</span>
                Riwayat Pesanan
            </a>

            <a
                href="{{ route('home') }}"
                target="_blank"
                rel="noopener noreferrer"
                class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold text-gray-600"
            >
                <span>🌐</span>
                Lihat Website
            </a>

        </div>

        <div
            class="border-t px-4 pb-5 pt-4"
            style="
                background-color: #fffdf0;
                border-color: #f1e7a4;
            "
        >
            <div class="flex items-center gap-3">

                <div
                    class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full text-sm font-extrabold text-white"
                    style="background-color: #be0000;"
                >
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>

                <div class="min-w-0">

                    <p class="truncate text-sm font-bold text-gray-800">
                        {{ Auth::user()->name }}
                    </p>

                    <p class="mt-0.5 truncate text-xs text-gray-500">
                        {{ Auth::user()->email }}
                    </p>

                </div>

            </div>

            <div class="mt-4 grid grid-cols-2 gap-3">

                <a
                    href="{{ route('profile.edit') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-xl border bg-white px-4 py-3 text-sm font-semibold text-gray-700"
                    style="border-color: #f1e7a4;"
                >
                    <span>👤</span>
                    Profil
                </a>

                <form
                    method="POST"
                    action="{{ route('logout') }}"
                >
                    @csrf

                    <button
                        type="submit"
                        class="inline-flex w-full items-center justify-center gap-2 rounded-xl px-4 py-3 text-sm font-semibold text-white"
                        style="background-color: #be0000;"
                    >
                        <span>🚪</span>
                        Keluar
                    </button>
                </form>

            </div>

        </div>

    </div>

    {{-- Toast pesanan baru --}}
    <div
        x-show="showToast && latestOrder"
        x-cloak
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="translate-x-8 opacity-0"
        x-transition:enter-end="translate-x-0 opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="translate-x-0 opacity-100"
        x-transition:leave-end="translate-x-8 opacity-0"
        class="fixed right-4 top-24 z-[70] w-[calc(100%-2rem)] max-w-sm overflow-hidden rounded-2xl border bg-white shadow-2xl sm:right-6"
        style="border-color: #f7e900;"
        role="alert"
        aria-live="polite"
    >
        <div class="maloppo-brand-line"></div>

        <div class="p-5">

            <div class="flex items-start gap-4">

                <div class="relative shrink-0">

                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-xl text-xl text-white"
                        style="background-color: #be0000;"
                    >
                        🔔
                    </div>

                    <span
                        class="absolute -right-1 -top-1 h-3 w-3 animate-ping rounded-full"
                        style="background-color: #f7e900;"
                    ></span>

                </div>

                <div class="min-w-0 flex-1">

                    <div class="flex items-start justify-between gap-3">

                        <div>

                            <p class="text-xs font-extrabold uppercase tracking-wider text-maloppo-red">
                                Pesanan Baru
                            </p>

                            <h3 class="mt-1 font-extrabold text-gray-900">
                                Pesanan baru telah masuk
                            </h3>

                        </div>

                        <button
                            type="button"
                            @click="closeNotificationToast()"
                            class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full text-gray-400 transition hover:bg-gray-100 hover:text-gray-700"
                            aria-label="Tutup notifikasi"
                        >
                            ✕
                        </button>

                    </div>

                    <p class="mt-3 text-sm leading-6 text-gray-600">
                        <span
                            class="font-bold text-gray-900"
                            x-text="latestOrder?.customer_name"
                        ></span>

                        membuat pesanan dengan total

                        <span
                            class="font-extrabold text-maloppo-red"
                            x-text="latestOrder?.total_formatted"
                        ></span>.
                    </p>

                    <div
                        class="mt-3 flex items-center justify-between gap-3 rounded-xl px-3 py-2"
                        style="background-color: #fff9b0;"
                    >
                        <span
                            class="text-xs font-bold"
                            style="color: #990100;"
                            x-text="latestOrder?.order_code"
                        ></span>

                        <span
                            class="text-xs text-gray-500"
                            x-text="latestOrder?.time_label"
                        ></span>
                    </div>

                    <a
                        :href="notificationUrl()"
                        class="mt-4 inline-flex w-full items-center justify-center gap-2 rounded-xl px-5 py-3 text-sm font-bold text-white"
                        style="background-color: #be0000;"
                    >
                        <span>👁️</span>
                        Lihat Pesanan
                    </a>

                </div>

            </div>

        </div>

    </div>

</nav>