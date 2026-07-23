<x-app-layout>

    <x-slot name="header">

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.20em] text-red-700">
                    Kegiatan Maloppo
                </p>

                <h1 class="mt-2 text-3xl font-bold tracking-tight text-gray-900">
                    Daftar Kegiatan
                </h1>

                <p class="mt-2 text-sm leading-6 text-gray-500">
                    Kelola berita, pelatihan, kegiatan, dan informasi UMKM Maloppo.
                </p>
            </div>

            <div class="flex flex-wrap gap-2">

                <a
                    href="{{ route('blog.index') }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="inline-flex items-center justify-center rounded-lg border border-red-200 bg-white px-5 py-3 text-sm font-semibold text-red-700 shadow-sm transition hover:bg-red-50"
                >
                    Lihat Halaman Publik
                </a>

                <a
                    href="{{ route('admin.posts.create') }}"
                    class="inline-flex items-center justify-center rounded-lg bg-red-700 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-red-800"
                >
                    Tambah Kegiatan
                </a>

            </div>

        </div>

    </x-slot>

    <div class="py-8">

        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">

            {{-- Notifikasi berhasil --}}
            @if (session('success'))

                <div class="rounded-2xl border border-green-200 bg-green-50 px-5 py-4 text-sm font-semibold text-green-800 shadow-sm">
                    {{ session('success') }}
                </div>

            @endif

            {{-- Ringkasan kecil --}}
            <section class="grid grid-cols-1 gap-4 sm:grid-cols-3">

                <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-semibold text-gray-500">
                        Total Kegiatan
                    </p>

                    <p class="mt-2 text-3xl font-bold text-gray-900">
                        {{ $posts->total() }}
                    </p>

                    <p class="mt-1 text-xs text-gray-500">
                        Kegiatan tersimpan di sistem.
                    </p>
                </div>

                <div class="rounded-2xl border border-yellow-200 bg-yellow-50 p-5 shadow-sm">
                    <p class="text-sm font-semibold text-red-700">
                        Halaman Publik
                    </p>

                    <p class="mt-2 text-lg font-bold text-gray-900">
                        Informasi UMKM
                    </p>

                    <p class="mt-1 text-xs text-gray-600">
                        Kegiatan yang diterbitkan akan tampil untuk pengunjung.
                    </p>
                </div>

                <div class="rounded-2xl border border-red-100 bg-red-50 p-5 shadow-sm">
                    <p class="text-sm font-semibold text-red-700">
                        Pengelolaan Konten
                    </p>

                    <p class="mt-2 text-lg font-bold text-gray-900">
                        Admin Maloppo
                    </p>

                    <p class="mt-1 text-xs text-gray-600">
                        Perbarui berita, pelatihan, dan aktivitas UMKM secara berkala.
                    </p>
                </div>

            </section>

            {{-- Daftar kegiatan --}}
            <section class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">

                {{-- Header daftar --}}
                <div class="flex flex-col gap-3 border-b border-gray-200 bg-white px-6 py-5 sm:flex-row sm:items-center sm:justify-between">

                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">
                            Data Kegiatan
                        </h2>

                        <p class="mt-1 text-sm text-gray-500">
                            {{ $posts->total() }} kegiatan tersimpan di dalam sistem.
                        </p>
                    </div>

                    @if ($posts->hasPages())

                        <div class="rounded-full bg-gray-100 px-4 py-2 text-xs font-semibold text-gray-600">
                            Halaman {{ $posts->currentPage() }} dari {{ $posts->lastPage() }}
                        </div>

                    @endif

                </div>

                {{-- Tampilan desktop --}}
                <div class="hidden overflow-x-auto md:block">

                    <table class="min-w-full divide-y divide-gray-200">

                        <thead class="bg-gray-50">
                            <tr>
                                <th class="w-16 px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">
                                    No
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">
                                    Kegiatan
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">
                                    Penulis
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">
                                    Status
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">
                                    Tanggal Terbit
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">
                                    Dibuat
                                </th>

                                <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-gray-500">
                                    Aksi
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100 bg-white">

                            @forelse ($posts as $post)

                                <tr class="transition hover:bg-gray-50">

                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $posts->firstItem() + $loop->index }}
                                    </td>

                                    {{-- Informasi kegiatan --}}
                                    <td class="px-6 py-4">

                                        <div class="flex items-center gap-4">

                                            <div class="flex h-14 w-14 shrink-0 items-center justify-center overflow-hidden rounded-2xl border border-yellow-200 bg-yellow-50">
                                                @if ($post->image)

                                                    <img
                                                        src="{{ asset('storage/' . $post->image) }}"
                                                        alt="{{ $post->title }}"
                                                        class="h-full w-full object-cover"
                                                    >

                                                @else

                                                    <span class="text-[10px] font-semibold text-gray-400">
                                                        Foto
                                                    </span>

                                                @endif
                                            </div>

                                            <div class="min-w-0">

                                                <p class="max-w-sm truncate font-bold text-gray-900">
                                                    {{ $post->title }}
                                                </p>

                                                <p class="mt-1 max-w-md truncate text-xs leading-5 text-gray-500">
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
                                    <td class="px-6 py-4 text-sm font-medium text-gray-600">
                                        {{ $post->user?->name ?? 'Admin' }}
                                    </td>

                                    {{-- Status --}}
                                    <td class="px-6 py-4">

                                        @if ($post->is_published)

                                            <span class="inline-flex rounded-full bg-green-50 px-3 py-1 text-xs font-bold text-green-700">
                                                Diterbitkan
                                            </span>

                                        @else

                                            <span class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-xs font-bold text-gray-600">
                                                Draf
                                            </span>

                                        @endif

                                    </td>

                                    {{-- Tanggal terbit --}}
                                    <td class="px-6 py-4">

                                        @if ($post->published_at)

                                            <p class="text-sm font-semibold text-gray-700">
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
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ $post->created_at->format('d M Y') }}
                                    </td>

                                    {{-- Aksi --}}
                                    <td class="px-6 py-4">

                                        <div class="flex items-center justify-end gap-3">

                                            <a
                                                href="{{ route('admin.posts.edit', $post) }}"
                                                class="inline-flex items-center justify-center rounded-lg border border-gray-200 px-3 py-2 text-sm font-semibold text-gray-700 transition hover:bg-gray-50 hover:text-red-700"
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
                                                    class="inline-flex items-center justify-center rounded-lg border border-red-200 px-3 py-2 text-sm font-semibold text-red-700 transition hover:bg-red-50 hover:text-red-900"
                                                >
                                                    Hapus
                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="7" class="px-6 py-16 text-center">

                                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-red-50 text-2xl">
                                            📝
                                        </div>

                                        <p class="mt-4 text-lg font-bold text-gray-800">
                                            Belum ada kegiatan
                                        </p>

                                        <p class="mt-1 text-sm text-gray-500">
                                            Tambahkan kegiatan pertama UMKM Maloppo.
                                        </p>

                                        <a
                                            href="{{ route('admin.posts.create') }}"
                                            class="mt-5 inline-flex items-center justify-center rounded-lg bg-red-700 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-red-800"
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

                        <article class="p-5">

                            <div class="flex items-start gap-4">

                                {{-- Gambar --}}
                                <div class="flex h-20 w-20 shrink-0 items-center justify-center overflow-hidden rounded-2xl border border-yellow-200 bg-yellow-50">

                                    @if ($post->image)

                                        <img
                                            src="{{ asset('storage/' . $post->image) }}"
                                            alt="{{ $post->title }}"
                                            class="h-full w-full object-cover"
                                        >

                                    @else

                                        <span class="text-xs font-semibold text-gray-400">
                                            Foto
                                        </span>

                                    @endif

                                </div>

                                {{-- Informasi --}}
                                <div class="min-w-0 flex-1">

                                    <div class="flex items-start justify-between gap-3">

                                        <div class="min-w-0">

                                            <p class="text-[11px] font-semibold text-gray-400">
                                                Kegiatan #{{ $posts->firstItem() + $loop->index }}
                                            </p>

                                            <h3 class="mt-1 line-clamp-2 text-sm font-bold leading-5 text-gray-900">
                                                {{ $post->title }}
                                            </h3>

                                        </div>

                                        @if ($post->is_published)

                                            <span class="shrink-0 rounded-full bg-green-50 px-2 py-1 text-[10px] font-bold text-green-700">
                                                Terbit
                                            </span>

                                        @else

                                            <span class="shrink-0 rounded-full bg-gray-100 px-2 py-1 text-[10px] font-bold text-gray-600">
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
                            <div class="mt-4 flex flex-wrap gap-x-5 gap-y-1 text-xs text-gray-500">

                                <span class="font-medium text-gray-600">
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
                            <div class="mt-4 flex items-center justify-end gap-3 border-t border-gray-100 pt-4">

                                <a
                                    href="{{ route('admin.posts.edit', $post) }}"
                                    class="inline-flex items-center justify-center rounded-lg border border-gray-200 px-4 py-2 text-sm font-semibold text-gray-700"
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
                                        class="inline-flex items-center justify-center rounded-lg border border-red-200 px-4 py-2 text-sm font-semibold text-red-700"
                                    >
                                        Hapus
                                    </button>

                                </form>

                            </div>

                        </article>

                    @empty

                        <div class="px-5 py-16 text-center">

                            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-red-50 text-2xl">
                                📝
                            </div>

                            <p class="mt-4 text-lg font-bold text-gray-800">
                                Belum ada kegiatan
                            </p>

                            <p class="mt-1 text-sm text-gray-500">
                                Tambahkan kegiatan pertama UMKM Maloppo.
                            </p>

                            <a
                                href="{{ route('admin.posts.create') }}"
                                class="mt-5 inline-flex items-center justify-center rounded-lg bg-red-700 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-red-800"
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