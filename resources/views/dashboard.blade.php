<x-app-layout>

    <x-slot name="header">

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.20em] text-red-700">
                    Administrator Maloppo
                </p>

                <h1 class="mt-2 text-3xl font-bold tracking-tight text-gray-900">
                    Dashboard Admin
                </h1>

                <p class="mt-2 text-sm leading-6 text-gray-500">
                    Ringkasan data produk, stok, kegiatan, dan pesanan UMKM Maloppo.
                </p>
            </div>

            <a
                href="{{ route('admin.products.create') }}"
                class="inline-flex items-center justify-center rounded-lg bg-red-700 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-red-800"
            >
                Tambah Produk
            </a>

        </div>

    </x-slot>

    <div class="py-8">

        <div class="mx-auto max-w-7xl space-y-8 px-4 sm:px-6 lg:px-8">

            {{-- Sambutan --}}
            <section class="overflow-hidden rounded-3xl bg-gradient-to-br from-red-700 via-red-600 to-orange-600 shadow-sm">

                <div class="grid grid-cols-1 gap-6 p-6 sm:p-8 lg:grid-cols-2 lg:items-center">

                    <div class="text-white">

                        <p class="text-sm font-semibold uppercase tracking-[0.20em] text-yellow-100">
                            Selamat Datang
                        </p>

                        <h2 class="mt-3 text-3xl font-bold tracking-tight sm:text-4xl">
                            {{ Auth::user()->name }}
                        </h2>

                        <p class="mt-4 max-w-2xl text-sm leading-7 text-red-50 sm:text-base">
                            Kelola produk, stok, kegiatan, dan pesanan pelanggan
                            melalui halaman administrator UMKM Maloppo.
                        </p>

                    </div>

                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">

                        <a
                            href="{{ route('admin.products.index') }}"
                            class="rounded-2xl bg-white/95 p-5 transition hover:bg-yellow-50"
                        >
                            <p class="text-sm font-bold text-red-700">
                                Kelola Produk
                            </p>

                            <p class="mt-2 text-xs leading-5 text-gray-600">
                                Tambah, ubah, hapus, dan atur stok produk.
                            </p>
                        </a>

                        <a
                            href="{{ route('admin.orders.index') }}"
                            class="rounded-2xl bg-white/95 p-5 transition hover:bg-yellow-50"
                        >
                            <p class="text-sm font-bold text-red-700">
                                Lihat Pesanan
                            </p>

                            <p class="mt-2 text-xs leading-5 text-gray-600">
                                Periksa pesanan pelanggan yang masuk.
                            </p>
                        </a>

                    </div>

                </div>

            </section>

            {{-- Statistik --}}
            <section>

                <div class="mb-5">

                    <p class="text-sm font-semibold uppercase tracking-[0.20em] text-red-700">
                        Ringkasan Produk
                    </p>

                    <h2 class="mt-2 text-2xl font-bold text-gray-900">
                        Kondisi Produk dan Persediaan
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Data ini membantu admin memantau kondisi produk secara cepat.
                    </p>

                </div>

                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">

                    <article class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">

                        <p class="text-sm font-semibold text-gray-500">
                            Total Produk
                        </p>

                        <p class="mt-3 text-4xl font-bold text-gray-900">
                            {{ $totalProducts }}
                        </p>

                        <p class="mt-2 text-xs text-gray-500">
                            Seluruh produk tersimpan.
                        </p>

                    </article>

                    <article class="rounded-2xl border border-green-100 bg-green-50 p-6 shadow-sm">

                        <p class="text-sm font-semibold text-green-700">
                            Produk Aktif
                        </p>

                        <p class="mt-3 text-4xl font-bold text-gray-900">
                            {{ $activeProducts }}
                        </p>

                        <p class="mt-2 text-xs text-green-700">
                            Tampil di katalog pelanggan.
                        </p>

                    </article>

                    <article class="rounded-2xl border border-red-100 bg-red-50 p-6 shadow-sm">

                        <p class="text-sm font-semibold text-red-700">
                            Stok Habis
                        </p>

                        <p class="mt-3 text-4xl font-bold {{ $outOfStockProducts > 0 ? 'text-red-700' : 'text-gray-900' }}">
                            {{ $outOfStockProducts }}
                        </p>

                        <a
                            href="{{ route('admin.products.index') }}"
                            class="mt-2 inline-block text-xs font-semibold text-red-700 transition hover:text-red-900"
                        >
                            Periksa produk
                        </a>

                    </article>

                    <article class="rounded-2xl border border-yellow-200 bg-yellow-50 p-6 shadow-sm">

                        <p class="text-sm font-semibold text-red-700">
                            Total Stok
                        </p>

                        <p class="mt-3 text-4xl font-bold text-gray-900">
                            {{ $totalStock }}
                        </p>

                        <p class="mt-2 text-xs text-gray-600">
                            Seluruh persediaan produk.
                        </p>

                    </article>

                </div>

            </section>

            {{-- Menu pengelolaan --}}
            <section class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">

                <div class="border-b border-gray-200 bg-yellow-50 px-6 py-5">

                    <p class="text-sm font-semibold uppercase tracking-[0.20em] text-red-700">
                        Menu Pengelolaan
                    </p>

                    <h2 class="mt-2 text-2xl font-bold text-gray-900">
                        Akses Cepat Admin
                    </h2>

                    <p class="mt-1 text-sm text-gray-600">
                        Pilih menu sesuai data yang ingin dikelola.
                    </p>

                </div>

                <div class="grid grid-cols-1 divide-y divide-gray-100 sm:grid-cols-2 sm:divide-x sm:divide-y-0 lg:grid-cols-4">

                    <a
                        href="{{ route('admin.products.index') }}"
                        class="p-6 transition hover:bg-red-50"
                    >
                        <p class="text-base font-bold text-gray-900">
                            Produk
                        </p>

                        <p class="mt-2 text-sm leading-6 text-gray-500">
                            Kelola data produk, harga, ukuran, stok, dan status.
                        </p>
                    </a>

                    <a
                        href="{{ route('admin.posts.index') }}"
                        class="p-6 transition hover:bg-red-50"
                    >
                        <p class="text-base font-bold text-gray-900">
                            Kegiatan
                        </p>

                        <p class="mt-2 text-sm leading-6 text-gray-500">
                            Kelola berita, pelatihan, dan aktivitas UMKM Maloppo.
                        </p>
                    </a>

                    <a
                        href="{{ route('admin.orders.index') }}"
                        class="p-6 transition hover:bg-red-50"
                    >
                        <p class="text-base font-bold text-gray-900">
                            Pesanan
                        </p>

                        <p class="mt-2 text-sm leading-6 text-gray-500">
                            Periksa pesanan pelanggan dan ubah status pesanan.
                        </p>
                    </a>

                    <a
                        href="{{ route('catalog.index') }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="p-6 transition hover:bg-red-50"
                    >
                        <p class="text-base font-bold text-gray-900">
                            Katalog Publik
                        </p>

                        <p class="mt-2 text-sm leading-6 text-gray-500">
                            Lihat tampilan produk seperti yang dilihat pelanggan.
                        </p>
                    </a>

                </div>

            </section>

            {{-- Produk terbaru --}}
            <section class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">

                <div class="flex flex-col gap-4 border-b border-gray-200 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">

                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.20em] text-red-700">
                            Produk Terbaru
                        </p>

                        <h2 class="mt-2 text-2xl font-bold text-gray-900">
                            Produk Terakhir Ditambahkan
                        </h2>

                        <p class="mt-1 text-sm text-gray-500">
                            Lima produk terbaru yang tersimpan di sistem.
                        </p>
                    </div>

                    <a
                        href="{{ route('admin.products.index') }}"
                        class="inline-flex items-center justify-center rounded-lg border border-red-200 px-4 py-2.5 text-sm font-semibold text-red-700 transition hover:bg-red-50"
                    >
                        Lihat Semua
                    </a>

                </div>

                {{-- Desktop --}}
                <div class="hidden overflow-x-auto md:block">

                    <table class="min-w-full divide-y divide-gray-200">

                        <thead class="bg-gray-50">
                            <tr>
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

                            @forelse ($latestProducts as $product)

                                <tr class="transition hover:bg-gray-50">

                                    <td class="px-6 py-4">

                                        <div class="flex items-center gap-3">

                                            <div class="flex h-12 w-12 shrink-0 items-center justify-center overflow-hidden rounded-xl border border-yellow-200 bg-yellow-50 p-1">
                                                @if ($product->image)

                                                    <img
                                                        src="{{ asset('storage/' . $product->image) }}"
                                                        alt="{{ $product->name }}"
                                                        class="h-full w-full object-contain"
                                                    >

                                                @else

                                                    <span class="text-xs font-medium text-gray-400">
                                                        Foto
                                                    </span>

                                                @endif
                                            </div>

                                            <div class="min-w-0">

                                                <p class="truncate font-semibold text-gray-900">
                                                    {{ $product->name }}
                                                </p>

                                                <p class="mt-1 text-xs text-gray-500">
                                                    {{ $product->created_at->format('d M Y') }}
                                                </p>

                                            </div>

                                        </div>

                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ $product->size ?? '-' }}
                                    </td>

                                    <td class="px-6 py-4 text-sm font-semibold text-gray-900">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </td>

                                    <td class="px-6 py-4 text-sm font-semibold {{ $product->stock > 0 ? 'text-green-700' : 'text-red-700' }}">
                                        {{ $product->stock }}
                                    </td>

                                    <td class="px-6 py-4">

                                        @if ($product->is_active)

                                            <span class="inline-flex rounded-full bg-green-50 px-3 py-1 text-xs font-semibold text-green-700">
                                                Aktif
                                            </span>

                                        @else

                                            <span class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-600">
                                                Tidak Aktif
                                            </span>

                                        @endif

                                    </td>

                                    <td class="px-6 py-4 text-right">

                                        <a
                                            href="{{ route('admin.products.edit', $product) }}"
                                            class="text-sm font-semibold text-red-700 transition hover:text-red-900"
                                        >
                                            Edit
                                        </a>

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="6" class="px-6 py-14 text-center">

                                        <p class="font-semibold text-gray-700">
                                            Belum ada produk
                                        </p>

                                        <p class="mt-1 text-sm text-gray-500">
                                            Tambahkan produk pertama ke katalog.
                                        </p>

                                        <a
                                            href="{{ route('admin.products.create') }}"
                                            class="mt-5 inline-flex items-center justify-center rounded-lg bg-red-700 px-5 py-3 text-sm font-semibold text-white transition hover:bg-red-800"
                                        >
                                            Tambah Produk
                                        </a>

                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                {{-- Mobile --}}
                <div class="divide-y divide-gray-100 md:hidden">

                    @forelse ($latestProducts as $product)

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

                                        <span class="text-xs font-medium text-gray-400">
                                            Foto
                                        </span>

                                    @endif

                                </div>

                                <div class="min-w-0 flex-1">

                                    <div class="flex items-start justify-between gap-3">

                                        <div class="min-w-0">

                                            <h3 class="truncate text-sm font-bold text-gray-900">
                                                {{ $product->name }}
                                            </h3>

                                            <p class="mt-1 text-xs text-gray-500">
                                                {{ $product->size ?? '-' }}
                                            </p>

                                        </div>

                                        @if ($product->is_active)

                                            <span class="shrink-0 rounded-full bg-green-50 px-2 py-1 text-[10px] font-semibold text-green-700">
                                                Aktif
                                            </span>

                                        @else

                                            <span class="shrink-0 rounded-full bg-gray-100 px-2 py-1 text-[10px] font-semibold text-gray-600">
                                                Nonaktif
                                            </span>

                                        @endif

                                    </div>

                                    <p class="mt-2 text-sm font-bold text-red-700">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </p>

                                    <div class="mt-3 flex items-center justify-between gap-3">

                                        <span class="text-xs font-semibold {{ $product->stock > 0 ? 'text-green-700' : 'text-red-700' }}">
                                            Stok {{ $product->stock }}
                                        </span>

                                        <a
                                            href="{{ route('admin.products.edit', $product) }}"
                                            class="text-xs font-bold text-red-700"
                                        >
                                            Edit
                                        </a>

                                    </div>

                                </div>

                            </div>

                        </article>

                    @empty

                        <div class="px-5 py-14 text-center">

                            <p class="font-semibold text-gray-700">
                                Belum ada produk
                            </p>

                            <p class="mt-1 text-sm text-gray-500">
                                Tambahkan produk pertama ke katalog.
                            </p>

                            <a
                                href="{{ route('admin.products.create') }}"
                                class="mt-5 inline-flex items-center justify-center rounded-lg bg-red-700 px-5 py-3 text-sm font-semibold text-white transition hover:bg-red-800"
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