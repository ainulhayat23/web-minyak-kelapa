<x-app-layout>

    <x-slot name="header">

        <div
            class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"
        >

            <div>

                <h1 class="text-2xl font-extrabold leading-tight text-gray-900">
                    Dashboard Admin
                </h1>

                <p class="mt-2 text-sm font-normal text-gray-600">
                    Ringkasan pengelolaan produk dan aktivitas UMKM Maloppo.
                </p>

            </div>

            <a
                href="{{ route('admin.products.create') }}"
                class="btn-maloppo-primary"
            >
                <span class="text-lg">
                    +
                </span>

                Tambah Produk
            </a>

        </div>

    </x-slot>

    <div class="py-8 lg:py-10">

        <div class="mx-auto max-w-7xl space-y-8 px-4 sm:px-6 lg:px-8">

            {{-- Sambutan --}}
            <section
                class="relative overflow-hidden rounded-3xl p-6 shadow-lg sm:p-8"
                style="
                    background:
                        radial-gradient(
                            circle at top right,
                            rgba(247, 233, 0, 0.35),
                            transparent 38%
                        ),
                        linear-gradient(
                            135deg,
                            #be0000 0%,
                            #990100 100%
                        );
                "
            >

                {{-- Dekorasi --}}
                <div
                    class="pointer-events-none absolute -right-16 -top-20 h-64 w-64 rounded-full opacity-20"
                    style="background-color: #f7e900;"
                ></div>

                <div
                    class="pointer-events-none absolute -bottom-24 left-1/3 h-52 w-52 rounded-full bg-white opacity-5"
                ></div>

                <div
                    class="relative flex flex-col gap-8 md:flex-row md:items-center md:justify-between"
                >

                    <div>

                        <span
                            class="inline-flex items-center gap-2 rounded-full px-4 py-2 text-xs font-bold uppercase tracking-wider"
                            style="
                                background-color: #f7e900;
                                color: #990100;
                            "
                        >
                            <span>👋</span>
                            Selamat datang
                        </span>

                        <h2 class="mt-5 text-3xl font-extrabold text-white">
                            {{ Auth::user()->name }}
                        </h2>

                        <p class="mt-3 max-w-2xl leading-7 text-red-100">
                            Kelola produk, harga, stok, gambar, kegiatan,
                            dan pesanan UMKM Maloppo melalui dashboard
                            administrator.
                        </p>

                        <div class="mt-6 flex flex-wrap gap-3">

                            <a
                                href="{{ route('admin.products.index') }}"
                                class="inline-flex items-center gap-2 rounded-xl bg-white px-5 py-3 text-sm font-bold shadow-sm"
                                style="color: #be0000;"
                            >
                                <span>🥥</span>
                                Kelola Produk
                            </a>

                            <a
                                href="{{ route('admin.orders.index') }}"
                                class="inline-flex items-center gap-2 rounded-xl border px-5 py-3 text-sm font-bold text-white"
                                style="
                                    border-color: rgba(255, 255, 255, 0.45);
                                    background-color: rgba(255, 255, 255, 0.10);
                                "
                            >
                                <span>📦</span>
                                Lihat Pesanan
                            </a>

                        </div>

                    </div>

                    {{-- Logo --}}
                    <div
                        class="relative flex h-36 w-full shrink-0 items-center justify-center overflow-hidden rounded-3xl border-4 p-3 shadow-xl md:w-64"
                        style="
                            background-color: #f7e900;
                            border-color: rgba(255, 255, 255, 0.45);
                        "
                    >
                        <img
                            src="{{ asset('images/brand/logo-maloppo-full.jpg') }}"
                            alt="Logo UMKM Maloppo"
                            class="h-full w-full object-contain"
                        >
                    </div>

                </div>

            </section>

            {{-- Statistik produk --}}
            <section>

                <div class="mb-5">

                    <span class="label-maloppo">
                        Ringkasan Data
                    </span>

                    <h2 class="mt-3 text-2xl font-extrabold text-gray-900">
                        Statistik Produk
                    </h2>

                    <p class="mt-2 text-sm text-gray-500">
                        Informasi terbaru mengenai produk dan persediaan.
                    </p>

                </div>

                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">

                    {{-- Total produk --}}
                    <article class="card-maloppo card-maloppo-hover p-6">

                        <div class="flex items-start justify-between gap-4">

                            <div>

                                <p class="text-sm font-semibold text-gray-500">
                                    Total Produk
                                </p>

                                <p class="mt-3 text-4xl font-extrabold text-gray-900">
                                    {{ $totalProducts }}
                                </p>

                                <p class="mt-2 text-xs leading-5 text-gray-500">
                                    Seluruh produk yang tersimpan
                                </p>

                            </div>

                            <div
                                class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl text-2xl"
                                style="background-color: #fff9b0;"
                            >
                                📦
                            </div>

                        </div>

                        <div
                            class="mt-5 h-1.5 w-full overflow-hidden rounded-full"
                            style="background-color: #fff9b0;"
                        >
                            <div
                                class="h-full w-3/4 rounded-full"
                                style="background-color: #be0000;"
                            ></div>
                        </div>

                    </article>

                    {{-- Produk aktif --}}
                    <article class="card-maloppo card-maloppo-hover p-6">

                        <div class="flex items-start justify-between gap-4">

                            <div>

                                <p class="text-sm font-semibold text-gray-500">
                                    Produk Aktif
                                </p>

                                <p class="mt-3 text-4xl font-extrabold text-gray-900">
                                    {{ $activeProducts }}
                                </p>

                                <p class="mt-2 text-xs leading-5 text-gray-500">
                                    Tampil pada katalog pengunjung
                                </p>

                            </div>

                            <div
                                class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl text-2xl"
                                style="
                                    background-color: #dcfce7;
                                    color: #166534;
                                "
                            >
                                ✓
                            </div>

                        </div>

                        <div
                            class="mt-5 rounded-xl px-3 py-2 text-xs font-semibold"
                            style="
                                background-color: #dcfce7;
                                color: #166534;
                            "
                        >
                            Produk dapat dilihat pelanggan
                        </div>

                    </article>

                    {{-- Stok habis --}}
                    <article class="card-maloppo card-maloppo-hover p-6">

                        <div class="flex items-start justify-between gap-4">

                            <div>

                                <p class="text-sm font-semibold text-gray-500">
                                    Stok Habis
                                </p>

                                <p class="mt-3 text-4xl font-extrabold text-gray-900">
                                    {{ $outOfStockProducts }}
                                </p>

                                <p class="mt-2 text-xs leading-5 text-gray-500">
                                    Produk dengan jumlah stok nol
                                </p>

                            </div>

                            <div
                                class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl text-2xl font-extrabold"
                                style="
                                    background-color: #fee2e2;
                                    color: #991b1b;
                                "
                            >
                                !
                            </div>

                        </div>

                        <a
                            href="{{ route('admin.products.index') }}"
                            class="mt-5 inline-flex text-xs font-bold text-maloppo-red"
                        >
                            Periksa persediaan →
                        </a>

                    </article>

                    {{-- Total stok --}}
                    <article class="card-maloppo card-maloppo-hover p-6">

                        <div class="flex items-start justify-between gap-4">

                            <div>

                                <p class="text-sm font-semibold text-gray-500">
                                    Total Stok
                                </p>

                                <p class="mt-3 text-4xl font-extrabold text-gray-900">
                                    {{ $totalStock }}
                                </p>

                                <p class="mt-2 text-xs leading-5 text-gray-500">
                                    Jumlah seluruh persediaan
                                </p>

                            </div>

                            <div
                                class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl text-2xl"
                                style="background-color: #fff9b0;"
                            >
                                📊
                            </div>

                        </div>

                        <div
                            class="mt-5 rounded-xl px-3 py-2 text-xs font-semibold"
                            style="
                                background-color: #fff9b0;
                                color: #990100;
                            "
                        >
                            Akumulasi seluruh produk
                        </div>

                    </article>

                </div>

            </section>

            {{-- Akses cepat --}}
            <section class="card-maloppo overflow-hidden">

                <div
                    class="border-b px-6 py-5"
                    style="
                        background-color: #fffdf0;
                        border-color: #f1e7a4;
                    "
                >

                    <div
                        class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between"
                    >

                        <div>

                            <h2 class="text-xl font-extrabold text-gray-900">
                                Akses Cepat
                            </h2>

                            <p class="mt-1 text-sm text-gray-500">
                                Pilih bagian sistem yang ingin dikelola.
                            </p>

                        </div>

                        <span
                            class="inline-flex w-fit rounded-full px-3 py-1.5 text-xs font-bold"
                            style="
                                background-color: #f7e900;
                                color: #990100;
                            "
                        >
                            Menu Administrator
                        </span>

                    </div>

                </div>

                <div
                    class="grid grid-cols-1 gap-4 p-6 sm:grid-cols-2 lg:grid-cols-5"
                >

                    {{-- Kelola produk --}}
                    <a
                        href="{{ route('admin.products.index') }}"
                        class="card-maloppo-hover rounded-2xl border p-5"
                        style="border-color: #f1e7a4;"
                    >

                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-xl text-xl"
                            style="background-color: #fff9b0;"
                        >
                            🥥
                        </div>

                        <h3 class="mt-4 font-bold text-gray-900">
                            Kelola Produk
                        </h3>

                        <p class="mt-2 text-xs leading-5 text-gray-500">
                            Lihat, ubah, dan hapus data produk.
                        </p>

                    </a>

                    {{-- Tambah produk --}}
                    <a
                        href="{{ route('admin.products.create') }}"
                        class="card-maloppo-hover rounded-2xl border p-5"
                        style="border-color: #f1e7a4;"
                    >

                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-xl text-2xl font-bold"
                            style="
                                background-color: #be0000;
                                color: white;
                            "
                        >
                            +
                        </div>

                        <h3 class="mt-4 font-bold text-gray-900">
                            Tambah Produk
                        </h3>

                        <p class="mt-2 text-xs leading-5 text-gray-500">
                            Masukkan produk baru ke katalog.
                        </p>

                    </a>

                    {{-- Kegiatan --}}
                    <a
                        href="{{ route('admin.posts.index') }}"
                        class="card-maloppo-hover rounded-2xl border p-5"
                        style="border-color: #f1e7a4;"
                    >

                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-xl text-xl"
                            style="background-color: #fff9b0;"
                        >
                            📰
                        </div>

                        <h3 class="mt-4 font-bold text-gray-900">
                            Kegiatan
                        </h3>

                        <p class="mt-2 text-xs leading-5 text-gray-500">
                            Kelola berita dan aktivitas UMKM.
                        </p>

                    </a>

                    {{-- Pesanan --}}
                    <a
                        href="{{ route('admin.orders.index') }}"
                        class="card-maloppo-hover rounded-2xl border p-5"
                        style="border-color: #f1e7a4;"
                    >

                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-xl text-xl"
                            style="background-color: #fff9b0;"
                        >
                            📦
                        </div>

                        <h3 class="mt-4 font-bold text-gray-900">
                            Pesanan
                        </h3>

                        <p class="mt-2 text-xs leading-5 text-gray-500">
                            Periksa dan proses pesanan pelanggan.
                        </p>

                    </a>

                    {{-- Katalog publik --}}
                    <a
                        href="{{ route('catalog.index') }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="card-maloppo-hover rounded-2xl border p-5"
                        style="border-color: #f1e7a4;"
                    >

                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-xl text-xl"
                            style="
                                background-color: #dbeafe;
                                color: #1d4ed8;
                            "
                        >
                            🌐
                        </div>

                        <h3 class="mt-4 font-bold text-gray-900">
                            Lihat Katalog
                        </h3>

                        <p class="mt-2 text-xs leading-5 text-gray-500">
                            Buka tampilan produk pengunjung.
                        </p>

                    </a>

                </div>

            </section>

            {{-- Produk terbaru --}}
            <section class="card-maloppo overflow-hidden">

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
                            🕘
                        </div>

                        <div>

                            <h2 class="text-xl font-extrabold text-gray-900">
                                Produk Terbaru
                            </h2>

                            <p class="mt-1 text-sm text-gray-500">
                                Lima produk yang terakhir ditambahkan.
                            </p>

                        </div>

                    </div>

                    <a
                        href="{{ route('admin.products.index') }}"
                        class="btn-maloppo-secondary"
                    >
                        Lihat Semua Produk
                    </a>

                </div>

                {{-- Tampilan desktop --}}
                <div class="hidden overflow-x-auto md:block">

                    <table class="w-full text-left">

                        <thead>

                            <tr
                                class="border-b"
                                style="
                                    background-color: #fff9b0;
                                    border-color: #f1e7a4;
                                "
                            >

                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-700">
                                    Produk
                                </th>

                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-700">
                                    Ukuran
                                </th>

                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-700">
                                    Harga
                                </th>

                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-700">
                                    Stok
                                </th>

                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-700">
                                    Status
                                </th>

                                <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider text-gray-700">
                                    Aksi
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse ($latestProducts as $product)

                                <tr
                                    class="border-b transition last:border-b-0 hover:bg-yellow-50/40"
                                    style="border-color: #f1e7a4;"
                                >

                                    <td class="px-6 py-4">

                                        <div class="flex items-center gap-4">

                                            <div
                                                class="flex h-12 w-12 shrink-0 items-center justify-center overflow-hidden rounded-xl border"
                                                style="
                                                    background-color: #fffdf0;
                                                    border-color: #f1e7a4;
                                                "
                                            >

                                                @if ($product->image)

                                                    <img
                                                        src="{{ asset('storage/' . $product->image) }}"
                                                        alt="{{ $product->name }}"
                                                        class="h-full w-full object-cover"
                                                    >

                                                @else

                                                    <span class="text-xl">
                                                        🥥
                                                    </span>

                                                @endif

                                            </div>

                                            <div>

                                                <p class="font-bold text-gray-900">
                                                    {{ $product->name }}
                                                </p>

                                                <p class="mt-1 text-xs text-gray-500">
                                                    Ditambahkan
                                                    {{ $product->created_at->format('d M Y') }}
                                                </p>

                                            </div>

                                        </div>

                                    </td>

                                    <td class="px-6 py-4">

                                        <span class="badge-maloppo-yellow">
                                            {{ $product->size ?? '-' }}
                                        </span>

                                    </td>

                                    <td class="px-6 py-4 text-sm font-extrabold text-maloppo-red">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </td>

                                    <td class="px-6 py-4">

                                        <span
                                            class="inline-flex rounded-full px-3 py-1 text-xs font-bold"
                                            style="{{ $product->stock > 0
                                                ? 'background-color: #dcfce7; color: #166534;'
                                                : 'background-color: #fee2e2; color: #991b1b;' }}"
                                        >
                                            {{ $product->stock }}
                                        </span>

                                    </td>

                                    <td class="px-6 py-4">

                                        @if ($product->is_active)

                                            <span
                                                class="inline-flex items-center gap-1 rounded-full px-3 py-1 text-xs font-bold"
                                                style="
                                                    background-color: #dcfce7;
                                                    color: #166534;
                                                "
                                            >
                                                <span>✓</span>
                                                Aktif
                                            </span>

                                        @else

                                            <span
                                                class="inline-flex rounded-full px-3 py-1 text-xs font-bold"
                                                style="
                                                    background-color: #fee2e2;
                                                    color: #991b1b;
                                                "
                                            >
                                                Tidak Aktif
                                            </span>

                                        @endif

                                    </td>

                                    <td class="px-6 py-4 text-center">

                                        <a
                                            href="{{ route('admin.products.edit', $product) }}"
                                            class="inline-flex items-center gap-2 rounded-lg px-4 py-2 text-xs font-bold text-white shadow-sm"
                                            style="background-color: #be0000;"
                                        >
                                            <span>✏️</span>
                                            Edit
                                        </a>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="6"
                                        class="px-6 py-16 text-center"
                                    >

                                        <div
                                            class="mx-auto flex h-16 w-16 items-center justify-center rounded-full text-4xl"
                                            style="background-color: #fff9b0;"
                                        >
                                            🥥
                                        </div>

                                        <p class="mt-4 font-bold text-gray-700">
                                            Belum ada produk
                                        </p>

                                        <p class="mt-2 text-sm text-gray-500">
                                            Tambahkan produk pertama ke katalog Maloppo.
                                        </p>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                {{-- Tampilan HP --}}
                <div class="divide-y md:hidden" style="border-color: #f1e7a4;">

                    @forelse ($latestProducts as $product)

                        <article class="p-5">

                            <div class="flex items-start gap-4">

                                <div
                                    class="flex h-20 w-20 shrink-0 items-center justify-center overflow-hidden rounded-2xl border"
                                    style="
                                        background-color: #fffdf0;
                                        border-color: #f1e7a4;
                                    "
                                >

                                    @if ($product->image)

                                        <img
                                            src="{{ asset('storage/' . $product->image) }}"
                                            alt="{{ $product->name }}"
                                            class="h-full w-full object-cover"
                                        >

                                    @else

                                        <span class="text-3xl">
                                            🥥
                                        </span>

                                    @endif

                                </div>

                                <div class="min-w-0 flex-1">

                                    <div class="flex items-start justify-between gap-3">

                                        <div>

                                            <h3 class="font-bold leading-6 text-gray-900">
                                                {{ $product->name }}
                                            </h3>

                                            <p class="mt-1 text-xs text-gray-500">
                                                {{ $product->created_at->format('d M Y') }}
                                            </p>

                                        </div>

                                        @if ($product->is_active)

                                            <span
                                                class="shrink-0 rounded-full px-2.5 py-1 text-xs font-bold"
                                                style="
                                                    background-color: #dcfce7;
                                                    color: #166534;
                                                "
                                            >
                                                Aktif
                                            </span>

                                        @else

                                            <span
                                                class="shrink-0 rounded-full px-2.5 py-1 text-xs font-bold"
                                                style="
                                                    background-color: #fee2e2;
                                                    color: #991b1b;
                                                "
                                            >
                                                Nonaktif
                                            </span>

                                        @endif

                                    </div>

                                    <div class="mt-3 flex flex-wrap items-center gap-2">

                                        <span class="badge-maloppo-yellow">
                                            {{ $product->size ?? '-' }}
                                        </span>

                                        <span class="text-xs text-gray-500">
                                            Stok {{ $product->stock }}
                                        </span>

                                    </div>

                                    <p class="mt-3 text-lg font-extrabold text-maloppo-red">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </p>

                                    <a
                                        href="{{ route('admin.products.edit', $product) }}"
                                        class="btn-maloppo-secondary mt-4 w-full py-2.5"
                                    >
                                        Edit Produk
                                    </a>

                                </div>

                            </div>

                        </article>

                    @empty

                        <div class="px-6 py-16 text-center">

                            <div
                                class="mx-auto flex h-16 w-16 items-center justify-center rounded-full text-4xl"
                                style="background-color: #fff9b0;"
                            >
                                🥥
                            </div>

                            <p class="mt-4 font-bold text-gray-700">
                                Belum ada produk
                            </p>

                            <a
                                href="{{ route('admin.products.create') }}"
                                class="btn-maloppo-primary mt-5"
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