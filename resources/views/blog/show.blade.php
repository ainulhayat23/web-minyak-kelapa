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

    {{-- Header artikel --}}
    <header class="border-b border-gray-200 bg-white">

        <div class="mx-auto max-w-4xl px-4 py-9 sm:px-6 lg:px-8 lg:py-12">

            <a
                href="{{ route('blog.index') }}"
                class="inline-flex items-center text-sm font-medium text-gray-600 transition hover:text-red-700"
            >
                <span class="mr-2" aria-hidden="true">←</span>
                Kembali ke kegiatan
            </a>

            <div class="mt-6">

                <p class="text-sm font-semibold uppercase tracking-wider text-red-700">
                    Blog dan Kegiatan
                </p>

                <h1 class="mt-3 text-3xl font-semibold leading-tight tracking-tight text-gray-900 sm:text-4xl lg:text-5xl">
                    {{ $post->title }}
                </h1>

                <div
                    class="mt-5 flex flex-wrap items-center gap-x-3 gap-y-2 text-sm text-gray-500"
                >
                    <span>
                        {{ $post->published_at?->format('d F Y') ?? 'Belum diterbitkan' }}
                    </span>

                    <span class="text-gray-300">
                        •
                    </span>

                    <span>
                        Ditulis oleh {{ $post->user?->name ?? 'Admin' }}
                    </span>
                </div>

            </div>

        </div>

    </header>

    <main class="mx-auto max-w-4xl px-4 py-8 sm:px-6 lg:px-8 lg:py-12">

        <article class="overflow-hidden rounded-xl border border-gray-200 bg-white">

            {{-- Gambar utama --}}
            @if ($post->image)

                <div class="h-64 overflow-hidden sm:h-80 lg:h-[440px]">

                    <img
                        src="{{ asset('storage/' . $post->image) }}"
                        alt="{{ $post->title }}"
                        class="h-full w-full object-cover"
                    >

                </div>

            @else

                <div
                    class="flex h-56 items-center justify-center bg-gray-50 sm:h-72"
                >
                    <p class="text-sm text-gray-400">
                        Gambar kegiatan belum tersedia
                    </p>
                </div>

            @endif

            {{-- Isi artikel --}}
            <div class="p-5 sm:p-8 lg:p-10">

                {{-- Ringkasan --}}
                @if ($post->excerpt)

                    <div class="border-l-2 border-red-700 pl-4 sm:pl-5">

                        <p class="text-base font-medium leading-7 text-gray-700 sm:text-lg">
                            {{ $post->excerpt }}
                        </p>

                    </div>

                @endif

                {{-- Konten --}}
                <div
                    class="{{ $post->excerpt ? 'mt-8' : '' }} whitespace-pre-line text-base leading-8 text-gray-700"
                >{{ $post->content }}</div>

                {{-- Informasi singkat --}}
                <div class="mt-10 border-t border-gray-200 pt-6">

                    <h2 class="text-sm font-semibold text-gray-900">
                        Tentang UMKM Maloppo
                    </h2>

                    <p class="mt-2 text-sm leading-6 text-gray-500">
                        UMKM Maloppo mengolah kelapa lokal menjadi produk minyak
                        kelapa berkualitas sekaligus meningkatkan nilai ekonomi
                        bahan baku lokal.
                    </p>

                </div>

                {{-- Navigasi --}}
                <div
                    class="mt-8 flex flex-col gap-3 border-t border-gray-200 pt-6 sm:flex-row sm:items-center sm:justify-between"
                >

                    <a
                        href="{{ route('blog.index') }}"
                        class="btn-maloppo-secondary"
                    >
                        Kegiatan Lainnya
                    </a>

                    <a
                        href="{{ route('catalog.index') }}"
                        class="btn-maloppo-primary"
                    >
                        Lihat Produk
                    </a>

                </div>

            </div>

        </article>

    </main>

    {{-- Footer --}}
    <footer class="border-t border-gray-200 bg-white">

        <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 gap-8 md:grid-cols-2 md:items-center">

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

                <a
                    href="{{ route('blog.index') }}"
                    class="font-medium text-gray-600 transition hover:text-red-700"
                >
                    Kembali ke Kegiatan
                </a>
            </div>

        </div>

    </footer>

</body>

</html>