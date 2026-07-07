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
        class="space-y-5"
    >
        @csrf
        @method('PATCH')

        {{-- Nama --}}
        <div>

            <label
                for="name"
                class="block text-sm font-medium text-gray-700"
            >
                Nama Administrator
                <span class="text-red-700">*</span>
            </label>

            <input
                id="name"
                name="name"
                type="text"
                value="{{ old('name', $user->name) }}"
                class="input-maloppo mt-2"
                placeholder="Masukkan nama administrator"
                required
                autofocus
                autocomplete="name"
            >

            <p class="mt-1.5 text-xs leading-5 text-gray-500">
                Nama ini akan digunakan pada akun administrator Maloppo.
            </p>

            @if ($errors->get('name'))

                <div class="mt-2 space-y-1">

                    @foreach ($errors->get('name') as $message)

                        <p class="text-sm text-red-700">
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
                class="block text-sm font-medium text-gray-700"
            >
                Alamat Email
                <span class="text-red-700">*</span>
            </label>

            <input
                id="email"
                name="email"
                type="email"
                value="{{ old('email', $user->email) }}"
                class="input-maloppo mt-2"
                placeholder="Masukkan alamat email"
                required
                autocomplete="username"
            >

            <p class="mt-1.5 text-xs leading-5 text-gray-500">
                Pastikan alamat email aktif dan dapat diakses.
            </p>

            @if ($errors->get('email'))

                <div class="mt-2 space-y-1">

                    @foreach ($errors->get('email') as $message)

                        <p class="text-sm text-red-700">
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

                <div class="mt-4 rounded-lg border border-amber-200 bg-amber-50 p-4">

                    <p class="text-sm font-medium text-amber-800">
                        Email belum diverifikasi
                    </p>

                    <p class="mt-1 text-xs leading-5 text-amber-700">
                        Kirim ulang tautan verifikasi ke alamat email Anda.
                    </p>

                    <button
                        form="send-verification"
                        type="submit"
                        class="mt-3 text-sm font-medium text-red-700 transition hover:text-red-900"
                    >
                        Kirim ulang verifikasi
                    </button>

                </div>

                @if (session('status') === 'verification-link-sent')

                    <div class="mt-3 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                        Tautan verifikasi baru telah dikirim ke alamat email Anda.
                    </div>

                @endif

            @endif

        </div>

        {{-- Tombol --}}
        <div
            class="flex flex-col gap-3 border-t border-gray-200 pt-5 sm:flex-row sm:items-center"
        >

            <button
                type="submit"
                class="btn-maloppo-primary"
            >
                Simpan Perubahan
            </button>

            @if (session('status') === 'profile-updated')

                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 3000)"
                    class="text-sm font-medium text-green-700"
                >
                    Profil berhasil diperbarui.
                </p>

            @endif

        </div>

    </form>

</section>