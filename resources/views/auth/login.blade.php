<x-guest-layout>

    <div
        x-data="{ showPassword: false }"
        class="w-full"
    >

        {{-- Identitas UMKM Maloppo --}}
        <div class="mb-7 text-center">

            <a
                href="{{ route('home') }}"
                class="inline-flex items-center justify-center"
            >
                <div
                    class="flex h-24 w-44 items-center justify-center overflow-hidden rounded-2xl border-2 p-2 shadow-sm"
                    style="
                        background-color: #f7e900;
                        border-color: #be0000;
                    "
                >
                    <img
                        src="{{ asset('images/brand/logo-maloppo-wordmark.jpg') }}"
                        alt="Logo UMKM Maloppo"
                        class="h-full w-full object-contain"
                    >
                </div>
            </a>

            <span class="label-maloppo mt-5">
                Akses Administrator
            </span>

            <h1 class="mt-4 text-2xl font-extrabold text-gray-900">
                Masuk ke Dashboard
            </h1>

            <p class="mx-auto mt-2 max-w-sm text-sm leading-6 text-gray-500">
                Kelola produk, kegiatan, stok, dan pesanan UMKM Maloppo
                melalui halaman administrator.
            </p>

        </div>

        {{-- Status sesi --}}
        @if (session('status'))
            <div
                class="mb-5 rounded-xl border px-4 py-3 text-sm font-medium"
                style="
                    background-color: #dcfce7;
                    border-color: #86efac;
                    color: #166534;
                "
            >
                {{ session('status') }}
            </div>
        @endif

        {{-- Kesalahan login --}}
        @if ($errors->any())
            <div class="alert-maloppo-error mb-5">

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
                            Login belum berhasil
                        </p>

                        <ul class="mt-1 list-inside list-disc space-y-1">
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

        <form
            method="POST"
            action="{{ route('login') }}"
            class="space-y-5"
        >
            @csrf

            {{-- Email --}}
            <div>

                <label
                    for="email"
                    class="block text-sm font-bold text-gray-700"
                >
                    Email
                </label>

                <div class="relative mt-2">

                    <div
                        class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400"
                    >
                        ✉️
                    </div>

                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        class="input-maloppo pl-11"
                        placeholder="Masukkan email administrator"
                        autocomplete="username"
                        autofocus
                        required
                    >

                </div>

                @error('email')
                    <p class="mt-2 text-sm font-medium text-red-600">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            {{-- Password --}}
            <div>

                <div class="flex items-center justify-between gap-4">

                    <label
                        for="password"
                        class="block text-sm font-bold text-gray-700"
                    >
                        Password
                    </label>

                    @if (Route::has('password.request'))
                        <a
                            href="{{ route('password.request') }}"
                            class="text-xs font-bold text-maloppo-red hover:underline"
                        >
                            Lupa password?
                        </a>
                    @endif

                </div>

                <div class="relative mt-2">

                    <div
                        class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400"
                    >
                        🔒
                    </div>

                    <input
                        id="password"
                        :type="showPassword ? 'text' : 'password'"
                        name="password"
                        class="input-maloppo pl-11 pr-14"
                        placeholder="Masukkan password"
                        autocomplete="current-password"
                        required
                    >

                    <button
                        type="button"
                        class="absolute inset-y-0 right-0 flex items-center px-4 text-xs font-bold text-maloppo-red"
                        @click="showPassword = ! showPassword"
                    >
                        <span x-show="! showPassword">
                            Lihat
                        </span>

                        <span
                            x-show="showPassword"
                            x-cloak
                        >
                            Tutup
                        </span>
                    </button>

                </div>

                @error('password')
                    <p class="mt-2 text-sm font-medium text-red-600">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            {{-- Ingat saya --}}
            <div
                class="flex flex-col gap-3 rounded-xl border p-4 sm:flex-row sm:items-center sm:justify-between"
                style="
                    background-color: #fffdf0;
                    border-color: #f1e7a4;
                "
            >

                <label
                    for="remember_me"
                    class="inline-flex cursor-pointer items-center"
                >
                    <input
                        id="remember_me"
                        type="checkbox"
                        name="remember"
                        class="rounded border-gray-300 shadow-sm"
                        style="color: #be0000;"
                    >

                    <span class="ml-2 text-sm font-medium text-gray-600">
                        Ingat akun saya
                    </span>
                </label>

                <span class="text-xs text-gray-400">
                    Khusus perangkat pribadi
                </span>

            </div>

            {{-- Tombol masuk --}}
            <button
                type="submit"
                class="btn-maloppo-primary w-full py-4 text-base"
            >
                <span>
                    🔐
                </span>

                Masuk ke Dashboard

                <span aria-hidden="true">
                    →
                </span>
            </button>

        </form>

        {{-- Kembali ke website --}}
        <div
            class="mt-7 border-t pt-6 text-center"
            style="border-color: #f1e7a4;"
        >

            <p class="text-xs text-gray-500">
                Bukan administrator?
            </p>

            <a
                href="{{ route('home') }}"
                class="mt-3 inline-flex items-center gap-2 text-sm font-bold text-maloppo-red"
            >
                <span aria-hidden="true">
                    ←
                </span>

                Kembali ke Website Maloppo
            </a>

        </div>

        {{-- Informasi keamanan --}}
        <div
            class="mt-6 flex items-start gap-3 rounded-xl px-4 py-3"
            style="
                background-color: #fff9b0;
                color: #713f12;
            "
        >

            <span class="text-lg">
                🛡️
            </span>

            <p class="text-xs leading-5">
                Halaman ini hanya digunakan oleh administrator resmi
                UMKM Maloppo. Jangan memberikan email dan password kepada
                orang lain.
            </p>

        </div>

    </div>

</x-guest-layout>