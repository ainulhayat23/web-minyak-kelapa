<x-app-layout>

    <x-slot name="header">

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.20em] text-red-700">
                    Produk Maloppo
                </p>

                <h1 class="mt-2 text-3xl font-bold tracking-tight text-gray-900">
                    Daftar Produk
                </h1>

                <p class="mt-2 text-sm leading-6 text-gray-500">
                    Kelola nama produk, harga, ukuran, stok, gambar, dan status tampil di katalog.
                </p>
            </div>

            <div class="flex flex-wrap gap-2">

                <a
                    href="{{ route('catalog.index') }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="inline-flex items-center justify-center rounded-lg border border-red-200 bg-white px-5 py-3 text-sm font-semibold text-red-700 shadow-sm transition hover:bg-red-50"
                >
                    Lihat Katalog
                </a>

                <a
                    href="{{ route('admin.products.create') }}"
                    class="inline-flex items-center justify-center rounded-lg bg-red-700 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-red-800"
                >
                    Tambah Produk
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
                        Total Produk
                    </p>

                    <p class="mt-2 text-3xl font-bold text-gray-900">
                        {{ $products->total() }}
                    </p>

                    <p class="mt-1 text-xs text-gray-500">
                        Produk tersimpan di sistem.
                    </p>
                </div>

                <div class="rounded-2xl border border-yellow-200 bg-yellow-50 p-5 shadow-sm">
                    <p class="text-sm font-semibold text-red-700">
                        Katalog Publik
                    </p>

                    <p class="mt-2 text-lg font-bold text-gray-900">
                        Siap Ditampilkan
                    </p>

                    <p class="mt-1 text-xs text-gray-600">
                        Produk aktif akan muncul di halaman katalog pelanggan.
                    </p>
                </div>

                <div class="rounded-2xl border border-red-100 bg-red-50 p-5 shadow-sm">
                    <p class="text-sm font-semibold text-red-700">
                        Pengelolaan Produk
                    </p>

                    <p class="mt-2 text-lg font-bold text-gray-900">
                        Admin Maloppo
                    </p>

                    <p class="mt-1 text-xs text-gray-600">
                        Perbarui harga, stok, dan status produk secara berkala.
                    </p>
                </div>

            </section>

            {{-- Daftar produk --}}
            <section class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">

                {{-- Header daftar --}}
                <div class="flex flex-col gap-3 border-b border-gray-200 bg-white px-6 py-5 sm:flex-row sm:items-center sm:justify-between">

                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">
                            Data Produk
                        </h2>

                        <p class="mt-1 text-sm text-gray-500">
                            {{ $products->total() }} produk tersimpan di dalam sistem.
                        </p>
                    </div>

                    @if ($products->hasPages())

                        <div class="rounded-full bg-gray-100 px-4 py-2 text-xs font-semibold text-gray-600">
                            Halaman {{ $products->currentPage() }} dari {{ $products->lastPage() }}
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
                                    Produk
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">
                                    Ukuran
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">
                                    Harga
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">
                                    Stok
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">
                                    Status
                                </th>

                                <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-gray-500">
                                    Aksi
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100 bg-white">

                            @forelse ($products as $product)

                                <tr class="transition hover:bg-gray-50">

                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $products->firstItem() + $loop->index }}
                                    </td>

                                    <td class="px-6 py-4">

                                        <div class="flex items-center gap-4">

                                            <div class="flex h-14 w-14 shrink-0 items-center justify-center overflow-hidden rounded-2xl border border-yellow-200 bg-yellow-50 p-2">
                                                @if ($product->image)

                                                    <img
                                                        src="{{ asset('storage/' . $product->image) }}"
                                                        alt="{{ $product->name }}"
                                                        class="h-full w-full object-contain"
                                                    >

                                                @else

                                                    <span class="text-[10px] font-semibold text-gray-400">
                                                        Foto
                                                    </span>

                                                @endif
                                            </div>

                                            <div class="min-w-0">

                                                <p class="max-w-xs truncate font-bold text-gray-900">
                                                    {{ $product->name }}
                                                </p>

                                                <p class="mt-1 max-w-sm truncate text-xs leading-5 text-gray-500">
                                                    {{ $product->short_description ?: 'Belum ada deskripsi singkat.' }}
                                                </p>

                                            </div>

                                        </div>

                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ $product->size ?? '-' }}
                                    </td>

                                    <td class="px-6 py-4 text-sm font-bold text-gray-900">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </td>

                                    <td class="px-6 py-4">

                                        @if ($product->stock > 0)

                                            <span class="inline-flex rounded-full bg-green-50 px-3 py-1 text-xs font-bold text-green-700">
                                                {{ $product->stock }} stok
                                            </span>

                                        @else

                                            <span class="inline-flex rounded-full bg-red-50 px-3 py-1 text-xs font-bold text-red-700">
                                                Habis
                                            </span>

                                        @endif

                                    </td>

                                    <td class="px-6 py-4">

                                        @if ($product->is_active)

                                            <span class="inline-flex rounded-full bg-green-50 px-3 py-1 text-xs font-bold text-green-700">
                                                Aktif
                                            </span>

                                        @else

                                            <span class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-xs font-bold text-gray-600">
                                                Tidak Aktif
                                            </span>

                                        @endif

                                    </td>

                                    <td class="px-6 py-4">

                                        <div class="flex items-center justify-end gap-3">

                                            <a
                                                href="{{ route('admin.products.edit', $product) }}"
                                                class="inline-flex items-center justify-center rounded-lg border border-gray-200 px-3 py-2 text-sm font-semibold text-gray-700 transition hover:bg-gray-50 hover:text-red-700"
                                            >
                                                Edit
                                            </a>

                                            <form
                                                action="{{ route('admin.products.destroy', $product) }}"
                                                method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus produk ini?')"
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
                                            🥥
                                        </div>

                                        <p class="mt-4 text-lg font-bold text-gray-800">
                                            Belum ada produk
                                        </p>

                                        <p class="mt-1 text-sm text-gray-500">
                                            Tambahkan produk pertama ke katalog Maloppo.
                                        </p>

                                        <a
                                            href="{{ route('admin.products.create') }}"
                                            class="mt-5 inline-flex items-center justify-center rounded-lg bg-red-700 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-red-800"
                                        >
                                            Tambah Produk
                                        </a>

                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                {{-- Tampilan HP --}}
                <div class="divide-y divide-gray-100 md:hidden">

                    @forelse ($products as $product)

                        <article class="p-5">

                            <div class="flex items-start gap-4">

                                <div class="flex h-20 w-20 shrink-0 items-center justify-center overflow-hidden rounded-2xl border border-yellow-200 bg-yellow-50 p-2">

                                    @if ($product->image)

                                        <img
                                            src="{{ asset('storage/' . $product->image) }}"
                                            alt="{{ $product->name }}"
                                            class="h-full w-full object-contain"
                                        >

                                    @else

                                        <span class="text-xs font-semibold text-gray-400">
                                            Foto
                                        </span>

                                    @endif

                                </div>

                                <div class="min-w-0 flex-1">

                                    <div class="flex items-start justify-between gap-3">

                                        <div class="min-w-0">

                                            <p class="text-[11px] font-semibold text-gray-400">
                                                Produk #{{ $products->firstItem() + $loop->index }}
                                            </p>

                                            <h3 class="mt-1 truncate text-sm font-bold text-gray-900">
                                                {{ $product->name }}
                                            </h3>

                                        </div>

                                        @if ($product->is_active)

                                            <span class="shrink-0 rounded-full bg-green-50 px-2 py-1 text-[10px] font-bold text-green-700">
                                                Aktif
                                            </span>

                                        @else

                                            <span class="shrink-0 rounded-full bg-gray-100 px-2 py-1 text-[10px] font-bold text-gray-600">
                                                Nonaktif
                                            </span>

                                        @endif

                                    </div>

                                    <p class="mt-2 text-sm font-bold text-red-700">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </p>

                                    <div class="mt-2 flex flex-wrap items-center gap-x-4 gap-y-1 text-xs text-gray-500">

                                        <span>
                                            Ukuran {{ $product->size ?? '-' }}
                                        </span>

                                        <span class="{{ $product->stock > 0 ? 'font-semibold text-green-700' : 'font-semibold text-red-700' }}">
                                            {{ $product->stock > 0 ? 'Stok ' . $product->stock : 'Stok habis' }}
                                        </span>

                                    </div>

                                </div>

                            </div>

                            @if ($product->short_description)

                                <p class="mt-4 line-clamp-2 text-xs leading-5 text-gray-500">
                                    {{ $product->short_description }}
                                </p>

                            @endif

                            <div class="mt-4 flex items-center justify-end gap-3 border-t border-gray-100 pt-4">

                                <a
                                    href="{{ route('admin.products.edit', $product) }}"
                                    class="inline-flex items-center justify-center rounded-lg border border-gray-200 px-4 py-2 text-sm font-semibold text-gray-700"
                                >
                                    Edit
                                </a>

                                <form
                                    action="{{ route('admin.products.destroy', $product) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus produk ini?')"
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
                                🥥
                            </div>

                            <p class="mt-4 text-lg font-bold text-gray-800">
                                Belum ada produk
                            </p>

                            <p class="mt-1 text-sm text-gray-500">
                                Tambahkan produk pertama ke katalog.
                            </p>

                            <a
                                href="{{ route('admin.products.create') }}"
                                class="mt-5 inline-flex items-center justify-center rounded-lg bg-red-700 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-red-800"
                            >
                                Tambah Produk
                            </a>

                        </div>

                    @endforelse

                </div>

                {{-- Pagination --}}
                @if ($products->hasPages())

                    <div class="border-t border-gray-200 bg-gray-50 px-5 py-4">
                        {{ $products->links() }}
                    </div>

                @endif

            </section>

        </div>

    </div>

</x-app-layout>