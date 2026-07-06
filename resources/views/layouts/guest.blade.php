<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <meta
        name="description"
        content="Halaman administrator UMKM Maloppo."
    >

    <title>Administrator | UMKM Maloppo</title>

    {{-- Font --}}
    <link
        rel="preconnect"
        href="https://fonts.bunny.net"
    >

    <link
        href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap"
        rel="stylesheet"
    >

    {{-- CSS dan JavaScript --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">

    <div
        class="relative flex min-h-screen flex-col overflow-hidden"
        style="
            background:
                radial-gradient(
                    circle at top right,
                    rgba(247, 233, 0, 0.42),
                    transparent 30%
                ),
                radial-gradient(
                    circle at bottom left,
                    rgba(190, 0, 0, 0.12),
                    transparent 32%
                ),
                linear-gradient(
                    135deg,
                    #fffef5 0%,
                    #fff9b0 100%
                );
        "
    >

        {{-- Garis identitas Maloppo --}}
        <div class="maloppo-brand-line"></div>

        {{-- Dekorasi latar --}}
        <div
            class="pointer-events-none absolute -right-24 top-20 h-72 w-72 rounded-full opacity-40"
            style="background-color: #f7e900;"
        ></div>

        <div
            class="pointer-events-none absolute -bottom-32 -left-24 h-96 w-96 rounded-full opacity-10"
            style="background-color: #be0000;"
        ></div>

        <div
            class="pointer-events-none absolute left-10 top-1/3 hidden h-20 w-20 rotate-12 rounded-3xl opacity-10 lg:block"
            style="background-color: #be0000;"
        ></div>

        {{-- Konten utama --}}
        <main
            class="relative z-10 flex flex-1 items-center justify-center px-4 py-10 sm:px-6 lg:px-8"
        >

            <div class="w-full max-w-lg">

                {{-- Keterangan atas --}}
                <div class="mb-5 text-center">

                    <a
                        href="{{ route('home') }}"
                        class="inline-flex items-center gap-2 text-sm font-bold text-maloppo-red"
                    >
                        <span aria-hidden="true">
                            ←
                        </span>

                        Kembali ke Website
                    </a>

                </div>

                {{-- Kartu autentikasi --}}
                <div
                    class="overflow-hidden rounded-3xl border bg-white shadow-2xl"
                    style="
                        border-color: #f1e7a4;
                        box-shadow:
                            0 20px 50px rgba(153, 1, 0, 0.12),
                            0 8px 20px rgba(0, 0, 0, 0.06);
                    "
                >

                    {{-- Aksen atas kartu --}}
                    <div
                        class="h-2 w-full"
                        style="
                            background: linear-gradient(
                                90deg,
                                #be0000 0%,
                                #be0000 65%,
                                #f7e900 65%,
                                #f7e900 100%
                            );
                        "
                    ></div>

                    <div class="px-6 py-8 sm:px-9 sm:py-10">
                        {{ $slot }}
                    </div>

                </div>

                {{-- Informasi bawah --}}
                <div class="mt-6 text-center">

                    <p class="text-xs font-medium text-gray-600">
                        &copy; {{ date('Y') }} UMKM Maloppo
                    </p>

                    <p class="mt-1 text-xs text-gray-500">
                        Sistem pengelolaan produk dan pesanan
                    </p>

                </div>

            </div>

        </main>

    </div>

</body>
</html>