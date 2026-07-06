@php
    $cartQuantity = collect(session('cart', []))->sum('quantity');
@endphp

<header
    x-data="{ mobileMenuOpen: false }"
    class="sticky top-0 z-50 border-b bg-white shadow-sm"
    style="border-color: #f3e7a2;"
>
    {{-- Garis identitas Maloppo --}}
    <div
        class="h-1 w-full"
        style="
            background: linear-gradient(
                90deg,
                #be0000 0%,
                #be0000 65%,
                #f7e900 65%,
                #f7e900 100%
            );
        "
    ></div>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-20 items-center justify-between">

            {{-- Identitas UMKM --}}
            <a
                href="{{ route('home') }}"
                class="flex shrink-0 items-center gap-3"
            >
                <div
                    class="flex h-14 w-24 items-center justify-center overflow-hidden rounded-lg"
                    style="background-color: #f7e900;"
                >
                    <img
                        src="{{ asset('images/brand/logo-maloppo-wordmark.jpg') }}"
                        alt="Logo Maloppo"
                        class="h-full w-full object-contain"
                    >
                </div>

                <div class="hidden sm:block">
                    <p
                        class="text-base font-bold"
                        style="color: #be0000;"
                    >
                        UMKM Maloppo
                    </p>

                    <p class="mt-0.5 text-xs text-gray-500">
                        Produk lokal berkualitas
                    </p>
                </div>
            </a>

            {{-- Navigasi desktop --}}
            <nav class="hidden items-center gap-6 text-sm font-medium md:flex">

                <a
                    href="{{ route('home') }}"
                    class="rounded-md px-2 py-2 transition"
                    style="{{ request()->routeIs('home')
                        ? 'color: #be0000; font-weight: 700;'
                        : 'color: #4b5563;' }}"
                >
                    Beranda
                </a>

                <a
                    href="{{ route('catalog.index') }}"
                    class="rounded-md px-2 py-2 transition"
                    style="{{ request()->routeIs('catalog.*')
                        ? 'color: #be0000; font-weight: 700;'
                        : 'color: #4b5563;' }}"
                >
                    Produk
                </a>

                <a
                    href="{{ route('blog.index') }}"
                    class="rounded-md px-2 py-2 transition"
                    style="{{ request()->routeIs('blog.*')
                        ? 'color: #be0000; font-weight: 700;'
                        : 'color: #4b5563;' }}"
                >
                    Kegiatan
                </a>

                {{-- Menu khusus pengunjung --}}
                @guest
                    <a
                        href="{{ route('cart.index') }}"
                        class="relative inline-flex items-center gap-2 rounded-lg border px-4 py-2 font-semibold transition"
                        style="
                            border-color: #be0000;
                            color: #be0000;
                            {{ request()->routeIs('cart.*') || request()->routeIs('checkout.*')
                                ? 'background-color: #fff7bf;'
                                : 'background-color: white;' }}
                        "
                    >
                        <span class="text-lg">
                            🛒
                        </span>

                        <span>
                            Keranjang
                        </span>

                        @if ($cartQuantity > 0)
                            <span
                                class="absolute -right-2 -top-2 flex h-6 min-w-6 items-center justify-center rounded-full px-1 text-xs font-bold"
                                style="
                                    background-color: #f7e900;
                                    color: #7f1d1d;
                                    border: 1px solid #be0000;
                                "
                            >
                                {{ $cartQuantity }}
                            </span>
                        @endif
                    </a>
                @endguest

                {{-- Login atau Dashboard --}}
                @auth
                    <a
                        href="{{ route('dashboard') }}"
                        class="inline-flex items-center justify-center rounded-lg px-5 py-2.5 font-semibold shadow-sm transition"
                        style="
                            background-color: #be0000;
                            color: white;
                        "
                    >
                        Dashboard
                    </a>
                @else
                    <a
                        href="{{ route('login') }}"
                        class="inline-flex items-center justify-center rounded-lg px-5 py-2.5 font-semibold shadow-sm transition"
                        style="
                            background-color: #be0000;
                            color: white;
                        "
                    >
                        Masuk
                    </a>
                @endauth

            </nav>

            {{-- Tombol menu HP --}}
            <button
                type="button"
                class="inline-flex items-center justify-center rounded-lg border p-2 md:hidden"
                style="
                    border-color: #be0000;
                    color: #be0000;
                    background-color: #fffdf0;
                "
                @click="mobileMenuOpen = ! mobileMenuOpen"
                aria-label="Buka menu navigasi"
            >
                <svg
                    x-show="! mobileMenuOpen"
                    class="h-6 w-6"
                    fill="none"
                    stroke="currentColor"
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
                    x-show="mobileMenuOpen"
                    x-cloak
                    class="h-6 w-6"
                    fill="none"
                    stroke="currentColor"
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

    {{-- Navigasi HP --}}
    <div
        x-show="mobileMenuOpen"
        x-transition
        x-cloak
        class="border-t bg-white md:hidden"
        style="border-color: #f3e7a2;"
    >
        <nav class="space-y-1 px-4 py-4">

            <a
                href="{{ route('home') }}"
                class="block rounded-lg px-4 py-3 text-sm font-medium"
                style="{{ request()->routeIs('home')
                    ? 'background-color: #fff7bf; color: #be0000; font-weight: 700;'
                    : 'color: #4b5563;' }}"
            >
                Beranda
            </a>

            <a
                href="{{ route('catalog.index') }}"
                class="block rounded-lg px-4 py-3 text-sm font-medium"
                style="{{ request()->routeIs('catalog.*')
                    ? 'background-color: #fff7bf; color: #be0000; font-weight: 700;'
                    : 'color: #4b5563;' }}"
            >
                Produk
            </a>

            <a
                href="{{ route('blog.index') }}"
                class="block rounded-lg px-4 py-3 text-sm font-medium"
                style="{{ request()->routeIs('blog.*')
                    ? 'background-color: #fff7bf; color: #be0000; font-weight: 700;'
                    : 'color: #4b5563;' }}"
            >
                Kegiatan
            </a>

            {{-- Keranjang khusus pengunjung --}}
            @guest
                <a
                    href="{{ route('cart.index') }}"
                    class="flex items-center justify-between rounded-lg px-4 py-3 text-sm font-medium"
                    style="{{ request()->routeIs('cart.*') || request()->routeIs('checkout.*')
                        ? 'background-color: #fff7bf; color: #be0000; font-weight: 700;'
                        : 'color: #4b5563;' }}"
                >
                    <span class="flex items-center gap-2">
                        <span>🛒</span>
                        Keranjang
                    </span>

                    @if ($cartQuantity > 0)
                        <span
                            class="flex h-6 min-w-6 items-center justify-center rounded-full px-1 text-xs font-bold"
                            style="
                                background-color: #f7e900;
                                color: #7f1d1d;
                                border: 1px solid #be0000;
                            "
                        >
                            {{ $cartQuantity }}
                        </span>
                    @endif
                </a>
            @endguest

            <div class="pt-3">
                @auth
                    <a
                        href="{{ route('dashboard') }}"
                        class="block rounded-lg px-4 py-3 text-center text-sm font-semibold shadow-sm"
                        style="
                            background-color: #be0000;
                            color: white;
                        "
                    >
                        Dashboard
                    </a>
                @else
                    <a
                        href="{{ route('login') }}"
                        class="block rounded-lg px-4 py-3 text-center text-sm font-semibold shadow-sm"
                        style="
                            background-color: #be0000;
                            color: white;
                        "
                    >
                        Masuk
                    </a>
                @endauth
            </div>

        </nav>
    </div>
</header>