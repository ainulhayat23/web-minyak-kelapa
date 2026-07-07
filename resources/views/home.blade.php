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
        <section class="border-b border-gray-200 bg-white">

            <div
                class="mx-auto grid max-w-7xl grid-cols-1 items-center gap-10 px-4 py-14 sm:px-6 lg:grid-cols-2 lg:px-8 lg:py-20"
            >

                {{-- Teks --}}
                <div>

                    <p class="text-sm font-semibold uppercase tracking-wider text-red-700">
                        Produk UMKM Lokal
                    </p>

                    <h1
                        class="mt-4 max-w-xl text-4xl font-semibold leading-tight tracking-tight text-gray-900 sm:text-5xl"
                    >
                        Minyak kelapa murni dari UMKM Maloppo
                    </h1>

                    <p class="mt-5 max-w-xl text-base leading-7 text-gray-600 sm:text-lg">
                        Diolah dari kelapa pilihan melalui proses yang bersih
                        dan terjaga untuk menghasilkan produk berkualitas.
                    </p>

                    <div class="mt-7 flex flex-col gap-3 sm:flex-row">

                        <a
                            href="{{ route('catalog.index') }}"
                            class="btn-maloppo-primary"
                        >
                            Lihat Produk
                        </a>

                        <a
                            href="#tentang"
                            class="btn-maloppo-secondary"
                        >
                            Tentang Maloppo
                        </a>

                    </div>

                    {{-- Keunggulan ringkas --}}
                    <div
                        class="mt-9 grid max-w-xl grid-cols-1 gap-3 border-t border-gray-200 pt-6 sm:grid-cols-3"
                    >

                        <div>
                            <p class="text-sm font-medium text-gray-900">
                                Kelapa Pilihan
                            </p>

                            <p class="mt-1 text-xs leading-5 text-gray-500">
                                Bahan baku dipilih sebelum diolah.
                            </p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-900">
                                Proses Bersih
                            </p>

                            <p class="mt-1 text-xs leading-5 text-gray-500">
                                Produksi dilakukan secara terjaga.
                            </p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-900">
                                Produk Lokal
                            </p>

                            <p class="mt-1 text-xs leading-5 text-gray-500">
                                Mendukung nilai ekonomi kelapa lokal.
                            </p>
                        </div>

                    </div>

                </div>

                {{-- Visual --}}
                <div class="lg:pl-8">

                    <div
                        class="overflow-hidden rounded-2xl border border-gray-200 bg-gray-50 p-6 sm:p-8"
                    >
                        <div
                            class="flex min-h-72 items-center justify-center overflow-hidden rounded-xl bg-white"
                        >
                            <img
                                src="{{ asset('images/brand/logo-maloppo-full.jpg') }}"
                                alt="Logo resmi UMKM Maloppo"
                                class="max-h-80 w-full object-contain"
                            >
                        </div>

                        <div
                            class="mt-5 border-t border-gray-200 pt-5 text-center"
                        >
                            <p class="text-sm font-semibold text-gray-900">
                                Alami, bersih, dan berkualitas
                            </p>

                            <p class="mt-1 text-xs text-gray-500">
                                Produk minyak kelapa dari kelapa pilihan
                            </p>
                        </div>
                    </div>

                </div>

            </div>

        </section>

        {{-- Produk unggulan --}}
        <section class="bg-gray-50">

            <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8 lg:py-16">

                <div
                    class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between"
                >

                    <div>
                        <p class="text-sm font-semibold uppercase tracking-wider text-red-700">
                            Produk Kami
                        </p>

                        <h2 class="mt-2 text-2xl font-semibold text-gray-900 sm:text-3xl">
                            Minyak Kelapa Maloppo
                        </h2>

                        <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-600">
                            Pilih ukuran dan jumlah produk sesuai kebutuhan Anda.
                        </p>
                    </div>

                    <a
                        href="{{ route('catalog.index') }}"
                        class="text-sm font-semibold text-red-700 transition hover:text-red-900"
                    >
                        Lihat semua produk
                    </a>

                </div>

                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">

                    @forelse ($featuredProducts as $product)

                        <article
                            class="overflow-hidden rounded-xl border border-gray-200 bg-white"
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

                                        <div class="px-5 text-center">
                                            <p class="text-sm font-medium text-gray-400">
                                                Gambar belum tersedia
                                            </p>
                                        </div>

                                    @endif
                                </div>
                            </a>

                            {{-- Informasi --}}
                            <div class="p-4">

                                <div class="flex items-start justify-between gap-3">

                                    <h3 class="line-clamp-2 text-sm font-semibold leading-5 text-gray-900">
                                        {{ $product->name }}
                                    </h3>

                                    @if ($product->size)

                                        <span
                                            class="shrink-0 rounded-full bg-gray-100 px-2.5 py-1 text-[10px] font-medium text-gray-600"
                                        >
                                            {{ $product->size }}
                                        </span>

                                    @endif

                                </div>

                                <p class="mt-2 line-clamp-2 text-xs leading-5 text-gray-500">
                                    {{
                                        $product->short_description
                                            ?: 'Produk minyak kelapa murni berkualitas dari UMKM Maloppo.'
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

                                    @if ($product->stock > 0)

                                        <span class="text-xs font-medium text-green-700">
                                            Stok tersedia
                                        </span>

                                    @else

                                        <span class="text-xs font-medium text-red-700">
                                            Stok habis
                                        </span>

                                    @endif
                                </div>

                                <a
                                    href="{{ route('catalog.show', $product->slug) }}"
                                    class="btn-maloppo-secondary mt-4 w-full"
                                >
                                    Lihat Detail
                                </a>

                            </div>

                        </article>

                    @empty

                        <div
                            class="col-span-full rounded-xl border border-gray-200 bg-white px-5 py-12 text-center"
                        >
                            <p class="font-medium text-gray-700">
                                Produk belum tersedia
                            </p>

                            <p class="mt-1 text-sm text-gray-500">
                                Produk minyak kelapa Maloppo akan segera ditambahkan.
                            </p>
                        </div>

                    @endforelse

                </div>

            </div>

        </section>

        {{-- Tentang --}}
        <section id="tentang" class="border-y border-gray-200 bg-white">

            <div
                class="mx-auto grid max-w-7xl grid-cols-1 items-center gap-10 px-4 py-14 sm:px-6 lg:grid-cols-2 lg:px-8 lg:py-16"
            >

                {{-- Logo --}}
                <div
                    class="flex min-h-72 items-center justify-center overflow-hidden rounded-2xl border border-gray-200 bg-gray-50 p-6"
                >
                    <img
                        src="{{ asset('images/brand/logo-maloppo-full.jpg') }}"
                        alt="Identitas UMKM Maloppo"
                        class="max-h-72 w-full object-contain"
                    >
                </div>

                {{-- Narasi --}}
                <div>

                    <p class="text-sm font-semibold uppercase tracking-wider text-red-700">
                        Tentang Kami
                    </p>

                    <h2 class="mt-2 text-2xl font-semibold text-gray-900 sm:text-3xl">
                        UMKM Maloppo
                    </h2>

                    <p class="mt-5 text-sm leading-7 text-gray-600 sm:text-base">
                        UMKM Maloppo merupakan usaha masyarakat yang mengolah
                        kelapa lokal menjadi produk minyak kelapa murni.
                        Bahan baku dipilih dan diolah melalui proses yang
                        terjaga untuk menghasilkan produk berkualitas.
                    </p>

                    <p class="mt-4 text-sm leading-7 text-gray-600 sm:text-base">
                        Melalui pengolahan kelapa, Maloppo berupaya meningkatkan
                        nilai ekonomi bahan baku lokal sekaligus menghadirkan
                        produk yang dapat digunakan oleh masyarakat.
                    </p>

                    <div class="mt-6 border-l-2 border-red-700 pl-4">

                        <p class="text-sm font-semibold text-gray-900">
                            Produk lokal berkualitas
                        </p>

                        <p class="mt-1 text-sm leading-6 text-gray-500">
                            Website ini digunakan untuk memperkenalkan usaha,
                            menampilkan produk, membagikan kegiatan, dan
                            mempermudah proses pemesanan.
                        </p>

                    </div>

                </div>

            </div>

        </section>

        {{-- Ajakan --}}
        <section class="bg-red-700">

            <div
                class="mx-auto flex max-w-7xl flex-col gap-6 px-4 py-12 sm:px-6 lg:flex-row lg:items-center lg:justify-between lg:px-8"
            >

                <div>

                    <h2 class="text-2xl font-semibold text-white sm:text-3xl">
                        Temukan produk minyak kelapa Maloppo
                    </h2>

                    <p class="mt-2 max-w-2xl text-sm leading-6 text-red-100">
                        Lihat ukuran, harga, stok, lalu lakukan pemesanan
                        melalui keranjang dan checkout.
                    </p>

                </div>

                <a
                    href="{{ route('catalog.index') }}"
                    class="inline-flex shrink-0 items-center justify-center rounded-lg bg-white px-5 py-3 text-sm font-semibold text-red-700 transition hover:bg-gray-100"
                >
                    Buka Katalog
                </a>

            </div>

        </section>

    </main>

    {{-- Footer --}}
    <footer class="border-t border-gray-200 bg-white">

        <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">

            <div
                class="grid grid-cols-1 gap-8 md:grid-cols-2 md:items-center"
            >

                {{-- Identitas --}}
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

                {{-- Media sosial --}}
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

                <p>
                    Produk lokal dari kelapa pilihan.
                </p>
            </div>

        </div>

    </footer>

</body>

</html>