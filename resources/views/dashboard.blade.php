<x-app-layout>

    <x-slot name="header">

        <div
            class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"
        >
            <div>
                <h1 class="page-title-maloppo">
                    Dashboard
                </h1>

                <p class="page-description-maloppo">
                    Ringkasan data produk dan persediaan UMKM Maloppo.
                </p>
            </div>

            <a
                href="{{ route('admin.products.create') }}"
                class="btn-maloppo-primary"
            >
                Tambah Produk
            </a>
        </div>

    </x-slot>

    <div class="py-6 lg:py-8">

        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">

            {{-- Sambutan sederhana --}}
            <section class="panel-maloppo px-5 py-5 sm:px-6">

                <div
                    class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"
                >
                    <div>
                        <p class="text-sm text-gray-500">
                            Selamat datang,
                        </p>

                        <h2 class="mt-1 text-xl font-semibold text-gray-900">
                            {{ Auth::user()->name }}
                        </h2>

                        <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-600">
                            Kelola produk, stok, kegiatan, dan pesanan melalui
                            halaman administrator Maloppo.
                        </p>
                    </div>

                    <div class="flex flex-wrap gap-2">

                        <a
                            href="{{ route('admin.products.index') }}"
                            class="btn-maloppo-secondary"
                        >
                            Kelola Produk
                        </a>

                        <a
                            href="{{ route('admin.orders.index') }}"
                            class="btn-maloppo-secondary"
                        >
                            Lihat Pesanan
                        </a>

                    </div>
                </div>

            </section>

            {{-- Statistik --}}
            <section>

                <div class="mb-4">
                    <h2 class="text-base font-semibold text-gray-900">
                        Ringkasan Produk
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Kondisi produk dan persediaan saat ini.
                    </p>
                </div>

                <div class="grid grid-cols-2 gap-3 lg:grid-cols-4">

                    {{-- Total produk --}}
                    <article class="panel-maloppo p-4 sm:p-5">

                        <p class="text-xs font-medium text-gray-500 sm:text-sm">
                            Total Produk
                        </p>

                        <p class="mt-2 text-2xl font-semibold text-gray-900 sm:text-3xl">
                            {{ $totalProducts }}
                        </p>

                        <p class="mt-2 text-xs text-gray-500">
                            Seluruh produk
                        </p>

                    </article>

                    {{-- Produk aktif --}}
                    <article class="panel-maloppo p-4 sm:p-5">

                        <p class="text-xs font-medium text-gray-500 sm:text-sm">
                            Produk Aktif
                        </p>

                        <p class="mt-2 text-2xl font-semibold text-gray-900 sm:text-3xl">
                            {{ $activeProducts }}
                        </p>

                        <p class="mt-2 text-xs text-green-700">
                            Tampil di katalog
                        </p>

                    </article>

                    {{-- Stok habis --}}
                    <article class="panel-maloppo p-4 sm:p-5">

                        <p class="text-xs font-medium text-gray-500 sm:text-sm">
                            Stok Habis
                        </p>

                        <p
                            class="mt-2 text-2xl font-semibold sm:text-3xl
                                {{ $outOfStockProducts > 0
                                    ? 'text-red-700'
                                    : 'text-gray-900' }}"
                        >
                            {{ $outOfStockProducts }}
                        </p>

                        <a
                            href="{{ route('admin.products.index') }}"
                            class="mt-2 inline-block text-xs font-medium text-red-700 hover:text-red-900"
                        >
                            Periksa produk
                        </a>

                    </article>

                    {{-- Total stok --}}
                    <article class="panel-maloppo p-4 sm:p-5">

                        <p class="text-xs font-medium text-gray-500 sm:text-sm">
                            Total Stok
                        </p>

                        <p class="mt-2 text-2xl font-semibold text-gray-900 sm:text-3xl">
                            {{ $totalStock }}
                        </p>

                        <p class="mt-2 text-xs text-gray-500">
                            Seluruh persediaan
                        </p>

                    </article>

                </div>

            </section>

            {{-- Menu pengelolaan --}}
            <section class="panel-maloppo overflow-hidden">

                <div class="section-header-maloppo">

                    <h2 class="section-title-maloppo">
                        Menu Pengelolaan
                    </h2>

                    <p class="section-description-maloppo">
                        Akses cepat ke bagian utama sistem.
                    </p>

                </div>

                <div class="grid grid-cols-2 divide-x divide-y divide-gray-100 md:grid-cols-4 md:divide-y-0">

                    <a
                        href="{{ route('admin.products.index') }}"
                        class="px-4 py-4 transition hover:bg-gray-50 sm:px-5"
                    >
                        <p class="text-sm font-semibold text-gray-900">
                            Produk
                        </p>

                        <p class="mt-1 text-xs leading-5 text-gray-500">
                            Kelola data dan stok produk.
                        </p>
                    </a>

                    <a
                        href="{{ route('admin.posts.index') }}"
                        class="px-4 py-4 transition hover:bg-gray-50 sm:px-5"
                    >
                        <p class="text-sm font-semibold text-gray-900">
                            Kegiatan
                        </p>

                        <p class="mt-1 text-xs leading-5 text-gray-500">
                            Kelola berita dan aktivitas.
                        </p>
                    </a>

                    <a
                        href="{{ route('admin.orders.index') }}"
                        class="px-4 py-4 transition hover:bg-gray-50 sm:px-5"
                    >
                        <p class="text-sm font-semibold text-gray-900">
                            Pesanan
                        </p>

                        <p class="mt-1 text-xs leading-5 text-gray-500">
                            Periksa pesanan pelanggan.
                        </p>
                    </a>

                    <a
                        href="{{ route('catalog.index') }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="px-4 py-4 transition hover:bg-gray-50 sm:px-5"
                    >
                        <p class="text-sm font-semibold text-gray-900">
                            Katalog Publik
                        </p>

                        <p class="mt-1 text-xs leading-5 text-gray-500">
                            Lihat tampilan untuk pelanggan.
                        </p>
                    </a>

                </div>

            </section>

            {{-- Produk terbaru --}}
            <section class="panel-maloppo overflow-hidden">

                <div
                    class="flex flex-col gap-3 border-b border-gray-200 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6"
                >
                    <div>
                        <h2 class="section-title-maloppo">
                            Produk Terbaru
                        </h2>

                        <p class="section-description-maloppo">
                            Lima produk yang terakhir ditambahkan.
                        </p>
                    </div>

                    <a
                        href="{{ route('admin.products.index') }}"
                        class="text-sm font-medium text-red-700 hover:text-red-900"
                    >
                        Lihat semua
                    </a>
                </div>

                {{-- Tampilan desktop --}}
                <div class="hidden overflow-x-auto md:block">

                    <table class="table-maloppo">

                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Ukuran</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Status</th>
                                <th class="text-right">
                                    Aksi
                                </th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse ($latestProducts as $product)

                                <tr>

                                    <td>

                                        <div class="flex items-center gap-3">

                                            <div
                                                class="flex h-10 w-10 shrink-0 items-center justify-center overflow-hidden rounded-lg border border-gray-200 bg-gray-50"
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

                                            <div class="min-w-0">

                                                <p class="truncate font-medium text-gray-900">
                                                    {{ $product->name }}
                                                </p>

                                                <p class="mt-1 text-xs text-gray-500">
                                                    {{ $product->created_at->format('d M Y') }}
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

                                        <span
                                            class="{{ $product->stock > 0
                                                ? 'text-green-700'
                                                : 'text-red-700' }}"
                                        >
                                            {{ $product->stock }}
                                        </span>

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

                                    <td class="text-right">

                                        <a
                                            href="{{ route('admin.products.edit', $product) }}"
                                            class="text-sm font-medium text-red-700 hover:text-red-900"
                                        >
                                            Edit
                                        </a>

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td
                                        colspan="6"
                                        class="py-12 text-center"
                                    >
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
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                {{-- Tampilan HP --}}
                <div class="divide-y divide-gray-100 md:hidden">

                    @forelse ($latestProducts as $product)

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

                                            <h3 class="truncate text-sm font-semibold text-gray-900">
                                                {{ $product->name }}
                                            </h3>

                                            <p class="mt-1 text-xs text-gray-500">
                                                {{ $product->size ?? '-' }}
                                            </p>

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

                                    <div class="mt-2 flex items-center justify-between gap-3">

                                        <span
                                            class="text-xs
                                                {{ $product->stock > 0
                                                    ? 'text-green-700'
                                                    : 'text-red-700' }}"
                                        >
                                            Stok {{ $product->stock }}
                                        </span>

                                        <a
                                            href="{{ route('admin.products.edit', $product) }}"
                                            class="text-xs font-semibold text-red-700"
                                        >
                                            Edit
                                        </a>

                                    </div>

                                </div>

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

            </section>

        </div>

    </div>

</x-app-layout>