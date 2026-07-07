<x-app-layout>

    <x-slot name="header">

        <div
            class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"
        >
            <div>
                <h1 class="page-title-maloppo">
                    Produk
                </h1>

                <p class="page-description-maloppo">
                    Kelola nama, harga, ukuran, stok, gambar, dan status produk.
                </p>
            </div>

            <div class="flex flex-wrap gap-2">

                <a
                    href="{{ route('catalog.index') }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="btn-maloppo-secondary"
                >
                    Lihat Katalog
                </a>

                <a
                    href="{{ route('admin.products.create') }}"
                    class="btn-maloppo-primary"
                >
                    Tambah Produk
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

            {{-- Daftar produk --}}
            <section class="panel-maloppo overflow-hidden">

                {{-- Header daftar --}}
                <div
                    class="flex flex-col gap-3 border-b border-gray-200 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6"
                >
                    <div>
                        <h2 class="section-title-maloppo">
                            Daftar Produk
                        </h2>

                        <p class="section-description-maloppo">
                            {{ $products->total() }} produk tersimpan di dalam sistem.
                        </p>
                    </div>

                    @if ($products->hasPages())

                        <p class="text-xs text-gray-500">
                            Halaman {{ $products->currentPage() }}
                            dari {{ $products->lastPage() }}
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
                                    Produk
                                </th>

                                <th>
                                    Ukuran
                                </th>

                                <th>
                                    Harga
                                </th>

                                <th>
                                    Stok
                                </th>

                                <th>
                                    Status
                                </th>

                                <th class="text-right">
                                    Aksi
                                </th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse ($products as $product)

                                <tr>

                                    <td class="text-gray-500">
                                        {{ $products->firstItem() + $loop->index }}
                                    </td>

                                    <td>

                                        <div class="flex items-center gap-3">

                                            <div
                                                class="flex h-11 w-11 shrink-0 items-center justify-center overflow-hidden rounded-lg border border-gray-200 bg-gray-50"
                                            >
                                                @if ($product->image)

                                                    <img
                                                        src="{{ asset('storage/' . $product->image) }}"
                                                        alt="{{ $product->name }}"
                                                        class="h-full w-full object-cover"
                                                    >

                                                @else

                                                    <span class="text-[10px] font-medium text-gray-400">
                                                        Foto
                                                    </span>

                                                @endif
                                            </div>

                                            <div class="min-w-0">

                                                <p class="max-w-xs truncate font-medium text-gray-900">
                                                    {{ $product->name }}
                                                </p>

                                                <p class="mt-1 max-w-xs truncate text-xs text-gray-500">
                                                    {{ $product->short_description ?: 'Belum ada deskripsi singkat.' }}
                                                </p>

                                            </div>

                                        </div>

                                    </td>

                                    <td>
                                        {{ $product->size ?? '-' }}
                                    </td>

                                    <td class="font-medium text-gray-900">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </td>

                                    <td>

                                        @if ($product->stock > 0)

                                            <span class="text-sm font-medium text-green-700">
                                                {{ $product->stock }}
                                            </span>

                                        @else

                                            <span class="text-sm font-medium text-red-700">
                                                Habis
                                            </span>

                                        @endif

                                    </td>

                                    <td>

                                        @if ($product->is_active)

                                            <span
                                                class="inline-flex rounded-full bg-green-50 px-2.5 py-1 text-xs font-medium text-green-700"
                                            >
                                                Aktif
                                            </span>

                                        @else

                                            <span
                                                class="inline-flex rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-600"
                                            >
                                                Tidak Aktif
                                            </span>

                                        @endif

                                    </td>

                                    <td>

                                        <div class="flex items-center justify-end gap-4">

                                            <a
                                                href="{{ route('admin.products.edit', $product) }}"
                                                class="text-sm font-medium text-gray-700 transition hover:text-red-700"
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
                                            Belum ada produk
                                        </p>

                                        <p class="mt-1 text-sm text-gray-500">
                                            Tambahkan produk pertama ke katalog Maloppo.
                                        </p>

                                        <a
                                            href="{{ route('admin.products.create') }}"
                                            class="btn-maloppo-primary mt-4"
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

                        <article class="p-4">

                            <div class="flex items-start gap-3">

                                <div
                                    class="flex h-16 w-16 shrink-0 items-center justify-center overflow-hidden rounded-lg border border-gray-200 bg-gray-50"
                                >
                                    @if ($product->image)

                                        <img
                                            src="{{ asset('storage/' . $product->image) }}"
                                            alt="{{ $product->name }}"
                                            class="h-full w-full object-cover"
                                        >

                                    @else

                                        <span class="text-xs font-medium text-gray-400">
                                            Foto
                                        </span>

                                    @endif
                                </div>

                                <div class="min-w-0 flex-1">

                                    <div class="flex items-start justify-between gap-3">

                                        <div class="min-w-0">

                                            <p class="text-[11px] text-gray-400">
                                                Produk #{{ $products->firstItem() + $loop->index }}
                                            </p>

                                            <h3 class="mt-1 truncate text-sm font-semibold text-gray-900">
                                                {{ $product->name }}
                                            </h3>

                                        </div>

                                        @if ($product->is_active)

                                            <span
                                                class="shrink-0 rounded-full bg-green-50 px-2 py-1 text-[10px] font-medium text-green-700"
                                            >
                                                Aktif
                                            </span>

                                        @else

                                            <span
                                                class="shrink-0 rounded-full bg-gray-100 px-2 py-1 text-[10px] font-medium text-gray-600"
                                            >
                                                Nonaktif
                                            </span>

                                        @endif

                                    </div>

                                    <p class="mt-2 text-sm font-semibold text-gray-900">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </p>

                                    <div class="mt-2 flex flex-wrap items-center gap-x-4 gap-y-1 text-xs text-gray-500">

                                        <span>
                                            Ukuran {{ $product->size ?? '-' }}
                                        </span>

                                        <span
                                            class="{{ $product->stock > 0
                                                ? 'text-green-700'
                                                : 'text-red-700' }}"
                                        >
                                            {{ $product->stock > 0
                                                ? 'Stok ' . $product->stock
                                                : 'Stok habis' }}
                                        </span>

                                    </div>

                                </div>

                            </div>

                            @if ($product->short_description)

                                <p class="mt-3 line-clamp-2 text-xs leading-5 text-gray-500">
                                    {{ $product->short_description }}
                                </p>

                            @endif

                            <div
                                class="mt-4 flex items-center justify-end gap-4 border-t border-gray-100 pt-3"
                            >
                                <a
                                    href="{{ route('admin.products.edit', $product) }}"
                                    class="text-sm font-medium text-gray-700"
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
                                Belum ada produk
                            </p>

                            <p class="mt-1 text-sm text-gray-500">
                                Tambahkan produk pertama ke katalog.
                            </p>

                            <a
                                href="{{ route('admin.products.create') }}"
                                class="btn-maloppo-primary mt-4"
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