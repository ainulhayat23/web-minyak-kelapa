<x-app-layout>

    <x-slot name="header">

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h1 class="text-2xl font-extrabold leading-tight text-gray-900">
                    Edit Blog atau Kegiatan
                </h1>

                <p class="mt-2 text-sm font-normal text-gray-600">
                    Perbarui informasi kegiatan {{ $post->title }}.
                </p>
            </div>

            <a
                href="{{ route('admin.posts.index') }}"
                class="btn-maloppo-secondary"
            >
                <span aria-hidden="true">←</span>
                Kembali ke Daftar Kegiatan
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
                action="{{ route('admin.posts.update', $post) }}"
                method="POST"
                enctype="multipart/form-data"
                class="space-y-7"
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

                        reader.onload = (e) => {
                            this.imagePreview = e.target.result;
                        };

                        reader.readAsDataURL(file);
                    }
                }"
            >
                @csrf
                @method('PUT')

                {{-- Informasi utama --}}
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
                                📰
                            </div>

                            <div>
                                <h2 class="text-xl font-extrabold text-gray-900">
                                    Informasi Kegiatan
                                </h2>

                                <p class="mt-1 text-sm text-gray-500">
                                    Perbarui judul dan ringkasan kegiatan.
                                </p>
                            </div>

                        </div>

                    </div>

                    <div class="space-y-6 p-6 md:p-8">

                        {{-- Judul --}}
                        <div>

                            <label
                                for="title"
                                class="block text-sm font-bold text-gray-700"
                            >
                                Judul Kegiatan
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
                                    name="title"
                                    id="title"
                                    value="{{ old('title', $post->title) }}"
                                    class="input-maloppo pl-11"
                                    placeholder="Masukkan judul kegiatan"
                                    autocomplete="off"
                                    required
                                >

                            </div>

                            <p class="mt-2 text-xs leading-5 text-gray-500">
                                Gunakan judul yang singkat, jelas, dan menggambarkan isi kegiatan.
                            </p>

                            @error('title')
                                <p class="mt-2 text-sm font-medium text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                        {{-- Ringkasan --}}
                        <div>

                            <label
                                for="excerpt"
                                class="block text-sm font-bold text-gray-700"
                            >
                                Ringkasan Singkat
                            </label>

                            <textarea
                                name="excerpt"
                                id="excerpt"
                                rows="4"
                                class="input-maloppo resize-y"
                                placeholder="Tuliskan ringkasan singkat mengenai kegiatan"
                            >{{ old('excerpt', $post->excerpt) }}</textarea>

                            <p class="mt-2 text-xs leading-5 text-gray-500">
                                Ringkasan akan ditampilkan pada kartu kegiatan di halaman publik.
                            </p>

                            @error('excerpt')
                                <p class="mt-2 text-sm font-medium text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                    </div>

                </section>

                {{-- Isi kegiatan --}}
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
                                    Isi Berita atau Kegiatan
                                </h2>

                                <p class="mt-1 text-sm text-gray-500">
                                    Perbarui informasi kegiatan secara lengkap.
                                </p>
                            </div>

                        </div>

                    </div>

                    <div class="p-6 md:p-8">

                        <label
                            for="content"
                            class="block text-sm font-bold text-gray-700"
                        >
                            Isi Kegiatan
                            <span style="color: #be0000;">*</span>
                        </label>

                        <textarea
                            name="content"
                            id="content"
                            rows="12"
                            class="input-maloppo mt-2 resize-y"
                            placeholder="Tuliskan informasi kegiatan secara lengkap..."
                            required
                        >{{ old('content', $post->content) }}</textarea>

                        <div
                            class="mt-3 flex items-start gap-3 rounded-xl border p-4"
                            style="
                                background-color: #fffdf0;
                                border-color: #f1e7a4;
                            "
                        >
                            <span class="text-lg">
                                💡
                            </span>

                            <p class="text-xs leading-6 text-gray-600">
                                Tuliskan informasi secara terurut, seperti waktu, tempat,
                                peserta, proses pelaksanaan, dan hasil kegiatan.
                            </p>
                        </div>

                        @error('content')
                            <p class="mt-2 text-sm font-medium text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                </section>

                {{-- Gambar dan publikasi --}}
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
                                    Gambar dan Publikasi
                                </h2>

                                <p class="mt-1 text-sm text-gray-500">
                                    Ganti gambar atau ubah status publikasi kegiatan.
                                </p>
                            </div>

                        </div>

                    </div>

                    <div class="p-6 md:p-8">

                        <div class="grid grid-cols-1 gap-7 md:grid-cols-2">

                            {{-- Gambar kegiatan --}}
                            <div>

                                <label
                                    for="image"
                                    class="block text-sm font-bold text-gray-700"
                                >
                                    Gambar Utama
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
                                                alt="Pratinjau gambar kegiatan"
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
                                                Belum ada gambar kegiatan
                                            </p>

                                            <p class="mt-2 text-xs leading-5 text-gray-500">
                                                Klik untuk memilih gambar dari perangkat.
                                            </p>

                                            <span
                                                class="mt-4 inline-flex rounded-lg px-4 py-2 text-xs font-bold text-white"
                                                style="background-color: #be0000;"
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
                                    Format JPG, JPEG, PNG, atau WEBP. Maksimal 2 MB.
                                </p>

                                @error('image')
                                    <p class="mt-2 text-sm font-medium text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                            {{-- Status publikasi --}}
                            <div>

                                <p class="text-sm font-bold text-gray-700">
                                    Status Publikasi
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
                                            class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl text-xl text-white"
                                            style="background-color: #be0000;"
                                        >
                                            🌐
                                        </div>

                                        <div>

                                            <h3 class="font-bold text-gray-900">
                                                Terbitkan di Website
                                            </h3>

                                            <p class="mt-2 text-sm leading-6 text-gray-600">
                                                Kegiatan yang diterbitkan akan tampil pada halaman publik Maloppo.
                                            </p>

                                        </div>

                                    </div>

                                    {{-- Nilai 0 dikirim saat checkbox dilepas --}}
                                    <input
                                        type="hidden"
                                        name="is_published"
                                        value="0"
                                    >

                                    <label
                                        for="is_published"
                                        class="mt-6 flex cursor-pointer items-center justify-between gap-4 rounded-xl bg-white p-4"
                                    >

                                        <div>

                                            <p class="text-sm font-bold text-gray-800">
                                                Terbitkan kegiatan
                                            </p>

                                            <p class="mt-1 text-xs leading-5 text-gray-500">
                                                Hilangkan centang untuk mengubah kegiatan menjadi draf.
                                            </p>

                                        </div>

                                        <input
                                            type="checkbox"
                                            name="is_published"
                                            id="is_published"
                                            value="1"
                                            class="h-5 w-5 rounded border-gray-300 shadow-sm"
                                            style="color: #be0000;"
                                            {{ old('is_published', $post->is_published) ? 'checked' : '' }}
                                        >

                                    </label>

                                </div>

                                {{-- Ringkasan kegiatan --}}
                                <div
                                    class="mt-5 rounded-2xl border p-5"
                                    style="
                                        background-color: #fffdf0;
                                        border-color: #f1e7a4;
                                    "
                                >

                                    <p class="text-xs font-bold uppercase tracking-wider text-gray-500">
                                        Ringkasan Kegiatan
                                    </p>

                                    <div class="mt-4 space-y-3">

                                        <div class="flex items-start justify-between gap-4 text-sm">

                                            <span class="text-gray-500">
                                                Judul
                                            </span>

                                            <span class="max-w-56 text-right font-bold text-gray-800">
                                                {{ $post->title }}
                                            </span>

                                        </div>

                                        <div class="flex items-center justify-between gap-4 text-sm">

                                            <span class="text-gray-500">
                                                Status saat ini
                                            </span>

                                            @if ($post->is_published)

                                                <span
                                                    class="rounded-full px-3 py-1 text-xs font-bold"
                                                    style="
                                                        background-color: #dcfce7;
                                                        color: #166534;
                                                    "
                                                >
                                                    Diterbitkan
                                                </span>

                                            @else

                                                <span
                                                    class="rounded-full px-3 py-1 text-xs font-bold"
                                                    style="
                                                        background-color: #fff9b0;
                                                        color: #92400e;
                                                    "
                                                >
                                                    Draf
                                                </span>

                                            @endif

                                        </div>

                                        <div class="flex items-center justify-between gap-4 text-sm">

                                            <span class="text-gray-500">
                                                Tanggal terbit
                                            </span>

                                            <span class="text-right font-medium text-gray-700">
                                                {{ $post->published_at?->format('d M Y H:i') ?? '-' }}
                                            </span>

                                        </div>

                                        <div class="flex items-center justify-between gap-4 text-sm">

                                            <span class="text-gray-500">
                                                Terakhir diperbarui
                                            </span>

                                            <span class="text-right font-medium text-gray-700">
                                                {{ $post->updated_at->format('d M Y H:i') }}
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
                            href="{{ route('admin.posts.index') }}"
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
                            Perbarui Kegiatan
                        </button>

                    </div>

                </section>

            </form>

        </div>

    </div>

</x-app-layout>