<section>

    <form
        method="POST"
        action="{{ route('password.update') }}"
        class="space-y-6"
        x-data="{
            showCurrentPassword: false,
            showNewPassword: false,
            showConfirmationPassword: false
        }"
    >
        @csrf
        @method('PUT')

        {{-- Informasi keamanan --}}
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
                🔐
            </div>

            <div>
                <p class="text-sm font-bold text-gray-800">
                    Lindungi akun administrator
                </p>

                <p class="mt-1 text-xs leading-5 text-gray-500">
                    Gunakan password yang sulit ditebak dan berbeda dari password akun lainnya.
                </p>
            </div>
        </div>

        {{-- Password saat ini --}}
        <div>

            <label
                for="update_password_current_password"
                class="block text-sm font-bold text-gray-700"
            >
                Password Saat Ini
                <span style="color: #be0000;">*</span>
            </label>

            <div class="relative mt-2">

                <div
                    class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400"
                >
                    🔒
                </div>

                <input
                    id="update_password_current_password"
                    name="current_password"
                    :type="showCurrentPassword ? 'text' : 'password'"
                    class="input-maloppo pl-11 pr-14"
                    placeholder="Masukkan password saat ini"
                    autocomplete="current-password"
                    required
                >

                <button
                    type="button"
                    class="absolute inset-y-0 right-0 flex items-center px-4 text-sm font-bold text-gray-500 hover:text-maloppo-red"
                    @click="showCurrentPassword = !showCurrentPassword"
                    :aria-label="showCurrentPassword ? 'Sembunyikan password' : 'Tampilkan password'"
                >
                    <span x-show="!showCurrentPassword">
                        👁️
                    </span>

                    <span x-show="showCurrentPassword" x-cloak>
                        🙈
                    </span>
                </button>

            </div>

            @if ($errors->updatePassword->get('current_password'))

                <div class="mt-2 space-y-1">

                    @foreach ($errors->updatePassword->get('current_password') as $message)

                        <p class="text-sm font-medium text-red-600">
                            {{ $message }}
                        </p>

                    @endforeach

                </div>

            @endif

        </div>

        {{-- Password baru --}}
        <div>

            <label
                for="update_password_password"
                class="block text-sm font-bold text-gray-700"
            >
                Password Baru
                <span style="color: #be0000;">*</span>
            </label>

            <div class="relative mt-2">

                <div
                    class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400"
                >
                    🔑
                </div>

                <input
                    id="update_password_password"
                    name="password"
                    :type="showNewPassword ? 'text' : 'password'"
                    class="input-maloppo pl-11 pr-14"
                    placeholder="Masukkan password baru"
                    autocomplete="new-password"
                    required
                >

                <button
                    type="button"
                    class="absolute inset-y-0 right-0 flex items-center px-4 text-sm font-bold text-gray-500 hover:text-maloppo-red"
                    @click="showNewPassword = !showNewPassword"
                    :aria-label="showNewPassword ? 'Sembunyikan password' : 'Tampilkan password'"
                >
                    <span x-show="!showNewPassword">
                        👁️
                    </span>

                    <span x-show="showNewPassword" x-cloak>
                        🙈
                    </span>
                </button>

            </div>

            <p class="mt-2 text-xs leading-5 text-gray-500">
                Gunakan minimal 8 karakter dan kombinasikan huruf, angka, serta simbol.
            </p>

            @if ($errors->updatePassword->get('password'))

                <div class="mt-2 space-y-1">

                    @foreach ($errors->updatePassword->get('password') as $message)

                        <p class="text-sm font-medium text-red-600">
                            {{ $message }}
                        </p>

                    @endforeach

                </div>

            @endif

        </div>

        {{-- Konfirmasi password --}}
        <div>

            <label
                for="update_password_password_confirmation"
                class="block text-sm font-bold text-gray-700"
            >
                Konfirmasi Password Baru
                <span style="color: #be0000;">*</span>
            </label>

            <div class="relative mt-2">

                <div
                    class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400"
                >
                    ✅
                </div>

                <input
                    id="update_password_password_confirmation"
                    name="password_confirmation"
                    :type="showConfirmationPassword ? 'text' : 'password'"
                    class="input-maloppo pl-11 pr-14"
                    placeholder="Ulangi password baru"
                    autocomplete="new-password"
                    required
                >

                <button
                    type="button"
                    class="absolute inset-y-0 right-0 flex items-center px-4 text-sm font-bold text-gray-500 hover:text-maloppo-red"
                    @click="showConfirmationPassword = !showConfirmationPassword"
                    :aria-label="showConfirmationPassword ? 'Sembunyikan password' : 'Tampilkan password'"
                >
                    <span x-show="!showConfirmationPassword">
                        👁️
                    </span>

                    <span x-show="showConfirmationPassword" x-cloak>
                        🙈
                    </span>
                </button>

            </div>

            @if ($errors->updatePassword->get('password_confirmation'))

                <div class="mt-2 space-y-1">

                    @foreach ($errors->updatePassword->get('password_confirmation') as $message)

                        <p class="text-sm font-medium text-red-600">
                            {{ $message }}
                        </p>

                    @endforeach

                </div>

            @endif

        </div>

        {{-- Peringatan --}}
        <div
            class="rounded-xl border p-4"
            style="
                background-color: #fff9b0;
                border-color: #f7e900;
            "
        >
            <div class="flex items-start gap-3">

                <span class="text-lg">
                    ⚠️
                </span>

                <p class="text-xs leading-6 text-gray-600">
                    Setelah password berhasil diubah, gunakan password baru tersebut saat login berikutnya.
                </p>

            </div>
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
                <span>🔐</span>
                Perbarui Password
            </button>

            @if (session('status') === 'password-updated')

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
                    Password berhasil diperbarui
                </div>

            @endif

        </div>

    </form>

</section>