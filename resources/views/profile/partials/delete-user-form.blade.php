<section class="space-y-5">

    {{-- Peringatan --}}
    <div class="rounded-lg border border-red-200 bg-red-50 p-4">

        <h3 class="text-sm font-semibold text-red-800">
            Penghapusan akun bersifat permanen
        </h3>

        <p class="mt-1 text-sm leading-6 text-red-700">
            Setelah akun dihapus, akun administrator tidak dapat digunakan
            kembali untuk masuk ke dashboard UMKM Maloppo.
        </p>

    </div>

    {{-- Informasi --}}
    <div>

        <p class="text-sm font-medium text-gray-800">
            Sebelum menghapus akun:
        </p>

        <ul class="mt-3 list-inside list-disc space-y-2 text-sm leading-6 text-gray-600">

            <li>
                Pastikan masih tersedia akun administrator lain.
            </li>

            <li>
                Simpan data penting yang masih diperlukan.
            </li>

            <li>
                Penghapusan akun tidak dapat dibatalkan.
            </li>

        </ul>

    </div>

    {{-- Tombol buka modal --}}
    <button
        type="button"
        x-data
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="inline-flex items-center justify-center rounded-lg bg-red-700 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-red-800"
    >
        Hapus Akun
    </button>

    {{-- Modal konfirmasi --}}
    <x-modal
        name="confirm-user-deletion"
        :show="$errors->userDeletion->isNotEmpty()"
        focusable
    >

        <form
            method="POST"
            action="{{ route('profile.destroy') }}"
            class="p-6 sm:p-7"
            x-data="{ showPassword: false }"
        >
            @csrf
            @method('DELETE')

            {{-- Header modal --}}
            <div>

                <h2 class="text-lg font-semibold text-gray-900">
                    Hapus Akun Administrator?
                </h2>

                <p class="mt-2 text-sm leading-6 text-gray-600">
                    Akun
                    <span class="font-medium text-gray-900">
                        {{ Auth::user()->email }}
                    </span>
                    akan dihapus secara permanen.
                </p>

            </div>

            {{-- Peringatan --}}
            <div class="mt-5 rounded-lg border border-red-200 bg-red-50 p-4">

                <p class="text-sm font-medium text-red-800">
                    Konfirmasi diperlukan
                </p>

                <p class="mt-1 text-xs leading-5 text-red-700">
                    Masukkan password akun saat ini untuk memastikan
                    penghapusan dilakukan oleh pemilik akun.
                </p>

            </div>

            {{-- Password --}}
            <div class="mt-5">

                <label
                    for="delete_account_password"
                    class="block text-sm font-medium text-gray-700"
                >
                    Password Saat Ini
                    <span class="text-red-700">*</span>
                </label>

                <div class="relative mt-2">

                    <input
                        id="delete_account_password"
                        name="password"
                        :type="showPassword ? 'text' : 'password'"
                        class="input-maloppo pr-12"
                        placeholder="Masukkan password untuk konfirmasi"
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

                @if ($errors->userDeletion->get('password'))

                    <div class="mt-2 space-y-1">

                        @foreach ($errors->userDeletion->get('password') as $message)

                            <p class="text-sm text-red-700">
                                {{ $message }}
                            </p>

                        @endforeach

                    </div>

                @endif

            </div>

            {{-- Tombol modal --}}
            <div
                class="mt-6 flex flex-col-reverse gap-3 border-t border-gray-200 pt-5 sm:flex-row sm:justify-end"
            >

                <button
                    type="button"
                    x-on:click="$dispatch('close')"
                    class="btn-maloppo-secondary"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    class="inline-flex items-center justify-center rounded-lg bg-red-700 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-red-800"
                >
                    Ya, Hapus Akun
                </button>

            </div>

        </form>

    </x-modal>

</section>