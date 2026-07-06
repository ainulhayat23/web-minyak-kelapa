<x-app-layout>

    <x-slot name="header">

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h1 class="text-2xl font-extrabold leading-tight text-gray-900">
                    Profil Admin
                </h1>

                <p class="mt-2 text-sm font-normal text-gray-600">
                    Kelola informasi akun dan keamanan administrator UMKM Maloppo.
                </p>
            </div>

            <a
                href="{{ route('dashboard') }}"
                class="btn-maloppo-secondary"
            >
                <span aria-hidden="true">←</span>
                Kembali ke Dashboard
            </a>

        </div>

    </x-slot>

    <div class="py-8 lg:py-10">

        <div class="mx-auto max-w-6xl space-y-7 px-4 sm:px-6 lg:px-8">

            {{-- Ringkasan akun --}}
            <section
                class="relative overflow-hidden rounded-3xl p-6 shadow-lg sm:p-8"
                style="
                    background:
                        radial-gradient(
                            circle at top right,
                            rgba(247, 233, 0, 0.35),
                            transparent 38%
                        ),
                        linear-gradient(
                            135deg,
                            #be0000 0%,
                            #990100 100%
                        );
                "
            >

                <div
                    class="pointer-events-none absolute -right-16 -top-20 h-56 w-56 rounded-full opacity-20"
                    style="background-color: #f7e900;"
                ></div>

                <div class="relative flex flex-col gap-6 sm:flex-row sm:items-center">

                    <div
                        class="flex h-20 w-20 shrink-0 items-center justify-center rounded-2xl text-3xl font-extrabold shadow-lg"
                        style="
                            background-color: #f7e900;
                            color: #990100;
                        "
                    >
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>

                    <div>

                        <span
                            class="inline-flex rounded-full px-3 py-1 text-xs font-bold uppercase tracking-wider"
                            style="
                                background-color: rgba(255, 255, 255, 0.16);
                                color: white;
                            "
                        >
                            Administrator
                        </span>

                        <h2 class="mt-3 text-2xl font-extrabold text-white">
                            {{ Auth::user()->name }}
                        </h2>

                        <p class="mt-2 text-sm text-red-100">
                            {{ Auth::user()->email }}
                        </p>

                    </div>

                </div>

            </section>

            {{-- Informasi profil --}}
            <section class="card-maloppo overflow-hidden">

                <div
                    class="border-b px-6 py-5 sm:px-8"
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
                                Informasi Profil
                            </h2>

                            <p class="mt-1 text-sm text-gray-500">
                                Perbarui nama dan alamat email akun administrator.
                            </p>

                        </div>

                    </div>

                </div>

                <div class="p-6 sm:p-8">

                    <div class="max-w-2xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>

                </div>

            </section>

            {{-- Password --}}
            <section class="card-maloppo overflow-hidden">

                <div
                    class="border-b px-6 py-5 sm:px-8"
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
                            🔐
                        </div>

                        <div>

                            <h2 class="text-xl font-extrabold text-gray-900">
                                Keamanan Password
                            </h2>

                            <p class="mt-1 text-sm text-gray-500">
                                Gunakan password yang kuat untuk menjaga keamanan akun.
                            </p>

                        </div>

                    </div>

                </div>

                <div class="p-6 sm:p-8">

                    <div class="max-w-2xl">
                        @include('profile.partials.update-password-form')
                    </div>

                </div>

            </section>

            {{-- Hapus akun --}}
            <section
                class="overflow-hidden rounded-2xl border bg-white shadow-sm"
                style="border-color: #fca5a5;"
            >

                <div
                    class="border-b px-6 py-5 sm:px-8"
                    style="
                        background-color: #fef2f2;
                        border-color: #fca5a5;
                    "
                >

                    <div class="flex items-center gap-4">

                        <div
                            class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl text-xl text-white"
                            style="background-color: #be0000;"
                        >
                            ⚠️
                        </div>

                        <div>

                            <h2 class="text-xl font-extrabold text-gray-900">
                                Hapus Akun
                            </h2>

                            <p class="mt-1 text-sm text-gray-500">
                                Tindakan ini akan menghapus akun secara permanen.
                            </p>

                        </div>

                    </div>

                </div>

                <div class="p-6 sm:p-8">

                    <div class="max-w-2xl">
                        @include('profile.partials.delete-user-form')
                    </div>

                </div>

            </section>

        </div>

    </div>

</x-app-layout>