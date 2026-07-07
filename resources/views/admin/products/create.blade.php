<x-app-layout>

    <x-slot name="header">

        <div
            class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"
        >
            <div>
                <h1 class="page-title-maloppo">
                    Tambah Produk
                </h1>

                <p class="page-description-maloppo">
                    Masukkan informasi produk baru yang akan ditampilkan pada katalog.
                </p>
            </div>

            <a
                href="{{ route('admin.products.index') }}"
                class="btn-maloppo-secondary"
            >
                Kembali
            </a>
        </div>

    </x-slot>

    <div class="py-6 lg:py-8">

        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">

            {{-- Kesalahan validasi --}}
            @if ($errors->any())

                <div class="alert-maloppo-error mb-5">

                    <p class="font-semibold">
                        Produk belum dapat disimpan.
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
                action="{{ route('admin.products.store') }}"
                method="POST"
                enctype="multipart/form-data"
                class="space-y-5"
                x-data="{
                    imagePreview: null,
                    imageName: '',

                    previewImage(event) {
                        const file = event.target.files[0];

                        if (!file) {
                            this.imagePreview = null;
                            this.imageName = '';
                            return;
                        }

                        this.imageName = file.name;

                        const reader = new FileReader();

                        reader.onload = (e) => {
                            this.imagePreview = e.target.result;
                        };

                        reader.readAsDataURL(file);
                    }
                }"
            >
                @csrf

                {{-- Informasi utama --}}
                <section class="panel-maloppo overflow-hidden">

                    <div class="section-header-maloppo">

                        <h2 class="section-title-maloppo">
                            Informasi Produk
                        </h2>

                        <p class="section-description-maloppo">
                            Isi nama, ukuran, harga, dan jumlah stok produk.
                        </p>

                    </div>

                    <div class="space-y-5 p-5 sm:p-6">

                        {{-- Nama produk --}}
                        <div>

                            <label
                                for="name"
                                class="block text-sm font-medium text-gray-700"
                            >
                                Nama Produk
                                <span class="text-red-700">*</span>
                            </label>

                            <input
                                type="text"
                                name="name"
                                id="name"
                                value="{{ old('name') }}"
                                class="input-maloppo mt-2"
                                placeholder="Contoh: Minyak Kelapa Murni Maloppo"
                                autocomplete="off"
                                required
                            >

                            <p class="mt-1.5 text-xs leading-5 text-gray-500">
                                Gunakan nama produk yang jelas dan mudah dikenali.
                            </p>

                            @error('name')
                                <p class="mt-2 text-sm text-red-700">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                        {{-- Ukuran, harga, dan stok --}}
                        <div class="grid grid-cols-1 gap-5 md:grid-cols-3">

                            <div>

                                <label
                                    for="size"
                                    class="block text-sm font-medium text-gray-700"
                                >
                                    Ukuran
                                </label>

                                <input
                                    type="text"
                                    name="size"
                                    id="size"
                                    value="{{ old('size') }}"
                                    class="input-maloppo mt-2"
                                    placeholder="Contoh: 250 ml"
                                >

                                @error('size')
                                    <p class="mt-2 text-sm text-red-700">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                            <div>

                                <label
                                    for="price"
                                    class="block text-sm font-medium text-gray-700"
                                >
                                    Harga
                                    <span class="text-red-700">*</span>
                                </label>

                                <div class="relative mt-2">

                                    <span
                                        class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-sm text-gray-500"
                                    >
                                        Rp
                                    </span>

                                    <input
                                        type="number"
                                        name="price"
                                        id="price"
                                        value="{{ old('price') }}"
                                        min="0"
                                        step="1"
                                        class="input-maloppo pl-10"
                                        placeholder="30000"
                                        inputmode="numeric"
                                        required
                                    >

                                </div>

                                @error('price')
                                    <p class="mt-2 text-sm text-red-700">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                            <div>

                                <label
                                    for="stock"
                                    class="block text-sm font-medium text-gray-700"
                                >
                                    Stok
                                    <span class="text-red-700">*</span>
                                </label>

                                <input
                                    type="number"
                                    name="stock"
                                    id="stock"
                                    value="{{ old('stock', 0) }}"
                                    min="0"
                                    step="1"
                                    class="input-maloppo mt-2"
                                    placeholder="0"
                                    inputmode="numeric"
                                    required
                                >

                                @error('stock')
                                    <p class="mt-2 text-sm text-red-700">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                        </div>

                    </div>

                </section>

                {{-- Deskripsi --}}
                <section class="panel-maloppo overflow-hidden">

                    <div class="section-header-maloppo">

                        <h2 class="section-title-maloppo">
                            Deskripsi Produk
                        </h2>

                        <p class="section-description-maloppo">
                            Tambahkan informasi yang membantu pelanggan memahami produk.
                        </p>

                    </div>

                    <div class="space-y-5 p-5 sm:p-6">

                        <div>

                            <label
                                for="short_description"
                                class="block text-sm font-medium text-gray-700"
                            >
                                Deskripsi Singkat
                            </label>

                            <textarea
                                name="short_description"
                                id="short_description"
                                rows="3"
                                class="input-maloppo mt-2 resize-y"
                                placeholder="Tuliskan penjelasan singkat produk"
                            >{{ old('short_description') }}</textarea>

                            <p class="mt-1.5 text-xs leading-5 text-gray-500">
                                Ditampilkan pada beranda dan kartu produk di katalog.
                            </p>

                            @error('short_description')
                                <p class="mt-2 text-sm text-red-700">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                        <div>

                            <label
                                for="description"
                                class="block text-sm font-medium text-gray-700"
                            >
                                Deskripsi Lengkap
                            </label>

                            <textarea
                                name="description"
                                id="description"
                                rows="6"
                                class="input-maloppo mt-2 resize-y"
                                placeholder="Jelaskan produk, proses pengolahan, manfaat, penggunaan, dan informasi lainnya"
                            >{{ old('description') }}</textarea>

                            <p class="mt-1.5 text-xs leading-5 text-gray-500">
                                Ditampilkan pada halaman detail produk.
                            </p>

                            @error('description')
                                <p class="mt-2 text-sm text-red-700">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                        <div>

                            <label
                                for="composition"
                                class="block text-sm font-medium text-gray-700"
                            >
                                Komposisi
                            </label>

                            <textarea
                                name="composition"
                                id="composition"
                                rows="3"
                                class="input-maloppo mt-2 resize-y"
                                placeholder="Contoh: 100% minyak kelapa murni"
                            >{{ old('composition') }}</textarea>

                            @error('composition')
                                <p class="mt-2 text-sm text-red-700">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                    </div>

                </section>

                {{-- Gambar dan status --}}
                <section class="panel-maloppo overflow-hidden">

                    <div class="section-header-maloppo">

                        <h2 class="section-title-maloppo">
                            Gambar dan Status
                        </h2>

                        <p class="section-description-maloppo">
                            Unggah gambar produk dan tentukan apakah produk ditampilkan.
                        </p>

                    </div>

                    <div class="grid grid-cols-1 gap-6 p-5 sm:p-6 md:grid-cols-2">

                        {{-- Upload gambar --}}
                        <div>

                            <label
                                for="image"
                                class="block text-sm font-medium text-gray-700"
                            >
                                Gambar Produk
                            </label>

                            <label
                                for="image"
                                class="mt-2 flex min-h-52 cursor-pointer items-center justify-center overflow-hidden rounded-lg border border-dashed border-gray-300 bg-gray-50 p-5 text-center transition hover:border-gray-400 hover:bg-gray-100"
                            >
                                <template x-if="!imagePreview">

                                    <div>
                                        <svg
                                            class="mx-auto h-9 w-9 text-gray-400"
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke-width="1.5"
                                            stroke="currentColor"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M3 16.5V6.75A2.25 2.25 0 015.25 4.5h13.5A2.25 2.25 0 0121 6.75v9.75m-18 0v.75a2.25 2.25 0 002.25 2.25h13.5A2.25 2.25 0 0021 17.25v-.75M3 16.5l4.72-4.72a2.25 2.25 0 013.182 0l1.348 1.348m0 0l2.098-2.098a2.25 2.25 0 013.182 0L21 14.25M14.25 8.25h.008v.008h-.008V8.25z"
                                            />
                                        </svg>

                                        <p class="mt-3 text-sm font-medium text-gray-700">
                                            Pilih gambar produk
                                        </p>

                                        <p class="mt-1 text-xs leading-5 text-gray-500">
                                            JPG, JPEG, PNG, atau WEBP.
                                        </p>
                                    </div>

                                </template>

                                <template x-if="imagePreview">

                                    <div class="w-full">

                                        <img
                                            :src="imagePreview"
                                            alt="Pratinjau gambar produk"
                                            class="mx-auto max-h-52 w-full rounded-lg object-contain"
                                        >

                                        <p
                                            class="mt-3 truncate text-xs text-gray-600"
                                            x-text="imageName"
                                        ></p>

                                        <p class="mt-1 text-xs font-medium text-red-700">
                                            Klik untuk mengganti gambar
                                        </p>

                                    </div>

                                </template>

                            </label>

                            <input
                                type="file"
                                name="image"
                                id="image"
                                accept=".jpg,.jpeg,.png,.webp"
                                class="sr-only"
                                @change="previewImage($event)"
                            >

                            @error('image')
                                <p class="mt-2 text-sm text-red-700">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                        {{-- Status produk --}}
                        <div>

                            <p class="text-sm font-medium text-gray-700">
                                Status Produk
                            </p>

                            <div class="mt-2 rounded-lg border border-gray-200 bg-gray-50 p-4">

                                <label
                                    for="is_active"
                                    class="flex cursor-pointer items-start justify-between gap-5"
                                >
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">
                                            Tampilkan di katalog
                                        </p>

                                        <p class="mt-1 text-xs leading-5 text-gray-500">
                                            Produk aktif dapat dilihat dan dipesan oleh pelanggan.
                                        </p>
                                    </div>

                                    <input
                                        type="checkbox"
                                        name="is_active"
                                        id="is_active"
                                        value="1"
                                        class="mt-1 h-5 w-5 shrink-0 rounded border-gray-300 text-red-700 focus:ring-red-200"
                                        {{ old('is_active', true) ? 'checked' : '' }}
                                    >
                                </label>

                            </div>

                            <div class="mt-4 rounded-lg border border-gray-200 p-4">

                                <p class="text-xs leading-5 text-gray-500">
                                    Produk yang tidak aktif tetap tersimpan di sistem dan
                                    dapat diaktifkan kembali melalui halaman edit.
                                </p>

                            </div>

                        </div>

                    </div>

                </section>

                {{-- Tombol tindakan --}}
                <div
                    class="flex flex-col-reverse gap-3 border-t border-gray-200 pt-5 sm:flex-row sm:items-center sm:justify-end"
                >
                    <a
                        href="{{ route('admin.products.index') }}"
                        class="btn-maloppo-secondary"
                    >
                        Batal
                    </a>

                    <button
                        type="submit"
                        class="btn-maloppo-primary"
                    >
                        Simpan Produk
                    </button>
                </div>

            </form>

        </div>

    </div>

</x-app-layout>