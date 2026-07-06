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

    {{-- Navigasi pelanggan --}}
    <x-public-navbar />

    {{-- Header halaman --}}
    <section class="hero-maloppo relative overflow-hidden">

        <div
            class="absolute -right-24 -top-24 h-64 w-64 rounded-full opacity-40"
            style="background-color: #f7e900;"
        ></div>

        <div
            class="absolute -bottom-28 -left-24 h-72 w-72 rounded-full opacity-10"
            style="background-color: #be0000;"
        ></div>

        <div
            class="relative mx-auto grid max-w-7xl grid-cols-1 items-center gap-10 px-6 py-14 lg:grid-cols-[1fr_auto] lg:py-16"
        >

            <div>

                <span class="label-maloppo">
                    Data Pemesanan
                </span>

                <h1
                    class="mt-5 text-4xl font-extrabold leading-tight text-gray-900 md:text-5xl"
                >
                    Checkout
                    <span class="text-maloppo-red">
                        Pesanan
                    </span>
                </h1>

                <p class="mt-4 max-w-2xl text-lg leading-8 text-gray-600">
                    Lengkapi informasi pelanggan sebelum pesanan disimpan
                    dan dilanjutkan melalui WhatsApp UMKM Maloppo.
                </p>

            </div>

            {{-- Tahapan pemesanan --}}
            <div
                class="rounded-2xl border bg-white p-5 shadow-md"
                style="border-color: #f1e7a4;"
            >

                <p class="mb-4 text-xs font-bold uppercase tracking-wider text-gray-500">
                    Tahapan Pemesanan
                </p>

                <div class="flex items-center gap-2">

                    <div class="flex flex-col items-center">

                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-full text-sm font-bold text-white"
                            style="background-color: #be0000;"
                        >
                            ✓
                        </div>

                        <span class="mt-2 text-xs font-medium text-gray-500">
                            Keranjang
                        </span>

                    </div>

                    <div
                        class="mb-5 h-1 w-10 rounded-full sm:w-14"
                        style="background-color: #f7e900;"
                    ></div>

                    <div class="flex flex-col items-center">

                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-full text-sm font-bold text-white"
                            style="background-color: #be0000;"
                        >
                            2
                        </div>

                        <span class="mt-2 text-xs font-bold text-maloppo-red">
                            Checkout
                        </span>

                    </div>

                    <div
                        class="mb-5 h-1 w-10 rounded-full bg-gray-200 sm:w-14"
                    ></div>

                    <div class="flex flex-col items-center">

                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-200 text-sm font-bold text-gray-500"
                        >
                            3
                        </div>

                        <span class="mt-2 text-xs font-medium text-gray-500">
                            Konfirmasi
                        </span>

                    </div>

                </div>

            </div>

        </div>

    </section>

    <main class="mx-auto max-w-7xl px-6 py-12 lg:py-16">

        {{-- Kesalahan validasi --}}
        @if ($errors->any())
            <div class="alert-maloppo-error mb-7">

                <div class="flex items-start gap-3">

                    <div
                        class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full font-bold"
                        style="
                            background-color: #fecaca;
                            color: #991b1b;
                        "
                    >
                        !
                    </div>

                    <div>

                        <p class="font-bold">
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

                </div>

            </div>
        @endif

        <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">

            {{-- Form data pelanggan --}}
            <section class="lg:col-span-2">

                <div class="card-maloppo overflow-hidden">

                    {{-- Header form --}}
                    <div
                        class="border-b px-6 py-5 md:px-8"
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
                                👤
                            </div>

                            <div>

                                <h2 class="text-xl font-extrabold text-gray-900">
                                    Informasi Pelanggan
                                </h2>

                                <p class="mt-1 text-sm text-gray-500">
                                    Pastikan nama, WhatsApp, dan alamat sudah benar.
                                </p>

                            </div>

                        </div>

                    </div>

                    <form
                        action="{{ route('checkout.store') }}"
                        method="POST"
                        class="p-6 md:p-8"
                    >
                        @csrf

                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                            {{-- Nama pelanggan --}}
                            <div>

                                <label
                                    for="customer_name"
                                    class="block text-sm font-bold text-gray-700"
                                >
                                    Nama Lengkap
                                    <span style="color: #be0000;">*</span>
                                </label>

                                <div class="relative mt-2">

                                    <div
                                        class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400"
                                    >
                                        👤
                                    </div>

                                    <input
                                        type="text"
                                        name="customer_name"
                                        id="customer_name"
                                        value="{{ old('customer_name') }}"
                                        class="input-maloppo pl-11"
                                        placeholder="Masukkan nama lengkap"
                                        autocomplete="name"
                                        required
                                    >

                                </div>

                                @error('customer_name')
                                    <p class="mt-2 text-sm font-medium text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                            {{-- Nomor WhatsApp --}}
                            <div>

                                <label
                                    for="customer_phone"
                                    class="block text-sm font-bold text-gray-700"
                                >
                                    Nomor WhatsApp
                                    <span style="color: #be0000;">*</span>
                                </label>

                                <div class="relative mt-2">

                                    <div
                                        class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400"
                                    >
                                        📱
                                    </div>

                                    <input
                                        type="tel"
                                        name="customer_phone"
                                        id="customer_phone"
                                        value="{{ old('customer_phone') }}"
                                        class="input-maloppo pl-11"
                                        placeholder="Contoh: 081234567890"
                                        autocomplete="tel"
                                        inputmode="tel"
                                        required
                                    >

                                </div>

                                <p class="mt-2 text-xs leading-5 text-gray-500">
                                    Admin menggunakan nomor ini untuk
                                    menghubungi dan mengonfirmasi pesanan.
                                </p>

                                @error('customer_phone')
                                    <p class="mt-2 text-sm font-medium text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                        </div>

                        {{-- Alamat --}}
                        <div class="mt-6">

                            <label
                                for="customer_address"
                                class="block text-sm font-bold text-gray-700"
                            >
                                Alamat Lengkap
                                <span style="color: #be0000;">*</span>
                            </label>

                            <div class="relative mt-2">

                                <div
                                    class="pointer-events-none absolute left-0 top-0 flex items-center pl-4 pt-4 text-gray-400"
                                >
                                    📍
                                </div>

                                <textarea
                                    name="customer_address"
                                    id="customer_address"
                                    rows="5"
                                    class="input-maloppo resize-y pl-11"
                                    placeholder="Masukkan alamat lengkap, nama jalan, desa, kecamatan, dan patokan lokasi"
                                    autocomplete="street-address"
                                    required
                                >{{ old('customer_address') }}</textarea>

                            </div>

                            <p class="mt-2 text-xs leading-5 text-gray-500">
                                Cantumkan alamat dan patokan lokasi agar
                                proses pengiriman lebih mudah dikonfirmasi.
                            </p>

                            @error('customer_address')
                                <p class="mt-2 text-sm font-medium text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                        {{-- Catatan --}}
                        <div class="mt-6">

                            <label
                                for="customer_notes"
                                class="block text-sm font-bold text-gray-700"
                            >
                                Catatan Pesanan
                                <span class="font-normal text-gray-400">
                                    (opsional)
                                </span>
                            </label>

                            <div class="relative mt-2">

                                <div
                                    class="pointer-events-none absolute left-0 top-0 flex items-center pl-4 pt-4 text-gray-400"
                                >
                                    📝
                                </div>

                                <textarea
                                    name="customer_notes"
                                    id="customer_notes"
                                    rows="4"
                                    class="input-maloppo resize-y pl-11"
                                    placeholder="Contoh: Hubungi sebelum pengiriman"
                                >{{ old('customer_notes') }}</textarea>

                            </div>

                            <p class="mt-2 text-xs text-gray-500">
                                Bagian ini boleh dikosongkan.
                            </p>

                            @error('customer_notes')
                                <p class="mt-2 text-sm font-medium text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                        {{-- Informasi privasi --}}
                        <div
                            class="mt-7 rounded-xl border p-4"
                            style="
                                background-color: #fff9b0;
                                border-color: #f7e900;
                            "
                        >

                            <div class="flex items-start gap-3">

                                <div
                                    class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full"
                                    style="
                                        background-color: #be0000;
                                        color: white;
                                    "
                                >
                                    🔒
                                </div>

                                <div>

                                    <p class="text-sm font-bold text-maloppo-red-dark">
                                        Informasi pelanggan
                                    </p>

                                    <p class="mt-1 text-xs leading-6 text-gray-600">
                                        Data yang Anda masukkan digunakan
                                        untuk pencatatan pesanan, konfirmasi,
                                        dan proses pengiriman produk.
                                    </p>

                                </div>

                            </div>

                        </div>

                        {{-- Tombol --}}
                        <div
                            class="mt-8 flex flex-col-reverse gap-3 border-t pt-7 sm:flex-row sm:items-center sm:justify-between"
                            style="border-color: #f1e7a4;"
                        >

                            <a
                                href="{{ route('cart.index') }}"
                                class="btn-maloppo-secondary"
                            >
                                <span aria-hidden="true">
                                    ←
                                </span>

                                Kembali ke Keranjang
                            </a>

                            <button
                                type="submit"
                                class="btn-maloppo-primary px-7 py-4 text-base"
                            >
                                <span>
                                    💬
                                </span>

                                Simpan dan Lanjut ke WhatsApp

                                <span aria-hidden="true">
                                    →
                                </span>
                            </button>

                        </div>

                    </form>

                </div>

            </section>

            {{-- Ringkasan pesanan --}}
            <aside>

                <div class="card-maloppo sticky top-28 overflow-hidden">

                    {{-- Header ringkasan --}}
                    <div
                        class="border-b px-6 py-5"
                        style="
                            background-color: #fff9b0;
                            border-color: #f1e7a4;
                        "
                    >

                        <div class="flex items-center gap-3">

                            <div
                                class="flex h-11 w-11 items-center justify-center rounded-xl text-xl"
                                style="
                                    background-color: #be0000;
                                    color: white;
                                "
                            >
                                🧾
                            </div>

                            <div>

                                <h2 class="text-xl font-extrabold text-gray-900">
                                    Ringkasan Pesanan
                                </h2>

                                <p class="mt-1 text-xs text-gray-600">
                                    Periksa kembali produk Anda
                                </p>

                            </div>

                        </div>

                    </div>

                    <div class="p-6">

                        {{-- Daftar produk --}}
                        <div class="space-y-5">

                            @foreach ($cart as $item)

                                @php
                                    $subtotal =
                                        $item['price'] * $item['quantity'];
                                @endphp

                                <div
                                    class="flex gap-4 border-b pb-5 last:border-b-0 last:pb-0"
                                    style="border-color: #f1e7a4;"
                                >

                                    {{-- Gambar --}}
                                    <div
                                        class="flex h-20 w-20 shrink-0 items-center justify-center overflow-hidden rounded-xl border"
                                        style="
                                            background-color: #fffdf0;
                                            border-color: #f1e7a4;
                                        "
                                    >

                                        @if ($item['image'])

                                            <img
                                                src="{{ asset('storage/' . $item['image']) }}"
                                                alt="{{ $item['name'] }}"
                                                class="h-full w-full object-cover"
                                            >

                                        @else

                                            <span class="text-3xl">
                                                🥥
                                            </span>

                                        @endif

                                    </div>

                                    {{-- Informasi --}}
                                    <div class="min-w-0 flex-1">

                                        <p class="font-bold leading-6 text-gray-900">
                                            {{ $item['name'] }}
                                        </p>

                                        <span class="badge-maloppo-yellow mt-2">
                                            {{ $item['size'] ?? '-' }}
                                        </span>

                                        <p class="mt-2 text-xs text-gray-500">
                                            {{ $item['quantity'] }} ×
                                            Rp {{ number_format($item['price'], 0, ',', '.') }}
                                        </p>

                                        <p class="mt-2 text-sm font-extrabold text-maloppo-red">
                                            Rp {{ number_format($subtotal, 0, ',', '.') }}
                                        </p>

                                    </div>

                                </div>

                            @endforeach

                        </div>

                        {{-- Total --}}
                        <div
                            class="mt-6 space-y-4 border-t pt-5"
                            style="border-color: #f1e7a4;"
                        >

                            <div class="flex items-center justify-between text-sm">

                                <span class="text-gray-600">
                                    Jumlah barang
                                </span>

                                <span
                                    class="rounded-full px-3 py-1 font-bold"
                                    style="
                                        background-color: #fff9b0;
                                        color: #990100;
                                    "
                                >
                                    {{ $totalQuantity }}
                                </span>

                            </div>

                            <div class="flex items-center justify-between gap-4 text-sm">

                                <span class="text-gray-600">
                                    Subtotal produk
                                </span>

                                <span class="font-bold text-gray-900">
                                    Rp {{ number_format($totalPrice, 0, ',', '.') }}
                                </span>

                            </div>

                            <div class="flex items-center justify-between gap-4 text-sm">

                                <span class="text-gray-600">
                                    Biaya pengiriman
                                </span>

                                <span class="text-right text-xs font-medium text-gray-500">
                                    Dikonfirmasi melalui WhatsApp
                                </span>

                            </div>

                            <div
                                class="border-t pt-5"
                                style="border-color: #f1e7a4;"
                            >

                                <div class="flex items-end justify-between gap-4">

                                    <div>

                                        <span class="font-bold text-gray-900">
                                            Total Produk
                                        </span>

                                        <p class="mt-1 text-xs text-gray-500">
                                            Belum termasuk pengiriman
                                        </p>

                                    </div>

                                    <span class="text-right text-2xl font-extrabold text-maloppo-red">
                                        Rp {{ number_format($totalPrice, 0, ',', '.') }}
                                    </span>

                                </div>

                            </div>

                        </div>

                        {{-- Informasi proses --}}
                        <div
                            class="mt-6 rounded-xl border p-4"
                            style="
                                background-color: #fffdf0;
                                border-color: #f1e7a4;
                            "
                        >

                            <div class="flex items-start gap-3">

                                <span class="text-lg">
                                    ℹ️
                                </span>

                                <p class="text-xs leading-6 text-gray-600">
                                    Pesanan akan disimpan pada sistem admin.
                                    Setelah itu, Anda diarahkan ke WhatsApp
                                    UMKM Maloppo untuk melakukan konfirmasi.
                                </p>

                            </div>

                        </div>

                        {{-- Logo --}}
                        <div
                            class="mt-5 flex items-center gap-3 rounded-xl p-3"
                            style="background-color: #f7e900;"
                        >

                            <div
                                class="flex h-12 w-20 shrink-0 items-center justify-center overflow-hidden rounded-lg"
                            >

                                <img
                                    src="{{ asset('images/brand/logo-maloppo-wordmark.jpg') }}"
                                    alt="Logo UMKM Maloppo"
                                    class="h-full w-full object-contain"
                                >

                            </div>

                            <div>

                                <p class="text-xs font-bold text-maloppo-red-dark">
                                    UMKM Maloppo
                                </p>

                                <p class="mt-1 text-xs text-gray-700">
                                    Produk lokal dari kelapa pilihan
                                </p>

                            </div>

                        </div>

                    </div>

                </div>

            </aside>

        </div>

    </main>

    {{-- Informasi pemesanan --}}
    <section class="section-maloppo-red">

        <div
            class="mx-auto grid max-w-7xl grid-cols-1 gap-6 px-6 py-12 md:grid-cols-3"
        >

            <div class="flex items-start gap-4">

                <div
                    class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl text-xl"
                    style="
                        background-color: #f7e900;
                        color: #990100;
                    "
                >
                    1
                </div>

                <div>

                    <h2 class="font-bold text-white">
                        Lengkapi Data
                    </h2>

                    <p class="mt-1 text-sm leading-6 text-red-100">
                        Isi nama, WhatsApp, alamat, dan catatan pesanan.
                    </p>

                </div>

            </div>

            <div class="flex items-start gap-4">

                <div
                    class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl text-xl"
                    style="
                        background-color: #f7e900;
                        color: #990100;
                    "
                >
                    2
                </div>

                <div>

                    <h2 class="font-bold text-white">
                        Pesanan Disimpan
                    </h2>

                    <p class="mt-1 text-sm leading-6 text-red-100">
                        Sistem mencatat pesanan agar dapat diproses admin.
                    </p>

                </div>

            </div>

            <div class="flex items-start gap-4">

                <div
                    class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl text-xl"
                    style="
                        background-color: #f7e900;
                        color: #990100;
                    "
                >
                    3
                </div>

                <div>

                    <h2 class="font-bold text-white">
                        Konfirmasi WhatsApp
                    </h2>

                    <p class="mt-1 text-sm leading-6 text-red-100">
                        Konfirmasikan pesanan dan pengiriman melalui WhatsApp.
                    </p>

                </div>

            </div>

        </div>

    </section>

    {{-- Footer --}}
    <footer
        class="border-t bg-white"
        style="border-color: #f1e7a4;"
    >

        <div class="maloppo-brand-line"></div>

        <div class="mx-auto max-w-7xl px-6 py-10">

            <div
                class="flex flex-col items-center justify-between gap-8 lg:flex-row"
            >

                {{-- Identitas footer --}}
                <div class="text-center lg:text-left">

                    <div
                        class="mx-auto flex h-20 w-36 items-center justify-center overflow-hidden rounded-xl lg:mx-0"
                        style="background-color: #f7e900;"
                    >

                        <img
                            src="{{ asset('images/brand/logo-maloppo-wordmark.jpg') }}"
                            alt="Logo UMKM Maloppo"
                            class="h-full w-full object-contain"
                        >

                    </div>

                    <p class="mt-4 text-sm font-bold text-gray-800">
                        UMKM Maloppo
                    </p>

                    <p class="mt-1 text-xs text-gray-500">
                        Produk minyak kelapa murni dari kelapa pilihan
                    </p>

                </div>

                {{-- Media sosial --}}
                <div class="text-center">

                    <p class="text-sm font-bold text-gray-700">
                        Ikuti dan hubungi UMKM Maloppo
                    </p>

                    <p class="mt-1 text-xs text-gray-500">
                        Dapatkan informasi produk dan kegiatan terbaru kami.
                    </p>

                    <div class="mt-5">
                        <x-social-media />
                    </div>

                </div>

            </div>

            <div
                class="mt-8 flex flex-col gap-2 border-t pt-6 text-center text-xs text-gray-500 sm:flex-row sm:items-center sm:justify-between sm:text-left"
                style="border-color: #f1e7a4;"
            >

                <p>
                    &copy; {{ date('Y') }} UMKM Maloppo. Hak cipta dilindungi.
                </p>

                <p>
                    Produk lokal dari kelapa pilihan
                </p>

            </div>

        </div>

    </footer>

</body>
</html>