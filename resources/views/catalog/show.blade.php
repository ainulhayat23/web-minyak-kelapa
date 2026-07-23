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

<body class="bg-white text-gray-900">

    {{-- Navigasi --}}
    <x-public-navbar />

    {{-- Header halaman --}}
    <header class="relative overflow-hidden bg-gradient-to-br from-red-700 via-red-600 to-yellow-500">

        <div class="absolute inset-0 bg-black/10"></div>

        <div class="relative mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8 lg:py-16">

            <a
                href="{{ route('catalog.index') }}"
                class="inline-flex items-center rounded-full bg-white/15 px-4 py-2 text-sm font-semibold text-white transition hover:bg-white/25"
            >
                <span class="mr-2" aria-hidden="true">←</span>
                Kembali ke katalog
            </a>

            <div class="mt-8 max-w-3xl text-white">

                <p class="text-sm font-semibold uppercase tracking-[0.25em] text-yellow-100">
                    Detail Produk
                </p>

                <h1 class="mt-4 text-4xl font-bold leading-tight tracking-tight sm:text-5xl">
                    {{ $product->name }}
                </h1>

                <p class="mt-5 text-base leading-8 text-red-50">
                    Lihat informasi lengkap produk minyak kelapa Maloppo,
                    mulai dari harga, ukuran, stok, deskripsi, hingga komposisi produk.
                </p>

            </div>

        </div>

    </header>

    <main class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8 lg:py-16">

        {{-- Notifikasi berhasil --}}
        @if (session('success'))

            <div class="mb-8 rounded-2xl border border-green-200 bg-green-50 px-5 py-4 text-sm text-green-800 sm:flex sm:items-center sm:justify-between">

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

        {{-- Detail produk --}}
        <section class="grid grid-cols-1 gap-10 rounded-3xl border border-gray-200 bg-white p-5 shadow-sm sm:p-6 lg:grid-cols-2 lg:p-8">

            {{-- Gambar produk --}}
            <div>

                <div class="flex min-h-[420px] items-center justify-center overflow-hidden rounded-3xl border border-yellow-200 bg-yellow-50 p-6">

                    @if ($product->image)

                        <img
                            src="{{ asset('storage/' . $product->image) }}"
                            alt="{{ $product->name }}"
                            class="max-h-[520px] w-auto max-w-full object-contain"
                        >

                    @else

                        <p class="px-6 text-center text-sm text-gray-400">
                            Gambar produk belum tersedia
                        </p>

                    @endif

                </div>

                {{-- Informasi singkat --}}
                <div class="mt-5 grid grid-cols-1 gap-4 sm:grid-cols-2">

                    <div class="rounded-2xl border border-red-100 bg-red-50 p-5">

                        <p class="text-xs font-semibold uppercase tracking-wider text-red-700">
                            Ukuran
                        </p>

                        <p class="mt-2 text-lg font-bold text-gray-900">
                            {{ $product->size ?: '-' }}
                        </p>

                    </div>

                    <div class="rounded-2xl border border-yellow-200 bg-yellow-50 p-5">

                        <p class="text-xs font-semibold uppercase tracking-wider text-red-700">
                            Ketersediaan
                        </p>

                        @if ($product->stock > 0)

                            <p class="mt-2 text-lg font-bold text-green-700">
                                {{ $product->stock }} produk
                            </p>

                        @else

                            <p class="mt-2 text-lg font-bold text-red-700">
                                Stok habis
                            </p>

                        @endif

                    </div>

                </div>

            </div>

            {{-- Informasi produk --}}
            <div class="flex flex-col">

                <div>

                    <p class="text-sm font-semibold uppercase tracking-[0.20em] text-red-700">
                        Minyak Kelapa Maloppo
                    </p>

                    <h2 class="mt-4 text-3xl font-bold leading-tight text-gray-900 sm:text-4xl">
                        {{ $product->name }}
                    </h2>

                    @if ($product->short_description)

                        <p class="mt-5 text-base leading-8 text-gray-600">
                            {{ $product->short_description }}
                        </p>

                    @else

                        <p class="mt-5 text-base leading-8 text-gray-600">
                            Produk minyak kelapa murni dari UMKM Maloppo yang
                            diolah dari kelapa pilihan dengan proses yang bersih dan terjaga.
                        </p>

                    @endif

                </div>

                {{-- Harga --}}
                <div class="mt-7 rounded-3xl border border-red-100 bg-red-50 p-6">

                    <p class="text-sm font-semibold text-gray-600">
                        Harga Produk
                    </p>

                    <p class="mt-2 text-4xl font-bold tracking-tight text-red-700">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </p>

                    <div class="mt-4">

                        @if ($product->stock > 0)

                            <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                Stok tersedia
                            </span>

                        @else

                            <span class="inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                                Stok habis
                            </span>

                        @endif

                    </div>

                </div>

                {{-- Deskripsi dan komposisi --}}
                <div class="mt-6 space-y-4">

                    <details
                        open
                        class="overflow-hidden rounded-2xl border border-gray-200 bg-white"
                    >

                        <summary class="cursor-pointer bg-gray-50 px-5 py-4 text-sm font-bold text-gray-900">
                            Deskripsi Produk
                        </summary>

                        <div class="border-t border-gray-200 px-5 py-5">
                            <p class="whitespace-pre-line text-sm leading-7 text-gray-600">{{ $product->description ?: 'Deskripsi lengkap produk belum tersedia.' }}</p>
                        </div>

                    </details>

                    <details class="overflow-hidden rounded-2xl border border-gray-200 bg-white">

                        <summary class="cursor-pointer bg-gray-50 px-5 py-4 text-sm font-bold text-gray-900">
                            Komposisi
                        </summary>

                        <div class="border-t border-gray-200 px-5 py-5">
                            <p class="whitespace-pre-line text-sm leading-7 text-gray-600">{{ $product->composition ?: 'Informasi komposisi belum tersedia.' }}</p>
                        </div>

                    </details>

                </div>

                {{-- Pemesanan --}}
                <div class="mt-7 border-t border-gray-200 pt-6">

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
                                    class="inline-flex w-full items-center justify-center rounded-lg bg-red-700 px-5 py-3 text-sm font-semibold text-white transition hover:bg-red-800"
                                >
                                    Tambah ke Keranjang
                                </button>

                            </form>

                            <a
                                href="{{ route('cart.index') }}"
                                class="mt-3 inline-flex w-full items-center justify-center rounded-lg border border-red-200 px-5 py-3 text-sm font-semibold text-red-700 transition hover:bg-red-50"
                            >
                                Lihat Keranjang
                            </a>

                            <p class="mt-3 text-xs leading-5 text-gray-500">
                                Jumlah produk dapat diubah kembali pada halaman keranjang.
                            </p>

                        @else

                            <div class="rounded-2xl border border-gray-200 bg-gray-50 p-5">

                                <p class="text-sm font-bold text-gray-900">
                                    Pemesanan tersedia untuk pengunjung
                                </p>

                                <p class="mt-1 text-xs leading-5 text-gray-500">
                                    Anda sedang masuk menggunakan akun administrator.
                                </p>

                            </div>

                            <a
                                href="{{ route('dashboard') }}"
                                class="mt-3 inline-flex w-full items-center justify-center rounded-lg border border-red-200 px-5 py-3 text-sm font-semibold text-red-700 transition hover:bg-red-50"
                            >
                                Kembali ke Dashboard
                            </a>

                        @endguest

                    @else

                        <div class="rounded-2xl border border-red-200 bg-red-50 p-5 text-center">

                            <p class="text-sm font-bold text-red-800">
                                Stok produk sedang habis
                            </p>

                            <p class="mt-1 text-xs leading-5 text-red-700">
                                Silakan pilih produk lain yang masih tersedia.
                            </p>

                        </div>

                        <a
                            href="{{ route('catalog.index') }}"
                            class="mt-3 inline-flex w-full items-center justify-center rounded-lg border border-red-200 px-5 py-3 text-sm font-semibold text-red-700 transition hover:bg-red-50"
                        >
                            Pilih Produk Lain
                        </a>

                    @endif

                </div>

            </div>

        </section>

        {{-- Informasi keunggulan --}}
        <section class="mt-12 rounded-3xl bg-yellow-50 px-6 py-10">

            <div class="mx-auto max-w-3xl text-center">

                <p class="text-sm font-semibold uppercase tracking-[0.25em] text-red-700">
                    Keunggulan Produk
                </p>

                <h2 class="mt-4 text-3xl font-bold tracking-tight text-gray-900">
                    Produk lokal dari kelapa pilihan.
                </h2>

            </div>

            <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-3">

                <div class="rounded-2xl border border-yellow-200 bg-white p-6 shadow-sm">

                    <h3 class="text-base font-bold text-gray-900">
                        Kelapa Pilihan
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-gray-600">
                        Bahan baku dipilih sebelum proses pengolahan.
                    </p>

                </div>

                <div class="rounded-2xl border border-yellow-200 bg-white p-6 shadow-sm">

                    <h3 class="text-base font-bold text-gray-900">
                        Proses Terjaga
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-gray-600">
                        Produksi dilakukan secara bersih untuk menjaga mutu produk.
                    </p>

                </div>

                <div class="rounded-2xl border border-yellow-200 bg-white p-6 shadow-sm">

                    <h3 class="text-base font-bold text-gray-900">
                        Kemasan Praktis
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-gray-600">
                        Produk dikemas agar mudah digunakan dan disimpan.
                    </p>

                </div>

            </div>

        </section>

        <div class="mt-10 text-center">

            <a
                href="{{ route('catalog.index') }}"
                class="inline-flex items-center justify-center rounded-lg bg-red-700 px-5 py-3 text-sm font-semibold text-white transition hover:bg-red-800"
            >
                Lihat Produk Maloppo Lainnya
            </a>

        </div>

    </main>

    {{-- Footer --}}
   <x-public-footer />

</body>

</html>