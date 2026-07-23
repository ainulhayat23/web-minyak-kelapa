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
                    <article class="panel-maloppo p-4 sm:p-5 relative overflow-hidden group hover:border-red-300 transition-all duration-300 hover:shadow-md">
                        <div class="absolute -right-6 -top-6 h-24 w-24 rounded-full bg-blue-50 opacity-50 transition-transform duration-300 group-hover:scale-110"></div>
                        <div class="relative z-10 flex justify-between items-start">
                            <div>
                                <p class="text-xs font-medium text-gray-500 sm:text-sm">
                                    Total Produk
                                </p>
                                <p class="mt-2 text-2xl font-bold text-gray-900 sm:text-3xl">
                                    {{ $totalProducts }}
                                </p>
                                <p class="mt-2 text-xs text-gray-500">
                                    Seluruh produk
                                </p>
                            </div>
                            <div class="rounded-xl bg-blue-50 p-2.5 text-blue-600 ring-1 ring-blue-100">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
                                </svg>
                            </div>
                        </div>
                    </article>

                    {{-- Produk aktif --}}
                    <article class="panel-maloppo p-4 sm:p-5 relative overflow-hidden group hover:border-green-300 transition-all duration-300 hover:shadow-md">
                        <div class="absolute -right-6 -top-6 h-24 w-24 rounded-full bg-green-50 opacity-50 transition-transform duration-300 group-hover:scale-110"></div>
                        <div class="relative z-10 flex justify-between items-start">
                            <div>
                                <p class="text-xs font-medium text-gray-500 sm:text-sm">
                                    Produk Aktif
                                </p>
                                <p class="mt-2 text-2xl font-bold text-gray-900 sm:text-3xl">
                                    {{ $activeProducts }}
                                </p>
                                <p class="mt-2 text-xs text-green-700 font-medium">
                                    Tampil di katalog
                                </p>
                            </div>
                            <div class="rounded-xl bg-green-50 p-2.5 text-green-600 ring-1 ring-green-100">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </article>

                    {{-- Stok habis --}}
                    <article class="panel-maloppo p-4 sm:p-5 relative overflow-hidden group hover:border-red-300 transition-all duration-300 hover:shadow-md">
                        <div class="absolute -right-6 -top-6 h-24 w-24 rounded-full bg-red-50 opacity-50 transition-transform duration-300 group-hover:scale-110"></div>
                        <div class="relative z-10 flex justify-between items-start">
                            <div>
                                <p class="text-xs font-medium text-gray-500 sm:text-sm">
                                    Stok Habis
                                </p>
                                <p class="mt-2 text-2xl font-bold sm:text-3xl {{ $outOfStockProducts > 0 ? 'text-red-700' : 'text-gray-900' }}">
                                    {{ $outOfStockProducts }}
                                </p>
                                <a href="{{ route('admin.products.index') }}" class="mt-2 inline-flex items-center gap-1 text-xs font-medium text-red-700 hover:text-red-900 transition-colors">
                                    Periksa produk
                                    <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                    </svg>
                                </a>
                            </div>
                            <div class="rounded-xl {{ $outOfStockProducts > 0 ? 'bg-red-50 text-red-600 ring-red-100' : 'bg-gray-50 text-gray-500 ring-gray-100' }} p-2.5 ring-1">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                        </div>
                    </article>

                    {{-- Total stok --}}
                    <article class="panel-maloppo p-4 sm:p-5 relative overflow-hidden group hover:border-yellow-300 transition-all duration-300 hover:shadow-md">
                        <div class="absolute -right-6 -top-6 h-24 w-24 rounded-full bg-yellow-50 opacity-50 transition-transform duration-300 group-hover:scale-110"></div>
                        <div class="relative z-10 flex justify-between items-start">
                            <div>
                                <p class="text-xs font-medium text-gray-500 sm:text-sm">
                                    Total Stok
                                </p>
                                <p class="mt-2 text-2xl font-bold text-gray-900 sm:text-3xl">
                                    {{ $totalStock }}
                                </p>
                                <p class="mt-2 text-xs text-gray-500">
                                    Seluruh persediaan
                                </p>
                            </div>
                            <div class="rounded-xl bg-yellow-50 p-2.5 text-yellow-600 ring-1 ring-yellow-100">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                                </svg>
                            </div>
                        </div>
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
                        class="group px-4 py-5 transition-all hover:bg-red-50/50 sm:px-6 flex flex-col justify-center items-center text-center"
                    >
                        <div class="mb-3 rounded-full bg-red-100 p-3 text-red-600 transition-transform group-hover:-translate-y-1 group-hover:shadow-sm">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                            </svg>
                        </div>
                        <p class="text-sm font-bold text-gray-900 group-hover:text-red-700">
                            Produk
                        </p>
                        <p class="mt-1 text-xs leading-5 text-gray-500">
                            Kelola data dan stok produk.
                        </p>
                    </a>

                    <a
                        href="{{ route('admin.posts.index') }}"
                        class="group px-4 py-5 transition-all hover:bg-yellow-50/50 sm:px-6 flex flex-col justify-center items-center text-center"
                    >
                        <div class="mb-3 rounded-full bg-yellow-100 p-3 text-yellow-600 transition-transform group-hover:-translate-y-1 group-hover:shadow-sm">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z" />
                            </svg>
                        </div>
                        <p class="text-sm font-bold text-gray-900 group-hover:text-yellow-700">
                            Kegiatan
                        </p>
                        <p class="mt-1 text-xs leading-5 text-gray-500">
                            Kelola berita dan aktivitas.
                        </p>
                    </a>

                    <a
                        href="{{ route('admin.orders.index') }}"
                        class="group px-4 py-5 transition-all hover:bg-green-50/50 sm:px-6 flex flex-col justify-center items-center text-center"
                    >
                        <div class="mb-3 rounded-full bg-green-100 p-3 text-green-600 transition-transform group-hover:-translate-y-1 group-hover:shadow-sm">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                            </svg>
                        </div>
                        <p class="text-sm font-bold text-gray-900 group-hover:text-green-700">
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
                        class="group px-4 py-5 transition-all hover:bg-blue-50/50 sm:px-6 flex flex-col justify-center items-center text-center"
                    >
                        <div class="mb-3 rounded-full bg-blue-100 p-3 text-blue-600 transition-transform group-hover:-translate-y-1 group-hover:shadow-sm">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                            </svg>
                        </div>
                        <p class="text-sm font-bold text-gray-900 group-hover:text-blue-700">
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