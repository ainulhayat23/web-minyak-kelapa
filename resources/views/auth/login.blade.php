<x-guest-layout>

    <div
        x-data="{ showPassword: false }"
        class="w-full"
    >

        {{-- Logo dan identitas --}}
        <div class="mb-7 text-center">

            <div class="flex justify-center">
                <a
                    href="{{ route('home') }}"
                    class="inline-flex items-center justify-center"
                >
                    <img
                        src="{{ asset('images/brand/logo-maloppo-wordmark.jpg') }}"
                        alt="Logo UMKM Maloppo"
                        class="h-16 w-auto rounded-xl object-contain"
                    >
                </a>
            </div>

            <div class="mt-5 flex justify-center">
                <span class="inline-flex items-center rounded-full bg-red-50 px-4 py-2 text-xs font-bold uppercase tracking-[0.20em] text-red-700">
                    Akses Administrator
                </span>
            </div>

            <h1 class="mt-4 text-3xl font-bold tracking-tight text-gray-900">
                Masuk ke Dashboard
            </h1>

            <p class="mx-auto mt-3 max-w-sm text-sm leading-6 text-gray-500">
                Gunakan akun administrator untuk mengelola produk, kegiatan, dan pesanan UMKM Maloppo.
            </p>

        </div>

        {{-- Status sesi --}}
        @if (session('status'))

            <div class="mb-5 rounded-2xl border border-green-200 bg-green-50 px-5 py-4 text-sm font-semibold text-green-800">
                {{ session('status') }}
            </div>

        @endif

        {{-- Kesalahan login --}}
        @if ($errors->any())

            <div class="mb-5 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-800">

                <p class="font-bold">
                    Login belum berhasil.
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

        {{-- Form login --}}
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
                    class="block text-sm font-semibold text-gray-700"
                >
                    Email Administrator
                </label>

                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="mt-2 block w-full rounded-xl border-gray-300 px-4 py-3 text-sm shadow-sm transition focus:border-red-500 focus:ring-red-500"
                    placeholder="Masukkan email administrator"
                    autocomplete="username"
                    autofocus
                    required
                >

                @error('email')
                    <p class="mt-2 text-sm font-medium text-red-700">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            {{-- Password --}}
            <div>

                <div class="flex items-center justify-between gap-4">

                    <label
                        for="password"
                        class="block text-sm font-semibold text-gray-700"
                    >
                        Password
                    </label>

                    @if (Route::has('password.request'))

                        <a
                            href="{{ route('password.request') }}"
                            class="text-xs font-semibold text-red-700 transition hover:text-red-900"
                        >
                            Lupa password?
                        </a>

                    @endif

                </div>

                <div class="relative mt-2">

                    <input
                        id="password"
                        :type="showPassword ? 'text' : 'password'"
                        name="password"
                        class="block w-full rounded-xl border-gray-300 px-4 py-3 pr-12 text-sm shadow-sm transition focus:border-red-500 focus:ring-red-500"
                        placeholder="Masukkan password"
                        autocomplete="current-password"
                        required
                    >

                    <button
                        type="button"
                        class="absolute inset-y-0 right-0 flex items-center justify-center px-4 text-gray-400 transition hover:text-red-700"
                        @click="showPassword = !showPassword"
                        :aria-label="showPassword ? 'Sembunyikan password' : 'Tampilkan password'"
                    >

                        <svg
                            x-show="!showPassword"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.7"
                            stroke="currentColor"
                            class="h-5 w-5"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .638C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"
                            />
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                            />
                        </svg>

                        <svg
                            x-show="showPassword"
                            x-cloak
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.7"
                            stroke="currentColor"
                            class="h-5 w-5"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M3.98 8.223A10.477 10.477 0 002.036 11.68a1.012 1.012 0 000 .639C3.423 16.49 7.36 19.5 12 19.5c1.526 0 2.97-.324 4.272-.904M6.228 6.228A9.953 9.953 0 0112 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .638a10.451 10.451 0 01-2.293 3.95M6.228 6.228L3 3m3.228 3.228l3.65 3.65m9.792 6.388L21 21m-3.33-3.33l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.243 4.243L9.88 9.88"
                            />
                        </svg>

                    </button>

                </div>

                @error('password')
                    <p class="mt-2 text-sm font-medium text-red-700">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            {{-- Ingat saya --}}
            <div class="flex items-center justify-between gap-4">

                <label
                    for="remember_me"
                    class="inline-flex cursor-pointer items-center"
                >
                    <input
                        id="remember_me"
                        type="checkbox"
                        name="remember"
                        class="rounded border-gray-300 text-red-700 shadow-sm focus:ring-red-500"
                    >

                    <span class="ml-2 text-sm text-gray-600">
                        Ingat akun saya
                    </span>
                </label>

                <span class="text-xs text-gray-400">
                    Perangkat pribadi
                </span>

            </div>

            {{-- Tombol masuk --}}
            <button
                type="submit"
                class="inline-flex w-full items-center justify-center rounded-xl bg-red-700 px-5 py-3 text-sm font-bold text-white shadow-sm transition hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
            >
                Masuk ke Dashboard
            </button>

        </form>

        {{-- Kembali --}}
        <div class="mt-6 border-t border-gray-200 pt-5 text-center">

            <a
                href="{{ route('home') }}"
                class="text-sm font-semibold text-gray-600 transition hover:text-red-700"
            >
                Kembali ke Website Maloppo
            </a>

        </div>

        {{-- Catatan keamanan --}}
        <p class="mt-4 text-center text-xs leading-5 text-gray-400">
            Halaman ini hanya digunakan oleh administrator resmi UMKM Maloppo.
        </p>

    </div>

</x-guest-layout>