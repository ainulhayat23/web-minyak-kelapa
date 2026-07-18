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

<body class="bg-white text-gray-900">

    {{-- Navigasi --}}
    <x-public-navbar />

    <main>

        {{-- Hero / Beranda --}}
        <section class="relative overflow-hidden bg-gradient-to-br from-red-800 via-red-700 to-yellow-600">

            <div class="absolute inset-0 bg-black/10"></div>

            <div
                class="relative mx-auto grid max-w-7xl grid-cols-1 items-center gap-10 px-4 py-16 sm:px-6 lg:grid-cols-2 lg:px-8 lg:py-24"
            >

                {{-- Teks --}}
                <div class="text-white">

                    <p class="text-sm font-semibold uppercase tracking-[0.25em] text-yellow-100">
                        UMKM Maloppo
                    </p>

                    <h1 class="mt-4 max-w-2xl text-4xl font-bold leading-tight tracking-tight sm:text-5xl">
                        Minyak kelapa murni dari kelapa pilihan.
                    </h1>

                    <p class="mt-5 max-w-xl text-base leading-7 text-red-50 sm:text-lg">
                        Maloppo menghadirkan produk minyak kelapa lokal yang
                        diolah secara bersih dan terjaga. Produk ini dibuat
                        untuk mendukung kebutuhan masyarakat sekaligus
                        meningkatkan nilai ekonomi kelapa lokal.
                    </p>

                    <div class="mt-8 flex flex-col gap-3 sm:flex-row">

                        <a
                            href="{{ route('catalog.index') }}"
                            class="inline-flex items-center justify-center rounded-lg bg-white px-5 py-3 text-sm font-semibold text-red-700 shadow-sm transition hover:bg-yellow-50"
                        >
                            Lihat Produk
                        </a>

                        <a
                            href="#tentang"
                            class="inline-flex items-center justify-center rounded-lg border border-white/70 px-5 py-3 text-sm font-semibold text-white transition hover:bg-white/10"
                        >
                            Tentang Maloppo
                        </a>

                    </div>

                </div>

                {{-- Visual --}}
                <div>

                    <div class="mx-auto max-w-md rounded-3xl bg-white/95 p-5 shadow-xl">

                        <div class="flex min-h-[360px] items-center justify-center overflow-hidden rounded-2xl bg-yellow-50">

                            <img
                                src="{{ asset('images/brand/produk-maloppo-hero.jpg') }}"
                                alt="Produk minyak kelapa UMKM Maloppo"
                                class="max-h-[360px] w-auto max-w-full object-contain p-4"
                                onerror="this.onerror=null; this.src='{{ asset('images/brand/logo-maloppo-full.jpg') }}';"
                            >

                        </div>

                        <div class="mt-5 text-center">

                            <p class="text-sm font-semibold text-gray-900">
                                Produk Minyak Kelapa Maloppo
                            </p>

                            <p class="mt-1 text-xs leading-5 text-gray-500">
                                Diolah dari kelapa pilihan dengan proses yang bersih dan terjaga.
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </section>

        {{-- Tentang Maloppo --}}
        <section id="tentang" class="relative overflow-hidden bg-white">

            <div class="absolute right-0 top-0 h-40 w-40 rounded-bl-full bg-yellow-100"></div>
            <div class="absolute bottom-0 left-0 h-32 w-32 rounded-tr-full bg-red-50"></div>

            <div class="relative mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">

                <div class="grid grid-cols-1 gap-10 lg:grid-cols-2 lg:items-center">

                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.25em] text-red-700">
                            Tentang Kami
                        </p>

                        <h2 class="mt-4 max-w-xl text-3xl font-bold leading-tight tracking-tight text-gray-900 sm:text-4xl">
                            Mengolah kelapa lokal menjadi produk minyak kelapa bernilai.
                        </h2>

                        <p class="mt-5 max-w-2xl text-base leading-8 text-gray-600">
                            UMKM Maloppo merupakan usaha masyarakat yang mengolah kelapa
                            lokal menjadi produk minyak kelapa murni. Produk ini dibuat
                            melalui proses yang bersih dan terjaga agar dapat digunakan
                            oleh masyarakat.
                        </p>

                        <p class="mt-4 max-w-2xl text-base leading-8 text-gray-600">
                            Melalui website ini, Maloppo memperkenalkan produk,
                            membagikan informasi kegiatan, dan memudahkan pelanggan
                            dalam melihat katalog serta melakukan pemesanan.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                        <div class="rounded-2xl border border-red-100 bg-red-50 p-6">
                            <p class="text-sm font-semibold text-red-700">
                                Produk Utama
                            </p>

                            <h3 class="mt-3 text-2xl font-bold text-gray-900">
                                Minyak Kelapa
                            </h3>

                            <p class="mt-2 text-sm leading-6 text-gray-600">
                                Produk lokal yang menjadi identitas utama UMKM Maloppo.
                            </p>
                        </div>

                        <div class="rounded-2xl border border-yellow-200 bg-yellow-50 p-6">
                            <p class="text-sm font-semibold text-red-700">
                                Bahan Baku
                            </p>

                            <h3 class="mt-3 text-2xl font-bold text-gray-900">
                                Kelapa Pilihan
                            </h3>

                            <p class="mt-2 text-sm leading-6 text-gray-600">
                                Kelapa dipilih sebelum masuk ke proses pengolahan.
                            </p>
                        </div>

                        <div class="rounded-2xl border border-yellow-200 bg-white p-6 shadow-sm sm:col-span-2">
                            <p class="text-sm font-semibold text-red-700">
                                Tujuan Website
                            </p>

                            <h3 class="mt-3 text-2xl font-bold text-gray-900">
                                Promosi dan pemesanan produk
                            </h3>

                            <p class="mt-2 text-sm leading-6 text-gray-600">
                                Website membantu pengunjung mengenal Maloppo, melihat
                                produk, membaca kegiatan, dan melakukan pemesanan dengan mudah.
                            </p>
                        </div>

                    </div>

                </div>

            </div>

        </section>

        {{-- Keunggulan --}}
        <section class="bg-yellow-50">

            <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">

                <div class="mx-auto max-w-3xl text-center">
                    <p class="text-sm font-semibold uppercase tracking-[0.25em] text-red-700">
                        Keunggulan Produk
                    </p>

                    <h2 class="mt-4 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                        Kenapa memilih Maloppo?
                    </h2>

                    <p class="mt-4 text-base leading-7 text-gray-600">
                        Maloppo menjaga kualitas produk melalui bahan baku pilihan,
                        proses pengolahan yang bersih, dan pemanfaatan hasil kelapa lokal.
                    </p>
                </div>

                <div class="mt-10 grid grid-cols-1 gap-6 md:grid-cols-3">

                    <article class="rounded-2xl border border-yellow-200 bg-white p-7 shadow-sm">
                        <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-full bg-red-700 text-lg font-bold text-white">
                            1
                        </div>

                        <h3 class="text-lg font-bold text-gray-900">
                            Kelapa Pilihan
                        </h3>

                        <p class="mt-3 text-sm leading-7 text-gray-600">
                            Bahan baku dipilih terlebih dahulu sebelum diproses menjadi
                            minyak kelapa.
                        </p>
                    </article>

                    <article class="rounded-2xl border border-yellow-200 bg-white p-7 shadow-sm">
                        <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-full bg-red-700 text-lg font-bold text-white">
                            2
                        </div>

                        <h3 class="text-lg font-bold text-gray-900">
                            Proses Bersih
                        </h3>

                        <p class="mt-3 text-sm leading-7 text-gray-600">
                            Proses pengolahan dilakukan dengan memperhatikan kebersihan
                            dan kualitas produk.
                        </p>
                    </article>

                    <article class="rounded-2xl border border-yellow-200 bg-white p-7 shadow-sm">
                        <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-full bg-red-700 text-lg font-bold text-white">
                            3
                        </div>

                        <h3 class="text-lg font-bold text-gray-900">
                            Produk Lokal
                        </h3>

                        <p class="mt-3 text-sm leading-7 text-gray-600">
                            Maloppo mendukung pemanfaatan kelapa lokal dan pengembangan
                            UMKM masyarakat.
                        </p>
                    </article>

                </div>

            </div>

        </section>

        {{-- Produk --}}
        <section class="bg-white">

            <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">

                <div class="mx-auto max-w-3xl text-center">
                    <p class="text-sm font-semibold uppercase tracking-[0.25em] text-red-700">
                        Produk Kami
                    </p>

                    <h2 class="mt-4 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                        Katalog Minyak Kelapa Maloppo
                    </h2>

                    <p class="mt-4 text-base leading-7 text-gray-600">
                        Pilih produk sesuai kebutuhan, lihat informasi harga, stok,
                        dan detail produk sebelum melakukan pemesanan.
                    </p>
                </div>

                <div class="mt-10 flex flex-wrap justify-center gap-6">

                    @forelse ($featuredProducts as $product)

                        <article class="flex w-full max-w-xs flex-col overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                            <a href="{{ route('catalog.show', $product->slug) }}">
                                <div class="flex h-64 items-center justify-center bg-yellow-50 p-5">
                                    @if ($product->image)
                                        <img
                                            src="{{ asset('storage/' . $product->image) }}"
                                            alt="{{ $product->name }}"
                                            class="h-full w-full object-contain"
                                        >
                                    @else
                                        <p class="text-center text-sm text-gray-400">
                                            Gambar belum tersedia
                                        </p>
                                    @endif
                                </div>
                            </a>

                            <div class="flex flex-1 flex-col p-5">

                                <div class="flex items-start justify-between gap-3">
                                    <h3 class="line-clamp-2 text-base font-bold leading-6 text-gray-900">
                                        {{ $product->name }}
                                    </h3>

                                    @if ($product->size)
                                        <span class="shrink-0 rounded-full bg-yellow-100 px-2.5 py-1 text-xs font-semibold text-red-700">
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
                                    <p class="text-xs text-gray-500">
                                        Harga
                                    </p>

                                    <p class="mt-1 text-xl font-bold text-red-700">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </p>

                                    @if ($product->stock > 0)
                                        <p class="mt-1 text-xs font-semibold text-green-700">
                                            Stok tersedia
                                        </p>
                                    @else
                                        <p class="mt-1 text-xs font-semibold text-red-700">
                                            Stok habis
                                        </p>
                                    @endif
                                </div>

                                <a
                                    href="{{ route('catalog.show', $product->slug) }}"
                                    class="mt-5 inline-flex w-full items-center justify-center rounded-lg border border-red-200 px-4 py-3 text-sm font-semibold text-red-700 transition hover:bg-red-50"
                                >
                                    Lihat Detail
                                </a>

                            </div>

                        </article>

                    @empty

                        <div class="w-full rounded-2xl border border-gray-200 bg-white px-5 py-12 text-center">
                            <p class="font-medium text-gray-700">
                                Produk belum tersedia
                            </p>

                            <p class="mt-1 text-sm text-gray-500">
                                Produk minyak kelapa Maloppo akan segera ditambahkan.
                            </p>
                        </div>

                    @endforelse

                </div>

                <div class="mt-10 text-center">
                    <a
                        href="{{ route('catalog.index') }}"
                        class="inline-flex items-center justify-center rounded-lg bg-red-700 px-5 py-3 text-sm font-semibold text-white transition hover:bg-red-800"
                    >
                        Lihat Semua Produk
                    </a>
                </div>

            </div>

        </section>

        {{-- Kegiatan --}}
        <section class="bg-gray-50">

            <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">

                <div class="overflow-hidden rounded-3xl bg-gradient-to-br from-red-700 via-red-600 to-yellow-500 p-8 text-white sm:p-10">

                    <div class="grid grid-cols-1 gap-8 lg:grid-cols-2 lg:items-center">

                        <div>
                            <p class="text-sm font-semibold uppercase tracking-[0.25em] text-yellow-100">
                                Kegiatan Maloppo
                            </p>

                            <h2 class="mt-4 text-3xl font-bold tracking-tight sm:text-4xl">
                                Informasi dan aktivitas UMKM Maloppo.
                            </h2>
                        </div>

                        <div>
                            <p class="text-base leading-8 text-red-50">
                                Halaman kegiatan digunakan untuk membagikan informasi
                                terbaru seputar proses produksi, dokumentasi kegiatan,
                                pelatihan, dan perkembangan UMKM Maloppo.
                            </p>

                            <a
                                href="{{ route('blog.index') }}"
                                class="mt-6 inline-flex items-center justify-center rounded-lg bg-white px-5 py-3 text-sm font-semibold text-red-700 transition hover:bg-yellow-50"
                            >
                                Lihat Kegiatan
                            </a>
                        </div>

                    </div>

                </div>

            </div>

        </section>

        {{-- Ajakan --}}
        <section class="bg-white">

            <div class="mx-auto max-w-7xl px-4 pb-16 sm:px-6 lg:px-8">

                <div class="rounded-3xl border border-red-100 bg-red-50 px-6 py-10 text-center">

                    <h2 class="text-3xl font-bold tracking-tight text-gray-900">
                        Tertarik dengan produk Maloppo?
                    </h2>

                    <p class="mx-auto mt-3 max-w-2xl text-sm leading-7 text-gray-600">
                        Buka katalog untuk melihat produk, ukuran, harga, stok,
                        dan lakukan pemesanan melalui website.
                    </p>

                    <a
                        href="{{ route('catalog.index') }}"
                        class="mt-6 inline-flex items-center justify-center rounded-lg bg-red-700 px-5 py-3 text-sm font-semibold text-white transition hover:bg-red-800"
                    >
                        Buka Katalog
                    </a>

                </div>

            </div>

        </section>

    </main>

    {{-- Footer --}}
    {{-- <footer class="border-t border-gray-200 bg-white">

        <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 gap-8 md:grid-cols-2 md:items-center">

                <div>

                    <div class="flex h-14 w-32 items-center justify-center overflow-hidden rounded-lg border border-gray-200 bg-gray-50">
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

            <div class="mt-8 flex flex-col gap-2 border-t border-gray-200 pt-5 text-xs text-gray-500 sm:flex-row sm:items-center sm:justify-between">
                <p>
                    &copy; {{ date('Y') }} UMKM Maloppo.
                </p>

                <p>
                    Produk lokal dari kelapa pilihan.
                </p>
            </div>

        </div>

    </footer> --}}
    <x-public-footer />

</body>

</html>