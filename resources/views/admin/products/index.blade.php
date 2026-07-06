<x-app-layout>

    <x-slot name="header">
        <div
            class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"
        >
            <div>
                <h1 class="text-2xl font-extrabold leading-tight text-gray-900">
                    Data Produk
                </h1>

                <p class="mt-2 text-sm font-normal text-gray-600">
                    Kelola produk, harga, ukuran, stok, dan status katalog UMKM Maloppo.
                </p>
            </div>

            <a
                href="{{ route('admin.products.create') }}"
                class="btn-maloppo-primary"
            >
                <span class="text-lg">+</span>
                Tambah Produk
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

            {{-- Informasi ringkas --}}
            <section class="mb-7 grid grid-cols-1 gap-4 sm:grid-cols-3">

                <article class="card-maloppo p-5">

                    <div class="flex items-center justify-between gap-4">

                        <div>
                            <p class="text-sm font-semibold text-gray-500">
                                Total Produk
                            </p>

                            <p class="mt-2 text-3xl font-extrabold text-gray-900">
                                {{ $products->total() }}
                            </p>
                        </div>

                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-xl text-xl"
                            style="background-color: #fff9b0;"
                        >
                            🥥
                        </div>

                    </div>

                </article>

                <article class="card-maloppo p-5">

                    <div class="flex items-center justify-between gap-4">

                        <div>
                            <p class="text-sm font-semibold text-gray-500">
                                Ditampilkan
                            </p>

                            <p class="mt-2 text-3xl font-extrabold text-gray-900">
                                {{ $products->count() }}
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

                <article class="card-maloppo p-5">

                    <div class="flex items-center justify-between gap-4">

                        <div>
                            <p class="text-sm font-semibold text-gray-500">
                                Halaman Aktif
                            </p>

                            <p class="mt-2 text-3xl font-extrabold text-gray-900">
                                {{ $products->currentPage() }}
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

            {{-- Daftar produk --}}
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
                            📦
                        </div>

                        <div>
                            <h2 class="text-xl font-extrabold text-gray-900">
                                Daftar Produk Maloppo
                            </h2>

                            <p class="mt-1 text-sm text-gray-500">
                                Data produk yang tersedia di dalam sistem.
                            </p>
                        </div>

                    </div>

                    <a
                        href="{{ route('catalog.index') }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="btn-maloppo-secondary"
                    >
                        <span>🌐</span>
                        Lihat Katalog
                    </a>

                </div>

                {{-- Tampilan tabel desktop --}}
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
                                <th
                                    class="px-5 py-4 text-xs font-bold uppercase tracking-wider text-gray-700"
                                >
                                    No.
                                </th>

                                <th
                                    class="px-5 py-4 text-xs font-bold uppercase tracking-wider text-gray-700"
                                >
                                    Produk
                                </th>

                                <th
                                    class="px-5 py-4 text-xs font-bold uppercase tracking-wider text-gray-700"
                                >
                                    Ukuran
                                </th>

                                <th
                                    class="px-5 py-4 text-xs font-bold uppercase tracking-wider text-gray-700"
                                >
                                    Harga
                                </th>

                                <th
                                    class="px-5 py-4 text-xs font-bold uppercase tracking-wider text-gray-700"
                                >
                                    Stok
                                </th>

                                <th
                                    class="px-5 py-4 text-xs font-bold uppercase tracking-wider text-gray-700"
                                >
                                    Status
                                </th>

                                <th
                                    class="px-5 py-4 text-center text-xs font-bold uppercase tracking-wider text-gray-700"
                                >
                                    Aksi
                                </th>
                            </tr>

                        </thead>

                        <tbody>

                            @forelse ($products as $product)

                                <tr
                                    class="border-b transition last:border-b-0 hover:bg-yellow-50/40"
                                    style="border-color: #f1e7a4;"
                                >

                                    <td class="px-5 py-4 text-sm font-semibold text-gray-500">
                                        {{ $products->firstItem() + $loop->index }}
                                    </td>

                                    <td class="px-5 py-4">

                                        <div class="flex items-center gap-4">

                                            <div
                                                class="flex h-14 w-14 shrink-0 items-center justify-center overflow-hidden rounded-xl border"
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

                                                    <span class="text-2xl">
                                                        🥥
                                                    </span>

                                                @endif

                                            </div>

                                            <div class="min-w-0">

                                                <p class="font-bold text-gray-900">
                                                    {{ $product->name }}
                                                </p>

                                                <p class="mt-1 max-w-xs truncate text-xs text-gray-500">
                                                    {{ $product->short_description ?: 'Belum ada deskripsi singkat.' }}
                                                </p>

                                            </div>

                                        </div>

                                    </td>

                                    <td class="px-5 py-4">

                                        <span class="badge-maloppo-yellow">
                                            {{ $product->size ?? '-' }}
                                        </span>

                                    </td>

                                    <td class="px-5 py-4 text-sm font-extrabold text-maloppo-red">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </td>

                                    <td class="px-5 py-4">

                                        @if ($product->stock > 0)

                                            <span
                                                class="inline-flex items-center gap-1 rounded-full px-3 py-1 text-xs font-bold"
                                                style="
                                                    background-color: #dcfce7;
                                                    color: #166534;
                                                "
                                            >
                                                {{ $product->stock }} tersedia
                                            </span>

                                        @else

                                            <span
                                                class="inline-flex rounded-full px-3 py-1 text-xs font-bold"
                                                style="
                                                    background-color: #fee2e2;
                                                    color: #991b1b;
                                                "
                                            >
                                                Stok habis
                                            </span>

                                        @endif

                                    </td>

                                    <td class="px-5 py-4">

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

                                    <td class="px-5 py-4">

                                        <div class="flex items-center justify-center gap-2">

                                            <a
                                                href="{{ route('admin.products.edit', $product) }}"
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
                                                action="{{ route('admin.products.destroy', $product) }}"
                                                method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus produk {{ addslashes($product->name) }}?')"
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
                                            🥥
                                        </div>

                                        <h3 class="mt-5 text-lg font-bold text-gray-800">
                                            Belum ada produk
                                        </h3>

                                        <p class="mt-2 text-sm text-gray-500">
                                            Tambahkan produk pertama UMKM Maloppo.
                                        </p>

                                        <a
                                            href="{{ route('admin.products.create') }}"
                                            class="btn-maloppo-primary mt-6"
                                        >
                                            + Tambah Produk
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

                    @forelse ($products as $product)

                        <article class="p-5">

                            <div class="flex items-start gap-4">

                                <div
                                    class="flex h-24 w-24 shrink-0 items-center justify-center overflow-hidden rounded-2xl border"
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

                                        <span class="text-4xl">
                                            🥥
                                        </span>

                                    @endif

                                </div>

                                <div class="min-w-0 flex-1">

                                    <div class="flex items-start justify-between gap-3">

                                        <div>

                                            <p class="text-xs font-semibold text-gray-400">
                                                Produk #{{ $products->firstItem() + $loop->index }}
                                            </p>

                                            <h3 class="mt-1 font-extrabold leading-6 text-gray-900">
                                                {{ $product->name }}
                                            </h3>

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

                                        <span
                                            class="rounded-full px-3 py-1 text-xs font-bold"
                                            style="{{ $product->stock > 0
                                                ? 'background-color: #dcfce7; color: #166534;'
                                                : 'background-color: #fee2e2; color: #991b1b;' }}"
                                        >
                                            Stok {{ $product->stock }}
                                        </span>

                                    </div>

                                    <p class="mt-3 text-lg font-extrabold text-maloppo-red">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </p>

                                </div>

                            </div>

                            <div class="mt-5 grid grid-cols-2 gap-3">

                                <a
                                    href="{{ route('admin.products.edit', $product) }}"
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
                                    action="{{ route('admin.products.destroy', $product) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus produk {{ addslashes($product->name) }}?')"
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
                                🥥
                            </div>

                            <h3 class="mt-5 font-bold text-gray-800">
                                Belum ada produk
                            </h3>

                            <a
                                href="{{ route('admin.products.create') }}"
                                class="btn-maloppo-primary mt-5"
                            >
                                Tambah Produk
                            </a>

                        </div>

                    @endforelse

                </div>

                {{-- Pagination --}}
                @if ($products->hasPages())

                    <div
                        class="border-t px-5 py-5"
                        style="
                            background-color: #fffdf0;
                            border-color: #f1e7a4;
                        "
                    >
                        {{ $products->links() }}
                    </div>

                @endif

            </section>

        </div>

    </div>

</x-app-layout>