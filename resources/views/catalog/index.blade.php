<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="description"
        content="Katalog produk minyak kelapa murni dari UMKM Maloppo."
    >

    <title>Katalog Produk | UMKM Maloppo</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-maloppo-page text-gray-900">

    @php
        $cartQuantity = collect(session('cart', []))->sum('quantity');
    @endphp

    {{-- Navigasi pelanggan --}}
    <x-public-navbar />

    {{-- Bagian pembuka --}}
    <section class="hero-maloppo relative overflow-hidden">

        <div
            class="absolute -right-20 -top-20 h-64 w-64 rounded-full opacity-40"
            style="background-color: #f7e900;"
        ></div>

        <div
            class="absolute -bottom-24 -left-20 h-72 w-72 rounded-full opacity-10"
            style="background-color: #be0000;"
        ></div>

        <div
            class="relative mx-auto grid max-w-7xl grid-cols-1 items-center gap-10 px-6 py-14 lg:grid-cols-[1fr_auto] lg:py-20"
        >

            <div>

                <span class="label-maloppo">
                    Katalog Produk
                </span>

                <h1
                    class="mt-5 max-w-3xl text-4xl font-extrabold leading-tight text-gray-900 md:text-5xl"
                >
                    Produk Minyak Kelapa
                    <span class="text-maloppo-red">
                        UMKM Maloppo
                    </span>
                </h1>

                <p class="mt-5 max-w-2xl text-lg leading-8 text-gray-600">
                    Temukan produk minyak kelapa murni yang diolah dari
                    kelapa pilihan melalui proses yang bersih dan terjaga.
                </p>

                <div class="mt-7 flex flex-wrap gap-3">

                    <div
                        class="inline-flex items-center gap-2 rounded-full bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm"
                    >
                        <span>🥥</span>
                        Kelapa pilihan
                    </div>

                    <div
                        class="inline-flex items-center gap-2 rounded-full bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm"
                    >
                        <span>✨</span>
                        Proses terjaga
                    </div>

                    <div
                        class="inline-flex items-center gap-2 rounded-full bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm"
                    >
                        <span>📦</span>
                        Kemasan praktis
                    </div>

                </div>

            </div>

            {{-- Logo --}}
            <div
                class="mx-auto flex h-40 w-64 items-center justify-center overflow-hidden rounded-3xl border-4 bg-white p-3 shadow-lg lg:mx-0"
                style="border-color: #f7e900;"
            >
                <img
                    src="{{ asset('images/brand/logo-maloppo-wordmark.jpg') }}"
                    alt="Logo UMKM Maloppo"
                    class="h-full w-full object-contain"
                >
            </div>

        </div>

    </section>

    {{-- Daftar produk --}}
    <main class="mx-auto max-w-7xl px-6 py-12 lg:py-16">

        {{-- Notifikasi berhasil --}}
        @if (session('success'))
            <div
                class="mb-7 flex flex-col gap-3 rounded-xl border px-5 py-4 text-sm sm:flex-row sm:items-center sm:justify-between"
                style="
                    background-color: #dcfce7;
                    border-color: #86efac;
                    color: #166534;
                "
            >
                <span class="font-medium">
                    {{ session('success') }}
                </span>

                @guest
                    <a
                        href="{{ route('cart.index') }}"
                        class="font-bold underline"
                    >
                        Lihat Keranjang
                    </a>
                @endguest
            </div>
        @endif

        {{-- Notifikasi kesalahan --}}
        @if (session('error'))
            <div class="alert-maloppo-error mb-7">
                {{ session('error') }}
            </div>
        @endif

        {{-- Validasi --}}
        @if ($errors->any())
            <div class="alert-maloppo-error mb-7">

                <p class="font-semibold">
                    Terjadi kesalahan:
                </p>

                <ul class="mt-2 list-inside list-disc space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>
                            {{ $error }}
                        </li>
                    @endforeach
                </ul>

            </div>
        @endif

        {{-- Judul daftar produk --}}
        <div
            class="mb-9 flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between"
        >

            <div>

                <span class="label-maloppo">
                    Produk Tersedia
                </span>

                <h2 class="mt-4 text-3xl font-extrabold text-gray-900">
                    Pilih Produk Anda
                </h2>

                <p class="mt-2 max-w-2xl leading-7 text-gray-500">
                    Pilih ukuran dan jumlah produk sesuai kebutuhan Anda.
                </p>

            </div>

            @guest
                @if ($cartQuantity > 0)
                    <a
                        href="{{ route('cart.index') }}"
                        class="btn-maloppo-yellow"
                    >
                        <span>🛒</span>

                        <span>
                            {{ $cartQuantity }} barang di keranjang
                        </span>

                        <span aria-hidden="true">
                            →
                        </span>
                    </a>
                @endif
            @endguest

        </div>

        {{-- Grid produk --}}
        <div class="grid grid-cols-1 gap-7 sm:grid-cols-2 lg:grid-cols-4">

            @forelse ($products as $product)

                <article
                    class="card-maloppo card-maloppo-hover flex h-full flex-col overflow-hidden"
                >

                    {{-- Gambar produk --}}
                    <a
                        href="{{ route('catalog.show', $product->slug) }}"
                        class="relative block overflow-hidden"
                    >

                        <div
                            class="flex h-60 items-center justify-center overflow-hidden"
                            style="background-color: #fffdf0;"
                        >
                            @if ($product->image)

                                <img
                                    src="{{ asset('storage/' . $product->image) }}"
                                    alt="{{ $product->name }}"
                                    class="h-full w-full object-cover transition duration-300 hover:scale-105"
                                >

                            @else

                                <div class="px-6 text-center">

                                    <div class="text-6xl">
                                        🥥
                                    </div>

                                    <p class="mt-4 text-sm text-gray-400">
                                        Gambar produk belum tersedia
                                    </p>

                                </div>

                            @endif
                        </div>

                        {{-- Status stok --}}
                        <div class="absolute left-4 top-4">

                            @if ($product->stock > 0)

                                <span
                                    class="inline-flex items-center gap-1 rounded-full px-3 py-1 text-xs font-bold shadow-sm"
                                    style="
                                        background-color: #dcfce7;
                                        color: #166534;
                                    "
                                >
                                    <span>✓</span>
                                    Stok tersedia
                                </span>

                            @else

                                <span
                                    class="inline-flex items-center rounded-full px-3 py-1 text-xs font-bold shadow-sm"
                                    style="
                                        background-color: #fee2e2;
                                        color: #991b1b;
                                    "
                                >
                                    Stok habis
                                </span>

                            @endif

                        </div>

                    </a>

                    {{-- Informasi produk --}}
                    <div class="flex flex-1 flex-col p-5">

                        <div class="flex items-start justify-between gap-3">

                            <h3 class="font-bold leading-6 text-gray-900">
                                {{ $product->name }}
                            </h3>

                            @if ($product->size)
                                <span class="badge-maloppo-yellow whitespace-nowrap">
                                    {{ $product->size }}
                                </span>
                            @endif

                        </div>

                        <p class="mt-3 line-clamp-3 flex-1 text-sm leading-6 text-gray-500">
                            {{
                                $product->short_description
                                ?: 'Produk minyak kelapa murni berkualitas dari UMKM Maloppo.'
                            }}
                        </p>

                        {{-- Harga dan stok --}}
                        <div
                            class="mt-5 flex items-end justify-between gap-3 border-t pt-4"
                            style="border-color: #f1e7a4;"
                        >

                            <div>
                                <p class="text-xs font-medium text-gray-400">
                                    Harga
                                </p>

                                <p class="mt-1 text-xl font-extrabold text-maloppo-red">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </p>
                            </div>

                            <div class="text-right">
                                <p class="text-xs text-gray-400">
                                    Stok
                                </p>

                                <p
                                    class="mt-1 text-sm font-bold"
                                    style="{{ $product->stock > 0
                                        ? 'color: #166534;'
                                        : 'color: #991b1b;' }}"
                                >
                                    {{ $product->stock }}
                                </p>
                            </div>

                        </div>

                        {{-- Tombol --}}
                        <div class="mt-5 grid grid-cols-1 gap-2">

                            <a
                                href="{{ route('catalog.show', $product->slug) }}"
                                class="btn-maloppo-secondary w-full"
                            >
                                Lihat Detail
                            </a>

                            @guest

                                @if ($product->stock > 0)

                                    <form
                                        action="{{ route('cart.add', $product) }}"
                                        method="POST"
                                    >
                                        @csrf

                                        <input
                                            type="hidden"
                                            name="quantity"
                                            value="1"
                                        >

                                        <button
                                            type="submit"
                                            class="btn-maloppo-primary w-full"
                                        >
                                            <span>
                                                🛒
                                            </span>

                                            Tambah ke Keranjang
                                        </button>

                                    </form>

                                @else

                                    <button
                                        type="button"
                                        disabled
                                        class="w-full cursor-not-allowed rounded-lg px-4 py-3 text-sm font-semibold"
                                        style="
                                            background-color: #e5e7eb;
                                            color: #6b7280;
                                        "
                                    >
                                        Stok Habis
                                    </button>

                                @endif

                            @else

                                <div
                                    class="rounded-lg px-4 py-3 text-center text-xs font-semibold"
                                    style="
                                        background-color: #fff9b0;
                                        color: #990100;
                                    "
                                >
                                    Pemesanan hanya tersedia untuk pengunjung
                                </div>

                            @endguest

                        </div>

                    </div>

                </article>

            @empty

                <div class="card-maloppo col-span-full px-6 py-20 text-center">

                    <div
                        class="mx-auto flex h-20 w-20 items-center justify-center rounded-full text-5xl"
                        style="background-color: #fff9b0;"
                    >
                        🥥
                    </div>

                    <h3 class="mt-6 text-xl font-bold text-gray-800">
                        Produk belum tersedia
                    </h3>

                    <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-gray-500">
                        Produk minyak kelapa UMKM Maloppo akan segera
                        ditambahkan.
                    </p>

                </div>

            @endforelse

        </div>

        {{-- Pagination --}}
        @if ($products->hasPages())
            <div
                class="mt-12 rounded-2xl border bg-white px-5 py-4 shadow-sm"
                style="border-color: #f1e7a4;"
            >
                {{ $products->links() }}
            </div>
        @endif

    </main>

    {{-- Ajakan --}}
    <section class="section-maloppo-red">

        <div
            class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-7 px-6 py-12 text-center lg:flex-row lg:text-left"
        >

            <div>

                <span
                    class="inline-flex rounded-full px-4 py-2 text-xs font-bold uppercase tracking-wider"
                    style="
                        background-color: #f7e900;
                        color: #990100;
                    "
                >
                    Produk Maloppo
                </span>

                <h2 class="mt-4 text-2xl font-extrabold text-white">
                    Pilih produk sesuai kebutuhan Anda
                </h2>

                <p class="mt-2 max-w-2xl text-sm leading-7 text-red-100">
                    Lihat informasi lengkap produk, ukuran, harga, dan stok
                    sebelum melakukan pemesanan.
                </p>

            </div>

            <a
                href="{{ route('home') }}"
                class="btn-maloppo-yellow whitespace-nowrap px-7 py-3.5"
            >
                Kembali ke Beranda
            </a>

        </div>

    </section>

    {{-- Footer --}}
    <footer
        class="border-t bg-white"
        style="border-color: #f1e7a4;"
    >

        <div class="maloppo-brand-line"></div>

        <div class="mx-auto max-w-7xl px-6 py-10">

            <div
                class="flex flex-col items-center justify-between gap-8 lg:flex-row"
            >

                {{-- Identitas footer --}}
                <div class="text-center lg:text-left">

                    <div
                        class="mx-auto flex h-20 w-36 items-center justify-center overflow-hidden rounded-xl lg:mx-0"
                        style="background-color: #f7e900;"
                    >
                        <img
                            src="{{ asset('images/brand/logo-maloppo-wordmark.jpg') }}"
                            alt="Logo UMKM Maloppo"
                            class="h-full w-full object-contain"
                        >
                    </div>

                    <p class="mt-4 text-sm font-bold text-gray-800">
                        UMKM Maloppo
                    </p>

                    <p class="mt-1 text-xs text-gray-500">
                        Produk minyak kelapa murni dari kelapa pilihan
                    </p>

                </div>

                {{-- Media sosial --}}
                <div class="text-center">

                    <p class="text-sm font-bold text-gray-700">
                        Ikuti dan hubungi UMKM Maloppo
                    </p>

                    <p class="mt-1 text-xs text-gray-500">
                        Dapatkan informasi produk dan kegiatan terbaru kami.
                    </p>

                    <div class="mt-5">
                        <x-social-media />
                    </div>

                </div>

            </div>

            <div
                class="mt-8 flex flex-col gap-2 border-t pt-6 text-center text-xs text-gray-500 sm:flex-row sm:items-center sm:justify-between sm:text-left"
                style="border-color: #f1e7a4;"
            >
                <p>
                    &copy; {{ date('Y') }} UMKM Maloppo. Hak cipta dilindungi.
                </p>

                <p>
                    Produk lokal dari kelapa pilihan
                </p>
            </div>

        </div>

    </footer>

</body>
</html>