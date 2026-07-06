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
        content="UMKM Maloppo menyediakan produk minyak kelapa murni dari kelapa pilihan."
    >

    <title>UMKM Maloppo | Minyak Kelapa Murni</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-maloppo-page text-gray-900">

    {{-- Navigasi --}}
    <x-public-navbar />

    <main>

        {{-- Hero --}}
        <section class="hero-maloppo overflow-hidden">

            <div
                class="mx-auto grid max-w-7xl grid-cols-1 items-center gap-12 px-6 py-16 lg:grid-cols-2 lg:py-24"
            >

                {{-- Teks hero --}}
                <div>

                    <span class="label-maloppo">
                        Produk UMKM Lokal
                    </span>

                    <h1
                        class="mt-6 text-4xl font-extrabold leading-tight text-gray-900 md:text-5xl lg:text-6xl"
                    >
                        Minyak Kelapa Murni dari
                        <span class="text-maloppo-red">
                            UMKM Maloppo
                        </span>
                    </h1>

                    <p class="mt-6 max-w-xl text-lg leading-8 text-gray-600">
                        Produk minyak kelapa murni yang diolah dari kelapa
                        pilihan melalui proses yang bersih, terjaga, dan
                        berkualitas.
                    </p>

                    <div class="mt-8 flex flex-col gap-3 sm:flex-row">

                        <a
                            href="{{ route('catalog.index') }}"
                            class="btn-maloppo-primary px-7 py-3.5"
                        >
                            <span>
                                Lihat Produk
                            </span>

                            <span aria-hidden="true">
                                →
                            </span>
                        </a>

                        <a
                            href="#tentang"
                            class="btn-maloppo-secondary px-7 py-3.5"
                        >
                            Tentang Maloppo
                        </a>

                    </div>

                    {{-- Informasi singkat --}}
                    <div
                        class="mt-10 grid max-w-xl grid-cols-1 gap-4 sm:grid-cols-3"
                    >

                        <div class="flex items-center gap-3">
                            <div
                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full"
                                style="
                                    background-color: #f7e900;
                                    color: #990100;
                                "
                            >
                                ✓
                            </div>

                            <p class="text-sm font-semibold text-gray-700">
                                Kelapa pilihan
                            </p>
                        </div>

                        <div class="flex items-center gap-3">
                            <div
                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full"
                                style="
                                    background-color: #f7e900;
                                    color: #990100;
                                "
                            >
                                ✓
                            </div>

                            <p class="text-sm font-semibold text-gray-700">
                                Proses bersih
                            </p>
                        </div>

                        <div class="flex items-center gap-3">
                            <div
                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full"
                                style="
                                    background-color: #f7e900;
                                    color: #990100;
                                "
                            >
                                ✓
                            </div>

                            <p class="text-sm font-semibold text-gray-700">
                                Produk lokal
                            </p>
                        </div>

                    </div>

                </div>

                {{-- Visual hero --}}
                <div class="relative">

                    <div
                        class="absolute -right-8 -top-8 h-36 w-36 rounded-full opacity-60"
                        style="background-color: #f7e900;"
                    ></div>

                    <div
                        class="absolute -bottom-10 -left-10 h-44 w-44 rounded-full opacity-10"
                        style="background-color: #be0000;"
                    ></div>

                    <div
                        class="relative overflow-hidden rounded-3xl border-4 bg-white p-6 shadow-xl sm:p-10"
                        style="border-color: #f7e900;"
                    >

                        <div
                            class="flex min-h-96 items-center justify-center overflow-hidden rounded-2xl"
                            style="background-color: #f7e900;"
                        >
                            <img
                                src="{{ asset('images/brand/logo-maloppo-full.jpg') }}"
                                alt="Logo resmi UMKM Maloppo"
                                class="h-full max-h-96 w-full object-contain"
                            >
                        </div>

                        <div
                            class="absolute bottom-5 left-1/2 w-[85%] -translate-x-1/2 rounded-2xl bg-white/95 px-5 py-4 text-center shadow-lg backdrop-blur"
                        >
                            <p class="font-bold text-gray-900">
                                Alami, Bersih, dan Berkualitas
                            </p>

                            <p class="mt-1 text-xs text-gray-500">
                                Produk lokal dari kelapa pilihan
                            </p>
                        </div>

                    </div>

                </div>

            </div>

        </section>

        {{-- Keunggulan --}}
        <section class="border-y bg-white">
            <div
                class="mx-auto grid max-w-7xl grid-cols-1 gap-6 px-6 py-14 md:grid-cols-3"
            >

                <article class="card-maloppo card-maloppo-hover p-6">

                    <div
                        class="mb-5 flex h-14 w-14 items-center justify-center rounded-2xl text-2xl"
                        style="
                            background-color: #fff9b0;
                            color: #990100;
                        "
                    >
                        🥥
                    </div>

                    <h2 class="text-lg font-bold text-gray-900">
                        Kelapa Pilihan
                    </h2>

                    <p class="mt-3 text-sm leading-7 text-gray-600">
                        Bahan baku dipilih terlebih dahulu sebelum memasuki
                        proses pengolahan.
                    </p>

                </article>

                <article class="card-maloppo card-maloppo-hover p-6">

                    <div
                        class="mb-5 flex h-14 w-14 items-center justify-center rounded-2xl text-2xl"
                        style="
                            background-color: #fff9b0;
                            color: #990100;
                        "
                    >
                        ✨
                    </div>

                    <h2 class="text-lg font-bold text-gray-900">
                        Proses Terjaga
                    </h2>

                    <p class="mt-3 text-sm leading-7 text-gray-600">
                        Proses produksi dilakukan secara bersih untuk menjaga
                        mutu dan kualitas produk.
                    </p>

                </article>

                <article class="card-maloppo card-maloppo-hover p-6">

                    <div
                        class="mb-5 flex h-14 w-14 items-center justify-center rounded-2xl text-2xl"
                        style="
                            background-color: #fff9b0;
                            color: #990100;
                        "
                    >
                        📦
                    </div>

                    <h2 class="text-lg font-bold text-gray-900">
                        Kemasan Praktis
                    </h2>

                    <p class="mt-3 text-sm leading-7 text-gray-600">
                        Produk tersedia dalam beberapa ukuran yang dapat
                        dipilih sesuai kebutuhan pelanggan.
                    </p>

                </article>

            </div>
        </section>

        {{-- Produk unggulan --}}
        <section class="section-maloppo-soft">

            <div class="mx-auto max-w-7xl px-6 py-16 lg:py-20">

                <div
                    class="mb-10 flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between"
                >

                    <div>
                        <span class="label-maloppo">
                            Produk Kami
                        </span>

                        <h2 class="mt-4 text-3xl font-extrabold text-gray-900">
                            Produk Minyak Kelapa Maloppo
                        </h2>

                        <p class="mt-3 max-w-2xl leading-7 text-gray-600">
                            Pilih ukuran produk minyak kelapa sesuai dengan
                            kebutuhan Anda.
                        </p>
                    </div>

                    <a
                        href="{{ route('catalog.index') }}"
                        class="inline-flex items-center gap-2 text-sm font-bold text-maloppo-red"
                    >
                        Lihat semua produk

                        <span aria-hidden="true">
                            →
                        </span>
                    </a>

                </div>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">

                    @forelse ($featuredProducts as $product)

                        <article
                            class="card-maloppo card-maloppo-hover overflow-hidden"
                        >

                            {{-- Gambar produk --}}
                            <a
                                href="{{ route('catalog.show', $product->slug) }}"
                                class="relative block"
                            >

                                <div
                                    class="flex h-56 items-center justify-center overflow-hidden"
                                    style="background-color: #fffdf0;"
                                >
                                    @if ($product->image)

                                        <img
                                            src="{{ asset('storage/' . $product->image) }}"
                                            alt="{{ $product->name }}"
                                            class="h-full w-full object-cover transition duration-300 hover:scale-105"
                                        >

                                    @else

                                        <div class="px-5 text-center">
                                            <div class="text-5xl">
                                                🥥
                                            </div>

                                            <p class="mt-3 text-sm text-gray-400">
                                                Gambar produk belum tersedia
                                            </p>
                                        </div>

                                    @endif
                                </div>

                                {{-- Status stok --}}
                                <div class="absolute left-4 top-4">

                                    @if ($product->stock > 0)

                                        <span
                                            class="inline-flex rounded-full px-3 py-1 text-xs font-bold"
                                            style="
                                                background-color: #dcfce7;
                                                color: #166534;
                                            "
                                        >
                                            Stok tersedia
                                        </span>

                                    @else

                                        <span
                                            class="inline-flex rounded-full px-3 py-1 text-xs font-bold"
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
                            <div class="p-5">

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

                                <p class="mt-3 line-clamp-2 text-sm leading-6 text-gray-500">
                                    {{ $product->short_description ?: 'Produk minyak kelapa murni berkualitas dari UMKM Maloppo.' }}
                                </p>

                                <div class="mt-5 border-t pt-4">

                                    <p class="text-xs text-gray-500">
                                        Harga
                                    </p>

                                    <p class="mt-1 text-xl font-extrabold text-maloppo-red">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </p>

                                </div>

                                <a
                                    href="{{ route('catalog.show', $product->slug) }}"
                                    class="btn-maloppo-primary mt-5 w-full"
                                >
                                    Lihat Detail
                                </a>

                            </div>

                        </article>

                    @empty

                        <div
                            class="card-maloppo col-span-full px-6 py-16 text-center"
                        >
                            <div class="text-6xl">
                                📦
                            </div>

                            <h3 class="mt-5 text-lg font-bold text-gray-800">
                                Produk belum tersedia
                            </h3>

                            <p class="mt-2 text-sm text-gray-500">
                                Produk minyak kelapa Maloppo akan segera
                                ditambahkan.
                            </p>
                        </div>

                    @endforelse

                </div>

            </div>

        </section>

        {{-- Tentang Maloppo --}}
        <section id="tentang" class="bg-white">

            <div
                class="mx-auto grid max-w-7xl grid-cols-1 items-center gap-12 px-6 py-16 lg:grid-cols-2 lg:py-20"
            >

                {{-- Logo tentang --}}
                <div class="relative">

                    <div
                        class="absolute -left-6 -top-6 h-28 w-28 rounded-full opacity-20"
                        style="background-color: #be0000;"
                    ></div>

                    <div
                        class="relative overflow-hidden rounded-3xl border-4 p-8 shadow-lg"
                        style="
                            background-color: #f7e900;
                            border-color: #be0000;
                        "
                    >
                        <img
                            src="{{ asset('images/brand/logo-maloppo-full.jpg') }}"
                            alt="Identitas UMKM Maloppo"
                            class="mx-auto max-h-80 w-full object-contain"
                        >
                    </div>

                </div>

                {{-- Narasi tentang --}}
                <div>

                    <span class="label-maloppo">
                        Tentang Kami
                    </span>

                    <h2 class="mt-4 text-3xl font-extrabold text-gray-900">
                        UMKM Maloppo
                    </h2>

                    <p class="mt-5 leading-8 text-gray-600">
                        UMKM Maloppo merupakan usaha masyarakat yang mengolah
                        kelapa lokal menjadi produk minyak kelapa murni.
                        Bahan baku dipilih dan diolah melalui proses yang
                        terjaga untuk menghasilkan produk berkualitas.
                    </p>

                    <p class="mt-4 leading-8 text-gray-600">
                        Melalui pengolahan kelapa, Maloppo berupaya
                        meningkatkan nilai ekonomi bahan baku lokal sekaligus
                        menghadirkan produk yang dapat digunakan oleh
                        masyarakat.
                    </p>

                    <div
                        class="mt-7 rounded-2xl border-l-4 p-5"
                        style="
                            background-color: #fffdf0;
                            border-color: #be0000;
                        "
                    >
                        <p class="font-bold text-maloppo-red">
                            Produk lokal berkualitas
                        </p>

                        <p class="mt-2 text-sm leading-6 text-gray-600">
                            Website ini digunakan untuk memperkenalkan usaha,
                            menampilkan produk, membagikan kegiatan, dan
                            mempermudah pelanggan melakukan pemesanan.
                        </p>
                    </div>

                </div>

            </div>

        </section>

        {{-- Ajakan pemesanan --}}
        <section class="section-maloppo-red">

            <div
                class="mx-auto grid max-w-7xl grid-cols-1 items-center gap-8 px-6 py-16 lg:grid-cols-[1fr_auto]"
            >

                <div>
                    <span
                        class="inline-flex rounded-full px-4 py-2 text-xs font-bold uppercase tracking-widest"
                        style="
                            background-color: #f7e900;
                            color: #990100;
                        "
                    >
                        Produk Maloppo
                    </span>

                    <h2 class="mt-5 text-3xl font-extrabold text-white">
                        Temukan Produk Minyak Kelapa Kami
                    </h2>

                    <p class="mt-4 max-w-2xl leading-7 text-red-100">
                        Lihat informasi ukuran, harga, stok, dan lakukan
                        pemesanan melalui sistem keranjang serta checkout
                        yang tersedia.
                    </p>
                </div>

                <a
                    href="{{ route('catalog.index') }}"
                    class="btn-maloppo-yellow px-7 py-4"
                >
                    Buka Katalog Produk
                </a>

            </div>

        </section>

    </main>

    {{-- Footer --}}
    <footer class="border-t bg-white" style="border-color: #f1e7a4;">

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
                            alt="Logo Maloppo"
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