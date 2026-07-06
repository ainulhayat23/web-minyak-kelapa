<x-app-layout>

    <x-slot name="header">

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h1 class="text-2xl font-extrabold leading-tight text-gray-900">
                    Blog dan Kegiatan
                </h1>

                <p class="mt-2 text-sm font-normal text-gray-600">
                    Kelola berita, kegiatan, pelatihan, dan informasi UMKM Maloppo.
                </p>
            </div>

            <a
                href="{{ route('admin.posts.create') }}"
                class="btn-maloppo-primary"
            >
                <span class="text-lg">+</span>
                Tambah Kegiatan
            </a>

        </div>

    </x-slot>

    <div class="py-8 lg:py-10">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Notifikasi berhasil --}}
            @if (session('success'))

                <div
                    class="mb-7 flex items-start gap-3 rounded-xl border px-5 py-4 text-sm"
                    style="
                        background-color: #dcfce7;
                        border-color: #86efac;
                        color: #166534;
                    "
                >
                    <span
                        class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full font-bold"
                        style="background-color: #bbf7d0;"
                    >
                        ✓
                    </span>

                    <p class="pt-1 font-medium">
                        {{ session('success') }}
                    </p>
                </div>

            @endif

            {{-- Statistik kegiatan --}}
            <section class="mb-7 grid grid-cols-1 gap-4 sm:grid-cols-3">

                {{-- Total kegiatan --}}
                <article class="card-maloppo p-5">

                    <div class="flex items-center justify-between gap-4">

                        <div>
                            <p class="text-sm font-semibold text-gray-500">
                                Total Kegiatan
                            </p>

                            <p class="mt-2 text-3xl font-extrabold text-gray-900">
                                {{ $posts->total() }}
                            </p>

                            <p class="mt-1 text-xs text-gray-500">
                                Seluruh data kegiatan
                            </p>
                        </div>

                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-xl text-xl"
                            style="background-color: #fff9b0;"
                        >
                            📰
                        </div>

                    </div>

                </article>

                {{-- Ditampilkan --}}
                <article class="card-maloppo p-5">

                    <div class="flex items-center justify-between gap-4">

                        <div>
                            <p class="text-sm font-semibold text-gray-500">
                                Ditampilkan
                            </p>

                            <p class="mt-2 text-3xl font-extrabold text-gray-900">
                                {{ $posts->count() }}
                            </p>

                            <p class="mt-1 text-xs text-gray-500">
                                Data pada halaman ini
                            </p>
                        </div>

                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-xl text-xl"
                            style="
                                background-color: #dcfce7;
                                color: #166534;
                            "
                        >
                            ✓
                        </div>

                    </div>

                </article>

                {{-- Halaman aktif --}}
                <article class="card-maloppo p-5">

                    <div class="flex items-center justify-between gap-4">

                        <div>
                            <p class="text-sm font-semibold text-gray-500">
                                Halaman Aktif
                            </p>

                            <p class="mt-2 text-3xl font-extrabold text-gray-900">
                                {{ $posts->currentPage() }}
                            </p>

                            <p class="mt-1 text-xs text-gray-500">
                                Dari {{ $posts->lastPage() }} halaman
                            </p>
                        </div>

                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-xl text-xl"
                            style="
                                background-color: #fee2e2;
                                color: #991b1b;
                            "
                        >
                            📄
                        </div>

                    </div>

                </article>

            </section>

            {{-- Daftar kegiatan --}}
            <section class="card-maloppo overflow-hidden">

                {{-- Header kartu --}}
                <div
                    class="flex flex-col gap-4 border-b px-6 py-5 sm:flex-row sm:items-center sm:justify-between"
                    style="
                        background-color: #fffdf0;
                        border-color: #f1e7a4;
                    "
                >

                    <div class="flex items-center gap-4">

                        <div
                            class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl text-xl"
                            style="background-color: #f7e900;"
                        >
                            📰
                        </div>

                        <div>
                            <h2 class="text-xl font-extrabold text-gray-900">
                                Daftar Kegiatan Maloppo
                            </h2>

                            <p class="mt-1 text-sm text-gray-500">
                                Informasi kegiatan yang tersimpan di dalam sistem.
                            </p>
                        </div>

                    </div>

                    <a
                        href="{{ route('blog.index') }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="btn-maloppo-secondary"
                    >
                        <span>🌐</span>
                        Lihat Halaman Kegiatan
                    </a>

                </div>

                {{-- Tabel desktop --}}
                <div class="hidden overflow-x-auto md:block">

                    <table class="w-full border-collapse text-left">

                        <thead>

                            <tr
                                class="border-b"
                                style="
                                    background-color: #fff9b0;
                                    border-color: #f1e7a4;
                                "
                            >

                                <th class="px-5 py-4 text-xs font-bold uppercase tracking-wider text-gray-700">
                                    No.
                                </th>

                                <th class="px-5 py-4 text-xs font-bold uppercase tracking-wider text-gray-700">
                                    Kegiatan
                                </th>

                                <th class="px-5 py-4 text-xs font-bold uppercase tracking-wider text-gray-700">
                                    Penulis
                                </th>

                                <th class="px-5 py-4 text-xs font-bold uppercase tracking-wider text-gray-700">
                                    Status
                                </th>

                                <th class="px-5 py-4 text-xs font-bold uppercase tracking-wider text-gray-700">
                                    Tanggal Terbit
                                </th>

                                <th class="px-5 py-4 text-xs font-bold uppercase tracking-wider text-gray-700">
                                    Dibuat
                                </th>

                                <th class="px-5 py-4 text-center text-xs font-bold uppercase tracking-wider text-gray-700">
                                    Aksi
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse ($posts as $post)

                                <tr
                                    class="border-b transition last:border-b-0 hover:bg-yellow-50/40"
                                    style="border-color: #f1e7a4;"
                                >

                                    <td class="px-5 py-4 text-sm font-semibold text-gray-500">
                                        {{ $posts->firstItem() + $loop->index }}
                                    </td>

                                    {{-- Informasi kegiatan --}}
                                    <td class="px-5 py-4">

                                        <div class="flex items-center gap-4">

                                            <div
                                                class="flex h-14 w-14 shrink-0 items-center justify-center overflow-hidden rounded-xl border"
                                                style="
                                                    background-color: #fffdf0;
                                                    border-color: #f1e7a4;
                                                "
                                            >

                                                @if ($post->image)

                                                    <img
                                                        src="{{ asset('storage/' . $post->image) }}"
                                                        alt="{{ $post->title }}"
                                                        class="h-full w-full object-cover"
                                                    >

                                                @else

                                                    <span class="text-2xl">
                                                        📰
                                                    </span>

                                                @endif

                                            </div>

                                            <div class="min-w-0">

                                                <p class="font-bold text-gray-900">
                                                    {{ $post->title }}
                                                </p>

                                                <p class="mt-1 max-w-xs truncate text-xs text-gray-500">
                                                    {{
                                                        $post->excerpt
                                                        ?: \Illuminate\Support\Str::limit(
                                                            strip_tags($post->content),
                                                            80
                                                        )
                                                    }}
                                                </p>

                                            </div>

                                        </div>

                                    </td>

                                    {{-- Penulis --}}
                                    <td class="px-5 py-4">

                                        <div class="flex items-center gap-2">

                                            <div
                                                class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full text-xs font-bold text-white"
                                                style="background-color: #be0000;"
                                            >
                                                {{ strtoupper(substr($post->user?->name ?? 'A', 0, 1)) }}
                                            </div>

                                            <span class="text-sm font-medium text-gray-700">
                                                {{ $post->user?->name ?? 'Admin' }}
                                            </span>

                                        </div>

                                    </td>

                                    {{-- Status --}}
                                    <td class="px-5 py-4">

                                        @if ($post->is_published)

                                            <span
                                                class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-bold"
                                                style="
                                                    background-color: #dcfce7;
                                                    color: #166534;
                                                "
                                            >
                                                <span>✓</span>
                                                Diterbitkan
                                            </span>

                                        @else

                                            <span
                                                class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-bold"
                                                style="
                                                    background-color: #fff9b0;
                                                    color: #92400e;
                                                "
                                            >
                                                <span>📝</span>
                                                Draf
                                            </span>

                                        @endif

                                    </td>

                                    {{-- Tanggal terbit --}}
                                    <td class="px-5 py-4 text-sm text-gray-600">

                                        @if ($post->published_at)

                                            <div>
                                                <p class="font-semibold text-gray-700">
                                                    {{ $post->published_at->format('d M Y') }}
                                                </p>

                                                <p class="mt-1 text-xs text-gray-400">
                                                    {{ $post->published_at->format('H:i') }}
                                                </p>
                                            </div>

                                        @else

                                            <span class="text-gray-400">
                                                Belum diterbitkan
                                            </span>

                                        @endif

                                    </td>

                                    {{-- Tanggal dibuat --}}
                                    <td class="px-5 py-4 text-sm text-gray-600">
                                        {{ $post->created_at->format('d M Y') }}
                                    </td>

                                    {{-- Aksi --}}
                                    <td class="px-5 py-4">

                                        <div class="flex items-center justify-center gap-2">

                                            <a
                                                href="{{ route('admin.posts.edit', $post) }}"
                                                class="inline-flex items-center justify-center gap-1.5 rounded-lg px-4 py-2 text-xs font-bold shadow-sm"
                                                style="
                                                    background-color: #f7e900;
                                                    color: #990100;
                                                "
                                            >
                                                <span>✏️</span>
                                                Edit
                                            </a>

                                            <form
                                                action="{{ route('admin.posts.destroy', $post) }}"
                                                method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus kegiatan ini?')"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="inline-flex items-center justify-center gap-1.5 rounded-lg px-4 py-2 text-xs font-bold text-white shadow-sm"
                                                    style="background-color: #be0000;"
                                                >
                                                    <span>🗑️</span>
                                                    Hapus
                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="7"
                                        class="px-6 py-20 text-center"
                                    >

                                        <div
                                            class="mx-auto flex h-20 w-20 items-center justify-center rounded-full text-5xl"
                                            style="background-color: #fff9b0;"
                                        >
                                            📰
                                        </div>

                                        <h3 class="mt-5 text-lg font-bold text-gray-800">
                                            Belum ada kegiatan
                                        </h3>

                                        <p class="mt-2 text-sm text-gray-500">
                                            Tambahkan kegiatan pertama UMKM Maloppo.
                                        </p>

                                        <a
                                            href="{{ route('admin.posts.create') }}"
                                            class="btn-maloppo-primary mt-6"
                                        >
                                            + Tambah Kegiatan
                                        </a>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                {{-- Tampilan HP --}}
                <div
                    class="divide-y md:hidden"
                    style="border-color: #f1e7a4;"
                >

                    @forelse ($posts as $post)

                        <article class="p-5">

                            <div class="flex items-start gap-4">

                                {{-- Gambar --}}
                                <div
                                    class="flex h-24 w-24 shrink-0 items-center justify-center overflow-hidden rounded-2xl border"
                                    style="
                                        background-color: #fffdf0;
                                        border-color: #f1e7a4;
                                    "
                                >

                                    @if ($post->image)

                                        <img
                                            src="{{ asset('storage/' . $post->image) }}"
                                            alt="{{ $post->title }}"
                                            class="h-full w-full object-cover"
                                        >

                                    @else

                                        <span class="text-4xl">
                                            📰
                                        </span>

                                    @endif

                                </div>

                                {{-- Informasi --}}
                                <div class="min-w-0 flex-1">

                                    <div class="flex items-start justify-between gap-3">

                                        <div>

                                            <p class="text-xs font-semibold text-gray-400">
                                                Kegiatan #{{ $posts->firstItem() + $loop->index }}
                                            </p>

                                            <h3 class="mt-1 font-extrabold leading-6 text-gray-900">
                                                {{ $post->title }}
                                            </h3>

                                        </div>

                                        @if ($post->is_published)

                                            <span
                                                class="shrink-0 rounded-full px-2.5 py-1 text-xs font-bold"
                                                style="
                                                    background-color: #dcfce7;
                                                    color: #166534;
                                                "
                                            >
                                                Terbit
                                            </span>

                                        @else

                                            <span
                                                class="shrink-0 rounded-full px-2.5 py-1 text-xs font-bold"
                                                style="
                                                    background-color: #fff9b0;
                                                    color: #92400e;
                                                "
                                            >
                                                Draf
                                            </span>

                                        @endif

                                    </div>

                                    <p class="mt-2 line-clamp-2 text-xs leading-5 text-gray-500">
                                        {{
                                            $post->excerpt
                                            ?: \Illuminate\Support\Str::limit(
                                                strip_tags($post->content),
                                                80
                                            )
                                        }}
                                    </p>

                                </div>

                            </div>

                            {{-- Detail tambahan --}}
                            <div
                                class="mt-5 grid grid-cols-2 gap-3 rounded-xl p-4"
                                style="background-color: #fffdf0;"
                            >

                                <div>
                                    <p class="text-xs text-gray-400">
                                        Penulis
                                    </p>

                                    <p class="mt-1 text-sm font-semibold text-gray-700">
                                        {{ $post->user?->name ?? 'Admin' }}
                                    </p>
                                </div>

                                <div>
                                    <p class="text-xs text-gray-400">
                                        Tanggal Terbit
                                    </p>

                                    <p class="mt-1 text-sm font-semibold text-gray-700">
                                        {{ $post->published_at?->format('d M Y') ?? '-' }}
                                    </p>
                                </div>

                            </div>

                            {{-- Tombol --}}
                            <div class="mt-5 grid grid-cols-2 gap-3">

                                <a
                                    href="{{ route('admin.posts.edit', $post) }}"
                                    class="inline-flex items-center justify-center gap-2 rounded-xl px-4 py-3 text-sm font-bold"
                                    style="
                                        background-color: #f7e900;
                                        color: #990100;
                                    "
                                >
                                    <span>✏️</span>
                                    Edit
                                </a>

                                <form
                                    action="{{ route('admin.posts.destroy', $post) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus kegiatan ini?')"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="inline-flex w-full items-center justify-center gap-2 rounded-xl px-4 py-3 text-sm font-bold text-white"
                                        style="background-color: #be0000;"
                                    >
                                        <span>🗑️</span>
                                        Hapus
                                    </button>

                                </form>

                            </div>

                        </article>

                    @empty

                        <div class="px-6 py-16 text-center">

                            <div
                                class="mx-auto flex h-20 w-20 items-center justify-center rounded-full text-5xl"
                                style="background-color: #fff9b0;"
                            >
                                📰
                            </div>

                            <h3 class="mt-5 font-bold text-gray-800">
                                Belum ada kegiatan
                            </h3>

                            <a
                                href="{{ route('admin.posts.create') }}"
                                class="btn-maloppo-primary mt-5"
                            >
                                Tambah Kegiatan
                            </a>

                        </div>

                    @endforelse

                </div>

                {{-- Pagination --}}
                @if ($posts->hasPages())

                    <div
                        class="border-t px-5 py-5"
                        style="
                            background-color: #fffdf0;
                            border-color: #f1e7a4;
                        "
                    >
                        {{ $posts->links() }}
                    </div>

                @endif

            </section>

        </div>

    </div>

</x-app-layout>