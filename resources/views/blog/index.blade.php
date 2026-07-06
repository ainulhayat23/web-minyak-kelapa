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
        content="Informasi kegiatan, pelatihan, produksi, dan perkembangan UMKM Maloppo."
    >

    <title>Kegiatan | UMKM Maloppo</title>

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

        <div
            class="relative mx-auto grid max-w-7xl grid-cols-1 items-center gap-10 px-6 py-16 lg:grid-cols-[1fr_auto] lg:py-20"
        >

            <div>

                <span class="label-maloppo">
                    Blog dan Kegiatan
                </span>

                <h1
                    class="mt-5 max-w-3xl text-4xl font-extrabold leading-tight text-gray-900 md:text-5xl"
                >
                    Kegiatan Terbaru
                    <span class="text-maloppo-red">
                        UMKM Maloppo
                    </span>
                </h1>

                <p class="mt-5 max-w-2xl text-lg leading-8 text-gray-600">
                    Informasi mengenai kegiatan, pelatihan, proses produksi,
                    pameran, dan perkembangan usaha minyak kelapa Maloppo.
                </p>

                <div class="mt-7 flex flex-wrap gap-3">

                    <div
                        class="inline-flex items-center gap-2 rounded-full bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm"
                    >
                        <span>🏭</span>
                        Proses produksi
                    </div>

                    <div
                        class="inline-flex items-center gap-2 rounded-full bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm"
                    >
                        <span>🎓</span>
                        Pelatihan UMKM
                    </div>

                    <div
                        class="inline-flex items-center gap-2 rounded-full bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm"
                    >
                        <span>📢</span>
                        Informasi terbaru
                    </div>

                </div>

            </div>

            {{-- Logo Maloppo --}}
            <div
                class="mx-auto flex h-44 w-64 items-center justify-center overflow-hidden rounded-3xl border-4 bg-white p-3 shadow-lg lg:mx-0"
                style="border-color: #f7e900;"
            >
                <img
                    src="{{ asset('images/brand/logo-maloppo-full.jpg') }}"
                    alt="Logo UMKM Maloppo"
                    class="h-full w-full object-contain"
                >
            </div>

        </div>

    </section>

    {{-- Daftar kegiatan --}}
    <main class="mx-auto max-w-7xl px-6 py-14 lg:py-16">

        {{-- Judul daftar --}}
        <div
            class="mb-10 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between"
        >

            <div>

                <span class="label-maloppo">
                    Informasi Terbaru
                </span>

                <h2 class="mt-4 text-3xl font-extrabold text-gray-900">
                    Berita dan Kegiatan
                </h2>

                <p class="mt-2 max-w-2xl leading-7 text-gray-500">
                    Ikuti berbagai kegiatan dan perkembangan terbaru dari
                    UMKM Maloppo.
                </p>

            </div>

            <a
                href="{{ route('catalog.index') }}"
                class="btn-maloppo-secondary whitespace-nowrap"
            >
                Lihat Produk
            </a>

        </div>

        {{-- Grid kegiatan --}}
        <div class="grid grid-cols-1 gap-7 md:grid-cols-2 lg:grid-cols-3">

            @forelse ($posts as $post)

                <article
                    class="card-maloppo card-maloppo-hover flex h-full flex-col overflow-hidden"
                >

                    {{-- Gambar kegiatan --}}
                    <a
                        href="{{ route('blog.show', $post->slug) }}"
                        class="relative block overflow-hidden"
                    >

                        <div
                            class="flex h-60 items-center justify-center overflow-hidden"
                            style="background-color: #fffdf0;"
                        >

                            @if ($post->image)

                                <img
                                    src="{{ asset('storage/' . $post->image) }}"
                                    alt="{{ $post->title }}"
                                    class="h-full w-full object-cover transition duration-300 hover:scale-105"
                                >

                            @else

                                <div class="px-6 text-center">

                                    <div class="text-6xl">
                                        📰
                                    </div>

                                    <p class="mt-4 text-sm text-gray-400">
                                        Gambar kegiatan belum tersedia
                                    </p>

                                </div>

                            @endif

                        </div>

                        {{-- Label --}}
                        <div class="absolute left-4 top-4">

                            <span
                                class="inline-flex rounded-full px-3 py-1 text-xs font-bold shadow-sm"
                                style="
                                    background-color: #f7e900;
                                    color: #990100;
                                "
                            >
                                Kegiatan Maloppo
                            </span>

                        </div>

                    </a>

                    {{-- Informasi kegiatan --}}
                    <div class="flex flex-1 flex-col p-6">

                        {{-- Tanggal dan penulis --}}
                        <div
                            class="flex flex-wrap items-center gap-2 text-xs text-gray-500"
                        >

                            <span
                                class="inline-flex items-center gap-1.5 rounded-full px-3 py-1.5"
                                style="background-color: #fff9b0;"
                            >
                                <span>📅</span>

                                {{ $post->published_at?->format('d M Y') ?? 'Belum diterbitkan' }}
                            </span>

                            <span
                                class="inline-flex items-center gap-1.5 rounded-full bg-gray-100 px-3 py-1.5"
                            >
                                <span>👤</span>

                                {{ $post->user?->name ?? 'Admin' }}
                            </span>

                        </div>

                        {{-- Judul --}}
                        <h3
                            class="mt-5 text-xl font-extrabold leading-7 text-gray-900"
                        >
                            <a
                                href="{{ route('blog.show', $post->slug) }}"
                                class="transition hover:text-maloppo-red"
                            >
                                {{ $post->title }}
                            </a>
                        </h3>

                        {{-- Ringkasan --}}
                        <p class="mt-3 line-clamp-4 flex-1 text-sm leading-7 text-gray-600">
                            {{
                                $post->excerpt
                                ?: \Illuminate\Support\Str::limit(
                                    strip_tags($post->content),
                                    150
                                )
                            }}
                        </p>

                        {{-- Tombol --}}
                        <div
                            class="mt-6 border-t pt-5"
                            style="border-color: #f1e7a4;"
                        >

                            <a
                                href="{{ route('blog.show', $post->slug) }}"
                                class="inline-flex items-center gap-2 text-sm font-bold text-maloppo-red"
                            >
                                Baca selengkapnya

                                <span aria-hidden="true">
                                    →
                                </span>
                            </a>

                        </div>

                    </div>

                </article>

            @empty

                <div class="card-maloppo col-span-full px-6 py-20 text-center">

                    <div
                        class="mx-auto flex h-20 w-20 items-center justify-center rounded-full text-5xl"
                        style="background-color: #fff9b0;"
                    >
                        📰
                    </div>

                    <h3 class="mt-6 text-xl font-bold text-gray-800">
                        Belum ada kegiatan yang diterbitkan
                    </h3>

                    <p class="mx-auto mt-3 max-w-md text-sm leading-6 text-gray-500">
                        Informasi kegiatan terbaru UMKM Maloppo akan
                        ditampilkan pada halaman ini.
                    </p>

                    <a
                        href="{{ route('home') }}"
                        class="btn-maloppo-primary mt-6"
                    >
                        Kembali ke Beranda
                    </a>

                </div>

            @endforelse

        </div>

        {{-- Pagination --}}
        @if ($posts->hasPages())
            <div
                class="mt-12 rounded-2xl border bg-white px-5 py-4 shadow-sm"
                style="border-color: #f1e7a4;"
            >
                {{ $posts->links() }}
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
                    UMKM Maloppo
                </span>

                <h2 class="mt-4 text-2xl font-extrabold text-white">
                    Temukan produk minyak kelapa Maloppo
                </h2>

                <p class="mt-2 max-w-2xl text-sm leading-7 text-red-100">
                    Lihat pilihan produk, ukuran, harga, dan ketersediaan
                    stok melalui katalog kami.
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