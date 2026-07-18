<x-app-layout>

    <x-slot name="header">

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.20em] text-red-700">
                    Kegiatan Maloppo
                </p>

                <h1 class="mt-2 text-3xl font-bold tracking-tight text-gray-900">
                    Edit Kegiatan
                </h1>

                <p class="mt-2 text-sm leading-6 text-gray-500">
                    Perbarui informasi kegiatan {{ $post->title }}.
                </p>
            </div>

            <a
                href="{{ route('admin.posts.index') }}"
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
                        Perubahan belum dapat disimpan.
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
                action="{{ route('admin.posts.update', $post) }}"
                method="POST"
                enctype="multipart/form-data"
                class="space-y-6"
                x-data="{
                    imagePreview: @js(
                        $post->image
                            ? asset('storage/' . $post->image)
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

                        reader.onload = (event) => {
                            this.imagePreview = event.target.result;
                        };

                        reader.readAsDataURL(file);
                    }
                }"
            >
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

                    {{-- Kolom utama --}}
                    <div class="space-y-6 lg:col-span-2">

                        {{-- Informasi kegiatan --}}
                        <section class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">

                            <div class="border-b border-gray-200 bg-yellow-50 px-6 py-5">

                                <p class="text-sm font-semibold uppercase tracking-[0.20em] text-red-700">
                                    Informasi Kegiatan
                                </p>

                                <h2 class="mt-2 text-2xl font-bold text-gray-900">
                                    Data Kegiatan
                                </h2>

                                <p class="mt-1 text-sm text-gray-600">
                                    Perbarui judul dan ringkasan singkat kegiatan.
                                </p>

                            </div>

                            <div class="space-y-5 p-6">

                                {{-- Judul --}}
                                <div>

                                    <label
                                        for="title"
                                        class="block text-sm font-semibold text-gray-700"
                                    >
                                        Judul Kegiatan
                                        <span class="text-red-700">*</span>
                                    </label>

                                    <input
                                        type="text"
                                        name="title"
                                        id="title"
                                        value="{{ old('title', $post->title) }}"
                                        class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm transition focus:border-red-500 focus:ring-red-500"
                                        placeholder="Masukkan judul kegiatan"
                                        autocomplete="off"
                                        required
                                    >

                                    <p class="mt-1.5 text-xs leading-5 text-gray-500">
                                        Gunakan judul yang singkat dan menggambarkan isi kegiatan.
                                    </p>

                                    @error('title')
                                        <p class="mt-2 text-sm font-medium text-red-700">
                                            {{ $message }}
                                        </p>
                                    @enderror

                                </div>

                                {{-- Ringkasan --}}
                                <div>

                                    <label
                                        for="excerpt"
                                        class="block text-sm font-semibold text-gray-700"
                                    >
                                        Ringkasan Singkat
                                    </label>

                                    <textarea
                                        name="excerpt"
                                        id="excerpt"
                                        rows="4"
                                        class="mt-2 block w-full resize-y rounded-xl border-gray-300 shadow-sm transition focus:border-red-500 focus:ring-red-500"
                                        placeholder="Tuliskan ringkasan singkat mengenai kegiatan"
                                    >{{ old('excerpt', $post->excerpt) }}</textarea>

                                    <p class="mt-1.5 text-xs leading-5 text-gray-500">
                                        Ditampilkan pada kartu kegiatan di halaman publik.
                                    </p>

                                    @error('excerpt')
                                        <p class="mt-2 text-sm font-medium text-red-700">
                                            {{ $message }}
                                        </p>
                                    @enderror

                                </div>

                            </div>

                        </section>

                        {{-- Isi kegiatan --}}
                        <section class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">

                            <div class="border-b border-gray-200 px-6 py-5">

                                <p class="text-sm font-semibold uppercase tracking-[0.20em] text-red-700">
                                    Isi Kegiatan
                                </p>

                                <h2 class="mt-2 text-2xl font-bold text-gray-900">
                                    Berita atau Informasi Kegiatan
                                </h2>

                                <p class="mt-1 text-sm text-gray-500">
                                    Perbarui informasi kegiatan secara lengkap dan berurutan.
                                </p>

                            </div>

                            <div class="p-6">

                                <label
                                    for="content"
                                    class="block text-sm font-semibold text-gray-700"
                                >
                                    Isi Berita atau Kegiatan
                                    <span class="text-red-700">*</span>
                                </label>

                                <textarea
                                    name="content"
                                    id="content"
                                    rows="14"
                                    class="mt-2 block w-full resize-y rounded-xl border-gray-300 shadow-sm transition focus:border-red-500 focus:ring-red-500"
                                    placeholder="Tuliskan waktu, lokasi, peserta, proses pelaksanaan, dan hasil kegiatan..."
                                    required
                                >{{ old('content', $post->content) }}</textarea>

                                <p class="mt-2 text-xs leading-5 text-gray-500">
                                    Susun isi mulai dari latar belakang, waktu dan tempat, pelaksanaan,
                                    hingga hasil kegiatan.
                                </p>

                                @error('content')
                                    <p class="mt-2 text-sm font-medium text-red-700">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                        </section>

                    </div>

                    {{-- Kolom samping --}}
                    <div class="space-y-6">

                        {{-- Gambar utama --}}
                        <section class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">

                            <div class="border-b border-gray-200 px-6 py-5">

                                <h2 class="text-xl font-bold text-gray-900">
                                    Gambar Utama
                                </h2>

                                <p class="mt-1 text-sm text-gray-500">
                                    Ganti gambar utama jika diperlukan.
                                </p>

                            </div>

                            <div class="p-6">

                                <label
                                    for="image"
                                    class="flex min-h-72 cursor-pointer items-center justify-center overflow-hidden rounded-2xl border-2 border-dashed border-gray-300 bg-gray-50 p-5 text-center transition hover:border-red-300 hover:bg-red-50"
                                >
                                    <template x-if="imagePreview">

                                        <div class="w-full">

                                            <img
                                                :src="imagePreview"
                                                alt="Pratinjau gambar kegiatan"
                                                class="mx-auto max-h-64 w-full rounded-2xl object-contain"
                                            >

                                            <p
                                                x-show="imageName"
                                                x-text="imageName"
                                                class="mt-3 truncate text-xs text-gray-600"
                                            ></p>

                                            <p class="mt-2 text-xs font-bold text-red-700">
                                                Klik untuk mengganti gambar
                                            </p>

                                        </div>

                                    </template>

                                    <template x-if="!imagePreview">

                                        <div>

                                            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-red-50 text-2xl">
                                                🖼️
                                            </div>

                                            <p class="mt-4 text-sm font-bold text-gray-800">
                                                Pilih gambar kegiatan
                                            </p>

                                            <p class="mt-1 text-xs leading-5 text-gray-500">
                                                Format JPG, JPEG, PNG, atau WEBP. Maksimal 2 MB.
                                            </p>

                                            <p class="mt-3 text-xs font-semibold text-red-700">
                                                Klik untuk unggah gambar
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

                                <p class="mt-2 text-xs leading-5 text-gray-500">
                                    Kosongkan jika gambar lama tidak ingin diganti.
                                </p>

                                @error('image')
                                    <p class="mt-2 text-sm font-medium text-red-700">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                        </section>

                        {{-- Status publikasi --}}
                        <section class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">

                            <div class="border-b border-gray-200 px-6 py-5">

                                <h2 class="text-xl font-bold text-gray-900">
                                    Status Publikasi
                                </h2>

                                <p class="mt-1 text-sm text-gray-500">
                                    Atur apakah kegiatan tampil di website.
                                </p>

                            </div>

                            <div class="space-y-4 p-6">

                                <input
                                    type="hidden"
                                    name="is_published"
                                    value="0"
                                >

                                <label
                                    for="is_published"
                                    class="flex cursor-pointer items-start justify-between gap-5 rounded-2xl border border-green-100 bg-green-50 p-5"
                                >
                                    <div>

                                        <p class="text-sm font-bold text-gray-900">
                                            Terbitkan di website
                                        </p>

                                        <p class="mt-1 text-xs leading-5 text-gray-600">
                                            Kegiatan yang diterbitkan dapat dilihat oleh pengunjung.
                                        </p>

                                    </div>

                                    <input
                                        type="checkbox"
                                        name="is_published"
                                        id="is_published"
                                        value="1"
                                        class="mt-1 h-5 w-5 shrink-0 rounded border-gray-300 text-red-700 focus:ring-red-200"
                                        {{ old('is_published', $post->is_published) ? 'checked' : '' }}
                                    >

                                </label>

                                <div class="rounded-2xl border border-yellow-200 bg-yellow-50 p-4">

                                    <p class="text-sm font-bold text-gray-800">
                                        Pilihan status
                                    </p>

                                    <div class="mt-3 space-y-3">

                                        <div>
                                            <p class="text-xs font-bold text-green-700">
                                                Diterbitkan
                                            </p>

                                            <p class="mt-1 text-xs leading-5 text-gray-600">
                                                Kegiatan muncul pada halaman publik.
                                            </p>
                                        </div>

                                        <div>
                                            <p class="text-xs font-bold text-gray-700">
                                                Draf
                                            </p>

                                            <p class="mt-1 text-xs leading-5 text-gray-600">
                                                Kegiatan tetap tersimpan, tetapi belum ditampilkan.
                                            </p>
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </section>

                        {{-- Ringkasan kegiatan --}}
                        <section class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">

                            <div class="border-b border-gray-200 px-6 py-5">

                                <h2 class="text-xl font-bold text-gray-900">
                                    Ringkasan
                                </h2>

                                <p class="mt-1 text-sm text-gray-500">
                                    Informasi kegiatan saat ini.
                                </p>

                            </div>

                            <div class="p-6">

                                <dl class="space-y-4">

                                    <div class="flex items-start justify-between gap-4 text-sm">

                                        <dt class="text-gray-500">
                                            Judul
                                        </dt>

                                        <dd class="max-w-56 text-right font-semibold text-gray-900">
                                            {{ $post->title }}
                                        </dd>

                                    </div>

                                    <div class="flex items-start justify-between gap-4 text-sm">

                                        <dt class="text-gray-500">
                                            Status saat ini
                                        </dt>

                                        <dd>
                                            @if ($post->is_published)

                                                <span class="inline-flex rounded-full bg-green-50 px-3 py-1 text-xs font-bold text-green-700">
                                                    Diterbitkan
                                                </span>

                                            @else

                                                <span class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-xs font-bold text-gray-600">
                                                    Draf
                                                </span>

                                            @endif
                                        </dd>

                                    </div>

                                    <div class="flex items-start justify-between gap-4 text-sm">

                                        <dt class="text-gray-500">
                                            Tanggal terbit
                                        </dt>

                                        <dd class="text-right font-semibold text-gray-700">
                                            {{ $post->published_at?->format('d M Y H:i') ?? '-' }}
                                        </dd>

                                    </div>

                                    <div class="flex items-start justify-between gap-4 text-sm">

                                        <dt class="text-gray-500">
                                            Diperbarui
                                        </dt>

                                        <dd class="text-right font-semibold text-gray-700">
                                            {{ $post->updated_at->format('d M Y H:i') }}
                                        </dd>

                                    </div>

                                </dl>

                            </div>

                        </section>

                    </div>

                </div>

                {{-- Tombol tindakan --}}
                <div class="flex flex-col-reverse gap-3 border-t border-gray-200 pt-6 sm:flex-row sm:items-center sm:justify-end">

                    <a
                        href="{{ route('admin.posts.index') }}"
                        class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-5 py-3 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50"
                    >
                        Batal
                    </a>

                    <button
                        type="submit"
                        class="inline-flex items-center justify-center rounded-lg bg-red-700 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-red-800"
                    >
                        Simpan Perubahan
                    </button>

                </div>

            </form>

        </div>

    </div>

</x-app-layout>