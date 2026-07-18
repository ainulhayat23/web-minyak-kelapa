<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="description"
        content="Keranjang belanja produk minyak kelapa UMKM Maloppo."
    >

    <title>Keranjang Belanja | UMKM Maloppo</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white text-gray-900">

    {{-- Navigasi --}}
    <x-public-navbar />

    {{-- Header --}}
    <header class="relative overflow-hidden bg-gradient-to-br from-red-700 via-red-600 to-yellow-500">

        <div class="absolute inset-0 bg-black/10"></div>

        <div class="relative mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8 lg:py-16">

            <div class="grid grid-cols-1 gap-8 lg:grid-cols-2 lg:items-center">

                <div class="text-white">

                    <p class="text-sm font-semibold uppercase tracking-[0.25em] text-yellow-100">
                        Pesanan Anda
                    </p>

                    <h1 class="mt-4 text-4xl font-bold leading-tight tracking-tight sm:text-5xl">
                        Keranjang Belanja
                    </h1>

                    <p class="mt-5 max-w-2xl text-base leading-8 text-red-50">
                        Periksa kembali produk minyak kelapa Maloppo yang sudah
                        dipilih sebelum melanjutkan ke proses checkout.
                    </p>

                </div>

                {{-- Tahapan --}}
                <div class="rounded-3xl bg-white/95 p-6 shadow-xl">

                    <p class="text-sm font-semibold text-gray-900">
                        Tahapan Pemesanan
                    </p>

                    <div class="mt-5 grid grid-cols-1 gap-3 sm:grid-cols-3">

                        <div class="rounded-2xl bg-red-700 p-4 text-white">
                            <p class="text-xs font-semibold uppercase tracking-wider text-red-100">
                                Langkah 1
                            </p>

                            <p class="mt-2 text-sm font-bold">
                                Keranjang
                            </p>
                        </div>

                        <div class="rounded-2xl bg-yellow-50 p-4">
                            <p class="text-xs font-semibold uppercase tracking-wider text-red-700">
                                Langkah 2
                            </p>

                            <p class="mt-2 text-sm font-bold text-gray-900">
                                Checkout
                            </p>
                        </div>

                        <div class="rounded-2xl bg-yellow-50 p-4">
                            <p class="text-xs font-semibold uppercase tracking-wider text-red-700">
                                Langkah 3
                            </p>

                            <p class="mt-2 text-sm font-bold text-gray-900">
                                Konfirmasi
                            </p>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </header>

    <main class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8 lg:py-16">

        {{-- Notifikasi berhasil --}}
        @if (session('success'))

            <div class="mb-8 rounded-2xl border border-green-200 bg-green-50 px-5 py-4 text-sm text-green-800">
                {{ session('success') }}
            </div>

        @endif

        {{-- Notifikasi kesalahan --}}
        @if (session('error'))

            <div class="mb-8 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700">
                {{ session('error') }}
            </div>

        @endif

        {{-- Kesalahan validasi --}}
        @if ($errors->any())

            <div class="mb-8 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700">

                <p class="font-semibold">
                    Data belum dapat diproses.
                </p>

                <ul class="mt-2 list-inside list-disc space-y-1">

                    @foreach ($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif

        @if (count($cart) > 0)

            <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">

                {{-- Daftar produk --}}
                <section class="lg:col-span-2">

                    <div class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">

                        {{-- Header daftar --}}
                        <div class="flex flex-col gap-4 border-b border-gray-200 bg-yellow-50 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">

                            <div>

                                <p class="text-sm font-semibold uppercase tracking-[0.20em] text-red-700">
                                    Isi Keranjang
                                </p>

                                <h2 class="mt-2 text-2xl font-bold text-gray-900">
                                    Produk dalam Keranjang
                                </h2>

                                <p class="mt-1 text-sm text-gray-600">
                                    {{ $totalQuantity }} barang dipilih.
                                </p>

                            </div>

                            <form
                                action="{{ route('cart.clear') }}"
                                method="POST"
                                onsubmit="return confirm('Yakin ingin mengosongkan seluruh keranjang?')"
                            >
                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="inline-flex items-center justify-center rounded-lg border border-red-200 bg-white px-4 py-2.5 text-sm font-semibold text-red-700 transition hover:bg-red-50"
                                >
                                    Kosongkan Keranjang
                                </button>

                            </form>

                        </div>

                        {{-- Isi keranjang --}}
                        <div class="divide-y divide-gray-100">

                            @foreach ($cart as $item)

                                @php
                                    $subtotal = $item['price'] * $item['quantity'];
                                @endphp

                                <article class="p-5 sm:p-6">

                                    <div class="flex flex-col gap-5 sm:flex-row">

                                        {{-- Gambar --}}
                                        <a
                                            href="{{ route('catalog.show', $item['slug']) }}"
                                            class="flex h-56 w-full shrink-0 items-center justify-center overflow-hidden rounded-2xl border border-yellow-200 bg-yellow-50 p-4 sm:h-36 sm:w-36"
                                        >

                                            @if ($item['image'])

                                                <img
                                                    src="{{ asset('storage/' . $item['image']) }}"
                                                    alt="{{ $item['name'] }}"
                                                    class="h-full w-full object-contain"
                                                >

                                            @else

                                                <span class="text-center text-xs text-gray-400">
                                                    Foto belum tersedia
                                                </span>

                                            @endif

                                        </a>

                                        {{-- Informasi --}}
                                        <div class="min-w-0 flex-1">

                                            <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">

                                                <div class="min-w-0">

                                                    <a
                                                        href="{{ route('catalog.show', $item['slug']) }}"
                                                        class="text-lg font-bold leading-6 text-gray-900 transition hover:text-red-700"
                                                    >
                                                        {{ $item['name'] }}
                                                    </a>

                                                    <div class="mt-3 flex flex-wrap items-center gap-2 text-xs">

                                                        <span class="rounded-full bg-yellow-100 px-3 py-1 font-semibold text-red-700">
                                                            Ukuran: {{ $item['size'] ?? '-' }}
                                                        </span>

                                                        <span class="rounded-full bg-green-50 px-3 py-1 font-semibold text-green-700">
                                                            Stok: {{ $item['stock'] }}
                                                        </span>

                                                    </div>

                                                    <p class="mt-4 text-xl font-bold text-red-700">
                                                        Rp {{ number_format($item['price'], 0, ',', '.') }}
                                                    </p>

                                                </div>

                                                {{-- Hapus --}}
                                                <form
                                                    action="{{ route('cart.remove', $item['product_id']) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Hapus produk ini dari keranjang?')"
                                                >
                                                    @csrf
                                                    @method('DELETE')

                                                    <button
                                                        type="submit"
                                                        class="inline-flex items-center justify-center rounded-lg border border-red-200 px-4 py-2 text-sm font-semibold text-red-700 transition hover:bg-red-50"
                                                    >
                                                        Hapus
                                                    </button>

                                                </form>

                                            </div>

                                            {{-- Jumlah dan subtotal --}}
                                            <div class="mt-5 flex flex-col gap-5 border-t border-gray-100 pt-5 sm:flex-row sm:items-end sm:justify-between">

                                                <form
                                                    action="{{ route('cart.update', $item['product_id']) }}"
                                                    method="POST"
                                                    class="flex flex-wrap items-end gap-3"
                                                >
                                                    @csrf
                                                    @method('PATCH')

                                                    <div>

                                                        <label
                                                            for="quantity-{{ $item['product_id'] }}"
                                                            class="block text-xs font-semibold uppercase tracking-wider text-gray-500"
                                                        >
                                                            Jumlah
                                                        </label>

                                                        <div class="mt-2 flex items-center overflow-hidden rounded-lg border border-gray-300 bg-white">

                                                            <button
                                                                type="button"
                                                                class="quantity-minus flex h-11 w-11 items-center justify-center text-lg font-bold text-gray-700 transition hover:bg-gray-50"
                                                                data-target="quantity-{{ $item['product_id'] }}"
                                                                aria-label="Kurangi jumlah"
                                                            >
                                                                −
                                                            </button>

                                                            <input
                                                                type="number"
                                                                name="quantity"
                                                                id="quantity-{{ $item['product_id'] }}"
                                                                value="{{ $item['quantity'] }}"
                                                                min="1"
                                                                max="{{ $item['stock'] }}"
                                                                class="h-11 w-16 border-x border-y-0 border-gray-300 p-0 text-center text-sm font-bold text-gray-900 focus:ring-0"
                                                                required
                                                            >

                                                            <button
                                                                type="button"
                                                                class="quantity-plus flex h-11 w-11 items-center justify-center text-lg font-bold text-gray-700 transition hover:bg-gray-50"
                                                                data-target="quantity-{{ $item['product_id'] }}"
                                                                aria-label="Tambah jumlah"
                                                            >
                                                                +
                                                            </button>

                                                        </div>

                                                    </div>

                                                    <button
                                                        type="submit"
                                                        class="inline-flex h-11 items-center justify-center rounded-lg border border-gray-300 bg-white px-4 text-sm font-semibold text-gray-700 transition hover:bg-gray-50"
                                                    >
                                                        Perbarui
                                                    </button>

                                                </form>

                                                <div class="rounded-2xl bg-red-50 px-5 py-4 sm:text-right">

                                                    <p class="text-xs font-semibold uppercase tracking-wider text-red-700">
                                                        Subtotal
                                                    </p>

                                                    <p class="mt-1 text-xl font-bold text-gray-900">
                                                        Rp {{ number_format($subtotal, 0, ',', '.') }}
                                                    </p>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </article>

                            @endforeach

                        </div>

                    </div>

                    <a
                        href="{{ route('catalog.index') }}"
                        class="mt-6 inline-flex items-center justify-center rounded-lg border border-red-200 px-4 py-2.5 text-sm font-semibold text-red-700 transition hover:bg-red-50"
                    >
                        <span class="mr-2" aria-hidden="true">←</span>
                        Lanjut memilih produk
                    </a>

                </section>

                {{-- Ringkasan --}}
                <aside>

                    <div class="sticky top-24 overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">

                        <div class="border-b border-gray-200 bg-yellow-50 px-6 py-5">

                            <p class="text-sm font-semibold uppercase tracking-[0.20em] text-red-700">
                                Ringkasan
                            </p>

                            <h2 class="mt-2 text-2xl font-bold text-gray-900">
                                Ringkasan Belanja
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                Rincian sementara pesanan.
                            </p>

                        </div>

                        <div class="p-6">

                            <dl class="space-y-5">

                                <div class="flex items-center justify-between gap-4 text-sm">

                                    <dt class="text-gray-500">
                                        Jumlah barang
                                    </dt>

                                    <dd class="font-bold text-gray-900">
                                        {{ $totalQuantity }}
                                    </dd>

                                </div>

                                <div class="flex items-center justify-between gap-4 text-sm">

                                    <dt class="text-gray-500">
                                        Subtotal produk
                                    </dt>

                                    <dd class="font-bold text-gray-900">
                                        Rp {{ number_format($totalPrice, 0, ',', '.') }}
                                    </dd>

                                </div>

                                <div class="flex items-start justify-between gap-4 text-sm">

                                    <dt class="text-gray-500">
                                        Pengiriman
                                    </dt>

                                    <dd class="max-w-36 text-right text-xs leading-5 text-gray-500">
                                        Dikonfirmasi melalui WhatsApp
                                    </dd>

                                </div>

                            </dl>

                            <div class="mt-6 rounded-2xl bg-red-50 p-5">

                                <p class="text-sm font-semibold text-gray-900">
                                    Total Produk
                                </p>

                                <p class="mt-1 text-xs text-gray-500">
                                    Belum termasuk biaya pengiriman
                                </p>

                                <p class="mt-3 text-3xl font-bold text-red-700">
                                    Rp {{ number_format($totalPrice, 0, ',', '.') }}
                                </p>

                            </div>

                            <a
                                href="{{ route('checkout.create') }}"
                                class="mt-6 inline-flex w-full items-center justify-center rounded-lg bg-red-700 px-5 py-3 text-sm font-semibold text-white transition hover:bg-red-800"
                            >
                                Lanjut ke Checkout
                            </a>

                            <p class="mt-3 text-center text-xs leading-5 text-gray-500">
                                Lengkapi nama, WhatsApp, alamat, dan catatan pesanan.
                            </p>

                            <div class="mt-5 border-t border-gray-100 pt-5">

                                <p class="text-xs leading-5 text-gray-500">
                                    Pesanan akan disimpan ke sistem, kemudian
                                    Anda diarahkan ke WhatsApp Maloppo untuk konfirmasi.
                                </p>

                            </div>

                        </div>

                    </div>

                </aside>

            </div>

        @else

            {{-- Keranjang kosong --}}
            <section class="rounded-3xl border border-gray-200 bg-white px-5 py-16 text-center shadow-sm sm:py-20">

                <div class="mx-auto max-w-xl">

                    <p class="text-sm font-semibold uppercase tracking-[0.25em] text-red-700">
                        Keranjang Kosong
                    </p>

                    <h2 class="mt-4 text-3xl font-bold text-gray-900">
                        Belum ada produk yang dipilih.
                    </h2>

                    <p class="mx-auto mt-3 max-w-md text-sm leading-7 text-gray-600">
                        Pilih produk minyak kelapa Maloppo, lalu tambahkan produk
                        tersebut ke dalam keranjang sebelum checkout.
                    </p>

                    <a
                        href="{{ route('catalog.index') }}"
                        class="mt-6 inline-flex items-center justify-center rounded-lg bg-red-700 px-5 py-3 text-sm font-semibold text-white transition hover:bg-red-800"
                    >
                        Lihat Produk
                    </a>

                </div>

            </section>

        @endif

    </main>

    {{-- Footer --}}
    <footer class="border-t border-gray-200 bg-white">

        <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 gap-8 md:grid-cols-2 md:items-center">

                <div>

                    <div class="flex h-14 w-32 items-center justify-center overflow-hidden rounded-lg border border-gray-200 bg-gray-50">
                        <img
                            src="{{ asset('images/brand/logo-maloppo-wordmark.jpg') }}"
                            alt="Logo UMKM Maloppo"
                            class="h-full w-full object-contain"
                        >
                    </div>

                    <p class="mt-4 text-sm font-semibold text-gray-900">
                        UMKM Maloppo
                    </p>

                    <p class="mt-1 max-w-sm text-xs leading-5 text-gray-500">
                        Produk minyak kelapa murni dari kelapa pilihan.
                    </p>

                </div>

                <div class="md:text-right">

                    <p class="text-sm font-semibold text-gray-900">
                        Hubungi dan ikuti Maloppo
                    </p>

                    <p class="mt-1 text-xs text-gray-500">
                        Dapatkan informasi produk dan kegiatan terbaru.
                    </p>

                    <div class="mt-4 md:flex md:justify-end">
                        <x-social-media />
                    </div>

                </div>

            </div>

            <div class="mt-8 flex flex-col gap-2 border-t border-gray-200 pt-5 text-xs text-gray-500 sm:flex-row sm:items-center sm:justify-between">
                <p>
                    &copy; {{ date('Y') }} UMKM Maloppo.
                </p>

                <a
                    href="{{ route('catalog.index') }}"
                    class="font-medium text-gray-600 hover:text-red-700"
                >
                    Kembali ke Katalog
                </a>
            </div>

        </div>

    </footer>

    {{-- Tombol tambah dan kurang jumlah --}}
    <script>
        document
            .querySelectorAll('.quantity-minus, .quantity-plus')
            .forEach((button) => {
                button.addEventListener('click', () => {
                    const input = document.getElementById(
                        button.dataset.target
                    );

                    if (!input) {
                        return;
                    }

                    const form = input.closest('form');

                    const minimum = Number(input.min || 1);
                    const maximum = Number(input.max || 999);
                    const oldValue = Number(input.value || minimum);

                    let newValue = oldValue;

                    if (button.classList.contains('quantity-plus')) {
                        newValue = Math.min(maximum, oldValue + 1);
                    }

                    if (button.classList.contains('quantity-minus')) {
                        newValue = Math.max(minimum, oldValue - 1);
                    }

                    if (newValue !== oldValue) {
                        input.value = newValue;

                        if (form) {
                            form.submit();
                        }
                    }
                });
            });
    </script>

</body>

</html>