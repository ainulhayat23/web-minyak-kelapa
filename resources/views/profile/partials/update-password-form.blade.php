<section>

    <form
        method="POST"
        action="{{ route('password.update') }}"
        class="space-y-5"
        x-data="{
            showCurrentPassword: false,
            showNewPassword: false,
            showConfirmationPassword: false
        }"
    >
        @csrf
        @method('PUT')

        {{-- Password saat ini --}}
        <div>

            <label
                for="update_password_current_password"
                class="block text-sm font-medium text-gray-700"
            >
                Password Saat Ini
                <span class="text-red-700">*</span>
            </label>

            <div class="relative mt-2">

                <input
                    id="update_password_current_password"
                    name="current_password"
                    :type="showCurrentPassword ? 'text' : 'password'"
                    class="input-maloppo pr-12"
                    placeholder="Masukkan password saat ini"
                    autocomplete="current-password"
                    required
                >

                <button
                    type="button"
                    class="absolute inset-y-0 right-0 flex items-center justify-center px-3 text-gray-400 transition hover:text-gray-700"
                    @click="showCurrentPassword = !showCurrentPassword"
                    :aria-label="showCurrentPassword ? 'Sembunyikan password' : 'Tampilkan password'"
                >
                    <svg
                        x-show="!showCurrentPassword"
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
                        x-show="showCurrentPassword"
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

            @if ($errors->updatePassword->get('current_password'))

                <div class="mt-2 space-y-1">

                    @foreach ($errors->updatePassword->get('current_password') as $message)

                        <p class="text-sm text-red-700">
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
                class="block text-sm font-medium text-gray-700"
            >
                Password Baru
                <span class="text-red-700">*</span>
            </label>

            <div class="relative mt-2">

                <input
                    id="update_password_password"
                    name="password"
                    :type="showNewPassword ? 'text' : 'password'"
                    class="input-maloppo pr-12"
                    placeholder="Masukkan password baru"
                    autocomplete="new-password"
                    required
                >

                <button
                    type="button"
                    class="absolute inset-y-0 right-0 flex items-center justify-center px-3 text-gray-400 transition hover:text-gray-700"
                    @click="showNewPassword = !showNewPassword"
                    :aria-label="showNewPassword ? 'Sembunyikan password' : 'Tampilkan password'"
                >
                    <svg
                        x-show="!showNewPassword"
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
                        x-show="showNewPassword"
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

            <p class="mt-1.5 text-xs leading-5 text-gray-500">
                Gunakan minimal 8 karakter dengan kombinasi huruf, angka, atau simbol.
            </p>

            @if ($errors->updatePassword->get('password'))

                <div class="mt-2 space-y-1">

                    @foreach ($errors->updatePassword->get('password') as $message)

                        <p class="text-sm text-red-700">
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
                class="block text-sm font-medium text-gray-700"
            >
                Konfirmasi Password Baru
                <span class="text-red-700">*</span>
            </label>

            <div class="relative mt-2">

                <input
                    id="update_password_password_confirmation"
                    name="password_confirmation"
                    :type="showConfirmationPassword ? 'text' : 'password'"
                    class="input-maloppo pr-12"
                    placeholder="Ulangi password baru"
                    autocomplete="new-password"
                    required
                >

                <button
                    type="button"
                    class="absolute inset-y-0 right-0 flex items-center justify-center px-3 text-gray-400 transition hover:text-gray-700"
                    @click="showConfirmationPassword = !showConfirmationPassword"
                    :aria-label="showConfirmationPassword ? 'Sembunyikan password' : 'Tampilkan password'"
                >
                    <svg
                        x-show="!showConfirmationPassword"
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
                        x-show="showConfirmationPassword"
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

            @if ($errors->updatePassword->get('password_confirmation'))

                <div class="mt-2 space-y-1">

                    @foreach ($errors->updatePassword->get('password_confirmation') as $message)

                        <p class="text-sm text-red-700">
                            {{ $message }}
                        </p>

                    @endforeach

                </div>

            @endif

        </div>

        <p class="text-xs leading-5 text-gray-500">
            Setelah password diperbarui, gunakan password baru saat login berikutnya.
        </p>

        {{-- Tombol --}}
        <div
            class="flex flex-col gap-3 border-t border-gray-200 pt-5 sm:flex-row sm:items-center"
        >

            <button
                type="submit"
                class="btn-maloppo-primary"
            >
                Perbarui Password
            </button>

            @if (session('status') === 'password-updated')

                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 3000)"
                    class="text-sm font-medium text-green-700"
                >
                    Password berhasil diperbarui.
                </p>

            @endif

        </div>

    </form>

</section>