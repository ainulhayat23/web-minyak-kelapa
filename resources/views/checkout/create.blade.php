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
        content="Lengkapi data pemesanan produk minyak kelapa UMKM Maloppo."
    >

    <title>Checkout Pesanan | UMKM Maloppo</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-maloppo-page text-gray-900">

    {{-- Navigasi --}}
    <x-public-navbar />

    {{-- Header --}}
    <header class="border-b border-gray-200 bg-white">

        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">

            <div
                class="flex flex-col gap-6 md:flex-row md:items-end md:justify-between"
            >
                <div>

                    <p class="text-sm font-semibold uppercase tracking-wider text-red-700">
                        Data Pemesanan
                    </p>

                    <h1 class="mt-2 text-3xl font-semibold tracking-tight text-gray-900 sm:text-4xl">
                        Checkout Pesanan
                    </h1>

                    <p class="mt-3 max-w-2xl text-sm leading-6 text-gray-600 sm:text-base">
                        Lengkapi data pelanggan sebelum pesanan disimpan dan
                        dilanjutkan melalui WhatsApp UMKM Maloppo.
                    </p>

                </div>

                {{-- Tahapan --}}
                <div class="flex items-center gap-2 text-xs sm:text-sm">

                    <span class="font-medium text-green-700">
                        1. Keranjang
                    </span>

                    <span class="text-gray-300">
                        —
                    </span>

                    <span
                        class="rounded-full bg-red-700 px-3 py-1.5 font-medium text-white"
                    >
                        2. Checkout
                    </span>

                    <span class="text-gray-300">
                        —
                    </span>

                    <span class="font-medium text-gray-400">
                        3. Konfirmasi
                    </span>

                </div>
            </div>

        </div>

    </header>

    <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8 lg:py-12">

        {{-- Kesalahan validasi --}}
        @if ($errors->any())

            <div class="alert-maloppo-error mb-6">

                <p class="font-semibold">
                    Periksa kembali data yang Anda masukkan.
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

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

            {{-- Form pelanggan --}}
            <section class="lg:col-span-2">

                <div class="overflow-hidden rounded-xl border border-gray-200 bg-white">

                    {{-- Header form --}}
                    <div class="border-b border-gray-200 px-5 py-4 sm:px-6">

                        <h2 class="text-base font-semibold text-gray-900">
                            Informasi Pelanggan
                        </h2>

                        <p class="mt-1 text-sm text-gray-500">
                            Pastikan nama, nomor WhatsApp, dan alamat sudah benar.
                        </p>

                    </div>

                    <form
                        action="{{ route('checkout.store') }}"
                        method="POST"
                        class="p-5 sm:p-6"
                    >
                        @csrf

                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                            {{-- Nama --}}
                            <div>

                                <label
                                    for="customer_name"
                                    class="block text-sm font-medium text-gray-700"
                                >
                                    Nama Lengkap
                                    <span class="text-red-700">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="customer_name"
                                    id="customer_name"
                                    value="{{ old('customer_name') }}"
                                    class="input-maloppo mt-2"
                                    placeholder="Masukkan nama lengkap"
                                    autocomplete="name"
                                    required
                                >

                                @error('customer_name')

                                    <p class="mt-2 text-sm text-red-700">
                                        {{ $message }}
                                    </p>

                                @enderror

                            </div>

                            {{-- WhatsApp --}}
                            <div>

                                <label
                                    for="customer_phone"
                                    class="block text-sm font-medium text-gray-700"
                                >
                                    Nomor WhatsApp
                                    <span class="text-red-700">*</span>
                                </label>

                                <input
                                    type="tel"
                                    name="customer_phone"
                                    id="customer_phone"
                                    value="{{ old('customer_phone') }}"
                                    class="input-maloppo mt-2"
                                    placeholder="Contoh: 081234567890"
                                    autocomplete="tel"
                                    inputmode="tel"
                                    required
                                >

                                <p class="mt-1.5 text-xs leading-5 text-gray-500">
                                    Nomor digunakan untuk mengonfirmasi pesanan.
                                </p>

                                @error('customer_phone')

                                    <p class="mt-2 text-sm text-red-700">
                                        {{ $message }}
                                    </p>

                                @enderror

                            </div>

                        </div>

                        {{-- Alamat --}}
                        <div class="mt-5">

                            <label
                                for="customer_address"
                                class="block text-sm font-medium text-gray-700"
                            >
                                Alamat Lengkap
                                <span class="text-red-700">*</span>
                            </label>

                            <textarea
                                name="customer_address"
                                id="customer_address"
                                rows="5"
                                class="input-maloppo mt-2 resize-y"
                                placeholder="Masukkan alamat lengkap, desa, kecamatan, dan patokan lokasi"
                                autocomplete="street-address"
                                required
                            >{{ old('customer_address') }}</textarea>

                            <p class="mt-1.5 text-xs leading-5 text-gray-500">
                                Sertakan patokan lokasi untuk memudahkan konfirmasi pengiriman.
                            </p>

                            @error('customer_address')

                                <p class="mt-2 text-sm text-red-700">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>

                        {{-- Catatan --}}
                        <div class="mt-5">

                            <label
                                for="customer_notes"
                                class="block text-sm font-medium text-gray-700"
                            >
                                Catatan Pesanan
                                <span class="font-normal text-gray-400">
                                    (opsional)
                                </span>
                            </label>

                            <textarea
                                name="customer_notes"
                                id="customer_notes"
                                rows="4"
                                class="input-maloppo mt-2 resize-y"
                                placeholder="Contoh: Hubungi sebelum pengiriman"
                            >{{ old('customer_notes') }}</textarea>

                            @error('customer_notes')

                                <p class="mt-2 text-sm text-red-700">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>

                        {{-- Informasi penggunaan data --}}
                        <div class="mt-6 rounded-lg border border-gray-200 bg-gray-50 p-4">

                            <p class="text-sm font-medium text-gray-800">
                                Penggunaan informasi pelanggan
                            </p>

                            <p class="mt-1 text-xs leading-5 text-gray-500">
                                Data digunakan untuk pencatatan pesanan,
                                konfirmasi, dan proses pengiriman produk.
                            </p>

                        </div>

                        {{-- Tombol --}}
                        <div
                            class="mt-6 flex flex-col-reverse gap-3 border-t border-gray-200 pt-5 sm:flex-row sm:items-center sm:justify-between"
                        >

                            <a
                                href="{{ route('cart.index') }}"
                                class="btn-maloppo-secondary"
                            >
                                Kembali ke Keranjang
                            </a>

                            <button
                                type="submit"
                                class="btn-maloppo-primary"
                            >
                                Simpan dan Lanjut ke WhatsApp
                            </button>

                        </div>

                    </form>

                </div>

            </section>

            {{-- Ringkasan pesanan --}}
            <aside>

                <div
                    class="sticky top-24 overflow-hidden rounded-xl border border-gray-200 bg-white"
                >

                    {{-- Header ringkasan --}}
                    <div class="border-b border-gray-200 px-5 py-4">

                        <h2 class="text-base font-semibold text-gray-900">
                            Ringkasan Pesanan
                        </h2>

                        <p class="mt-1 text-xs text-gray-500">
                            Periksa produk sebelum menyimpan pesanan.
                        </p>

                    </div>

                    <div class="p-5">

                        {{-- Produk --}}
                        <div class="divide-y divide-gray-100">

                            @foreach ($cart as $item)

                                @php
                                    $subtotal =
                                        $item['price'] * $item['quantity'];
                                @endphp

                                <div class="flex gap-3 py-4 first:pt-0 last:pb-0">

                                    {{-- Gambar --}}
                                    <div
                                        class="flex h-16 w-16 shrink-0 items-center justify-center overflow-hidden rounded-lg border border-gray-200 bg-gray-50"
                                    >

                                        @if ($item['image'])

                                            <img
                                                src="{{ asset('storage/' . $item['image']) }}"
                                                alt="{{ $item['name'] }}"
                                                class="h-full w-full object-cover"
                                            >

                                        @else

                                            <span class="px-2 text-center text-[10px] text-gray-400">
                                                Tanpa foto
                                            </span>

                                        @endif

                                    </div>

                                    {{-- Informasi --}}
                                    <div class="min-w-0 flex-1">

                                        <p class="line-clamp-2 text-sm font-medium leading-5 text-gray-900">
                                            {{ $item['name'] }}
                                        </p>

                                        <p class="mt-1 text-xs text-gray-500">
                                            Ukuran {{ $item['size'] ?? '-' }}
                                        </p>

                                        <p class="mt-1 text-xs text-gray-500">
                                            {{ $item['quantity'] }} ×
                                            Rp {{ number_format($item['price'], 0, ',', '.') }}
                                        </p>

                                        <p class="mt-2 text-sm font-semibold text-gray-900">
                                            Rp {{ number_format($subtotal, 0, ',', '.') }}
                                        </p>

                                    </div>

                                </div>

                            @endforeach

                        </div>

                        {{-- Total --}}
                        <dl class="mt-5 space-y-4 border-t border-gray-200 pt-5">

                            <div class="flex items-center justify-between gap-4 text-sm">

                                <dt class="text-gray-500">
                                    Jumlah barang
                                </dt>

                                <dd class="font-medium text-gray-900">
                                    {{ $totalQuantity }}
                                </dd>

                            </div>

                            <div class="flex items-center justify-between gap-4 text-sm">

                                <dt class="text-gray-500">
                                    Subtotal produk
                                </dt>

                                <dd class="font-medium text-gray-900">
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

                        <div class="mt-5 border-t border-gray-200 pt-5">

                            <div class="flex items-end justify-between gap-4">

                                <div>

                                    <p class="text-sm font-medium text-gray-900">
                                        Total Produk
                                    </p>

                                    <p class="mt-1 text-xs text-gray-500">
                                        Belum termasuk pengiriman
                                    </p>

                                </div>

                                <p class="text-xl font-semibold text-red-700">
                                    Rp {{ number_format($totalPrice, 0, ',', '.') }}
                                </p>

                            </div>

                        </div>

                        {{-- Informasi proses --}}
                        <div class="mt-5 border-t border-gray-100 pt-4">

                            <p class="text-xs leading-5 text-gray-500">
                                Setelah formulir dikirim, pesanan akan dicatat
                                di sistem dan Anda diarahkan ke WhatsApp Maloppo
                                untuk melakukan konfirmasi.
                            </p>

                        </div>

                    </div>

                </div>

            </aside>

        </div>

        {{-- Penjelasan proses --}}
        <section
            class="mt-8 grid grid-cols-1 gap-6 border-y border-gray-200 py-8 sm:grid-cols-3"
        >

            <div>

                <p class="text-xs font-medium text-red-700">
                    Langkah 1
                </p>

                <h2 class="mt-1 text-sm font-semibold text-gray-900">
                    Lengkapi Data
                </h2>

                <p class="mt-1 text-xs leading-5 text-gray-500">
                    Isi nama, WhatsApp, alamat, dan catatan pesanan.
                </p>

            </div>

            <div>

                <p class="text-xs font-medium text-red-700">
                    Langkah 2
                </p>

                <h2 class="mt-1 text-sm font-semibold text-gray-900">
                    Pesanan Disimpan
                </h2>

                <p class="mt-1 text-xs leading-5 text-gray-500">
                    Sistem mencatat pesanan agar dapat diproses admin.
                </p>

            </div>

            <div>

                <p class="text-xs font-medium text-red-700">
                    Langkah 3
                </p>

                <h2 class="mt-1 text-sm font-semibold text-gray-900">
                    Konfirmasi WhatsApp
                </h2>

                <p class="mt-1 text-xs leading-5 text-gray-500">
                    Konfirmasikan rincian pesanan dan proses pengiriman.
                </p>

            </div>

        </section>

    </main>

    {{-- Footer --}}
    <footer class="border-t border-gray-200 bg-white">

        <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 gap-8 md:grid-cols-2 md:items-center">

                <div>

                    <div
                        class="flex h-14 w-32 items-center justify-center overflow-hidden rounded-lg border border-gray-200 bg-gray-50"
                    >
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

            <div
                class="mt-8 flex flex-col gap-2 border-t border-gray-200 pt-5 text-xs text-gray-500 sm:flex-row sm:items-center sm:justify-between"
            >
                <p>
                    &copy; {{ date('Y') }} UMKM Maloppo.
                </p>

                <a
                    href="{{ route('cart.index') }}"
                    class="font-medium text-gray-600 hover:text-red-700"
                >
                    Kembali ke Keranjang
                </a>
            </div>

        </div>

    </footer>

</body>

</html>