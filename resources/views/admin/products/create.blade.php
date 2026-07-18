<x-app-layout>

    <x-slot name="header">

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.20em] text-red-700">
                    Produk Maloppo
                </p>

                <h1 class="mt-2 text-3xl font-bold tracking-tight text-gray-900">
                    Tambah Produk
                </h1>

                <p class="mt-2 text-sm leading-6 text-gray-500">
                    Masukkan informasi produk baru yang akan ditampilkan pada katalog pelanggan.
                </p>
            </div>

            <a
                href="{{ route('admin.products.index') }}"
                class="inline-flex items-center justify-center rounded-lg border border-red-200 bg-white px-5 py-3 text-sm font-semibold text-red-700 shadow-sm transition hover:bg-red-50"
            >
                Kembali
            </a>

        </div>

    </x-slot>

    <div class="py-8">

        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">

            {{-- Kesalahan validasi --}}
            @if ($errors->any())

                <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-800 shadow-sm">

                    <p class="font-bold">
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
                class="space-y-6"
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

                <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

                    {{-- Kolom utama --}}
                    <div class="space-y-6 lg:col-span-2">

                        {{-- Informasi utama --}}
                        <section class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">

                            <div class="border-b border-gray-200 bg-yellow-50 px-6 py-5">

                                <p class="text-sm font-semibold uppercase tracking-[0.20em] text-red-700">
                                    Informasi Utama
                                </p>

                                <h2 class="mt-2 text-2xl font-bold text-gray-900">
                                    Data Produk
                                </h2>

                                <p class="mt-1 text-sm text-gray-600">
                                    Isi nama, ukuran, harga, dan jumlah stok produk.
                                </p>

                            </div>

                            <div class="space-y-5 p-6">

                                {{-- Nama produk --}}
                                <div>

                                    <label
                                        for="name"
                                        class="block text-sm font-semibold text-gray-700"
                                    >
                                        Nama Produk
                                        <span class="text-red-700">*</span>
                                    </label>

                                    <input
                                        type="text"
                                        name="name"
                                        id="name"
                                        value="{{ old('name') }}"
                                        class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm transition focus:border-red-500 focus:ring-red-500"
                                        placeholder="Contoh: Minyak Kelapa Murni Maloppo"
                                        autocomplete="off"
                                        required
                                    >

                                    <p class="mt-1.5 text-xs leading-5 text-gray-500">
                                        Gunakan nama produk yang jelas dan mudah dikenali pelanggan.
                                    </p>

                                    @error('name')
                                        <p class="mt-2 text-sm font-medium text-red-700">
                                            {{ $message }}
                                        </p>
                                    @enderror

                                </div>

                                {{-- Ukuran, harga, stok --}}
                                <div class="grid grid-cols-1 gap-5 md:grid-cols-3">

                                    <div>

                                        <label
                                            for="size"
                                            class="block text-sm font-semibold text-gray-700"
                                        >
                                            Ukuran
                                        </label>

                                        <input
                                            type="text"
                                            name="size"
                                            id="size"
                                            value="{{ old('size') }}"
                                            class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm transition focus:border-red-500 focus:ring-red-500"
                                            placeholder="Contoh: 250 ml"
                                        >

                                        @error('size')
                                            <p class="mt-2 text-sm font-medium text-red-700">
                                                {{ $message }}
                                            </p>
                                        @enderror

                                    </div>

                                    <div>

                                        <label
                                            for="price"
                                            class="block text-sm font-semibold text-gray-700"
                                        >
                                            Harga
                                            <span class="text-red-700">*</span>
                                        </label>

                                        <div class="relative mt-2">

                                            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-sm font-semibold text-gray-500">
                                                Rp
                                            </span>

                                            <input
                                                type="number"
                                                name="price"
                                                id="price"
                                                value="{{ old('price') }}"
                                                min="0"
                                                step="1"
                                                class="block w-full rounded-xl border-gray-300 pl-11 shadow-sm transition focus:border-red-500 focus:ring-red-500"
                                                placeholder="30000"
                                                inputmode="numeric"
                                                required
                                            >

                                        </div>

                                        @error('price')
                                            <p class="mt-2 text-sm font-medium text-red-700">
                                                {{ $message }}
                                            </p>
                                        @enderror

                                    </div>

                                    <div>

                                        <label
                                            for="stock"
                                            class="block text-sm font-semibold text-gray-700"
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
                                            class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm transition focus:border-red-500 focus:ring-red-500"
                                            placeholder="0"
                                            inputmode="numeric"
                                            required
                                        >

                                        @error('stock')
                                            <p class="mt-2 text-sm font-medium text-red-700">
                                                {{ $message }}
                                            </p>
                                        @enderror

                                    </div>

                                </div>

                            </div>

                        </section>

                        {{-- Deskripsi --}}
                        <section class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">

                            <div class="border-b border-gray-200 px-6 py-5">

                                <p class="text-sm font-semibold uppercase tracking-[0.20em] text-red-700">
                                    Deskripsi
                                </p>

                                <h2 class="mt-2 text-2xl font-bold text-gray-900">
                                    Keterangan Produk
                                </h2>

                                <p class="mt-1 text-sm text-gray-500">
                                    Tambahkan informasi agar pelanggan lebih memahami produk.
                                </p>

                            </div>

                            <div class="space-y-5 p-6">

                                <div>

                                    <label
                                        for="short_description"
                                        class="block text-sm font-semibold text-gray-700"
                                    >
                                        Deskripsi Singkat
                                    </label>

                                    <textarea
                                        name="short_description"
                                        id="short_description"
                                        rows="3"
                                        class="mt-2 block w-full resize-y rounded-xl border-gray-300 shadow-sm transition focus:border-red-500 focus:ring-red-500"
                                        placeholder="Tuliskan penjelasan singkat produk"
                                    >{{ old('short_description') }}</textarea>

                                    <p class="mt-1.5 text-xs leading-5 text-gray-500">
                                        Ditampilkan pada kartu produk di beranda dan katalog.
                                    </p>

                                    @error('short_description')
                                        <p class="mt-2 text-sm font-medium text-red-700">
                                            {{ $message }}
                                        </p>
                                    @enderror

                                </div>

                                <div>

                                    <label
                                        for="description"
                                        class="block text-sm font-semibold text-gray-700"
                                    >
                                        Deskripsi Lengkap
                                    </label>

                                    <textarea
                                        name="description"
                                        id="description"
                                        rows="6"
                                        class="mt-2 block w-full resize-y rounded-xl border-gray-300 shadow-sm transition focus:border-red-500 focus:ring-red-500"
                                        placeholder="Jelaskan produk, proses pengolahan, manfaat, penggunaan, dan informasi lainnya"
                                    >{{ old('description') }}</textarea>

                                    <p class="mt-1.5 text-xs leading-5 text-gray-500">
                                        Ditampilkan pada halaman detail produk.
                                    </p>

                                    @error('description')
                                        <p class="mt-2 text-sm font-medium text-red-700">
                                            {{ $message }}
                                        </p>
                                    @enderror

                                </div>

                                <div>

                                    <label
                                        for="composition"
                                        class="block text-sm font-semibold text-gray-700"
                                    >
                                        Komposisi
                                    </label>

                                    <textarea
                                        name="composition"
                                        id="composition"
                                        rows="3"
                                        class="mt-2 block w-full resize-y rounded-xl border-gray-300 shadow-sm transition focus:border-red-500 focus:ring-red-500"
                                        placeholder="Contoh: 100% minyak kelapa murni"
                                    >{{ old('composition') }}</textarea>

                                    @error('composition')
                                        <p class="mt-2 text-sm font-medium text-red-700">
                                            {{ $message }}
                                        </p>
                                    @enderror

                                </div>

                            </div>

                        </section>

                    </div>

                    {{-- Kolom samping --}}
                    <div class="space-y-6">

                        {{-- Upload gambar --}}
                        <section class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">

                            <div class="border-b border-gray-200 px-6 py-5">

                                <h2 class="text-xl font-bold text-gray-900">
                                    Gambar Produk
                                </h2>

                                <p class="mt-1 text-sm text-gray-500">
                                    Unggah gambar produk yang jelas.
                                </p>

                            </div>

                            <div class="p-6">

                                <label
                                    for="image"
                                    class="flex min-h-72 cursor-pointer items-center justify-center overflow-hidden rounded-2xl border-2 border-dashed border-gray-300 bg-gray-50 p-5 text-center transition hover:border-red-300 hover:bg-red-50"
                                >
                                    <template x-if="!imagePreview">

                                        <div>
                                            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-red-50 text-2xl">
                                                🖼️
                                            </div>

                                            <p class="mt-4 text-sm font-bold text-gray-800">
                                                Pilih gambar produk
                                            </p>

                                            <p class="mt-1 text-xs leading-5 text-gray-500">
                                                Format JPG, JPEG, PNG, atau WEBP.
                                            </p>

                                            <p class="mt-3 text-xs font-semibold text-red-700">
                                                Klik untuk unggah gambar
                                            </p>
                                        </div>

                                    </template>

                                    <template x-if="imagePreview">

                                        <div class="w-full">

                                            <img
                                                :src="imagePreview"
                                                alt="Pratinjau gambar produk"
                                                class="mx-auto max-h-64 w-full rounded-2xl object-contain"
                                            >

                                            <p
                                                class="mt-3 truncate text-xs text-gray-600"
                                                x-text="imageName"
                                            ></p>

                                            <p class="mt-1 text-xs font-bold text-red-700">
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
                                    <p class="mt-2 text-sm font-medium text-red-700">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                        </section>

                        {{-- Status produk --}}
                        <section class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">

                            <div class="border-b border-gray-200 px-6 py-5">

                                <h2 class="text-xl font-bold text-gray-900">
                                    Status Produk
                                </h2>

                                <p class="mt-1 text-sm text-gray-500">
                                    Atur apakah produk tampil di katalog.
                                </p>

                            </div>

                            <div class="space-y-4 p-6">

                                <label
                                    for="is_active"
                                    class="flex cursor-pointer items-start justify-between gap-5 rounded-2xl border border-green-100 bg-green-50 p-5"
                                >
                                    <div>
                                        <p class="text-sm font-bold text-gray-900">
                                            Tampilkan di katalog
                                        </p>

                                        <p class="mt-1 text-xs leading-5 text-gray-600">
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

                                <div class="rounded-2xl border border-yellow-200 bg-yellow-50 p-4">

                                    <p class="text-xs leading-5 text-gray-600">
                                        Produk yang tidak aktif tetap tersimpan di sistem dan
                                        dapat diaktifkan kembali melalui halaman edit produk.
                                    </p>

                                </div>

                            </div>

                        </section>

                    </div>

                </div>

                {{-- Tombol tindakan --}}
                <div class="flex flex-col-reverse gap-3 border-t border-gray-200 pt-6 sm:flex-row sm:items-center sm:justify-end">

                    <a
                        href="{{ route('admin.products.index') }}"
                        class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-5 py-3 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50"
                    >
                        Batal
                    </a>

                    <button
                        type="submit"
                        class="inline-flex items-center justify-center rounded-lg bg-red-700 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-red-800"
                    >
                        Simpan Produk
                    </button>

                </div>

            </form>

        </div>

    </div>

</x-app-layout>