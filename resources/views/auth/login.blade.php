<x-guest-layout>

    <div
        x-data="{ showPassword: false }"
        class="w-full"
    >

        {{-- Identitas --}}
        <div class="mb-6 text-center">

            <a
                href="{{ route('home') }}"
                class="inline-flex items-center justify-center"
            >
                <div
                    class="flex h-14 w-32 items-center justify-center overflow-hidden rounded-lg border border-gray-200 bg-white"
                >
                    <img
                        src="{{ asset('images/brand/logo-maloppo-wordmark.jpg') }}"
                        alt="Logo UMKM Maloppo"
                        class="h-full w-full object-contain"
                    >
                </div>
            </a>

            <p class="mt-5 text-xs font-semibold uppercase tracking-wider text-red-700">
                Akses Administrator
            </p>

            <h1 class="mt-2 text-2xl font-semibold text-gray-900">
                Masuk ke Dashboard
            </h1>

            <p class="mx-auto mt-2 max-w-sm text-sm leading-6 text-gray-500">
                Masukkan email dan password administrator UMKM Maloppo.
            </p>

        </div>

        {{-- Status sesi --}}
        @if (session('status'))

            <div class="mb-5 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                {{ session('status') }}
            </div>

        @endif

        {{-- Kesalahan login --}}
        @if ($errors->any())

            <div class="alert-maloppo-error mb-5">

                <p class="font-semibold">
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
                    class="block text-sm font-medium text-gray-700"
                >
                    Email
                </label>

                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="input-maloppo mt-2"
                    placeholder="Masukkan email administrator"
                    autocomplete="username"
                    autofocus
                    required
                >

                @error('email')

                    <p class="mt-2 text-sm text-red-700">
                        {{ $message }}
                    </p>

                @enderror

            </div>

            {{-- Password --}}
            <div>

                <div class="flex items-center justify-between gap-4">

                    <label
                        for="password"
                        class="block text-sm font-medium text-gray-700"
                    >
                        Password
                    </label>

                    @if (Route::has('password.request'))

                        <a
                            href="{{ route('password.request') }}"
                            class="text-xs font-medium text-red-700 transition hover:text-red-900"
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
                        class="input-maloppo pr-12"
                        placeholder="Masukkan password"
                        autocomplete="current-password"
                        required
                    >

                    <button
                        type="button"
                        class="absolute inset-y-0 right-0 flex items-center justify-center px-3 text-gray-400 transition hover:text-gray-700"
                        @click="showPassword = !showPassword"
                        :aria-label="showPassword ? 'Sembunyikan password' : 'Tampilkan password'"
                    >

                        <svg
                            x-show="!showPassword"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
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
                            stroke-width="1.5"
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

                    <p class="mt-2 text-sm text-red-700">
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
                        class="rounded border-gray-300 text-red-700 shadow-sm focus:ring-red-600"
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
                class="btn-maloppo-primary w-full"
            >
                Masuk ke Dashboard
            </button>

        </form>

        {{-- Kembali ke website --}}
        <div class="mt-6 border-t border-gray-200 pt-5 text-center">

            <a
                href="{{ route('home') }}"
                class="text-sm font-medium text-gray-600 transition hover:text-red-700"
            >
                Kembali ke Website Maloppo
            </a>

        </div>

        {{-- Informasi keamanan --}}
        <p class="mt-4 text-center text-xs leading-5 text-gray-400">
            Halaman ini hanya digunakan oleh administrator resmi UMKM Maloppo.
        </p>

    </div>

</x-guest-layout>