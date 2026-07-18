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

    <div class="flex min-h-screen flex-col bg-gray-50">

        {{-- Navigasi admin --}}
        @include('layouts.navigation')

        {{-- Judul halaman --}}
        @isset($header)

            <header class="border-b border-gray-200 bg-white">

                <div class="h-1 w-full bg-gradient-to-r from-red-700 via-red-600 to-yellow-400"></div>

                <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>

            </header>

        @endisset

        {{-- Isi halaman --}}
        <main class="flex-1">
            {{ $slot }}
        </main>

        {{-- Footer admin --}}
        <footer class="border-t border-gray-200 bg-white">

            <div class="mx-auto flex max-w-7xl flex-col gap-2 px-4 py-5 text-xs text-gray-500 sm:flex-row sm:items-center sm:justify-between sm:px-6 lg:px-8">

                <p>
                    &copy; {{ date('Y') }} UMKM Maloppo.
                </p>

                <p class="font-medium text-red-700">
                    Sistem pengelolaan produk, kegiatan, dan pesanan.
                </p>

            </div>

        </footer>

    </div>

</body>

</html>