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

<body class="bg-white text-gray-900">

    {{-- Navigasi --}}
    <x-public-navbar />

    {{-- Header artikel --}}
    <header class="relative overflow-hidden bg-gradient-to-br from-red-700 via-red-600 to-yellow-500">

        <div class="absolute inset-0 bg-black/10"></div>

        <div class="relative mx-auto max-w-5xl px-4 py-12 sm:px-6 lg:px-8 lg:py-16">

            <a
                href="{{ route('blog.index') }}"
                class="inline-flex items-center rounded-full bg-white/15 px-4 py-2 text-sm font-semibold text-white transition hover:bg-white/25"
            >
                <span class="mr-2" aria-hidden="true">←</span>
                Kembali ke kegiatan
            </a>

            <div class="mt-8 text-white">

                <p class="text-sm font-semibold uppercase tracking-[0.25em] text-yellow-100">
                    Blog dan Kegiatan
                </p>

                <h1 class="mt-4 max-w-4xl text-4xl font-bold leading-tight tracking-tight sm:text-5xl">
                    {{ $post->title }}
                </h1>

                <div class="mt-6 flex flex-wrap items-center gap-3 text-sm text-red-50">

                    <span class="rounded-full bg-white/15 px-3 py-1.5 font-semibold">
                        {{ $post->published_at?->format('d F Y') ?? 'Belum diterbitkan' }}
                    </span>

                    <span class="rounded-full bg-white/15 px-3 py-1.5 font-semibold">
                        Ditulis oleh {{ $post->user?->name ?? 'Admin' }}
                    </span>

                </div>

            </div>

        </div>

    </header>

    <main class="mx-auto max-w-5xl px-4 py-14 sm:px-6 lg:px-8 lg:py-16">

        <article class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">

            {{-- Gambar utama --}}
            @if ($post->image)

                <div class="bg-yellow-50 p-4 sm:p-5">

                    <div class="overflow-hidden rounded-2xl">

                        <img
                            src="{{ asset('storage/' . $post->image) }}"
                            alt="{{ $post->title }}"
                            class="h-72 w-full object-cover sm:h-96 lg:h-[460px]"
                        >

                    </div>

                </div>

            @else

                <div class="flex h-64 items-center justify-center bg-yellow-50 sm:h-80">
                    <p class="text-sm text-gray-400">
                        Gambar kegiatan belum tersedia
                    </p>
                </div>

            @endif

            {{-- Isi artikel --}}
            <div class="p-6 sm:p-8 lg:p-10">

                {{-- Ringkasan --}}
                @if ($post->excerpt)

                    <div class="rounded-2xl border border-red-100 bg-red-50 p-5">

                        <p class="text-base font-semibold leading-8 text-gray-800 sm:text-lg">
                            {{ $post->excerpt }}
                        </p>

                    </div>

                @endif

                {{-- Konten --}}
                <div class="{{ $post->excerpt ? 'mt-8' : '' }} whitespace-pre-line text-base leading-8 text-gray-700">
{{ $post->content }}
                </div>

                {{-- Tentang Maloppo --}}
                <div class="mt-10 rounded-2xl border border-yellow-200 bg-yellow-50 p-6">

                    <p class="text-sm font-semibold uppercase tracking-[0.20em] text-red-700">
                        Tentang UMKM Maloppo
                    </p>

                    <h2 class="mt-3 text-2xl font-bold text-gray-900">
                        Produk lokal dari kelapa pilihan.
                    </h2>

                    <p class="mt-3 text-sm leading-7 text-gray-600">
                        UMKM Maloppo mengolah kelapa lokal menjadi produk minyak
                        kelapa berkualitas sekaligus meningkatkan nilai ekonomi
                        bahan baku lokal.
                    </p>

                </div>

                {{-- Navigasi --}}
                <div class="mt-8 flex flex-col gap-3 border-t border-gray-200 pt-6 sm:flex-row sm:items-center sm:justify-between">

                    <a
                        href="{{ route('blog.index') }}"
                        class="inline-flex items-center justify-center rounded-lg border border-red-200 px-5 py-3 text-sm font-semibold text-red-700 transition hover:bg-red-50"
                    >
                        Kegiatan Lainnya
                    </a>

                    <a
                        href="{{ route('catalog.index') }}"
                        class="inline-flex items-center justify-center rounded-lg bg-red-700 px-5 py-3 text-sm font-semibold text-white transition hover:bg-red-800"
                    >
                        Lihat Produk
                    </a>

                </div>

            </div>

        </article>

        {{-- Informasi tambahan --}}
        <section class="mt-12 rounded-3xl bg-yellow-50 px-6 py-10">

            <div class="mx-auto max-w-3xl text-center">

                <p class="text-sm font-semibold uppercase tracking-[0.25em] text-red-700">
                    Informasi Maloppo
                </p>

                <h2 class="mt-4 text-3xl font-bold tracking-tight text-gray-900">
                    Kenali produk dan kegiatan UMKM Maloppo.
                </h2>

            </div>

            <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-3">

                <div class="rounded-2xl border border-yellow-200 bg-white p-6 shadow-sm">

                    <h3 class="text-base font-bold text-gray-900">
                        Proses Produksi
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-gray-600">
                        Informasi mengenai proses pengolahan minyak kelapa Maloppo.
                    </p>

                </div>

                <div class="rounded-2xl border border-yellow-200 bg-white p-6 shadow-sm">

                    <h3 class="text-base font-bold text-gray-900">
                        Kegiatan UMKM
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-gray-600">
                        Dokumentasi kegiatan dan perkembangan usaha Maloppo.
                    </p>

                </div>

                <div class="rounded-2xl border border-yellow-200 bg-white p-6 shadow-sm">

                    <h3 class="text-base font-bold text-gray-900">
                        Produk Lokal
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-gray-600">
                        Produk minyak kelapa dari kelapa pilihan masyarakat lokal.
                    </p>

                </div>

            </div>

        </section>

    </main>

    {{-- Footer --}}
    <x-public-footer />

</body>

</html>