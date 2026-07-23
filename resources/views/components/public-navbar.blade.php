@php
    $cartQuantity = collect(session('cart', []))->sum('quantity');
@endphp

<header
    x-data="{ mobileMenuOpen: false }"
    class="sticky top-0 z-50 bg-gradient-to-r from-red-800 via-red-700 to-yellow-600 shadow-sm"
>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="flex h-[76px] items-center justify-between">

            {{-- Identitas UMKM --}}
            <a
                href="{{ route('home') }}"
                class="flex shrink-0 items-center gap-3"
            >
                <img
                    src="{{ asset('images/brand/logo-maloppo-wordmark.jpg') }}"
                    alt="Logo UMKM Maloppo"
                    class="h-12 w-auto rounded-xl object-contain"
                >

                <div class="hidden sm:block">
                    <p class="text-base font-bold leading-none text-white">
                        UMKM Maloppo
                    </p>

                    <p class="mt-1 text-xs text-yellow-100">
                        Minyak kelapa murni
                    </p>
                </div>
            </a>

            {{-- Navigasi desktop --}}
            <nav class="hidden items-center gap-2 text-sm font-semibold md:flex">

                <a
                    href="{{ route('home') }}"
                    class="{{ request()->routeIs('home')
                        ? 'bg-white text-red-700'
                        : 'text-white hover:bg-white/10' }} rounded-lg px-3 py-2 transition"
                >
                    Beranda
                </a>

                <a
                    href="{{ route('catalog.index') }}"
                    class="{{ request()->routeIs('catalog.*')
                        ? 'bg-white text-red-700'
                        : 'text-white hover:bg-white/10' }} rounded-lg px-3 py-2 transition"
                >
                    Produk
                </a>

                <a
                    href="{{ route('blog.index') }}"
                    class="{{ request()->routeIs('blog.*')
                        ? 'bg-white text-red-700'
                        : 'text-white hover:bg-white/10' }} rounded-lg px-3 py-2 transition"
                >
                    Kegiatan
                </a>

                {{-- Keranjang khusus pengunjung --}}
                @guest
                    <a
                        href="{{ route('cart.index') }}"
                        class="{{ request()->routeIs('cart.*') || request()->routeIs('checkout.*')
                            ? 'bg-white text-red-700'
                            : 'border-white/50 bg-white/10 text-white hover:bg-white/20' }} relative ml-2 inline-flex items-center gap-2 rounded-lg border px-4 py-2 transition"
                    >
                        <span>
                            🛒
                        </span>

                        <span>
                            Keranjang
                        </span>

                        @if ($cartQuantity > 0)
                            <span class="absolute -right-2 -top-2 flex h-6 min-w-6 items-center justify-center rounded-full border border-red-700 bg-yellow-300 px-1 text-xs font-bold text-red-900">
                                {{ $cartQuantity }}
                            </span>
                        @endif
                    </a>
                @endguest

                {{-- Login atau Dashboard --}}
                @auth
                    <a
                        href="{{ route('dashboard') }}"
                        class="ml-2 inline-flex items-center justify-center rounded-lg bg-white px-5 py-2.5 text-sm font-semibold text-red-700 shadow-sm transition hover:bg-yellow-50"
                    >
                        Dashboard
                    </a>
                @else
                    <a
                        href="{{ route('login') }}"
                        class="ml-2 inline-flex items-center justify-center rounded-lg bg-white px-5 py-2.5 text-sm font-semibold text-red-700 shadow-sm transition hover:bg-yellow-50"
                    >
                        Masuk
                    </a>
                @endauth

            </nav>

            {{-- Tombol menu HP --}}
            <button
                type="button"
                class="inline-flex items-center justify-center rounded-lg border border-white/50 bg-white/10 p-2 text-white transition hover:bg-white/20 md:hidden"
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
        class="border-t border-white/20 bg-red-800 md:hidden"
    >
        <nav class="space-y-1 px-4 py-4">

            <a
                href="{{ route('home') }}"
                class="{{ request()->routeIs('home')
                    ? 'bg-white text-red-700'
                    : 'text-white hover:bg-white/10' }} block rounded-lg px-4 py-3 text-sm font-semibold transition"
            >
                Beranda
            </a>

            <a
                href="{{ route('catalog.index') }}"
                class="{{ request()->routeIs('catalog.*')
                    ? 'bg-white text-red-700'
                    : 'text-white hover:bg-white/10' }} block rounded-lg px-4 py-3 text-sm font-semibold transition"
            >
                Produk
            </a>

            <a
                href="{{ route('blog.index') }}"
                class="{{ request()->routeIs('blog.*')
                    ? 'bg-white text-red-700'
                    : 'text-white hover:bg-white/10' }} block rounded-lg px-4 py-3 text-sm font-semibold transition"
            >
                Kegiatan
            </a>

            {{-- Keranjang khusus pengunjung --}}
            @guest
                <a
                    href="{{ route('cart.index') }}"
                    class="{{ request()->routeIs('cart.*') || request()->routeIs('checkout.*')
                        ? 'bg-white text-red-700'
                        : 'text-white hover:bg-white/10' }} flex items-center justify-between rounded-lg px-4 py-3 text-sm font-semibold transition"
                >
                    <span class="flex items-center gap-2">
                        <span>🛒</span>
                        Keranjang
                    </span>

                    @if ($cartQuantity > 0)
                        <span class="flex h-6 min-w-6 items-center justify-center rounded-full border border-red-700 bg-yellow-300 px-1 text-xs font-bold text-red-900">
                            {{ $cartQuantity }}
                        </span>
                    @endif
                </a>
            @endguest

            <div class="pt-3">
                @auth
                    <a
                        href="{{ route('dashboard') }}"
                        class="block rounded-lg bg-white px-4 py-3 text-center text-sm font-semibold text-red-700 shadow-sm transition hover:bg-yellow-50"
                    >
                        Dashboard
                    </a>
                @else
                    <a
                        href="{{ route('login') }}"
                        class="block rounded-lg bg-white px-4 py-3 text-center text-sm font-semibold text-red-700 shadow-sm transition hover:bg-yellow-50"
                    >
                        Masuk
                    </a>
                @endauth
            </div>

        </nav>
    </div>
</header>