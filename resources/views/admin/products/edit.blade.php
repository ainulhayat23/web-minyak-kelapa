<x-app-layout>

    <x-slot name="header">

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h1 class="text-2xl font-extrabold leading-tight text-gray-900">
                    Edit Produk
                </h1>

                <p class="mt-2 text-sm font-normal text-gray-600">
                    Perbarui informasi produk {{ $product->name }}.
                </p>
            </div>

            <a
                href="{{ route('admin.products.index') }}"
                class="btn-maloppo-secondary"
            >
                <span aria-hidden="true">←</span>
                Kembali ke Data Produk
            </a>

        </div>

    </x-slot>

    <div class="py-8 lg:py-10">

        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">

            {{-- Kesalahan validasi --}}
            @if ($errors->any())

                <div class="alert-maloppo-error mb-7">

                    <div class="flex items-start gap-3">

                        <div
                            class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full font-bold"
                            style="
                                background-color: #fecaca;
                                color: #991b1b;
                            "
                        >
                            !
                        </div>

                        <div>

                            <p class="font-bold">
                                Perubahan belum dapat disimpan
                            </p>

                            <p class="mt-1 text-sm">
                                Periksa kembali data berikut:
                            </p>

                            <ul class="mt-2 list-inside list-disc space-y-1 text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>
                                        {{ $error }}
                                    </li>
                                @endforeach
                            </ul>

                        </div>

                    </div>

                </div>

            @endif

            <form
                action="{{ route('admin.products.update', $product) }}"
                method="POST"
                enctype="multipart/form-data"
                class="space-y-7"
                x-data="{
                    imagePreview: @js(
                        $product->image
                            ? asset('storage/' . $product->image)
                            : null
                    ),
                    imageName: '',

                    previewImage(event) {
                        const file = event.target.files[0];

                        if (!file) {
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
                @method('PUT')

                {{-- Informasi dasar --}}
                <section class="card-maloppo overflow-hidden">

                    <div
                        class="border-b px-6 py-5 md:px-8"
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
                                🥥
                            </div>

                            <div>
                                <h2 class="text-xl font-extrabold text-gray-900">
                                    Informasi Dasar Produk
                                </h2>

                                <p class="mt-1 text-sm text-gray-500">
                                    Ubah nama, ukuran, harga, dan jumlah stok produk.
                                </p>
                            </div>

                        </div>

                    </div>

                    <div class="space-y-6 p-6 md:p-8">

                        {{-- Nama produk --}}
                        <div>

                            <label
                                for="name"
                                class="block text-sm font-bold text-gray-700"
                            >
                                Nama Produk
                                <span style="color: #be0000;">*</span>
                            </label>

                            <div class="relative mt-2">

                                <div
                                    class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400"
                                >
                                    🏷️
                                </div>

                                <input
                                    type="text"
                                    name="name"
                                    id="name"
                                    value="{{ old('name', $product->name) }}"
                                    class="input-maloppo pl-11"
                                    placeholder="Masukkan nama produk"
                                    autocomplete="off"
                                    required
                                >

                            </div>

                            <p class="mt-2 text-xs leading-5 text-gray-500">
                                Gunakan nama produk yang jelas dan mudah dikenali pelanggan.
                            </p>

                            @error('name')
                                <p class="mt-2 text-sm font-medium text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                        {{-- Ukuran, harga, dan stok --}}
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">

                            {{-- Ukuran --}}
                            <div>

                                <label
                                    for="size"
                                    class="block text-sm font-bold text-gray-700"
                                >
                                    Ukuran
                                </label>

                                <div class="relative mt-2">

                                    <div
                                        class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400"
                                    >
                                        📏
                                    </div>

                                    <input
                                        type="text"
                                        name="size"
                                        id="size"
                                        value="{{ old('size', $product->size) }}"
                                        class="input-maloppo pl-11"
                                        placeholder="Contoh: 250 ml"
                                    >

                                </div>

                                @error('size')
                                    <p class="mt-2 text-sm font-medium text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                            {{-- Harga --}}
                            <div>

                                <label
                                    for="price"
                                    class="block text-sm font-bold text-gray-700"
                                >
                                    Harga
                                    <span style="color: #be0000;">*</span>
                                </label>

                                <div class="relative mt-2">

                                    <div
                                        class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-sm font-bold text-gray-500"
                                    >
                                        Rp
                                    </div>

                                    <input
                                        type="number"
                                        name="price"
                                        id="price"
                                        value="{{ old('price', $product->price) }}"
                                        min="0"
                                        step="1"
                                        class="input-maloppo pl-12"
                                        placeholder="30000"
                                        inputmode="numeric"
                                        required
                                    >

                                </div>

                                @error('price')
                                    <p class="mt-2 text-sm font-medium text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                            {{-- Stok --}}
                            <div>

                                <label
                                    for="stock"
                                    class="block text-sm font-bold text-gray-700"
                                >
                                    Stok
                                    <span style="color: #be0000;">*</span>
                                </label>

                                <div class="relative mt-2">

                                    <div
                                        class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400"
                                    >
                                        📦
                                    </div>

                                    <input
                                        type="number"
                                        name="stock"
                                        id="stock"
                                        value="{{ old('stock', $product->stock) }}"
                                        min="0"
                                        step="1"
                                        class="input-maloppo pl-11"
                                        placeholder="0"
                                        inputmode="numeric"
                                        required
                                    >

                                </div>

                                @error('stock')
                                    <p class="mt-2 text-sm font-medium text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                        </div>

                    </div>

                </section>

                {{-- Deskripsi produk --}}
                <section class="card-maloppo overflow-hidden">

                    <div
                        class="border-b px-6 py-5 md:px-8"
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
                                📝
                            </div>

                            <div>
                                <h2 class="text-xl font-extrabold text-gray-900">
                                    Deskripsi Produk
                                </h2>

                                <p class="mt-1 text-sm text-gray-500">
                                    Perbarui informasi yang dibaca pelanggan.
                                </p>
                            </div>

                        </div>

                    </div>

                    <div class="space-y-6 p-6 md:p-8">

                        {{-- Deskripsi singkat --}}
                        <div>

                            <label
                                for="short_description"
                                class="block text-sm font-bold text-gray-700"
                            >
                                Deskripsi Singkat
                            </label>

                            <textarea
                                name="short_description"
                                id="short_description"
                                rows="3"
                                class="input-maloppo resize-y"
                                placeholder="Tuliskan penjelasan singkat produk"
                            >{{ old('short_description', $product->short_description) }}</textarea>

                            <p class="mt-2 text-xs leading-5 text-gray-500">
                                Ditampilkan pada kartu produk di beranda dan katalog.
                            </p>

                            @error('short_description')
                                <p class="mt-2 text-sm font-medium text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                        {{-- Deskripsi lengkap --}}
                        <div>

                            <label
                                for="description"
                                class="block text-sm font-bold text-gray-700"
                            >
                                Deskripsi Lengkap
                            </label>

                            <textarea
                                name="description"
                                id="description"
                                rows="6"
                                class="input-maloppo resize-y"
                                placeholder="Jelaskan produk secara lengkap"
                            >{{ old('description', $product->description) }}</textarea>

                            <p class="mt-2 text-xs leading-5 text-gray-500">
                                Ditampilkan pada halaman detail produk.
                            </p>

                            @error('description')
                                <p class="mt-2 text-sm font-medium text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                        {{-- Komposisi --}}
                        <div>

                            <label
                                for="composition"
                                class="block text-sm font-bold text-gray-700"
                            >
                                Komposisi
                            </label>

                            <textarea
                                name="composition"
                                id="composition"
                                rows="3"
                                class="input-maloppo resize-y"
                                placeholder="Contoh: 100% minyak kelapa murni"
                            >{{ old('composition', $product->composition) }}</textarea>

                            @error('composition')
                                <p class="mt-2 text-sm font-medium text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                    </div>

                </section>

                {{-- Gambar dan status --}}
                <section class="card-maloppo overflow-hidden">

                    <div
                        class="border-b px-6 py-5 md:px-8"
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
                                🖼️
                            </div>

                            <div>
                                <h2 class="text-xl font-extrabold text-gray-900">
                                    Gambar dan Status
                                </h2>

                                <p class="mt-1 text-sm text-gray-500">
                                    Ganti gambar atau ubah status tampil produk.
                                </p>
                            </div>

                        </div>

                    </div>

                    <div class="p-6 md:p-8">

                        <div class="grid grid-cols-1 gap-7 md:grid-cols-2">

                            {{-- Gambar produk --}}
                            <div>

                                <label
                                    for="image"
                                    class="block text-sm font-bold text-gray-700"
                                >
                                    Gambar Produk
                                </label>

                                <label
                                    for="image"
                                    class="mt-2 flex min-h-72 cursor-pointer flex-col items-center justify-center overflow-hidden rounded-2xl border-2 border-dashed p-5 text-center transition hover:bg-yellow-50"
                                    style="
                                        background-color: #fffdf0;
                                        border-color: #f7e900;
                                    "
                                >

                                    <template x-if="imagePreview">

                                        <div class="w-full">

                                            <img
                                                :src="imagePreview"
                                                alt="Pratinjau gambar produk"
                                                class="mx-auto max-h-60 w-full rounded-xl object-contain"
                                            >

                                            <p
                                                x-show="imageName"
                                                x-text="imageName"
                                                class="mt-3 truncate text-xs font-medium text-gray-600"
                                            ></p>

                                            <p class="mt-2 text-xs font-bold text-maloppo-red">
                                                Klik untuk mengganti gambar
                                            </p>

                                        </div>

                                    </template>

                                    <template x-if="!imagePreview">

                                        <div>

                                            <div
                                                class="mx-auto flex h-16 w-16 items-center justify-center rounded-full text-3xl"
                                                style="background-color: #fff9b0;"
                                            >
                                                📷
                                            </div>

                                            <p class="mt-4 font-bold text-gray-800">
                                                Belum ada gambar produk
                                            </p>

                                            <p class="mt-2 text-xs leading-5 text-gray-500">
                                                Klik untuk memilih gambar dari perangkat.
                                            </p>

                                            <span
                                                class="mt-4 inline-flex rounded-lg px-4 py-2 text-xs font-bold"
                                                style="
                                                    background-color: #be0000;
                                                    color: white;
                                                "
                                            >
                                                Pilih Gambar
                                            </span>

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

                                <p class="mt-3 text-xs leading-5 text-gray-500">
                                    Kosongkan jika gambar lama tidak ingin diganti.
                                    Format: JPG, JPEG, PNG, atau WEBP.
                                </p>

                                @error('image')
                                    <p class="mt-2 text-sm font-medium text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                            {{-- Status produk --}}
                            <div>

                                <p class="text-sm font-bold text-gray-700">
                                    Status Produk
                                </p>

                                <div
                                    class="mt-2 rounded-2xl border p-6"
                                    style="
                                        background-color: #fff9b0;
                                        border-color: #f7e900;
                                    "
                                >

                                    <div class="flex items-start gap-4">

                                        <div
                                            class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl text-xl"
                                            style="
                                                background-color: #be0000;
                                                color: white;
                                            "
                                        >
                                            🌐
                                        </div>

                                        <div>

                                            <h3 class="font-bold text-gray-900">
                                                Tampilkan di Website
                                            </h3>

                                            <p class="mt-2 text-sm leading-6 text-gray-600">
                                                Produk aktif akan ditampilkan pada katalog
                                                dan dapat dilihat pelanggan.
                                            </p>

                                        </div>

                                    </div>

                                    {{-- Nilai 0 dikirim jika checkbox tidak dicentang --}}
                                    <input
                                        type="hidden"
                                        name="is_active"
                                        value="0"
                                    >

                                    <label
                                        for="is_active"
                                        class="mt-6 flex cursor-pointer items-center justify-between gap-4 rounded-xl bg-white p-4"
                                    >

                                        <div>

                                            <p class="text-sm font-bold text-gray-800">
                                                Aktifkan produk
                                            </p>

                                            <p class="mt-1 text-xs text-gray-500">
                                                Centang agar produk tampil pada website.
                                            </p>

                                        </div>

                                        <input
                                            type="checkbox"
                                            name="is_active"
                                            id="is_active"
                                            value="1"
                                            class="h-5 w-5 rounded border-gray-300 shadow-sm"
                                            style="color: #be0000;"
                                            {{ old('is_active', $product->active) ? 'checked' : '' }}
                                        >

                                    </label>

                                </div>

                                {{-- Ringkasan produk --}}
                                <div
                                    class="mt-5 rounded-2xl border p-5"
                                    style="
                                        background-color: #fffdf0;
                                        border-color: #f1e7a4;
                                    "
                                >

                                    <p class="text-xs font-bold uppercase tracking-wider text-gray-500">
                                        Ringkasan Produk
                                    </p>

                                    <div class="mt-4 space-y-3">

                                        <div class="flex items-center justify-between gap-4 text-sm">

                                            <span class="text-gray-500">
                                                Nama
                                            </span>

                                            <span class="text-right font-bold text-gray-800">
                                                {{ $product->name }}
                                            </span>

                                        </div>

                                        <div class="flex items-center justify-between gap-4 text-sm">

                                            <span class="text-gray-500">
                                                Harga
                                            </span>

                                            <span class="font-bold text-maloppo-red">
                                                Rp {{ number_format($product->price, 0, ',', '.') }}
                                            </span>

                                        </div>

                                        <div class="flex items-center justify-between gap-4 text-sm">

                                            <span class="text-gray-500">
                                                Stok saat ini
                                            </span>

                                            <span class="font-bold text-gray-800">
                                                {{ $product->stock }}
                                            </span>

                                        </div>

                                        <div class="flex items-center justify-between gap-4 text-sm">

                                            <span class="text-gray-500">
                                                Terakhir diperbarui
                                            </span>

                                            <span class="text-right font-medium text-gray-700">
                                                {{ $product->updated_at->format('d M Y') }}
                                            </span>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </section>

                {{-- Tombol tindakan --}}
                <section class="card-maloppo p-5 md:p-6">

                    <div
                        class="flex flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-between"
                    >

                        <a
                            href="{{ route('admin.products.index') }}"
                            class="btn-maloppo-secondary"
                        >
                            <span aria-hidden="true">←</span>
                            Batal dan Kembali
                        </a>

                        <button
                            type="submit"
                            class="btn-maloppo-primary px-8 py-4 text-base"
                        >
                            <span>💾</span>
                            Perbarui Produk
                        </button>

                    </div>

                </section>

            </form>

        </div>

    </div>

</x-app-layout>