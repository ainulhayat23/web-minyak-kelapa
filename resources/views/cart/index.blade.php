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
                    Pesanan Anda
                </span>

                <h1
                    class="mt-5 text-4xl font-extrabold leading-tight text-gray-900 md:text-5xl"
                >
                    Keranjang
                    <span class="text-maloppo-red">
                        Belanja
                    </span>
                </h1>

                <p class="mt-4 max-w-2xl text-lg leading-8 text-gray-600">
                    Periksa kembali produk dan jumlah pesanan sebelum
                    melanjutkan ke proses checkout.
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
                            1
                        </div>

                        <span class="mt-2 text-xs font-bold text-maloppo-red">
                            Keranjang
                        </span>

                    </div>

                    <div
                        class="mb-5 h-1 w-10 rounded-full sm:w-14"
                        style="background-color: #f7e900;"
                    ></div>

                    <div class="flex flex-col items-center">

                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-full text-sm font-bold"
                            style="
                                background-color: #fff9b0;
                                color: #990100;
                            "
                        >
                            2
                        </div>

                        <span class="mt-2 text-xs font-medium text-gray-500">
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

        {{-- Notifikasi kesalahan --}}
        @if (session('error'))
            <div class="alert-maloppo-error mb-7">
                {{ session('error') }}
            </div>
        @endif

        {{-- Kesalahan validasi --}}
        @if ($errors->any())
            <div class="alert-maloppo-error mb-7">

                <p class="font-semibold">
                    Terjadi kesalahan:
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

                    <div class="card-maloppo overflow-hidden">

                        {{-- Header daftar produk --}}
                        <div
                            class="border-b px-6 py-5"
                            style="
                                background-color: #fffdf0;
                                border-color: #f1e7a4;
                            "
                        >

                            <div
                                class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"
                            >

                                <div class="flex items-center gap-4">

                                    <div
                                        class="flex h-12 w-12 items-center justify-center rounded-xl text-xl"
                                        style="background-color: #f7e900;"
                                    >
                                        🛒
                                    </div>

                                    <div>

                                        <h2 class="text-lg font-extrabold text-gray-900">
                                            Produk dalam Keranjang
                                        </h2>

                                        <p class="mt-1 text-sm text-gray-500">
                                            Total {{ $totalQuantity }} barang dipilih
                                        </p>

                                    </div>

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
                                        class="inline-flex items-center gap-2 rounded-lg border px-4 py-2 text-sm font-semibold transition hover:bg-red-50"
                                        style="
                                            border-color: #fca5a5;
                                            color: #b91c1c;
                                        "
                                    >
                                        <span>🗑️</span>
                                        Kosongkan Keranjang
                                    </button>

                                </form>

                            </div>

                        </div>

                        {{-- Isi keranjang --}}
                        <div
                            class="divide-y"
                            style="--tw-divide-opacity: 1; border-color: #f1e7a4;"
                        >

                            @foreach ($cart as $item)

                                @php
                                    $subtotal = $item['price'] * $item['quantity'];
                                @endphp

                                <article class="p-6 transition hover:bg-yellow-50/30">

                                    <div class="flex flex-col gap-5 sm:flex-row">

                                        {{-- Gambar produk --}}
                                        <a
                                            href="{{ route('catalog.show', $item['slug']) }}"
                                            class="flex h-36 w-full shrink-0 items-center justify-center overflow-hidden rounded-2xl border sm:h-32 sm:w-32"
                                            style="
                                                background-color: #fffdf0;
                                                border-color: #f1e7a4;
                                            "
                                        >

                                            @if ($item['image'])

                                                <img
                                                    src="{{ asset('storage/' . $item['image']) }}"
                                                    alt="{{ $item['name'] }}"
                                                    class="h-full w-full object-cover transition duration-300 hover:scale-105"
                                                >

                                            @else

                                                <span class="text-5xl">
                                                    🥥
                                                </span>

                                            @endif

                                        </a>

                                        {{-- Informasi produk --}}
                                        <div class="flex-1">

                                            <div
                                                class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between"
                                            >

                                                <div>

                                                    <span
                                                        class="inline-flex rounded-full px-3 py-1 text-xs font-bold"
                                                        style="
                                                            background-color: #fff9b0;
                                                            color: #990100;
                                                        "
                                                    >
                                                        Produk Maloppo
                                                    </span>

                                                    <a
                                                        href="{{ route('catalog.show', $item['slug']) }}"
                                                        class="mt-3 block text-lg font-extrabold text-gray-900 transition hover:text-maloppo-red"
                                                    >
                                                        {{ $item['name'] }}
                                                    </a>

                                                    <div
                                                        class="mt-2 flex flex-wrap items-center gap-2 text-sm text-gray-500"
                                                    >

                                                        <span>
                                                            Ukuran:
                                                        </span>

                                                        <span class="badge-maloppo-yellow">
                                                            {{ $item['size'] ?? '-' }}
                                                        </span>

                                                    </div>

                                                    <p class="mt-3 text-lg font-extrabold text-maloppo-red">
                                                        Rp {{ number_format($item['price'], 0, ',', '.') }}
                                                    </p>

                                                </div>

                                                {{-- Hapus produk --}}
                                                <form
                                                    action="{{ route('cart.remove', $item['product_id']) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Hapus produk ini dari keranjang?')"
                                                >
                                                    @csrf
                                                    @method('DELETE')

                                                    <button
                                                        type="submit"
                                                        class="inline-flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-semibold transition hover:bg-red-50"
                                                        style="color: #b91c1c;"
                                                    >
                                                        <span>🗑️</span>
                                                        Hapus
                                                    </button>

                                                </form>

                                            </div>

                                            <div
                                                class="mt-5 flex flex-col gap-5 border-t pt-5 sm:flex-row sm:items-end sm:justify-between"
                                                style="border-color: #f1e7a4;"
                                            >

                                                {{-- Pengaturan jumlah --}}
                                                <form
                                                    action="{{ route('cart.update', $item['product_id']) }}"
                                                    method="POST"
                                                    class="flex flex-col gap-3 sm:flex-row sm:items-end"
                                                >
                                                    @csrf
                                                    @method('PATCH')

                                                    <div>

                                                        <label
                                                            for="quantity-{{ $item['product_id'] }}"
                                                            class="block text-xs font-bold uppercase tracking-wider text-gray-500"
                                                        >
                                                            Jumlah Produk
                                                        </label>

                                                        <div
                                                            class="mt-2 flex w-fit items-center overflow-hidden rounded-xl border bg-white"
                                                            style="border-color: #f1e7a4;"
                                                        >

                                                            <button
                                                                type="button"
                                                                class="quantity-minus flex h-11 w-11 items-center justify-center text-xl font-bold text-maloppo-red transition hover:bg-yellow-50"
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
                                                                class="h-11 w-16 border-x border-y-0 p-0 text-center font-bold text-gray-900 focus:ring-0"
                                                                style="border-color: #f1e7a4;"
                                                                required
                                                            >

                                                            <button
                                                                type="button"
                                                                class="quantity-plus flex h-11 w-11 items-center justify-center text-xl font-bold text-maloppo-red transition hover:bg-yellow-50"
                                                                data-target="quantity-{{ $item['product_id'] }}"
                                                                aria-label="Tambah jumlah"
                                                            >
                                                                +
                                                            </button>

                                                        </div>

                                                        <p class="mt-2 text-xs text-gray-400">
                                                            Maksimal stok: {{ $item['stock'] }}
                                                        </p>

                                                    </div>

                                                    <button
                                                        type="submit"
                                                        class="inline-flex h-11 items-center justify-center rounded-xl px-4 text-sm font-bold"
                                                        style="
                                                            background-color: #fff9b0;
                                                            color: #990100;
                                                        "
                                                    >
                                                        Perbarui
                                                    </button>

                                                </form>

                                                {{-- Subtotal produk --}}
                                                <div
                                                    class="rounded-xl px-5 py-3 text-left sm:text-right"
                                                    style="background-color: #fffdf0;"
                                                >

                                                    <p class="text-xs font-medium text-gray-500">
                                                        Subtotal
                                                    </p>

                                                    <p class="mt-1 text-xl font-extrabold text-gray-900">
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
                        class="btn-maloppo-secondary mt-6"
                    >
                        <span aria-hidden="true">
                            ←
                        </span>

                        Lanjut Memilih Produk
                    </a>

                </section>

                {{-- Ringkasan belanja --}}
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
                                        Ringkasan Belanja
                                    </h2>

                                    <p class="mt-1 text-xs text-gray-600">
                                        Rincian sementara pesanan Anda
                                    </p>

                                </div>

                            </div>

                        </div>

                        <div class="p-6">

                            <div class="space-y-4">

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

                                        <span class="text-2xl font-extrabold text-maloppo-red">
                                            Rp {{ number_format($totalPrice, 0, ',', '.') }}
                                        </span>

                                    </div>

                                </div>

                            </div>

                            {{-- Tombol checkout --}}
                            <a
                                href="{{ route('checkout.create') }}"
                                class="btn-maloppo-primary mt-7 w-full py-4 text-base"
                            >
                                <span class="text-xl">
                                    📝
                                </span>

                                Lanjutkan Pemesanan

                                <span aria-hidden="true">
                                    →
                                </span>
                            </a>

                            <p class="mt-4 text-center text-xs leading-5 text-gray-500">
                                Lengkapi data pelanggan, nomor WhatsApp,
                                alamat, dan catatan sebelum pesanan disimpan.
                            </p>

                            <div
                                class="mt-5 rounded-xl border p-4"
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
                                        Pesanan akan disimpan ke sistem admin.
                                        Setelah itu, Anda diarahkan ke WhatsApp
                                        UMKM Maloppo untuk melakukan konfirmasi.
                                    </p>

                                </div>

                            </div>

                            {{-- Keamanan informasi --}}
                            <div class="mt-5 grid grid-cols-2 gap-3">

                                <div
                                    class="rounded-xl px-3 py-3 text-center"
                                    style="background-color: #f3f4f6;"
                                >
                                    <div class="text-xl">
                                        🔒
                                    </div>

                                    <p class="mt-1 text-xs font-semibold text-gray-600">
                                        Data aman
                                    </p>
                                </div>

                                <div
                                    class="rounded-xl px-3 py-3 text-center"
                                    style="background-color: #f3f4f6;"
                                >
                                    <div class="text-xl">
                                        💬
                                    </div>

                                    <p class="mt-1 text-xs font-semibold text-gray-600">
                                        Konfirmasi WA
                                    </p>
                                </div>

                            </div>

                        </div>

                    </div>

                </aside>

            </div>

        @else

            {{-- Keranjang kosong --}}
            <section class="card-maloppo overflow-hidden">

                <div
                    class="relative px-6 py-20 text-center"
                    style="background-color: #fffdf0;"
                >

                    <div
                        class="absolute left-1/2 top-10 h-36 w-36 -translate-x-1/2 rounded-full opacity-50"
                        style="background-color: #fff9b0;"
                    ></div>

                    <div class="relative">

                        <div
                            class="mx-auto flex h-24 w-24 items-center justify-center rounded-full text-6xl shadow-sm"
                            style="background-color: #f7e900;"
                        >
                            🛒
                        </div>

                        <h2 class="mt-7 text-3xl font-extrabold text-gray-900">
                            Keranjang Masih Kosong
                        </h2>

                        <p class="mx-auto mt-4 max-w-md leading-7 text-gray-500">
                            Pilih produk minyak kelapa Maloppo yang ingin
                            dipesan, kemudian tambahkan produk tersebut ke
                            dalam keranjang.
                        </p>

                        <a
                            href="{{ route('catalog.index') }}"
                            class="btn-maloppo-primary mt-7 px-7"
                        >
                            <span>
                                🥥
                            </span>

                            Lihat Produk Maloppo
                        </a>

                    </div>

                </div>

            </section>

        @endif

    </main>

    {{-- Ajakan --}}
    <section class="section-maloppo-red">

        <div
            class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-7 px-6 py-12 text-center lg:flex-row lg:text-left"
        >

            <div>

                <span
                    class="inline-flex rounded-full px-4 py-2 text-xs font-bold uppercase tracking-wider"
                    style="
                        background-color: #f7e900;
                        color: #990100;
                    "
                >
                    UMKM Maloppo
                </span>

                <h2 class="mt-4 text-2xl font-extrabold text-white">
                    Belanja produk lokal berkualitas
                </h2>

                <p class="mt-2 max-w-2xl text-sm leading-7 text-red-100">
                    Produk minyak kelapa Maloppo diolah dari bahan baku
                    pilihan melalui proses yang bersih dan terjaga.
                </p>

            </div>

            <a
                href="{{ route('catalog.index') }}"
                class="btn-maloppo-yellow whitespace-nowrap px-7 py-3.5"
            >
                Lihat Produk Lain
            </a>

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
                        newValue = Math.min(
                            maximum,
                            oldValue + 1
                        );
                    }

                    if (button.classList.contains('quantity-minus')) {
                        newValue = Math.max(
                            minimum,
                            oldValue - 1
                        );
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