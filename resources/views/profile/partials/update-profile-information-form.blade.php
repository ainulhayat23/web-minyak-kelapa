<section>

    <form
        id="send-verification"
        method="POST"
        action="{{ route('verification.send') }}"
    >
        @csrf
    </form>

    <form
        method="POST"
        action="{{ route('profile.update') }}"
        class="space-y-6"
    >
        @csrf
        @method('PATCH')

        {{-- Penjelasan --}}
        <div
            class="flex items-start gap-3 rounded-xl border p-4"
            style="
                background-color: #fffdf0;
                border-color: #f1e7a4;
            "
        >
            <div
                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg text-lg"
                style="background-color: #fff9b0;"
            >
                ℹ️
            </div>

            <div>
                <p class="text-sm font-bold text-gray-800">
                    Informasi akun administrator
                </p>

                <p class="mt-1 text-xs leading-5 text-gray-500">
                    Nama dan alamat email ini digunakan untuk akun admin UMKM Maloppo.
                </p>
            </div>
        </div>

        {{-- Nama --}}
        <div>

            <label
                for="name"
                class="block text-sm font-bold text-gray-700"
            >
                Nama Administrator
                <span style="color: #be0000;">*</span>
            </label>

            <div class="relative mt-2">

                <div
                    class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400"
                >
                    👤
                </div>

                <input
                    id="name"
                    name="name"
                    type="text"
                    value="{{ old('name', $user->name) }}"
                    class="input-maloppo pl-11"
                    placeholder="Masukkan nama administrator"
                    required
                    autofocus
                    autocomplete="name"
                >

            </div>

            @if ($errors->get('name'))

                <div class="mt-2 space-y-1">

                    @foreach ($errors->get('name') as $message)

                        <p class="text-sm font-medium text-red-600">
                            {{ $message }}
                        </p>

                    @endforeach

                </div>

            @endif

        </div>

        {{-- Email --}}
        <div>

            <label
                for="email"
                class="block text-sm font-bold text-gray-700"
            >
                Alamat Email
                <span style="color: #be0000;">*</span>
            </label>

            <div class="relative mt-2">

                <div
                    class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400"
                >
                    ✉️
                </div>

                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email', $user->email) }}"
                    class="input-maloppo pl-11"
                    placeholder="Masukkan alamat email"
                    required
                    autocomplete="username"
                >

            </div>

            <p class="mt-2 text-xs leading-5 text-gray-500">
                Pastikan alamat email masih aktif dan dapat diakses.
            </p>

            @if ($errors->get('email'))

                <div class="mt-2 space-y-1">

                    @foreach ($errors->get('email') as $message)

                        <p class="text-sm font-medium text-red-600">
                            {{ $message }}
                        </p>

                    @endforeach

                </div>

            @endif

            {{-- Verifikasi email --}}
            @if (
                $user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail
                && ! $user->hasVerifiedEmail()
            )

                <div
                    class="mt-4 rounded-xl border p-4"
                    style="
                        background-color: #fff9b0;
                        border-color: #f7e900;
                    "
                >

                    <div class="flex items-start gap-3">

                        <span class="text-lg">
                            ⚠️
                        </span>

                        <div>

                            <p class="text-sm font-bold text-gray-800">
                                Email belum diverifikasi
                            </p>

                            <p class="mt-1 text-xs leading-5 text-gray-600">
                                Silakan kirim ulang tautan verifikasi ke alamat email Anda.
                            </p>

                            <button
                                form="send-verification"
                                type="submit"
                                class="mt-3 inline-flex items-center rounded-lg px-4 py-2 text-xs font-bold"
                                style="
                                    background-color: #be0000;
                                    color: white;
                                "
                            >
                                Kirim Ulang Verifikasi
                            </button>

                        </div>

                    </div>

                </div>

                @if (session('status') === 'verification-link-sent')

                    <div
                        class="mt-3 rounded-xl border px-4 py-3 text-sm font-medium"
                        style="
                            background-color: #dcfce7;
                            border-color: #86efac;
                            color: #166534;
                        "
                    >
                        Tautan verifikasi baru telah dikirim ke alamat email Anda.
                    </div>

                @endif

            @endif

        </div>

        {{-- Tombol --}}
        <div
            class="flex flex-col gap-3 border-t pt-6 sm:flex-row sm:items-center"
            style="border-color: #f1e7a4;"
        >

            <button
                type="submit"
                class="btn-maloppo-primary px-7 py-3"
            >
                <span>💾</span>
                Simpan Perubahan
            </button>

            @if (session('status') === 'profile-updated')

                <div
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 3000)"
                    class="inline-flex items-center gap-2 rounded-lg px-4 py-2 text-sm font-bold"
                    style="
                        background-color: #dcfce7;
                        color: #166534;
                    "
                >
                    <span>✓</span>
                    Profil berhasil diperbarui
                </div>

            @endif

        </div>

    </form>

</section>