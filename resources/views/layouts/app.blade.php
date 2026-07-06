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
        content="Sistem pengelolaan produk, kegiatan, dan pesanan UMKM Maloppo."
    >

    <title>Dashboard Admin | UMKM Maloppo</title>

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
        class="flex min-h-screen flex-col"
        style="background-color: #fffef5;"
    >

        {{-- Navigasi admin --}}
        @include('layouts.navigation')

        {{-- Judul halaman --}}
        @isset($header)
            <header
                class="relative overflow-hidden border-b"
                style="
                    background:
                        radial-gradient(
                            circle at top right,
                            rgba(247, 233, 0, 0.45),
                            transparent 35%
                        ),
                        linear-gradient(
                            135deg,
                            #ffffff 0%,
                            #fff9b0 100%
                        );
                    border-color: #f1e7a4;
                "
            >
                {{-- Dekorasi --}}
                <div
                    class="pointer-events-none absolute -right-16 -top-20 h-52 w-52 rounded-full opacity-30"
                    style="background-color: #f7e900;"
                ></div>

                <div
                    class="pointer-events-none absolute -bottom-24 -left-16 h-48 w-48 rounded-full opacity-5"
                    style="background-color: #be0000;"
                ></div>

                <div
                    class="relative mx-auto max-w-7xl px-4 py-7 sm:px-6 lg:px-8"
                >
                    <div
                        class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"
                    >
                        <div class="min-w-0">

                            <div
                                class="mb-3 inline-flex items-center gap-2 rounded-full px-3 py-1.5 text-xs font-bold uppercase tracking-wider"
                                style="
                                    background-color: #f7e900;
                                    color: #990100;
                                "
                            >
                                <span>⚙️</span>
                                Administrator Maloppo
                            </div>

                            <div
                                class="text-2xl font-extrabold text-gray-900 sm:text-3xl"
                            >
                                {{ $header }}
                            </div>

                        </div>

                        <div
                            class="hidden h-16 w-28 shrink-0 items-center justify-center overflow-hidden rounded-xl border bg-white p-1 shadow-sm sm:flex"
                            style="border-color: #f1e7a4;"
                        >
                            <img
                                src="{{ asset('images/brand/logo-maloppo-wordmark.jpg') }}"
                                alt="Logo UMKM Maloppo"
                                class="h-full w-full object-contain"
                            >
                        </div>

                    </div>
                </div>
            </header>
        @endisset

        {{-- Isi halaman --}}
        <main class="flex-1">

            <div class="relative">

                {{-- Dekorasi latar admin --}}
                <div
                    class="pointer-events-none fixed bottom-0 right-0 -z-0 h-64 w-64 rounded-full opacity-[0.03]"
                    style="background-color: #be0000;"
                ></div>

                <div class="relative z-10">
                    {{ $slot }}
                </div>

            </div>

        </main>

        {{-- Footer admin --}}
        <footer
            class="border-t bg-white"
            style="border-color: #f1e7a4;"
        >
            <div
                class="mx-auto flex max-w-7xl flex-col gap-3 px-4 py-5 text-center sm:flex-row sm:items-center sm:justify-between sm:px-6 sm:text-left lg:px-8"
            >
                <div class="flex items-center justify-center gap-3 sm:justify-start">

                    <div
                        class="flex h-10 w-16 items-center justify-center overflow-hidden rounded-lg"
                        style="background-color: #f7e900;"
                    >
                        <img
                            src="{{ asset('images/brand/logo-maloppo-wordmark.jpg') }}"
                            alt="Logo Maloppo"
                            class="h-full w-full object-contain"
                        >
                    </div>

                    <div>

                        <p class="text-xs font-bold text-gray-700">
                            UMKM Maloppo
                        </p>

                        <p class="mt-0.5 text-xs text-gray-400">
                            Sistem pengelolaan usaha
                        </p>

                    </div>

                </div>

                <p class="text-xs text-gray-500">
                    &copy; {{ date('Y') }} UMKM Maloppo. Hak cipta dilindungi.
                </p>
            </div>
        </footer>

    </div>

</body>
</html>