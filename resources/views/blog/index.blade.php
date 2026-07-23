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

<body class="bg-white text-gray-900">

    {{-- Navigasi --}}
    <x-public-navbar />

    {{-- Header halaman --}}
    <header class="relative overflow-hidden bg-gradient-to-br from-red-700 via-red-600 to-yellow-500">

        <div class="absolute inset-0 bg-black/10"></div>

        <div class="relative mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8 lg:py-16">

            <div class="grid grid-cols-1 gap-8 lg:grid-cols-2 lg:items-center">

                <div class="text-white">

                    <p class="text-sm font-semibold uppercase tracking-[0.25em] text-yellow-100">
                        Blog dan Kegiatan
                    </p>

                    <h1 class="mt-4 max-w-3xl text-4xl font-bold leading-tight tracking-tight sm:text-5xl">
                        Kegiatan terbaru UMKM Maloppo.
                    </h1>

                    <p class="mt-5 max-w-2xl text-base leading-8 text-red-50">
                        Temukan informasi mengenai kegiatan, pelatihan, proses
                        produksi, pameran, dan perkembangan usaha UMKM Maloppo.
                    </p>

                    <a
                        href="{{ route('catalog.index') }}"
                        class="mt-7 inline-flex items-center justify-center rounded-lg bg-white px-5 py-3 text-sm font-semibold text-red-700 shadow-sm transition hover:bg-yellow-50"
                    >
                        Lihat Produk
                    </a>

                </div>

                <div class="rounded-3xl bg-white/95 p-6 shadow-xl">

                    <p class="text-sm font-semibold text-gray-900">
                        Informasi Maloppo
                    </p>

                    <div class="mt-5 grid grid-cols-1 gap-4 sm:grid-cols-3">

                        <div class="rounded-2xl bg-yellow-50 p-5">
                            <p class="text-sm font-semibold text-red-700">
                                Produksi
                            </p>

                            <p class="mt-2 text-xs leading-5 text-gray-600">
                                Informasi pengolahan minyak kelapa.
                            </p>
                        </div>

                        <div class="rounded-2xl bg-red-50 p-5">
                            <p class="text-sm font-semibold text-red-700">
                                Pelatihan
                            </p>

                            <p class="mt-2 text-xs leading-5 text-gray-600">
                                Dokumentasi pengembangan UMKM.
                            </p>
                        </div>

                        <div class="rounded-2xl bg-yellow-50 p-5">
                            <p class="text-sm font-semibold text-red-700">
                                Kegiatan
                            </p>

                            <p class="mt-2 text-xs leading-5 text-gray-600">
                                Aktivitas terbaru UMKM Maloppo.
                            </p>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </header>

    {{-- Daftar kegiatan --}}
    <main class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8 lg:py-16">

        {{-- Judul daftar --}}
        <div class="mx-auto max-w-3xl text-center">

            <p class="text-sm font-semibold uppercase tracking-[0.25em] text-red-700">
                Berita dan Kegiatan
            </p>

            <h2 class="mt-4 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                Cerita dan perkembangan Maloppo.
            </h2>

            <p class="mt-4 text-base leading-7 text-gray-600">
                {{ $posts->total() }} artikel dan kegiatan ditemukan. Halaman ini
                menampilkan informasi terbaru seputar UMKM Maloppo.
            </p>

            @if ($posts->hasPages())

                <p class="mt-3 text-xs text-gray-500">
                    Halaman {{ $posts->currentPage() }} dari {{ $posts->lastPage() }}
                </p>

            @endif

        </div>

        {{-- Grid kegiatan --}}
        <div class="mt-10 grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">

            @forelse ($posts as $post)

                <article class="flex h-full flex-col overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-md">

                    {{-- Gambar --}}
                    <a
                        href="{{ route('blog.show', $post->slug) }}"
                        class="block"
                    >
                        <div class="flex h-56 items-center justify-center overflow-hidden bg-yellow-50">

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
                        <div class="flex flex-wrap items-center gap-2 text-xs">

                            <span class="rounded-full bg-yellow-100 px-2.5 py-1 font-semibold text-red-700">
                                {{ $post->published_at?->format('d M Y') ?? 'Belum diterbitkan' }}
                            </span>

                            <span class="rounded-full bg-gray-100 px-2.5 py-1 font-semibold text-gray-600">
                                {{ $post->user?->name ?? 'Admin' }}
                            </span>

                        </div>

                        {{-- Judul --}}
                        <h2 class="mt-4 line-clamp-2 text-xl font-bold leading-7 text-gray-900">

                            <a
                                href="{{ route('blog.show', $post->slug) }}"
                                class="transition hover:text-red-700"
                            >
                                {{ $post->title }}
                            </a>

                        </h2>

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

                        {{-- Aksi --}}
                        <div class="mt-6 border-t border-gray-100 pt-5">

                            <a
                                href="{{ route('blog.show', $post->slug) }}"
                                class="inline-flex w-full items-center justify-center rounded-lg border border-red-200 px-4 py-3 text-sm font-semibold text-red-700 transition hover:bg-red-50"
                            >
                                Baca Selengkapnya
                            </a>

                        </div>

                    </div>

                </article>

            @empty

                <section class="col-span-full rounded-3xl border border-gray-200 bg-white px-5 py-16 text-center shadow-sm">

                    <p class="text-sm font-semibold uppercase tracking-[0.25em] text-red-700">
                        Belum Ada Kegiatan
                    </p>

                    <h2 class="mt-4 text-3xl font-bold text-gray-900">
                        Kegiatan belum diterbitkan.
                    </h2>

                    <p class="mx-auto mt-3 max-w-md text-sm leading-7 text-gray-600">
                        Informasi kegiatan terbaru UMKM Maloppo akan ditampilkan
                        pada halaman ini.
                    </p>

                    <a
                        href="{{ route('home') }}"
                        class="mt-6 inline-flex items-center justify-center rounded-lg bg-red-700 px-5 py-3 text-sm font-semibold text-white transition hover:bg-red-800"
                    >
                        Kembali ke Beranda
                    </a>

                </section>

            @endforelse

        </div>

        {{-- Pagination --}}
        @if ($posts->hasPages())

            <div class="mt-10 rounded-2xl border border-gray-200 bg-white px-5 py-4">
                {{ $posts->links() }}
            </div>

        @endif

    </main>

    {{-- Informasi singkat --}}
    <section class="bg-yellow-50">

        <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">

            <div class="mx-auto max-w-3xl text-center">

                <p class="text-sm font-semibold uppercase tracking-[0.25em] text-red-700">
                    Informasi Website
                </p>

                <h2 class="mt-4 text-3xl font-bold tracking-tight text-gray-900">
                    Mengenal aktivitas UMKM Maloppo.
                </h2>

            </div>

            <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-3">

                <div class="rounded-2xl border border-yellow-200 bg-white p-6 shadow-sm">

                    <h3 class="text-base font-bold text-gray-900">
                        Proses Produksi
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-gray-600">
                        Informasi mengenai proses pengolahan produk minyak kelapa Maloppo.
                    </p>

                </div>

                <div class="rounded-2xl border border-yellow-200 bg-white p-6 shadow-sm">

                    <h3 class="text-base font-bold text-gray-900">
                        Pelatihan UMKM
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-gray-600">
                        Dokumentasi pelatihan dan kegiatan pengembangan usaha.
                    </p>

                </div>

                <div class="rounded-2xl border border-yellow-200 bg-white p-6 shadow-sm">

                    <h3 class="text-base font-bold text-gray-900">
                        Informasi Terbaru
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-gray-600">
                        Perkembangan kegiatan dan usaha UMKM Maloppo.
                    </p>

                </div>

            </div>

        </div>

    </section>

    {{-- Footer --}}
    <x-public-footer />

</body>

</html>