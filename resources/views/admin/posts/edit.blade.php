<x-app-layout>

    <x-slot name="header">

        <div
            class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"
        >
            <div>
                <h1 class="page-title-maloppo">
                    Edit Kegiatan
                </h1>

                <p class="page-description-maloppo">
                    Perbarui informasi kegiatan {{ $post->title }}.
                </p>
            </div>

            <a
                href="{{ route('admin.posts.index') }}"
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
                class="space-y-5"
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

                {{-- Informasi kegiatan --}}
                <section class="panel-maloppo overflow-hidden">

                    <div class="section-header-maloppo">

                        <h2 class="section-title-maloppo">
                            Informasi Kegiatan
                        </h2>

                        <p class="section-description-maloppo">
                            Perbarui judul dan ringkasan singkat kegiatan.
                        </p>

                    </div>

                    <div class="space-y-5 p-5 sm:p-6">

                        {{-- Judul --}}
                        <div>

                            <label
                                for="title"
                                class="block text-sm font-medium text-gray-700"
                            >
                                Judul Kegiatan
                                <span class="text-red-700">*</span>
                            </label>

                            <input
                                type="text"
                                name="title"
                                id="title"
                                value="{{ old('title', $post->title) }}"
                                class="input-maloppo mt-2"
                                placeholder="Masukkan judul kegiatan"
                                autocomplete="off"
                                required
                            >

                            <p class="mt-1.5 text-xs leading-5 text-gray-500">
                                Gunakan judul yang singkat dan menggambarkan isi kegiatan.
                            </p>

                            @error('title')
                                <p class="mt-2 text-sm text-red-700">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                        {{-- Ringkasan --}}
                        <div>

                            <label
                                for="excerpt"
                                class="block text-sm font-medium text-gray-700"
                            >
                                Ringkasan Singkat
                            </label>

                            <textarea
                                name="excerpt"
                                id="excerpt"
                                rows="4"
                                class="input-maloppo mt-2 resize-y"
                                placeholder="Tuliskan ringkasan singkat mengenai kegiatan"
                            >{{ old('excerpt', $post->excerpt) }}</textarea>

                            <p class="mt-1.5 text-xs leading-5 text-gray-500">
                                Ditampilkan pada kartu kegiatan di halaman publik.
                            </p>

                            @error('excerpt')
                                <p class="mt-2 text-sm text-red-700">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                    </div>

                </section>

                {{-- Isi kegiatan --}}
                <section class="panel-maloppo overflow-hidden">

                    <div class="section-header-maloppo">

                        <h2 class="section-title-maloppo">
                            Isi Kegiatan
                        </h2>

                        <p class="section-description-maloppo">
                            Perbarui informasi kegiatan secara lengkap dan berurutan.
                        </p>

                    </div>

                    <div class="p-5 sm:p-6">

                        <label
                            for="content"
                            class="block text-sm font-medium text-gray-700"
                        >
                            Isi Berita atau Kegiatan
                            <span class="text-red-700">*</span>
                        </label>

                        <textarea
                            name="content"
                            id="content"
                            rows="12"
                            class="input-maloppo mt-2 resize-y"
                            placeholder="Tuliskan waktu, lokasi, peserta, proses pelaksanaan, dan hasil kegiatan..."
                            required
                        >{{ old('content', $post->content) }}</textarea>

                        <p class="mt-2 text-xs leading-5 text-gray-500">
                            Susun isi mulai dari latar belakang, waktu dan tempat,
                            pelaksanaan, hingga hasil kegiatan.
                        </p>

                        @error('content')
                            <p class="mt-2 text-sm text-red-700">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                </section>

                {{-- Gambar dan publikasi --}}
                <section class="panel-maloppo overflow-hidden">

                    <div class="section-header-maloppo">

                        <h2 class="section-title-maloppo">
                            Gambar dan Publikasi
                        </h2>

                        <p class="section-description-maloppo">
                            Ganti gambar utama atau ubah status penerbitan kegiatan.
                        </p>

                    </div>

                    <div class="grid grid-cols-1 gap-6 p-5 sm:p-6 md:grid-cols-2">

                        {{-- Gambar utama --}}
                        <div>

                            <label
                                for="image"
                                class="block text-sm font-medium text-gray-700"
                            >
                                Gambar Utama
                            </label>

                            <label
                                for="image"
                                class="mt-2 flex min-h-52 cursor-pointer items-center justify-center overflow-hidden rounded-lg border border-dashed border-gray-300 bg-gray-50 p-5 text-center transition hover:border-gray-400 hover:bg-gray-100"
                            >

                                <template x-if="imagePreview">

                                    <div class="w-full">

                                        <img
                                            :src="imagePreview"
                                            alt="Pratinjau gambar kegiatan"
                                            class="mx-auto max-h-52 w-full rounded-lg object-contain"
                                        >

                                        <p
                                            x-show="imageName"
                                            x-text="imageName"
                                            class="mt-3 truncate text-xs text-gray-600"
                                        ></p>

                                        <p class="mt-1 text-xs font-medium text-red-700">
                                            Klik untuk mengganti gambar
                                        </p>

                                    </div>

                                </template>

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
                                            Pilih gambar kegiatan
                                        </p>

                                        <p class="mt-1 text-xs leading-5 text-gray-500">
                                            JPG, JPEG, PNG, atau WEBP. Maksimal 2 MB.
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
                                <p class="mt-2 text-sm text-red-700">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                        {{-- Status dan ringkasan --}}
                        <div class="space-y-4">

                            <div>

                                <p class="text-sm font-medium text-gray-700">
                                    Status Publikasi
                                </p>

                                <div class="mt-2 rounded-lg border border-gray-200 bg-gray-50 p-4">

                                    <input
                                        type="hidden"
                                        name="is_published"
                                        value="0"
                                    >

                                    <label
                                        for="is_published"
                                        class="flex cursor-pointer items-start justify-between gap-5"
                                    >
                                        <div>

                                            <p class="text-sm font-medium text-gray-900">
                                                Terbitkan di website
                                            </p>

                                            <p class="mt-1 text-xs leading-5 text-gray-500">
                                                Kegiatan yang diterbitkan dapat dilihat pengunjung.
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

                                </div>

                            </div>

                            {{-- Ringkasan kegiatan --}}
                            <div class="rounded-lg border border-gray-200 p-4">

                                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                                    Ringkasan Kegiatan
                                </p>

                                <dl class="mt-4 space-y-3">

                                    <div class="flex items-start justify-between gap-4 text-sm">

                                        <dt class="text-gray-500">
                                            Judul
                                        </dt>

                                        <dd class="max-w-56 text-right font-medium text-gray-900">
                                            {{ $post->title }}
                                        </dd>

                                    </div>

                                    <div class="flex items-start justify-between gap-4 text-sm">

                                        <dt class="text-gray-500">
                                            Status saat ini
                                        </dt>

                                        <dd>

                                            @if ($post->is_published)

                                                <span
                                                    class="inline-flex rounded-full bg-green-50 px-2.5 py-1 text-xs font-medium text-green-700"
                                                >
                                                    Diterbitkan
                                                </span>

                                            @else

                                                <span
                                                    class="inline-flex rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-600"
                                                >
                                                    Draf
                                                </span>

                                            @endif

                                        </dd>

                                    </div>

                                    <div class="flex items-start justify-between gap-4 text-sm">

                                        <dt class="text-gray-500">
                                            Tanggal terbit
                                        </dt>

                                        <dd class="text-right font-medium text-gray-700">
                                            {{ $post->published_at?->format('d M Y H:i') ?? '-' }}
                                        </dd>

                                    </div>

                                    <div class="flex items-start justify-between gap-4 text-sm">

                                        <dt class="text-gray-500">
                                            Terakhir diperbarui
                                        </dt>

                                        <dd class="text-right font-medium text-gray-700">
                                            {{ $post->updated_at->format('d M Y H:i') }}
                                        </dd>

                                    </div>

                                </dl>

                            </div>

                        </div>

                    </div>

                </section>

                {{-- Tombol tindakan --}}
                <div
                    class="flex flex-col-reverse gap-3 border-t border-gray-200 pt-5 sm:flex-row sm:items-center sm:justify-end"
                >
                    <a
                        href="{{ route('admin.posts.index') }}"
                        class="btn-maloppo-secondary"
                    >
                        Batal
                    </a>

                    <button
                        type="submit"
                        class="btn-maloppo-primary"
                    >
                        Simpan Perubahan
                    </button>
                </div>

            </form>

        </div>

    </div>

</x-app-layout>