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
    <section class="hero-maloppo relative overflow-hidden">

        <div
            class="absolute -right-24 -top-24 h-64 w-64 rounded-full opacity-40"
            style="background-color: #f7e900;"
        ></div>

        <div
            class="absolute -bottom-28 -left-24 h-72 w-72 rounded-full opacity-10"
            style="background-color: #be0000;"
        ></div>

        <div class="relative mx-auto max-w-7xl px-6 py-12">

            <a
                href="{{ route('catalog.index') }}"
                class="inline-flex items-center gap-2 text-sm font-bold text-maloppo-red"
            >
                <span aria-hidden="true">
                    ←
                </span>

                Kembali ke katalog
            </a>

            <div class="mt-6">

                <span class="label-maloppo">
                    Detail Produk
                </span>

                <h1
                    class="mt-4 max-w-4xl text-3xl font-extrabold leading-tight text-gray-900 md:text-4xl"
                >
                    {{ $product->name }}
                </h1>

                <p class="mt-3 max-w-2xl leading-7 text-gray-600">
                    Informasi lengkap mengenai produk, ukuran, harga,
                    ketersediaan stok, dan komposisi produk Maloppo.
                </p>

            </div>

        </div>

    </section>

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

        {{-- Detail utama --}}
        <section
            class="card-maloppo grid grid-cols-1 gap-10 overflow-hidden p-6 lg:grid-cols-2 lg:p-10"
        >

            {{-- Gambar produk --}}
            <div class="relative">

                <div
                    class="relative flex min-h-96 items-center justify-center overflow-hidden rounded-3xl border"
                    style="
                        background-color: #fffdf0;
                        border-color: #f1e7a4;
                    "
                >

                    @if ($product->image)

                        <img
                            src="{{ asset('storage/' . $product->image) }}"
                            alt="{{ $product->name }}"
                            class="h-full min-h-96 w-full object-cover"
                        >

                    @else

                        <div class="px-8 py-20 text-center">

                            <div class="text-7xl">
                                🥥
                            </div>

                            <p class="mt-5 text-sm font-medium text-gray-400">
                                Gambar produk belum tersedia
                            </p>

                        </div>

                    @endif

                    {{-- Status stok --}}
                    <div class="absolute left-5 top-5">

                        @if ($product->stock > 0)

                            <span
                                class="inline-flex items-center gap-2 rounded-full px-4 py-2 text-xs font-bold shadow-sm"
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
                                class="inline-flex items-center rounded-full px-4 py-2 text-xs font-bold shadow-sm"
                                style="
                                    background-color: #fee2e2;
                                    color: #991b1b;
                                "
                            >
                                Stok habis
                            </span>

                        @endif

                    </div>

                </div>

                {{-- Identitas produk --}}
                <div
                    class="mt-5 flex items-center gap-4 rounded-2xl border p-4"
                    style="
                        background-color: #fff9b0;
                        border-color: #f7e900;
                    "
                >
                    <div
                        class="flex h-14 w-24 shrink-0 items-center justify-center overflow-hidden rounded-lg"
                        style="background-color: #f7e900;"
                    >
                        <img
                            src="{{ asset('images/brand/logo-maloppo-wordmark.jpg') }}"
                            alt="Logo Maloppo"
                            class="h-full w-full object-contain"
                        >
                    </div>

                    <div>
                        <p class="text-sm font-bold text-maloppo-red-dark">
                            Produk UMKM Maloppo
                        </p>

                        <p class="mt-1 text-xs leading-5 text-gray-600">
                            Diolah dari kelapa pilihan melalui proses yang
                            bersih dan terjaga.
                        </p>
                    </div>

                </div>

            </div>

            {{-- Informasi produk --}}
            <div class="flex flex-col">

                <div>

                    <span class="label-maloppo">
                        Minyak Kelapa Maloppo
                    </span>

                    <h2
                        class="mt-5 text-3xl font-extrabold leading-tight text-gray-900 md:text-4xl"
                    >
                        {{ $product->name }}
                    </h2>

                    @if ($product->size)

                        <span class="badge-maloppo-yellow mt-4">
                            Ukuran {{ $product->size }}
                        </span>

                    @endif

                </div>

                {{-- Harga dan stok --}}
                <div
                    class="mt-7 rounded-2xl border p-5"
                    style="
                        background-color: #fffdf0;
                        border-color: #f1e7a4;
                    "
                >

                    <div
                        class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between"
                    >

                        <div>
                            <p class="text-sm font-medium text-gray-500">
                                Harga Produk
                            </p>

                            <p class="mt-1 text-3xl font-extrabold text-maloppo-red">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </p>
                        </div>

                        <div class="sm:text-right">

                            <p class="text-sm text-gray-500">
                                Ketersediaan stok
                            </p>

                            @if ($product->stock > 0)

                                <p
                                    class="mt-1 text-lg font-bold"
                                    style="color: #166534;"
                                >
                                    {{ $product->stock }} produk
                                </p>

                            @else

                                <p
                                    class="mt-1 text-lg font-bold"
                                    style="color: #991b1b;"
                                >
                                    Stok sedang habis
                                </p>

                            @endif

                        </div>

                    </div>

                </div>

                {{-- Deskripsi singkat --}}
                @if ($product->short_description)

                    <div class="mt-7">

                        <p class="text-sm font-bold uppercase tracking-wider text-maloppo-red">
                            Ringkasan Produk
                        </p>

                        <p class="mt-3 leading-8 text-gray-600">
                            {{ $product->short_description }}
                        </p>

                    </div>

                @endif

                {{-- Informasi produk --}}
                <div class="mt-8 space-y-4">

                    {{-- Deskripsi lengkap --}}
                    <div
                        x-data="{ open: true }"
                        class="overflow-hidden rounded-2xl border"
                        style="border-color: #f1e7a4;"
                    >

                        <button
                            type="button"
                            class="flex w-full items-center justify-between gap-4 px-5 py-4 text-left"
                            style="background-color: #fffdf0;"
                            @click="open = ! open"
                        >
                            <span class="flex items-center gap-3">

                                <span
                                    class="flex h-9 w-9 items-center justify-center rounded-lg"
                                    style="
                                        background-color: #f7e900;
                                        color: #990100;
                                    "
                                >
                                    📄
                                </span>

                                <span class="font-bold text-gray-900">
                                    Deskripsi Produk
                                </span>

                            </span>

                            <span
                                class="font-bold text-maloppo-red"
                                x-text="open ? '−' : '+'"
                            ></span>
                        </button>

                        <div
                            x-show="open"
                            x-collapse
                            class="border-t px-5 py-5"
                            style="border-color: #f1e7a4;"
                        >
                            <p class="whitespace-pre-line leading-8 text-gray-600">
                                {{ $product->description ?: 'Deskripsi lengkap produk belum tersedia.' }}
                            </p>
                        </div>

                    </div>

                    {{-- Komposisi --}}
                    <div
                        x-data="{ open: true }"
                        class="overflow-hidden rounded-2xl border"
                        style="border-color: #f1e7a4;"
                    >

                        <button
                            type="button"
                            class="flex w-full items-center justify-between gap-4 px-5 py-4 text-left"
                            style="background-color: #fffdf0;"
                            @click="open = ! open"
                        >
                            <span class="flex items-center gap-3">

                                <span
                                    class="flex h-9 w-9 items-center justify-center rounded-lg"
                                    style="
                                        background-color: #f7e900;
                                        color: #990100;
                                    "
                                >
                                    🥥
                                </span>

                                <span class="font-bold text-gray-900">
                                    Komposisi
                                </span>

                            </span>

                            <span
                                class="font-bold text-maloppo-red"
                                x-text="open ? '−' : '+'"
                            ></span>
                        </button>

                        <div
                            x-show="open"
                            x-collapse
                            class="border-t px-5 py-5"
                            style="border-color: #f1e7a4;"
                        >
                            <p class="whitespace-pre-line leading-8 text-gray-600">
                                {{ $product->composition ?: 'Informasi komposisi belum tersedia.' }}
                            </p>
                        </div>

                    </div>

                </div>

                {{-- Bagian pemesanan --}}
                <div
                    class="mt-8 border-t pt-7"
                    style="border-color: #f1e7a4;"
                >

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
                                    class="btn-maloppo-primary w-full py-4 text-base"
                                >
                                    <span>
                                        🛒
                                    </span>

                                    Tambahkan ke Keranjang
                                </button>

                            </form>

                            <a
                                href="{{ route('cart.index') }}"
                                class="btn-maloppo-secondary mt-3 w-full py-4"
                            >
                                Lihat Keranjang
                            </a>

                            <div
                                class="mt-4 flex items-start gap-3 rounded-xl px-4 py-3"
                                style="
                                    background-color: #fff9b0;
                                    color: #713f12;
                                "
                            >
                                <span>
                                    ℹ️
                                </span>

                                <p class="text-xs leading-5">
                                    Produk akan dimasukkan ke keranjang.
                                    Jumlah produk masih dapat diubah sebelum
                                    melanjutkan ke proses checkout.
                                </p>
                            </div>

                        @else

                            <div
                                class="rounded-xl border px-5 py-5 text-center"
                                style="
                                    background-color: #fff9b0;
                                    border-color: #f7e900;
                                    color: #990100;
                                "
                            >
                                <p class="text-sm font-bold">
                                    Anda sedang masuk sebagai admin
                                </p>

                                <p class="mt-2 text-xs leading-5">
                                    Pemesanan produk hanya tersedia untuk
                                    pengunjung website.
                                </p>
                            </div>

                            <a
                                href="{{ route('dashboard') }}"
                                class="btn-maloppo-primary mt-3 w-full"
                            >
                                Kembali ke Dashboard
                            </a>

                        @endguest

                    @else

                        <div
                            class="rounded-xl border px-6 py-5 text-center"
                            style="
                                background-color: #fee2e2;
                                border-color: #fca5a5;
                                color: #991b1b;
                            "
                        >
                            <p class="font-bold">
                                Stok produk sedang habis
                            </p>

                            <p class="mt-2 text-xs leading-5">
                                Silakan pilih produk lain yang masih tersedia
                                di dalam katalog.
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

        {{-- Keunggulan --}}
        <section class="mt-10">

            <div class="grid grid-cols-1 gap-5 md:grid-cols-3">

                <article class="card-maloppo p-5">

                    <div
                        class="flex h-11 w-11 items-center justify-center rounded-xl text-xl"
                        style="background-color: #fff9b0;"
                    >
                        🥥
                    </div>

                    <h3 class="mt-4 font-bold text-gray-900">
                        Kelapa Pilihan
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-gray-500">
                        Menggunakan bahan baku kelapa yang dipilih sebelum
                        proses pengolahan.
                    </p>

                </article>

                <article class="card-maloppo p-5">

                    <div
                        class="flex h-11 w-11 items-center justify-center rounded-xl text-xl"
                        style="background-color: #fff9b0;"
                    >
                        ✨
                    </div>

                    <h3 class="mt-4 font-bold text-gray-900">
                        Proses Terjaga
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-gray-500">
                        Proses produksi dilakukan secara bersih untuk menjaga
                        mutu produk.
                    </p>

                </article>

                <article class="card-maloppo p-5">

                    <div
                        class="flex h-11 w-11 items-center justify-center rounded-xl text-xl"
                        style="background-color: #fff9b0;"
                    >
                        📦
                    </div>

                    <h3 class="mt-4 font-bold text-gray-900">
                        Kemasan Praktis
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-gray-500">
                        Produk dikemas agar lebih praktis digunakan dan
                        disimpan.
                    </p>

                </article>

            </div>

        </section>

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
                    Lihat produk Maloppo lainnya
                </h2>

                <p class="mt-2 max-w-2xl text-sm leading-7 text-red-100">
                    Temukan pilihan ukuran dan produk yang sesuai dengan
                    kebutuhan Anda.
                </p>

            </div>

            <a
                href="{{ route('catalog.index') }}"
                class="btn-maloppo-yellow whitespace-nowrap px-7 py-3.5"
            >
                Buka Katalog Produk
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