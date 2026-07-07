<x-app-layout>

    <x-slot name="header">

        <div
            class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"
        >
            <div>
                <h1 class="page-title-maloppo">
                    Kegiatan
                </h1>

                <p class="page-description-maloppo">
                    Kelola berita, pelatihan, kegiatan, dan informasi UMKM Maloppo.
                </p>
            </div>

            <div class="flex flex-wrap gap-2">

                <a
                    href="{{ route('blog.index') }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="btn-maloppo-secondary"
                >
                    Lihat Halaman Publik
                </a>

                <a
                    href="{{ route('admin.posts.create') }}"
                    class="btn-maloppo-primary"
                >
                    Tambah Kegiatan
                </a>

            </div>
        </div>

    </x-slot>

    <div class="py-6 lg:py-8">

        <div class="mx-auto max-w-7xl space-y-5 px-4 sm:px-6 lg:px-8">

            {{-- Notifikasi berhasil --}}
            @if (session('success'))

                <div class="alert-maloppo-success">
                    {{ session('success') }}
                </div>

            @endif

            {{-- Daftar kegiatan --}}
            <section class="panel-maloppo overflow-hidden">

                {{-- Header daftar --}}
                <div
                    class="flex flex-col gap-3 border-b border-gray-200 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6"
                >
                    <div>
                        <h2 class="section-title-maloppo">
                            Daftar Kegiatan
                        </h2>

                        <p class="section-description-maloppo">
                            {{ $posts->total() }} kegiatan tersimpan di dalam sistem.
                        </p>
                    </div>

                    @if ($posts->hasPages())

                        <p class="text-xs text-gray-500">
                            Halaman {{ $posts->currentPage() }}
                            dari {{ $posts->lastPage() }}
                        </p>

                    @endif
                </div>

                {{-- Tampilan desktop --}}
                <div class="hidden overflow-x-auto md:block">

                    <table class="table-maloppo">

                        <thead>
                            <tr>
                                <th class="w-16">
                                    No.
                                </th>

                                <th>
                                    Kegiatan
                                </th>

                                <th>
                                    Penulis
                                </th>

                                <th>
                                    Status
                                </th>

                                <th>
                                    Tanggal Terbit
                                </th>

                                <th>
                                    Dibuat
                                </th>

                                <th class="text-right">
                                    Aksi
                                </th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse ($posts as $post)

                                <tr>

                                    <td class="text-gray-500">
                                        {{ $posts->firstItem() + $loop->index }}
                                    </td>

                                    {{-- Informasi kegiatan --}}
                                    <td>

                                        <div class="flex items-center gap-3">

                                            <div
                                                class="flex h-11 w-11 shrink-0 items-center justify-center overflow-hidden rounded-lg border border-gray-200 bg-gray-50"
                                            >
                                                @if ($post->image)

                                                    <img
                                                        src="{{ asset('storage/' . $post->image) }}"
                                                        alt="{{ $post->title }}"
                                                        class="h-full w-full object-cover"
                                                    >

                                                @else

                                                    <span class="text-[10px] font-medium text-gray-400">
                                                        Foto
                                                    </span>

                                                @endif
                                            </div>

                                            <div class="min-w-0">

                                                <p class="max-w-sm truncate font-medium text-gray-900">
                                                    {{ $post->title }}
                                                </p>

                                                <p class="mt-1 max-w-sm truncate text-xs text-gray-500">
                                                    {{
                                                        $post->excerpt
                                                        ?: \Illuminate\Support\Str::limit(
                                                            strip_tags($post->content),
                                                            90
                                                        )
                                                    }}
                                                </p>

                                            </div>

                                        </div>

                                    </td>

                                    {{-- Penulis --}}
                                    <td class="text-sm text-gray-600">
                                        {{ $post->user?->name ?? 'Admin' }}
                                    </td>

                                    {{-- Status --}}
                                    <td>

                                        @if ($post->is_published)

                                            <span
                                                class="inline-flex rounded-full bg-green-50 px-2.5 py-1 text-xs font-medium text-green-700"
                                            >
                                                Diterbitkan
                                            </span>

                                        @else

                                            <span
                                                class="inline-flex rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-600"
                                            >
                                                Draf
                                            </span>

                                        @endif

                                    </td>

                                    {{-- Tanggal terbit --}}
                                    <td>

                                        @if ($post->published_at)

                                            <p class="text-sm text-gray-700">
                                                {{ $post->published_at->format('d M Y') }}
                                            </p>

                                            <p class="mt-1 text-xs text-gray-400">
                                                {{ $post->published_at->format('H:i') }}
                                            </p>

                                        @else

                                            <span class="text-sm text-gray-400">
                                                Belum terbit
                                            </span>

                                        @endif

                                    </td>

                                    {{-- Tanggal dibuat --}}
                                    <td class="text-sm text-gray-600">
                                        {{ $post->created_at->format('d M Y') }}
                                    </td>

                                    {{-- Aksi --}}
                                    <td>

                                        <div class="flex items-center justify-end gap-4">

                                            <a
                                                href="{{ route('admin.posts.edit', $post) }}"
                                                class="text-sm font-medium text-gray-700 transition hover:text-red-700"
                                            >
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
                                                    class="text-sm font-medium text-red-700 transition hover:text-red-900"
                                                >
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
                                        class="py-14 text-center"
                                    >
                                        <p class="font-medium text-gray-700">
                                            Belum ada kegiatan
                                        </p>

                                        <p class="mt-1 text-sm text-gray-500">
                                            Tambahkan kegiatan pertama UMKM Maloppo.
                                        </p>

                                        <a
                                            href="{{ route('admin.posts.create') }}"
                                            class="btn-maloppo-primary mt-4"
                                        >
                                            Tambah Kegiatan
                                        </a>
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                {{-- Tampilan HP --}}
                <div class="divide-y divide-gray-100 md:hidden">

                    @forelse ($posts as $post)

                        <article class="p-4">

                            <div class="flex items-start gap-3">

                                {{-- Gambar --}}
                                <div
                                    class="flex h-16 w-16 shrink-0 items-center justify-center overflow-hidden rounded-lg border border-gray-200 bg-gray-50"
                                >
                                    @if ($post->image)

                                        <img
                                            src="{{ asset('storage/' . $post->image) }}"
                                            alt="{{ $post->title }}"
                                            class="h-full w-full object-cover"
                                        >

                                    @else

                                        <span class="text-xs font-medium text-gray-400">
                                            Foto
                                        </span>

                                    @endif
                                </div>

                                {{-- Informasi --}}
                                <div class="min-w-0 flex-1">

                                    <div class="flex items-start justify-between gap-3">

                                        <div class="min-w-0">

                                            <p class="text-[11px] text-gray-400">
                                                Kegiatan #{{ $posts->firstItem() + $loop->index }}
                                            </p>

                                            <h3 class="mt-1 line-clamp-2 text-sm font-semibold leading-5 text-gray-900">
                                                {{ $post->title }}
                                            </h3>

                                        </div>

                                        @if ($post->is_published)

                                            <span
                                                class="shrink-0 rounded-full bg-green-50 px-2 py-1 text-[10px] font-medium text-green-700"
                                            >
                                                Terbit
                                            </span>

                                        @else

                                            <span
                                                class="shrink-0 rounded-full bg-gray-100 px-2 py-1 text-[10px] font-medium text-gray-600"
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
                                                100
                                            )
                                        }}
                                    </p>

                                </div>

                            </div>

                            {{-- Informasi tambahan --}}
                            <div class="mt-3 flex flex-wrap gap-x-5 gap-y-1 text-xs text-gray-500">

                                <span>
                                    {{ $post->user?->name ?? 'Admin' }}
                                </span>

                                <span>
                                    {{
                                        $post->published_at
                                            ? $post->published_at->format('d M Y')
                                            : 'Belum diterbitkan'
                                    }}
                                </span>

                            </div>

                            {{-- Aksi --}}
                            <div
                                class="mt-4 flex items-center justify-end gap-4 border-t border-gray-100 pt-3"
                            >
                                <a
                                    href="{{ route('admin.posts.edit', $post) }}"
                                    class="text-sm font-medium text-gray-700"
                                >
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
                                        class="text-sm font-medium text-red-700"
                                    >
                                        Hapus
                                    </button>

                                </form>
                            </div>

                        </article>

                    @empty

                        <div class="px-5 py-12 text-center">

                            <p class="font-medium text-gray-700">
                                Belum ada kegiatan
                            </p>

                            <p class="mt-1 text-sm text-gray-500">
                                Tambahkan kegiatan pertama UMKM Maloppo.
                            </p>

                            <a
                                href="{{ route('admin.posts.create') }}"
                                class="btn-maloppo-primary mt-4"
                            >
                                Tambah Kegiatan
                            </a>

                        </div>

                    @endforelse

                </div>

                {{-- Pagination --}}
                @if ($posts->hasPages())

                    <div class="border-t border-gray-200 bg-gray-50 px-5 py-4">
                        {{ $posts->links() }}
                    </div>

                @endif

            </section>

        </div>

    </div>

</x-app-layout>