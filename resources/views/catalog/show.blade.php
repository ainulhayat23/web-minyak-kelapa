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
        content="{{ $product->short_description ?: 'Produk minyak kelapa murni berkualitas dari UMKM Maloppo.' }}"
    >

    <title>{{ $product->name }} | UMKM Maloppo</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-maloppo-page text-gray-900">

    {{-- Navigasi --}}
    <x-public-navbar />

    {{-- Header halaman --}}
    <header class="border-b border-gray-200 bg-white">

        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">

            <a
                href="{{ route('catalog.index') }}"
                class="inline-flex items-center text-sm font-medium text-gray-600 transition hover:text-red-700"
            >
                <span class="mr-2" aria-hidden="true">←</span>
                Kembali ke katalog
            </a>

            <div class="mt-5">

                <p class="text-sm font-semibold uppercase tracking-wider text-red-700">
                    Detail Produk
                </p>

                <h1 class="mt-2 max-w-3xl text-3xl font-semibold tracking-tight text-gray-900 sm:text-4xl">
                    {{ $product->name }}
                </h1>

                <p class="mt-3 max-w-2xl text-sm leading-6 text-gray-600 sm:text-base">
                    Lihat informasi harga, ukuran, stok, deskripsi, dan komposisi produk.
                </p>

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

        {{-- Detail produk --}}
        <section
            class="grid grid-cols-1 gap-8 rounded-xl border border-gray-200 bg-white p-4 sm:p-6 lg:grid-cols-2 lg:gap-10 lg:p-8"
        >

            {{-- Gambar produk --}}
            <div>

                <div
                    class="flex min-h-80 items-center justify-center overflow-hidden rounded-xl border border-gray-200 bg-gray-50 sm:min-h-96"
                >

                    @if ($product->image)

                        <img
                            src="{{ asset('storage/' . $product->image) }}"
                            alt="{{ $product->name }}"
                            class="h-full min-h-80 w-full object-cover sm:min-h-96"
                        >

                    @else

                        <p class="px-6 text-center text-sm text-gray-400">
                            Gambar produk belum tersedia
                        </p>

                    @endif

                </div>

                {{-- Informasi singkat --}}
                <div
                    class="mt-4 grid grid-cols-2 gap-4 rounded-lg border border-gray-200 bg-gray-50 p-4"
                >

                    <div>

                        <p class="text-xs text-gray-500">
                            Ukuran
                        </p>

                        <p class="mt-1 text-sm font-medium text-gray-900">
                            {{ $product->size ?: '-' }}
                        </p>

                    </div>

                    <div>

                        <p class="text-xs text-gray-500">
                            Ketersediaan
                        </p>

                        @if ($product->stock > 0)

                            <p class="mt-1 text-sm font-medium text-green-700">
                                {{ $product->stock }} produk
                            </p>

                        @else

                            <p class="mt-1 text-sm font-medium text-red-700">
                                Stok habis
                            </p>

                        @endif

                    </div>

                </div>

            </div>

            {{-- Informasi produk --}}
            <div class="flex flex-col">

                <div>

                    <p class="text-sm font-medium text-red-700">
                        Minyak Kelapa Maloppo
                    </p>

                    <h2 class="mt-2 text-2xl font-semibold leading-tight text-gray-900 sm:text-3xl">
                        {{ $product->name }}
                    </h2>

                    @if ($product->short_description)

                        <p class="mt-4 text-sm leading-7 text-gray-600 sm:text-base">
                            {{ $product->short_description }}
                        </p>

                    @endif

                </div>

                {{-- Harga --}}
                <div class="mt-6 border-y border-gray-200 py-5">

                    <p class="text-sm text-gray-500">
                        Harga Produk
                    </p>

                    <p class="mt-1 text-3xl font-semibold text-red-700">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </p>

                    <div class="mt-3">

                        @if ($product->stock > 0)

                            <span
                                class="inline-flex rounded-full bg-green-50 px-2.5 py-1 text-xs font-medium text-green-700"
                            >
                                Stok tersedia
                            </span>

                        @else

                            <span
                                class="inline-flex rounded-full bg-red-50 px-2.5 py-1 text-xs font-medium text-red-700"
                            >
                                Stok habis
                            </span>

                        @endif

                    </div>

                </div>

                {{-- Deskripsi dan komposisi --}}
                <div class="mt-6 space-y-3">

                    <div
                        x-data="{ open: true }"
                        class="overflow-hidden rounded-lg border border-gray-200"
                    >

                        <button
                            type="button"
                            class="flex w-full items-center justify-between gap-4 bg-gray-50 px-4 py-3 text-left"
                            @click="open = !open"
                        >
                            <span class="text-sm font-semibold text-gray-900">
                                Deskripsi Produk
                            </span>

                            <span
                                class="text-lg text-gray-500"
                                x-text="open ? '−' : '+'"
                            ></span>
                        </button>

                        <div
                            x-show="open"
                            x-collapse
                            class="border-t border-gray-200 px-4 py-4"
                        >
                            <p class="whitespace-pre-line text-sm leading-7 text-gray-600">{{ $product->description ?: 'Deskripsi lengkap produk belum tersedia.' }}</p>
                        </div>

                    </div>

                    <div
                        x-data="{ open: false }"
                        class="overflow-hidden rounded-lg border border-gray-200"
                    >

                        <button
                            type="button"
                            class="flex w-full items-center justify-between gap-4 bg-gray-50 px-4 py-3 text-left"
                            @click="open = !open"
                        >
                            <span class="text-sm font-semibold text-gray-900">
                                Komposisi
                            </span>

                            <span
                                class="text-lg text-gray-500"
                                x-text="open ? '−' : '+'"
                            ></span>
                        </button>

                        <div
                            x-show="open"
                            x-collapse
                            class="border-t border-gray-200 px-4 py-4"
                        >
                            <p class="whitespace-pre-line text-sm leading-7 text-gray-600">{{ $product->composition ?: 'Informasi komposisi belum tersedia.' }}</p>
                        </div>

                    </div>

                </div>

                {{-- Pemesanan --}}
                <div class="mt-6 border-t border-gray-200 pt-6">

                    @if ($product->stock > 0)

                        @guest

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

                            <a
                                href="{{ route('cart.index') }}"
                                class="btn-maloppo-secondary mt-3 w-full"
                            >
                                Lihat Keranjang
                            </a>

                            <p class="mt-3 text-xs leading-5 text-gray-500">
                                Jumlah produk dapat diubah kembali pada halaman keranjang.
                            </p>

                        @else

                            <div class="rounded-lg border border-gray-200 bg-gray-50 p-4">

                                <p class="text-sm font-medium text-gray-900">
                                    Pemesanan tersedia untuk pengunjung
                                </p>

                                <p class="mt-1 text-xs leading-5 text-gray-500">
                                    Anda sedang masuk menggunakan akun administrator.
                                </p>

                            </div>

                            <a
                                href="{{ route('dashboard') }}"
                                class="btn-maloppo-secondary mt-3 w-full"
                            >
                                Kembali ke Dashboard
                            </a>

                        @endguest

                    @else

                        <div class="rounded-lg border border-red-200 bg-red-50 p-4 text-center">

                            <p class="text-sm font-semibold text-red-800">
                                Stok produk sedang habis
                            </p>

                            <p class="mt-1 text-xs leading-5 text-red-700">
                                Silakan pilih produk lain yang masih tersedia.
                            </p>

                        </div>

                        <a
                            href="{{ route('catalog.index') }}"
                            class="btn-maloppo-secondary mt-3 w-full"
                        >
                            Pilih Produk Lain
                        </a>

                    @endif

                </div>

            </div>

        </section>

        {{-- Informasi keunggulan --}}
        <section
            class="mt-8 grid grid-cols-1 gap-6 border-y border-gray-200 py-8 sm:grid-cols-3"
        >

            <div>

                <h3 class="text-sm font-semibold text-gray-900">
                    Kelapa Pilihan
                </h3>

                <p class="mt-1 text-xs leading-5 text-gray-500">
                    Bahan baku dipilih sebelum proses pengolahan.
                </p>

            </div>

            <div>

                <h3 class="text-sm font-semibold text-gray-900">
                    Proses Terjaga
                </h3>

                <p class="mt-1 text-xs leading-5 text-gray-500">
                    Produksi dilakukan secara bersih untuk menjaga mutu produk.
                </p>

            </div>

            <div>

                <h3 class="text-sm font-semibold text-gray-900">
                    Kemasan Praktis
                </h3>

                <p class="mt-1 text-xs leading-5 text-gray-500">
                    Produk dikemas agar mudah digunakan dan disimpan.
                </p>

            </div>

        </section>

        <div class="mt-8 text-center">

            <a
                href="{{ route('catalog.index') }}"
                class="text-sm font-semibold text-red-700 transition hover:text-red-900"
            >
                Lihat produk Maloppo lainnya
            </a>

        </div>

    </main>

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
                    href="{{ route('catalog.index') }}"
                    class="font-medium text-gray-600 hover:text-red-700"
                >
                    Kembali ke Katalog
                </a>
            </div>

        </div>

    </footer>

</body>

</html>