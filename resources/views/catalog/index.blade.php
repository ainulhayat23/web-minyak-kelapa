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

    {{-- Navigasi --}}
    <x-public-navbar />

    {{-- Pembuka --}}
    <header class="border-b border-gray-200 bg-white">

        <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8 lg:py-12">

            <div
                class="flex flex-col gap-6 md:flex-row md:items-end md:justify-between"
            >
                <div>

                    <p class="text-sm font-semibold uppercase tracking-wider text-red-700">
                        Katalog Produk
                    </p>

                    <h1 class="mt-2 text-3xl font-semibold tracking-tight text-gray-900 sm:text-4xl">
                        Produk Minyak Kelapa Maloppo
                    </h1>

                    <p class="mt-3 max-w-2xl text-sm leading-6 text-gray-600 sm:text-base">
                        Pilih ukuran dan jumlah produk sesuai kebutuhan Anda.
                        Informasi harga dan stok ditampilkan secara langsung.
                    </p>

                </div>

                @guest
                    @if ($cartQuantity > 0)

                        <a
                            href="{{ route('cart.index') }}"
                            class="btn-maloppo-primary shrink-0"
                        >
                            Keranjang · {{ $cartQuantity }} barang
                        </a>

                    @endif
                @endguest

            </div>

        </div>

    </header>

    <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8 lg:py-12">

        {{-- Notifikasi berhasil --}}
        @if (session('success'))

            <div
                class="alert-maloppo-success mb-6 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between"
            >
                <span>
                    {{ session('success') }}
                </span>

                @guest
                    <a
                        href="{{ route('cart.index') }}"
                        class="font-semibold underline"
                    >
                        Lihat Keranjang
                    </a>
                @endguest
            </div>

        @endif

        {{-- Notifikasi kesalahan --}}
        @if (session('error'))

            <div class="alert-maloppo-error mb-6">
                {{ session('error') }}
            </div>

        @endif

        {{-- Validasi --}}
        @if ($errors->any())

            <div class="alert-maloppo-error mb-6">

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

        {{-- Informasi daftar --}}
        <div
            class="mb-6 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between"
        >
            <div>

                <h2 class="text-lg font-semibold text-gray-900">
                    Produk Tersedia
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    {{ $products->total() }} produk ditemukan.
                </p>

            </div>

            @if ($products->hasPages())

                <p class="text-xs text-gray-500">
                    Halaman {{ $products->currentPage() }}
                    dari {{ $products->lastPage() }}
                </p>

            @endif
        </div>

        {{-- Grid produk --}}
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">

            @forelse ($products as $product)

                <article
                    class="flex h-full flex-col overflow-hidden rounded-xl border border-gray-200 bg-white"
                >

                    {{-- Gambar --}}
                    <a
                        href="{{ route('catalog.show', $product->slug) }}"
                        class="block"
                    >
                        <div
                            class="flex h-52 items-center justify-center overflow-hidden bg-gray-50"
                        >
                            @if ($product->image)

                                <img
                                    src="{{ asset('storage/' . $product->image) }}"
                                    alt="{{ $product->name }}"
                                    class="h-full w-full object-cover"
                                >

                            @else

                                <p class="px-4 text-center text-sm text-gray-400">
                                    Gambar belum tersedia
                                </p>

                            @endif
                        </div>
                    </a>

                    {{-- Informasi produk --}}
                    <div class="flex flex-1 flex-col p-4">

                        <div class="flex items-start justify-between gap-3">

                            <h2 class="line-clamp-2 text-sm font-semibold leading-5 text-gray-900">
                                {{ $product->name }}
                            </h2>

                            @if ($product->size)

                                <span
                                    class="shrink-0 rounded-full bg-gray-100 px-2.5 py-1 text-[10px] font-medium text-gray-600"
                                >
                                    {{ $product->size }}
                                </span>

                            @endif

                        </div>

                        <p class="mt-2 line-clamp-2 flex-1 text-xs leading-5 text-gray-500">
                            {{
                                $product->short_description
                                    ?: 'Produk minyak kelapa murni dari UMKM Maloppo.'
                            }}
                        </p>

                        <div
                            class="mt-4 flex items-end justify-between gap-3 border-t border-gray-100 pt-4"
                        >
                            <div>

                                <p class="text-xs text-gray-500">
                                    Harga
                                </p>

                                <p class="mt-1 text-base font-semibold text-red-700">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </p>

                            </div>

                            <div class="text-right">

                                <p class="text-xs text-gray-500">
                                    Stok
                                </p>

                                @if ($product->stock > 0)

                                    <p class="mt-1 text-sm font-medium text-green-700">
                                        {{ $product->stock }}
                                    </p>

                                @else

                                    <p class="mt-1 text-sm font-medium text-red-700">
                                        Habis
                                    </p>

                                @endif

                            </div>
                        </div>

                        {{-- Aksi --}}
                        <div class="mt-4 space-y-2">

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
                                            Tambah ke Keranjang
                                        </button>

                                    </form>

                                @else

                                    <button
                                        type="button"
                                        disabled
                                        class="inline-flex w-full cursor-not-allowed items-center justify-center rounded-lg bg-gray-100 px-4 py-2.5 text-sm font-medium text-gray-500"
                                    >
                                        Stok Habis
                                    </button>

                                @endif

                            @else

                                <p
                                    class="rounded-lg bg-gray-50 px-3 py-2.5 text-center text-xs text-gray-500"
                                >
                                    Pemesanan tersedia untuk pengunjung.
                                </p>

                            @endguest

                        </div>

                    </div>

                </article>

            @empty

                <div
                    class="col-span-full rounded-xl border border-gray-200 bg-white px-5 py-14 text-center"
                >
                    <p class="font-medium text-gray-700">
                        Produk belum tersedia
                    </p>

                    <p class="mx-auto mt-1 max-w-md text-sm leading-6 text-gray-500">
                        Produk minyak kelapa UMKM Maloppo akan segera ditambahkan.
                    </p>
                </div>

            @endforelse

        </div>

        {{-- Pagination --}}
        @if ($products->hasPages())

            <div class="mt-8 rounded-xl border border-gray-200 bg-white px-5 py-4">
                {{ $products->links() }}
            </div>

        @endif

    </main>

    {{-- Informasi singkat --}}
    <section class="border-y border-gray-200 bg-white">

        <div
            class="mx-auto grid max-w-7xl grid-cols-1 gap-6 px-4 py-10 sm:grid-cols-3 sm:px-6 lg:px-8"
        >

            <div>
                <h2 class="text-sm font-semibold text-gray-900">
                    Kelapa Pilihan
                </h2>

                <p class="mt-1 text-xs leading-5 text-gray-500">
                    Bahan baku dipilih sebelum memasuki proses pengolahan.
                </p>
            </div>

            <div>
                <h2 class="text-sm font-semibold text-gray-900">
                    Proses Terjaga
                </h2>

                <p class="mt-1 text-xs leading-5 text-gray-500">
                    Produk diolah melalui proses yang bersih dan terkontrol.
                </p>
            </div>

            <div>
                <h2 class="text-sm font-semibold text-gray-900">
                    Pemesanan Mudah
                </h2>

                <p class="mt-1 text-xs leading-5 text-gray-500">
                    Pilih produk, masukkan ke keranjang, lalu isi data checkout.
                </p>
            </div>

        </div>

    </section>

    {{-- Footer --}}
    <footer class="border-t border-gray-200 bg-white">

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

    </footer>

</body>

</html>