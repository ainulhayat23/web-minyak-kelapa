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

<body class="bg-white text-gray-900">

    @php
        $cartQuantity = collect(session('cart', []))->sum('quantity');
    @endphp

    {{-- Navigasi --}}
    <x-public-navbar />

    {{-- Header katalog --}}
    <header class="relative overflow-hidden bg-gradient-to-br from-red-700 via-red-600 to-yellow-500">

        <div class="absolute inset-0 bg-black/10"></div>

        <div class="relative mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8 lg:py-16">

            <div class="grid grid-cols-1 gap-8 lg:grid-cols-2 lg:items-center">

                <div class="text-white">

                    <p class="text-sm font-semibold uppercase tracking-[0.25em] text-yellow-100">
                        Katalog Produk
                    </p>

                    <h1 class="mt-4 max-w-2xl text-4xl font-bold leading-tight tracking-tight sm:text-5xl">
                        Produk minyak kelapa UMKM Maloppo.
                    </h1>

                    <p class="mt-5 max-w-2xl text-base leading-8 text-red-50">
                        Pilih produk minyak kelapa sesuai kebutuhan Anda.
                        Informasi harga, ukuran, dan stok produk dapat dilihat
                        langsung melalui halaman katalog ini.
                    </p>

                    @guest
                        @if ($cartQuantity > 0)

                            <a
                                href="{{ route('cart.index') }}"
                                class="mt-7 inline-flex items-center justify-center rounded-lg bg-white px-5 py-3 text-sm font-semibold text-red-700 shadow-sm transition hover:bg-yellow-50"
                            >
                                Lihat Keranjang · {{ $cartQuantity }} barang
                            </a>

                        @endif
                    @endguest

                </div>

                <div class="rounded-3xl bg-white/95 p-6 shadow-xl">

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">

                        <div class="rounded-2xl bg-yellow-50 p-5">
                            <p class="text-sm font-semibold text-red-700">
                                Kelapa Pilihan
                            </p>

                            <p class="mt-2 text-xs leading-5 text-gray-600">
                                Bahan baku dipilih sebelum proses pengolahan.
                            </p>
                        </div>

                        <div class="rounded-2xl bg-red-50 p-5">
                            <p class="text-sm font-semibold text-red-700">
                                Proses Bersih
                            </p>

                            <p class="mt-2 text-xs leading-5 text-gray-600">
                                Produk diolah secara bersih dan terjaga.
                            </p>
                        </div>

                        <div class="rounded-2xl bg-yellow-50 p-5">
                            <p class="text-sm font-semibold text-red-700">
                                Mudah Dipesan
                            </p>

                            <p class="mt-2 text-xs leading-5 text-gray-600">
                                Pilih produk lalu lanjutkan ke keranjang.
                            </p>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </header>

    <main class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8 lg:py-16">

        {{-- Notifikasi berhasil --}}
        @if (session('success'))

            <div
                class="mb-8 rounded-2xl border border-green-200 bg-green-50 px-5 py-4 text-sm text-green-800 sm:flex sm:items-center sm:justify-between"
            >
                <span>
                    {{ session('success') }}
                </span>

                @guest
                    <a
                        href="{{ route('cart.index') }}"
                        class="mt-2 inline-block font-semibold underline sm:mt-0"
                    >
                        Lihat Keranjang
                    </a>
                @endguest
            </div>

        @endif

        {{-- Notifikasi kesalahan --}}
        @if (session('error'))

            <div class="mb-8 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700">
                {{ session('error') }}
            </div>

        @endif

        {{-- Validasi --}}
        @if ($errors->any())

            <div class="mb-8 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700">

                <p class="font-semibold">
                    Data belum dapat diproses.
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
        <div class="mx-auto max-w-3xl text-center">

            <p class="text-sm font-semibold uppercase tracking-[0.25em] text-red-700">
                Produk Tersedia
            </p>

            <h2 class="mt-4 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                Katalog Minyak Kelapa Maloppo
            </h2>

            <p class="mt-4 text-base leading-7 text-gray-600">
                {{ $products->total() }} produk ditemukan. Silakan pilih produk,
                lihat detailnya, lalu tambahkan ke keranjang jika ingin memesan.
            </p>

            @if ($products->hasPages())

                <p class="mt-3 text-xs text-gray-500">
                    Halaman {{ $products->currentPage() }} dari {{ $products->lastPage() }}
                </p>

            @endif

        </div>

        {{-- Grid produk --}}
        <div class="mt-10 flex flex-wrap justify-center gap-6">

            @forelse ($products as $product)

                <article
                    class="flex w-full max-w-xs flex-col overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-md"
                >

                    {{-- Gambar --}}
                    <a
                        href="{{ route('catalog.show', $product->slug) }}"
                        class="block"
                    >
                        <div class="flex h-64 items-center justify-center bg-yellow-50 p-5">

                            @if ($product->image)

                                <img
                                    src="{{ asset('storage/' . $product->image) }}"
                                    alt="{{ $product->name }}"
                                    class="h-full w-full object-contain"
                                >

                            @else

                                <p class="px-4 text-center text-sm text-gray-400">
                                    Gambar belum tersedia
                                </p>

                            @endif

                        </div>
                    </a>

                    {{-- Informasi produk --}}
                    <div class="flex flex-1 flex-col p-5">

                        <div class="flex items-start justify-between gap-3">

                            <h2 class="line-clamp-2 text-base font-bold leading-6 text-gray-900">
                                {{ $product->name }}
                            </h2>

                            @if ($product->size)

                                <span
                                    class="shrink-0 rounded-full bg-yellow-100 px-2.5 py-1 text-xs font-semibold text-red-700"
                                >
                                    {{ $product->size }}
                                </span>

                            @endif

                        </div>

                        <p class="mt-3 line-clamp-2 flex-1 text-sm leading-6 text-gray-500">
                            {{
                                $product->short_description
                                    ?: 'Produk minyak kelapa murni dari UMKM Maloppo.'
                            }}
                        </p>

                        <div class="mt-5 border-t border-gray-100 pt-4">

                            <div class="flex items-end justify-between gap-3">

                                <div>
                                    <p class="text-xs text-gray-500">
                                        Harga
                                    </p>

                                    <p class="mt-1 text-xl font-bold text-red-700">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </p>
                                </div>

                                <div class="text-right">
                                    <p class="text-xs text-gray-500">
                                        Stok
                                    </p>

                                    @if ($product->stock > 0)

                                        <p class="mt-1 text-sm font-semibold text-green-700">
                                            {{ $product->stock }}
                                        </p>

                                    @else

                                        <p class="mt-1 text-sm font-semibold text-red-700">
                                            Habis
                                        </p>

                                    @endif
                                </div>

                            </div>

                        </div>

                        {{-- Aksi --}}
                        <div class="mt-5 space-y-2">

                            <a
                                href="{{ route('catalog.show', $product->slug) }}"
                                class="inline-flex w-full items-center justify-center rounded-lg border border-red-200 px-4 py-3 text-sm font-semibold text-red-700 transition hover:bg-red-50"
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
                                            class="inline-flex w-full items-center justify-center rounded-lg bg-red-700 px-4 py-3 text-sm font-semibold text-white transition hover:bg-red-800"
                                        >
                                            Tambah ke Keranjang
                                        </button>

                                    </form>

                                @else

                                    <button
                                        type="button"
                                        disabled
                                        class="inline-flex w-full cursor-not-allowed items-center justify-center rounded-lg bg-gray-100 px-4 py-3 text-sm font-semibold text-gray-500"
                                    >
                                        Stok Habis
                                    </button>

                                @endif

                            @else

                                <p class="rounded-lg bg-gray-50 px-3 py-3 text-center text-xs text-gray-500">
                                    Pemesanan tersedia untuk pengunjung.
                                </p>

                            @endguest

                        </div>

                    </div>

                </article>

            @empty

                <div class="w-full rounded-2xl border border-gray-200 bg-white px-5 py-14 text-center">
                    <p class="font-semibold text-gray-700">
                        Produk belum tersedia
                    </p>

                    <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-gray-500">
                        Produk minyak kelapa UMKM Maloppo akan segera ditambahkan.
                    </p>
                </div>

            @endforelse

        </div>

        {{-- Pagination --}}
        @if ($products->hasPages())

            <div class="mt-10 rounded-2xl border border-gray-200 bg-white px-5 py-4">
                {{ $products->links() }}
            </div>

        @endif

    </main>

    {{-- Informasi singkat --}}
    <section class="bg-yellow-50">

        <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">

                <div class="rounded-2xl border border-yellow-200 bg-white p-6 shadow-sm">
                    <h2 class="text-base font-bold text-gray-900">
                        Kelapa Pilihan
                    </h2>

                    <p class="mt-2 text-sm leading-6 text-gray-600">
                        Bahan baku dipilih sebelum memasuki proses pengolahan.
                    </p>
                </div>

                <div class="rounded-2xl border border-yellow-200 bg-white p-6 shadow-sm">
                    <h2 class="text-base font-bold text-gray-900">
                        Proses Terjaga
                    </h2>

                    <p class="mt-2 text-sm leading-6 text-gray-600">
                        Produk diolah melalui proses yang bersih dan terkontrol.
                    </p>
                </div>

                <div class="rounded-2xl border border-yellow-200 bg-white p-6 shadow-sm">
                    <h2 class="text-base font-bold text-gray-900">
                        Pemesanan Mudah
                    </h2>

                    <p class="mt-2 text-sm leading-6 text-gray-600">
                        Pilih produk, masukkan ke keranjang, lalu isi data checkout.
                    </p>
                </div>

            </div>

        </div>

    </section>

    {{-- Footer --}}
    {{-- <footer class="border-t border-gray-200 bg-white">

        <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 gap-8 md:grid-cols-2 md:items-center">

                <div>

                    <div
                        class="flex h-14 w-32 items-center justify-center overflow-hidden rounded-lg border border-gray-200 bg-gray-50"
                    >
                        <img
                            src="{{ asset('images/brand/logo-maloppo-wordmark.jpg') }}"
                            alt="Logo UMKM Maloppo"
                            class="h-full w-full object-contain"
                        >
                    </div>

                    <p class="mt-4 text-sm font-semibold text-gray-900">
                        UMKM Maloppo
                    </p>

                    <p class="mt-1 max-w-sm text-xs leading-5 text-gray-500">
                        Produk minyak kelapa murni dari kelapa pilihan.
                    </p>

                </div>

                <div class="md:text-right">

                    <p class="text-sm font-semibold text-gray-900">
                        Hubungi dan ikuti Maloppo
                    </p>

                    <p class="mt-1 text-xs text-gray-500">
                        Dapatkan informasi produk dan kegiatan terbaru.
                    </p>

                    <div class="mt-4 md:flex md:justify-end">
                        <x-social-media />
                    </div>

                </div>

            </div>

            <div
                class="mt-8 flex flex-col gap-2 border-t border-gray-200 pt-5 text-xs text-gray-500 sm:flex-row sm:items-center sm:justify-between"
            >
                <p>
                    &copy; {{ date('Y') }} UMKM Maloppo.
                </p>

                <a
                    href="{{ route('home') }}"
                    class="font-medium text-gray-600 hover:text-red-700"
                >
                    Kembali ke Beranda
                </a>
            </div>

        </div>

    </footer> --}}
    <x-public-footer />

</body>

</html>