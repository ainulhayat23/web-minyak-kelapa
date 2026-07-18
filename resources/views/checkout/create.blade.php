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
                        Data Pemesanan
                    </p>

                    <h1 class="mt-4 text-4xl font-bold leading-tight tracking-tight sm:text-5xl">
                        Checkout Pesanan
                    </h1>

                    <p class="mt-5 max-w-2xl text-base leading-8 text-red-50">
                        Lengkapi data pelanggan agar pesanan produk minyak
                        kelapa Maloppo dapat dicatat dan dikonfirmasi melalui WhatsApp.
                    </p>

                </div>

                {{-- Tahapan --}}
                <div class="rounded-3xl bg-white/95 p-6 shadow-xl">

                    <p class="text-sm font-semibold text-gray-900">
                        Tahapan Pemesanan
                    </p>

                    <div class="mt-5 grid grid-cols-1 gap-3 sm:grid-cols-3">

                        <div class="rounded-2xl bg-green-50 p-4">
                            <p class="text-xs font-semibold uppercase tracking-wider text-green-700">
                                Langkah 1
                            </p>

                            <p class="mt-2 text-sm font-bold text-gray-900">
                                Keranjang
                            </p>
                        </div>

                        <div class="rounded-2xl bg-red-700 p-4 text-white">
                            <p class="text-xs font-semibold uppercase tracking-wider text-red-100">
                                Langkah 2
                            </p>

                            <p class="mt-2 text-sm font-bold">
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

        {{-- Kesalahan validasi --}}
        @if ($errors->any())

            <div class="mb-8 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700">

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

        <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">

            {{-- Form pelanggan --}}
            <section class="lg:col-span-2">

                <div class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">

                    {{-- Header form --}}
                    <div class="border-b border-gray-200 bg-yellow-50 px-6 py-5">

                        <p class="text-sm font-semibold uppercase tracking-[0.20em] text-red-700">
                            Informasi Pelanggan
                        </p>

                        <h2 class="mt-2 text-2xl font-bold text-gray-900">
                            Lengkapi Data Pesanan
                        </h2>

                        <p class="mt-1 text-sm text-gray-600">
                            Pastikan nama, nomor WhatsApp, dan alamat sudah benar.
                        </p>

                    </div>

                    <form
                        action="{{ route('checkout.store') }}"
                        method="POST"
                        class="p-6"
                    >
                        @csrf

                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                            {{-- Nama --}}
                            <div>

                                <label
                                    for="customer_name"
                                    class="block text-sm font-semibold text-gray-700"
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
                                    class="block text-sm font-semibold text-gray-700"
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
                                class="block text-sm font-semibold text-gray-700"
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
                                class="block text-sm font-semibold text-gray-700"
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
                        <div class="mt-6 rounded-2xl border border-yellow-200 bg-yellow-50 p-5">

                            <p class="text-sm font-bold text-gray-900">
                                Penggunaan informasi pelanggan
                            </p>

                            <p class="mt-1 text-sm leading-6 text-gray-600">
                                Data digunakan untuk pencatatan pesanan,
                                konfirmasi melalui WhatsApp, dan proses pengiriman produk.
                            </p>

                        </div>

                        {{-- Tombol --}}
                        <div class="mt-6 flex flex-col-reverse gap-3 border-t border-gray-200 pt-6 sm:flex-row sm:items-center sm:justify-between">

                            <a
                                href="{{ route('cart.index') }}"
                                class="inline-flex items-center justify-center rounded-lg border border-red-200 px-5 py-3 text-sm font-semibold text-red-700 transition hover:bg-red-50"
                            >
                                Kembali ke Keranjang
                            </a>

                            <button
                                type="submit"
                                class="inline-flex items-center justify-center rounded-lg bg-red-700 px-5 py-3 text-sm font-semibold text-white transition hover:bg-red-800"
                            >
                                Simpan dan Lanjut ke WhatsApp
                            </button>

                        </div>

                    </form>

                </div>

            </section>

            {{-- Ringkasan pesanan --}}
            <aside>

                <div class="sticky top-24 overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">

                    {{-- Header ringkasan --}}
                    <div class="border-b border-gray-200 bg-yellow-50 px-6 py-5">

                        <p class="text-sm font-semibold uppercase tracking-[0.20em] text-red-700">
                            Ringkasan
                        </p>

                        <h2 class="mt-2 text-2xl font-bold text-gray-900">
                            Ringkasan Pesanan
                        </h2>

                        <p class="mt-1 text-sm text-gray-600">
                            Periksa produk sebelum menyimpan pesanan.
                        </p>

                    </div>

                    <div class="p-6">

                        {{-- Produk --}}
                        <div class="divide-y divide-gray-100">

                            @foreach ($cart as $item)

                                @php
                                    $subtotal = $item['price'] * $item['quantity'];
                                @endphp

                                <div class="flex gap-4 py-4 first:pt-0 last:pb-0">

                                    {{-- Gambar --}}
                                    <div class="flex h-20 w-20 shrink-0 items-center justify-center overflow-hidden rounded-2xl border border-yellow-200 bg-yellow-50 p-2">

                                        @if ($item['image'])

                                            <img
                                                src="{{ asset('storage/' . $item['image']) }}"
                                                alt="{{ $item['name'] }}"
                                                class="h-full w-full object-contain"
                                            >

                                        @else

                                            <span class="px-2 text-center text-[10px] text-gray-400">
                                                Tanpa foto
                                            </span>

                                        @endif

                                    </div>

                                    {{-- Informasi --}}
                                    <div class="min-w-0 flex-1">

                                        <p class="line-clamp-2 text-sm font-bold leading-5 text-gray-900">
                                            {{ $item['name'] }}
                                        </p>

                                        <div class="mt-2 flex flex-wrap gap-2">

                                            <span class="rounded-full bg-yellow-100 px-2.5 py-1 text-[11px] font-semibold text-red-700">
                                                {{ $item['size'] ?? '-' }}
                                            </span>

                                            <span class="rounded-full bg-gray-100 px-2.5 py-1 text-[11px] font-semibold text-gray-600">
                                                {{ $item['quantity'] }} barang
                                            </span>

                                        </div>

                                        <p class="mt-2 text-xs text-gray-500">
                                            {{ $item['quantity'] }} ×
                                            Rp {{ number_format($item['price'], 0, ',', '.') }}
                                        </p>

                                        <p class="mt-1 text-sm font-bold text-red-700">
                                            Rp {{ number_format($subtotal, 0, ',', '.') }}
                                        </p>

                                    </div>

                                </div>

                            @endforeach

                        </div>

                        {{-- Total --}}
                        <dl class="mt-6 space-y-4 border-t border-gray-200 pt-5">

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

                        {{-- Informasi proses --}}
                        <div class="mt-5 border-t border-gray-100 pt-5">

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
        <section class="mt-12 rounded-3xl bg-yellow-50 px-6 py-10">

            <div class="mx-auto max-w-3xl text-center">

                <p class="text-sm font-semibold uppercase tracking-[0.25em] text-red-700">
                    Proses Pesanan
                </p>

                <h2 class="mt-4 text-3xl font-bold tracking-tight text-gray-900">
                    Setelah checkout, pesanan dikonfirmasi melalui WhatsApp.
                </h2>

            </div>

            <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-3">

                <div class="rounded-2xl border border-yellow-200 bg-white p-6 shadow-sm">

                    <p class="text-xs font-semibold uppercase tracking-wider text-red-700">
                        Langkah 1
                    </p>

                    <h3 class="mt-2 text-base font-bold text-gray-900">
                        Lengkapi Data
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-gray-600">
                        Isi nama, WhatsApp, alamat, dan catatan pesanan.
                    </p>

                </div>

                <div class="rounded-2xl border border-yellow-200 bg-white p-6 shadow-sm">

                    <p class="text-xs font-semibold uppercase tracking-wider text-red-700">
                        Langkah 2
                    </p>

                    <h3 class="mt-2 text-base font-bold text-gray-900">
                        Pesanan Disimpan
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-gray-600">
                        Sistem mencatat pesanan agar dapat diproses admin.
                    </p>

                </div>

                <div class="rounded-2xl border border-yellow-200 bg-white p-6 shadow-sm">

                    <p class="text-xs font-semibold uppercase tracking-wider text-red-700">
                        Langkah 3
                    </p>

                    <h3 class="mt-2 text-base font-bold text-gray-900">
                        Konfirmasi WhatsApp
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-gray-600">
                        Pelanggan diarahkan ke WhatsApp untuk konfirmasi pesanan.
                    </p>

                </div>

            </div>

        </section>

    </main>

    {{-- Footer --}}
    {{-- <footer class="border-t border-gray-200 bg-white">

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
                    href="{{ route('cart.index') }}"
                    class="font-medium text-gray-600 hover:text-red-700"
                >
                    Kembali ke Keranjang
                </a>
            </div>

        </div>

    </footer> --}}
    <x-public-footer />

</body>

</html>