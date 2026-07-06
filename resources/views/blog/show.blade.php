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
        content="{{ $post->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($post->content), 150) }}"
    >

    <title>{{ $post->title }} | UMKM Maloppo</title>

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

        <div class="relative mx-auto max-w-5xl px-6 py-12 lg:py-16">

            <a
                href="{{ route('blog.index') }}"
                class="inline-flex items-center gap-2 text-sm font-bold text-maloppo-red"
            >
                <span aria-hidden="true">
                    ←
                </span>

                Kembali ke daftar kegiatan
            </a>

            <div class="mt-7">

                <span class="label-maloppo">
                    Blog dan Kegiatan
                </span>

                <h1
                    class="mt-5 max-w-4xl text-3xl font-extrabold leading-tight text-gray-900 md:text-5xl"
                >
                    {{ $post->title }}
                </h1>

                <div class="mt-6 flex flex-wrap items-center gap-3">

                    <span
                        class="inline-flex items-center gap-2 rounded-full bg-white px-4 py-2 text-sm font-semibold text-gray-600 shadow-sm"
                    >
                        <span>📅</span>

                        {{ $post->published_at?->format('d M Y') ?? 'Belum diterbitkan' }}
                    </span>

                    <span
                        class="inline-flex items-center gap-2 rounded-full bg-white px-4 py-2 text-sm font-semibold text-gray-600 shadow-sm"
                    >
                        <span>👤</span>

                        {{ $post->user?->name ?? 'Admin' }}
                    </span>

                </div>

            </div>

        </div>

    </section>

    <main class="mx-auto max-w-5xl px-6 py-12 lg:py-16">

        <article class="card-maloppo overflow-hidden">

            {{-- Gambar utama --}}
            <div class="relative">

                @if ($post->image)

                    <div class="h-72 overflow-hidden md:h-[480px]">

                        <img
                            src="{{ asset('storage/' . $post->image) }}"
                            alt="{{ $post->title }}"
                            class="h-full w-full object-cover"
                        >

                    </div>

                @else

                    <div
                        class="flex h-72 items-center justify-center md:h-96"
                        style="background-color: #fffdf0;"
                    >

                        <div class="px-6 text-center">

                            <div class="text-7xl">
                                📰
                            </div>

                            <p class="mt-4 text-sm font-medium text-gray-400">
                                Gambar kegiatan belum tersedia
                            </p>

                        </div>

                    </div>

                @endif

                <div class="absolute left-5 top-5">

                    <span
                        class="inline-flex rounded-full px-4 py-2 text-xs font-bold shadow-sm"
                        style="
                            background-color: #f7e900;
                            color: #990100;
                        "
                    >
                        Kegiatan UMKM Maloppo
                    </span>

                </div>

            </div>

            {{-- Isi artikel --}}
            <div class="p-6 md:p-10 lg:p-12">

                {{-- Identitas artikel --}}
                <div
                    class="flex flex-col gap-5 border-b pb-7 sm:flex-row sm:items-center sm:justify-between"
                    style="border-color: #f1e7a4;"
                >

                    <div>

                        <p
                            class="text-sm font-bold uppercase tracking-widest text-maloppo-red"
                        >
                            Informasi Kegiatan
                        </p>

                        <p class="mt-2 text-sm text-gray-500">
                            Informasi dan perkembangan terbaru dari UMKM Maloppo
                        </p>

                    </div>

                    <div
                        class="flex h-16 w-28 items-center justify-center overflow-hidden rounded-xl"
                        style="background-color: #f7e900;"
                    >

                        <img
                            src="{{ asset('images/brand/logo-maloppo-wordmark.jpg') }}"
                            alt="Logo UMKM Maloppo"
                            class="h-full w-full object-contain"
                        >

                    </div>

                </div>

                {{-- Judul artikel --}}
                <h2
                    class="mt-8 text-3xl font-extrabold leading-tight text-gray-900 md:text-4xl"
                >
                    {{ $post->title }}
                </h2>

                {{-- Metadata --}}
                <div class="mt-5 flex flex-wrap items-center gap-3 text-sm text-gray-500">

                    <span class="inline-flex items-center gap-2">
                        <span>📅</span>

                        {{ $post->published_at?->format('d F Y') ?? 'Belum diterbitkan' }}
                    </span>

                    <span class="text-gray-300">
                        •
                    </span>

                    <span class="inline-flex items-center gap-2">
                        <span>👤</span>

                        Ditulis oleh {{ $post->user?->name ?? 'Admin' }}
                    </span>

                </div>

                {{-- Ringkasan --}}
                @if ($post->excerpt)

                    <div
                        class="mt-8 rounded-2xl border-l-4 p-6"
                        style="
                            background-color: #fff9b0;
                            border-color: #be0000;
                        "
                    >

                        <div class="flex items-start gap-4">

                            <div
                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full"
                                style="
                                    background-color: #be0000;
                                    color: white;
                                "
                            >
                                “
                            </div>

                            <p
                                class="text-base font-medium leading-8 text-gray-700"
                            >
                                {{ $post->excerpt }}
                            </p>

                        </div>

                    </div>

                @endif

                {{-- Isi kegiatan --}}
                <div class="mt-10">

                    <div class="mb-6 flex items-center gap-4">

                        <div
                            class="flex h-11 w-11 items-center justify-center rounded-xl text-xl"
                            style="background-color: #fff9b0;"
                        >
                            📄
                        </div>

                        <div>

                            <h3 class="text-xl font-extrabold text-gray-900">
                                Informasi Lengkap
                            </h3>

                            <p class="mt-1 text-sm text-gray-500">
                                Rangkaian informasi kegiatan UMKM Maloppo
                            </p>

                        </div>

                    </div>

                    <div
                        class="whitespace-pre-line text-base leading-9 text-gray-700"
                    >{{ $post->content }}</div>

                </div>

                {{-- Informasi tambahan --}}
                <div
                    class="mt-10 rounded-2xl border p-6"
                    style="
                        background-color: #fffdf0;
                        border-color: #f1e7a4;
                    "
                >

                    <div class="flex items-start gap-4">

                        <div
                            class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl text-2xl"
                            style="background-color: #f7e900;"
                        >
                            🏪
                        </div>

                        <div>

                            <h3 class="font-bold text-gray-900">
                                Tentang UMKM Maloppo
                            </h3>

                            <p class="mt-2 text-sm leading-7 text-gray-600">
                                UMKM Maloppo mengolah kelapa lokal menjadi
                                produk minyak kelapa berkualitas sekaligus
                                meningkatkan nilai ekonomi bahan baku lokal.
                            </p>

                        </div>

                    </div>

                </div>

                {{-- Navigasi bawah --}}
                <div
                    class="mt-10 flex flex-col gap-3 border-t pt-7 sm:flex-row sm:items-center sm:justify-between"
                    style="border-color: #f1e7a4;"
                >

                    <a
                        href="{{ route('blog.index') }}"
                        class="btn-maloppo-secondary"
                    >
                        <span aria-hidden="true">
                            ←
                        </span>

                        Kegiatan Lainnya
                    </a>

                    <a
                        href="{{ route('catalog.index') }}"
                        class="btn-maloppo-primary"
                    >
                        Lihat Produk Maloppo

                        <span aria-hidden="true">
                            →
                        </span>
                    </a>

                </div>

            </div>

        </article>

        {{-- Kartu navigasi tambahan --}}
        <section class="mt-8 grid grid-cols-1 gap-5 md:grid-cols-2">

            <a
                href="{{ route('blog.index') }}"
                class="card-maloppo card-maloppo-hover flex items-center gap-4 p-5"
            >

                <div
                    class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl text-xl"
                    style="background-color: #fff9b0;"
                >
                    📰
                </div>

                <div>

                    <p class="font-bold text-gray-900">
                        Berita dan Kegiatan
                    </p>

                    <p class="mt-1 text-sm text-gray-500">
                        Lihat informasi kegiatan Maloppo lainnya.
                    </p>

                </div>

            </a>

            <a
                href="{{ route('catalog.index') }}"
                class="card-maloppo card-maloppo-hover flex items-center gap-4 p-5"
            >

                <div
                    class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl text-xl"
                    style="background-color: #fff9b0;"
                >
                    🥥
                </div>

                <div>

                    <p class="font-bold text-gray-900">
                        Produk Maloppo
                    </p>

                    <p class="mt-1 text-sm text-gray-500">
                        Temukan produk minyak kelapa pilihan kami.
                    </p>

                </div>

            </a>

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
                    UMKM Maloppo
                </span>

                <h2 class="mt-4 text-2xl font-extrabold text-white">
                    Temukan produk minyak kelapa Maloppo
                </h2>

                <p class="mt-2 max-w-2xl text-sm leading-7 text-red-100">
                    Lihat informasi produk, ukuran, harga, dan ketersediaan
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