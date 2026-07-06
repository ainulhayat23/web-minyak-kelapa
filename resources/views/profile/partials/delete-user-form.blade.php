<section class="space-y-6">

    {{-- Peringatan utama --}}
    <div
        class="rounded-2xl border p-5"
        style="
            background-color: #fef2f2;
            border-color: #fca5a5;
        "
    >
        <div class="flex items-start gap-4">

            <div
                class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl text-xl text-white"
                style="background-color: #be0000;"
            >
                ⚠️
            </div>

            <div>

                <h3 class="font-extrabold text-gray-900">
                    Tindakan permanen
                </h3>

                <p class="mt-2 text-sm leading-6 text-gray-600">
                    Setelah akun dihapus, akun administrator tidak dapat digunakan
                    kembali untuk masuk ke dashboard UMKM Maloppo.
                </p>

            </div>

        </div>
    </div>

    {{-- Informasi akibat penghapusan --}}
    <div
        class="rounded-2xl border p-5"
        style="
            background-color: #fffdf0;
            border-color: #f1e7a4;
        "
    >

        <p class="text-sm font-bold text-gray-800">
            Sebelum menghapus akun
        </p>

        <div class="mt-4 space-y-3">

            <div class="flex items-start gap-3">

                <span
                    class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full text-xs font-bold"
                    style="
                        background-color: #fff9b0;
                        color: #990100;
                    "
                >
                    1
                </span>

                <p class="pt-1 text-sm leading-5 text-gray-600">
                    Pastikan masih ada akun administrator lain yang dapat digunakan.
                </p>

            </div>

            <div class="flex items-start gap-3">

                <span
                    class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full text-xs font-bold"
                    style="
                        background-color: #fff9b0;
                        color: #990100;
                    "
                >
                    2
                </span>

                <p class="pt-1 text-sm leading-5 text-gray-600">
                    Simpan data penting yang masih diperlukan sebelum melanjutkan.
                </p>

            </div>

            <div class="flex items-start gap-3">

                <span
                    class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full text-xs font-bold"
                    style="
                        background-color: #fff9b0;
                        color: #990100;
                    "
                >
                    3
                </span>

                <p class="pt-1 text-sm leading-5 text-gray-600">
                    Penghapusan akun tidak dapat dibatalkan setelah dikonfirmasi.
                </p>

            </div>

        </div>

    </div>

    {{-- Tombol buka modal --}}
    <button
        type="button"
        x-data
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="inline-flex items-center justify-center gap-2 rounded-xl px-6 py-3 text-sm font-bold text-white shadow-sm transition hover:opacity-90"
        style="background-color: #be0000;"
    >
        <span>🗑️</span>
        Hapus Akun Permanen
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
            class="p-6 sm:p-8"
            x-data="{ showPassword: false }"
        >
            @csrf
            @method('DELETE')

            {{-- Header modal --}}
            <div class="flex items-start gap-4">

                <div
                    class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl text-xl text-white"
                    style="background-color: #be0000;"
                >
                    ⚠️
                </div>

                <div>

                    <h2 class="text-xl font-extrabold text-gray-900">
                        Hapus Akun Administrator?
                    </h2>

                    <p class="mt-2 text-sm leading-6 text-gray-600">
                        Akun
                        <span class="font-bold text-gray-900">
                            {{ Auth::user()->email }}
                        </span>
                        akan dihapus secara permanen.
                    </p>

                </div>

            </div>

            {{-- Peringatan --}}
            <div
                class="mt-6 rounded-xl border p-4"
                style="
                    background-color: #fef2f2;
                    border-color: #fca5a5;
                "
            >

                <p class="text-sm font-bold text-red-800">
                    Konfirmasi diperlukan
                </p>

                <p class="mt-1 text-xs leading-6 text-red-700">
                    Masukkan password akun saat ini untuk memastikan bahwa
                    penghapusan dilakukan oleh pemilik akun.
                </p>

            </div>

            {{-- Password --}}
            <div class="mt-6">

                <label
                    for="delete_account_password"
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
                        id="delete_account_password"
                        name="password"
                        :type="showPassword ? 'text' : 'password'"
                        class="input-maloppo pl-11 pr-14"
                        placeholder="Masukkan password untuk konfirmasi"
                        autocomplete="current-password"
                    >

                    <button
                        type="button"
                        class="absolute inset-y-0 right-0 flex items-center px-4 text-gray-500 hover:text-maloppo-red"
                        @click="showPassword = !showPassword"
                        :aria-label="showPassword ? 'Sembunyikan password' : 'Tampilkan password'"
                    >
                        <span x-show="!showPassword">
                            👁️
                        </span>

                        <span
                            x-show="showPassword"
                            x-cloak
                        >
                            🙈
                        </span>
                    </button>

                </div>

                @if ($errors->userDeletion->get('password'))

                    <div class="mt-2 space-y-1">

                        @foreach ($errors->userDeletion->get('password') as $message)

                            <p class="text-sm font-medium text-red-600">
                                {{ $message }}
                            </p>

                        @endforeach

                    </div>

                @endif

            </div>

            {{-- Tombol modal --}}
            <div
                class="mt-7 flex flex-col-reverse gap-3 border-t pt-6 sm:flex-row sm:justify-end"
                style="border-color: #f1e7a4;"
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
                    class="inline-flex items-center justify-center gap-2 rounded-xl px-6 py-3 text-sm font-bold text-white shadow-sm transition hover:opacity-90"
                    style="background-color: #be0000;"
                >
                    <span>🗑️</span>
                    Ya, Hapus Akun
                </button>

            </div>

        </form>

    </x-modal>

</section>