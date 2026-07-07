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
    <header class="border-b border-gray-200 bg-white">

        <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8 lg:py-12">

            <div
                class="flex flex-col gap-6 md:flex-row md:items-end md:justify-between"
            >
                <div>

                    <p class="text-sm font-semibold uppercase tracking-wider text-red-700">
                        Blog dan Kegiatan
                    </p>

                    <h1 class="mt-2 max-w-3xl text-3xl font-semibold tracking-tight text-gray-900 sm:text-4xl">
                        Kegiatan Terbaru UMKM Maloppo
                    </h1>

                    <p class="mt-3 max-w-2xl text-sm leading-6 text-gray-600 sm:text-base">
                        Informasi mengenai kegiatan, pelatihan, proses produksi,
                        pameran, dan perkembangan usaha UMKM Maloppo.
                    </p>

                </div>

                <a
                    href="{{ route('catalog.index') }}"
                    class="btn-maloppo-secondary shrink-0"
                >
                    Lihat Produk
                </a>

            </div>

        </div>

    </header>

    {{-- Daftar kegiatan --}}
    <main class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8 lg:py-14">

        {{-- Informasi daftar --}}
        <div
            class="mb-7 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between"
        >
            <div>

                <h2 class="text-xl font-semibold text-gray-900">
                    Berita dan Kegiatan
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    {{ $posts->total() }} artikel dan kegiatan ditemukan.
                </p>

            </div>

            @if ($posts->hasPages())

                <p class="text-xs text-gray-500">
                    Halaman {{ $posts->currentPage() }}
                    dari {{ $posts->lastPage() }}
                </p>

            @endif
        </div>

        {{-- Grid kegiatan --}}
        <div class="grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-3">

            @forelse ($posts as $post)

                <article
                    class="flex h-full flex-col overflow-hidden rounded-xl border border-gray-200 bg-white"
                >

                    {{-- Gambar --}}
                    <a
                        href="{{ route('blog.show', $post->slug) }}"
                        class="block"
                    >
                        <div
                            class="flex h-52 items-center justify-center overflow-hidden bg-gray-50"
                        >

                            @if ($post->image)

                                <img
                                    src="{{ asset('storage/' . $post->image) }}"
                                    alt="{{ $post->title }}"
                                    class="h-full w-full object-cover"
                                >

                            @else

                                <p class="px-5 text-center text-sm text-gray-400">
                                    Gambar kegiatan belum tersedia
                                </p>

                            @endif

                        </div>
                    </a>

                    {{-- Isi artikel --}}
                    <div class="flex flex-1 flex-col p-5">

                        {{-- Metadata --}}
                        <div
                            class="flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-gray-500"
                        >
                            <span>
                                {{ $post->published_at?->format('d M Y') ?? 'Belum diterbitkan' }}
                            </span>

                            <span class="text-gray-300">
                                •
                            </span>

                            <span>
                                {{ $post->user?->name ?? 'Admin' }}
                            </span>
                        </div>

                        {{-- Judul --}}
                        <h2 class="mt-3 line-clamp-2 text-lg font-semibold leading-7 text-gray-900">

                            <a
                                href="{{ route('blog.show', $post->slug) }}"
                                class="transition hover:text-red-700"
                            >
                                {{ $post->title }}
                            </a>

                        </h2>

                        {{-- Ringkasan --}}
                        <p class="mt-3 line-clamp-4 flex-1 text-sm leading-6 text-gray-600">
                            {{
                                $post->excerpt
                                    ?: \Illuminate\Support\Str::limit(
                                        strip_tags($post->content),
                                        150
                                    )
                            }}
                        </p>

                        {{-- Aksi --}}
                        <div class="mt-5 border-t border-gray-100 pt-4">

                            <a
                                href="{{ route('blog.show', $post->slug) }}"
                                class="text-sm font-semibold text-red-700 transition hover:text-red-900"
                            >
                                Baca selengkapnya
                            </a>

                        </div>

                    </div>

                </article>

            @empty

                <section
                    class="col-span-full rounded-xl border border-gray-200 bg-white px-5 py-14 text-center"
                >

                    <h2 class="text-lg font-semibold text-gray-900">
                        Belum ada kegiatan yang diterbitkan
                    </h2>

                    <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-gray-500">
                        Informasi kegiatan terbaru UMKM Maloppo akan ditampilkan
                        pada halaman ini.
                    </p>

                    <a
                        href="{{ route('home') }}"
                        class="btn-maloppo-secondary mt-5"
                    >
                        Kembali ke Beranda
                    </a>

                </section>

            @endforelse

        </div>

        {{-- Pagination --}}
        @if ($posts->hasPages())

            <div class="mt-8 rounded-xl border border-gray-200 bg-white px-5 py-4">
                {{ $posts->links() }}
            </div>

        @endif

    </main>

    {{-- Informasi singkat --}}
    <section class="border-y border-gray-200 bg-white">

        <div
            class="mx-auto grid max-w-7xl grid-cols-1 gap-6 px-4 py-10 sm:grid-cols-3 sm:px-6 lg:px-8"
        >

            <div>

                <h2 class="text-sm font-semibold text-gray-900">
                    Proses Produksi
                </h2>

                <p class="mt-1 text-xs leading-5 text-gray-500">
                    Informasi mengenai proses pengolahan produk Maloppo.
                </p>

            </div>

            <div>

                <h2 class="text-sm font-semibold text-gray-900">
                    Pelatihan UMKM
                </h2>

                <p class="mt-1 text-xs leading-5 text-gray-500">
                    Dokumentasi pelatihan dan pengembangan usaha.
                </p>

            </div>

            <div>

                <h2 class="text-sm font-semibold text-gray-900">
                    Informasi Terbaru
                </h2>

                <p class="mt-1 text-xs leading-5 text-gray-500">
                    Perkembangan kegiatan dan usaha UMKM Maloppo.
                </p>

            </div>

        </div>

    </section>

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
                    href="{{ route('catalog.index') }}"
                    class="font-medium text-gray-600 transition hover:text-red-700"
                >
                    Lihat Produk
                </a>
            </div>

        </div>

    </footer>

</body>

</html>