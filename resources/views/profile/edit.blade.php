<x-app-layout>

    <x-slot name="header">

        <div
            class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"
        >
            <div>
                <h1 class="page-title-maloppo">
                    Profil Admin
                </h1>

                <p class="page-description-maloppo">
                    Kelola informasi akun dan keamanan administrator UMKM Maloppo.
                </p>
            </div>

            <a
                href="{{ route('dashboard') }}"
                class="btn-maloppo-secondary"
            >
                Kembali
            </a>
        </div>

    </x-slot>

    <div class="py-6 lg:py-8">

        <div class="mx-auto max-w-5xl space-y-5 px-4 sm:px-6 lg:px-8">

            {{-- Ringkasan akun --}}
            <section class="panel-maloppo p-5 sm:p-6">

                <div class="flex items-center gap-4">

                    <div
                        class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-red-50 text-base font-semibold text-red-700"
                    >
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>

                    <div class="min-w-0">

                        <div class="flex flex-wrap items-center gap-2">

                            <h2 class="truncate text-base font-semibold text-gray-900">
                                {{ Auth::user()->name }}
                            </h2>

                            <span
                                class="inline-flex rounded-full bg-gray-100 px-2.5 py-1 text-[10px] font-medium uppercase tracking-wide text-gray-600"
                            >
                                Administrator
                            </span>

                        </div>

                        <p class="mt-1 truncate text-sm text-gray-500">
                            {{ Auth::user()->email }}
                        </p>

                    </div>

                </div>

            </section>

            {{-- Informasi profil --}}
            <section class="panel-maloppo overflow-hidden">

                <div class="section-header-maloppo">

                    <h2 class="section-title-maloppo">
                        Informasi Profil
                    </h2>

                    <p class="section-description-maloppo">
                        Perbarui nama dan alamat email akun administrator.
                    </p>

                </div>

                <div class="p-5 sm:p-6">

                    <div class="max-w-2xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>

                </div>

            </section>

            {{-- Password --}}
            <section class="panel-maloppo overflow-hidden">

                <div class="section-header-maloppo">

                    <h2 class="section-title-maloppo">
                        Ubah Password
                    </h2>

                    <p class="section-description-maloppo">
                        Gunakan password yang kuat dan tidak mudah ditebak.
                    </p>

                </div>

                <div class="p-5 sm:p-6">

                    <div class="max-w-2xl">
                        @include('profile.partials.update-password-form')
                    </div>

                </div>

            </section>

            {{-- Hapus akun --}}
            <section class="overflow-hidden rounded-xl border border-red-200 bg-white">

                <div class="border-b border-red-100 bg-red-50 px-5 py-4 sm:px-6">

                    <h2 class="text-base font-semibold text-red-800">
                        Hapus Akun
                    </h2>

                    <p class="mt-1 text-sm text-red-700">
                        Tindakan ini akan menghapus akun administrator secara permanen.
                    </p>

                </div>

                <div class="p-5 sm:p-6">

                    <div class="max-w-2xl">
                        @include('profile.partials.delete-user-form')
                    </div>

                </div>

            </section>

        </div>

    </div>

</x-app-layout>