<x-app-layout>

    <x-slot name="header">

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>

                <p class="text-sm font-semibold text-maloppo-red">
                    Detail Pesanan
                </p>

                <h1 class="mt-1 text-2xl font-extrabold leading-tight text-gray-900">
                    {{ $order->order_code }}
                </h1>

                <p class="mt-2 text-sm text-gray-600">
                    Periksa rincian pelanggan, produk, dan perkembangan pesanan.
                </p>

            </div>

            <a
                href="{{ route('admin.orders.index') }}"
                class="btn-maloppo-secondary"
            >
                <span aria-hidden="true">←</span>
                Kembali ke Pesanan
            </a>

        </div>

    </x-slot>

    @php
        $statusLabel = match ($order->status) {
            'pending' => 'Menunggu',
            'confirmed' => 'Dikonfirmasi',
            'processing' => 'Diproses',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            default => ucfirst($order->status),
        };

        $statusStyle = match ($order->status) {
            'pending' => 'background-color: #fff9b0; color: #92400e;',
            'confirmed' => 'background-color: #dbeafe; color: #1d4ed8;',
            'processing' => 'background-color: #e0e7ff; color: #4338ca;',
            'completed' => 'background-color: #dcfce7; color: #166534;',
            'cancelled' => 'background-color: #fee2e2; color: #991b1b;',
            default => 'background-color: #f3f4f6; color: #374151;',
        };

        $statusIcon = match ($order->status) {
            'pending' => '⏳',
            'confirmed' => '✓',
            'processing' => '⚙️',
            'completed' => '✅',
            'cancelled' => '✕',
            default => '•',
        };

        $totalQuantity = $order->items->sum('quantity');

        $whatsappNumber = preg_replace(
            '/[^0-9]/',
            '',
            $order->customer_phone
        );

        if (str_starts_with($whatsappNumber, '0')) {
            $whatsappNumber = '62' . substr($whatsappNumber, 1);
        } elseif (str_starts_with($whatsappNumber, '8')) {
            $whatsappNumber = '62' . $whatsappNumber;
        }

        $messageLines = [
            'Halo Bapak/Ibu ' . $order->customer_name . ',',
            '',
            'Kami dari UMKM Maloppo ingin mengonfirmasi pesanan Anda.',
            '',
            'Kode Pesanan: ' . $order->order_code,
            'Tanggal Pesanan: ' . $order->created_at->format('d/m/Y H:i') . ' WITA',
            'Nomor WhatsApp: ' . $order->customer_phone,
            '',
            'Alamat Pengiriman:',
            $order->customer_address,
            '',
            'Rincian Pesanan:',
        ];

        foreach ($order->items as $item) {
            $messageLines[] =
                '- ' .
                $item->product_name .
                ' (' .
                ($item->product_size ?? '-') .
                ')';

            $messageLines[] =
                '  ' .
                $item->quantity .
                ' x Rp ' .
                number_format($item->price, 0, ',', '.') .
                ' = Rp ' .
                number_format($item->subtotal, 0, ',', '.');
        }

        $messageLines[] = '';

        $messageLines[] =
            'Total Pesanan: Rp ' .
            number_format($order->total_amount, 0, ',', '.');

        $messageLines[] =
            'Status Pesanan: ' .
            $statusLabel;

        if ($order->customer_notes) {
            $messageLines[] = '';
            $messageLines[] = 'Catatan Pelanggan:';
            $messageLines[] = $order->customer_notes;
        }

        $messageLines[] = '';

        $messageLines[] =
            'Mohon konfirmasi apakah rincian pesanan dan alamat pengiriman tersebut sudah benar.';

        $messageLines[] =
            'Setelah dikonfirmasi, pesanan akan segera kami proses.';

        $messageLines[] = '';

        $messageLines[] =
            'Terima kasih telah berbelanja di UMKM Maloppo.';

        $whatsappMessage = implode("\n", $messageLines);

        $whatsappUrl =
            'https://wa.me/' .
            $whatsappNumber .
            '?text=' .
            urlencode($whatsappMessage);
    @endphp

    <div class="py-8 lg:py-10">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Notifikasi berhasil --}}
            @if (session('success'))

                <div
                    class="mb-7 flex items-start gap-3 rounded-xl border px-5 py-4 text-sm"
                    style="
                        background-color: #dcfce7;
                        border-color: #86efac;
                        color: #166534;
                    "
                >
                    <span
                        class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full font-bold"
                        style="background-color: #bbf7d0;"
                    >
                        ✓
                    </span>

                    <p class="pt-1 font-medium">
                        {{ session('success') }}
                    </p>
                </div>

            @endif

            {{-- Notifikasi kesalahan --}}
            @if (session('error'))

                <div
                    class="mb-7 flex items-start gap-3 rounded-xl border px-5 py-4 text-sm"
                    style="
                        background-color: #fee2e2;
                        border-color: #fca5a5;
                        color: #991b1b;
                    "
                >
                    <span
                        class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full font-bold"
                        style="background-color: #fecaca;"
                    >
                        !
                    </span>

                    <p class="pt-1 font-medium">
                        {{ session('error') }}
                    </p>
                </div>

            @endif

            {{-- Kesalahan validasi --}}
            @if ($errors->any())

                <div class="alert-maloppo-error mb-7">

                    <p class="font-bold">
                        Perubahan belum dapat disimpan
                    </p>

                    <ul class="mt-2 list-inside list-disc space-y-1 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>
                                {{ $error }}
                            </li>
                        @endforeach
                    </ul>

                </div>

            @endif

            {{-- Ringkasan atas --}}
            <section
                class="relative mb-8 overflow-hidden rounded-3xl p-6 shadow-lg sm:p-8"
                style="
                    background:
                        radial-gradient(
                            circle at top right,
                            rgba(247, 233, 0, 0.32),
                            transparent 38%
                        ),
                        linear-gradient(
                            135deg,
                            #be0000 0%,
                            #990100 100%
                        );
                "
            >

                <div
                    class="pointer-events-none absolute -right-16 -top-16 h-52 w-52 rounded-full opacity-20"
                    style="background-color: #f7e900;"
                ></div>

                <div
                    class="relative flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between"
                >

                    <div>

                        <span
                            class="inline-flex items-center gap-2 rounded-full px-4 py-2 text-xs font-extrabold uppercase tracking-wider"
                            style="
                                background-color: #f7e900;
                                color: #990100;
                            "
                        >
                            <span>📦</span>
                            Pesanan Pelanggan
                        </span>

                        <h2 class="mt-5 text-3xl font-extrabold text-white">
                            {{ $order->order_code }}
                        </h2>

                        <p class="mt-3 text-sm text-red-100">
                            Dibuat pada
                            {{ $order->created_at->format('d/m/Y H:i') }}
                            WITA
                        </p>

                    </div>

                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center">

                        <span
                            class="inline-flex items-center justify-center gap-2 rounded-xl px-5 py-3 text-sm font-extrabold"
                            style="{{ $statusStyle }}"
                        >
                            <span>{{ $statusIcon }}</span>
                            {{ $statusLabel }}
                        </span>

                        <a
                            href="{{ $whatsappUrl }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="inline-flex items-center justify-center gap-2 rounded-xl px-5 py-3 text-sm font-bold text-white shadow-sm"
                            style="background-color: #16a34a;"
                        >
                            <span>💬</span>
                            Hubungi Pelanggan
                        </a>

                    </div>

                </div>

            </section>

            <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">

                {{-- Bagian utama --}}
                <div class="space-y-8 lg:col-span-2">

                    {{-- Produk yang dipesan --}}
                    <section class="card-maloppo overflow-hidden">

                        <div
                            class="flex flex-col gap-3 border-b px-6 py-5 sm:flex-row sm:items-center sm:justify-between"
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
                                    🛒
                                </div>

                                <div>

                                    <h2 class="text-xl font-extrabold text-gray-900">
                                        Produk yang Dipesan
                                    </h2>

                                    <p class="mt-1 text-sm text-gray-500">
                                        {{ $order->items->count() }} jenis produk,
                                        total {{ $totalQuantity }} barang.
                                    </p>

                                </div>

                            </div>

                            <span class="badge-maloppo-yellow">
                                {{ $totalQuantity }} Barang
                            </span>

                        </div>

                        <div
                            class="divide-y"
                            style="border-color: #f1e7a4;"
                        >

                            @foreach ($order->items as $item)

                                <article class="p-5 sm:p-6">

                                    <div class="flex flex-col gap-5 sm:flex-row sm:items-center">

                                        {{-- Gambar produk --}}
                                        <div
                                            class="flex h-24 w-24 shrink-0 items-center justify-center overflow-hidden rounded-2xl border"
                                            style="
                                                background-color: #fffdf0;
                                                border-color: #f1e7a4;
                                            "
                                        >

                                            @if ($item->product && $item->product->image)

                                                <img
                                                    src="{{ asset('storage/' . $item->product->image) }}"
                                                    alt="{{ $item->product_name }}"
                                                    class="h-full w-full object-cover"
                                                >

                                            @else

                                                <span class="text-4xl">
                                                    🥥
                                                </span>

                                            @endif

                                        </div>

                                        {{-- Detail produk --}}
                                        <div class="min-w-0 flex-1">

                                            <div
                                                class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between"
                                            >

                                                <div>

                                                    <h3 class="text-lg font-extrabold text-gray-900">
                                                        {{ $item->product_name }}
                                                    </h3>

                                                    <div class="mt-3 flex flex-wrap items-center gap-2">

                                                        <span class="badge-maloppo-yellow">
                                                            {{ $item->product_size ?? '-' }}
                                                        </span>

                                                        <span
                                                            class="inline-flex rounded-full px-3 py-1 text-xs font-bold"
                                                            style="
                                                                background-color: #dcfce7;
                                                                color: #166534;
                                                            "
                                                        >
                                                            {{ $item->quantity }} barang
                                                        </span>

                                                    </div>

                                                    <p class="mt-3 text-sm text-gray-500">
                                                        {{ $item->quantity }} ×
                                                        Rp {{ number_format($item->price, 0, ',', '.') }}
                                                    </p>

                                                </div>

                                                <div class="sm:text-right">

                                                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">
                                                        Subtotal
                                                    </p>

                                                    <p class="mt-2 text-xl font-extrabold text-maloppo-red">
                                                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                                    </p>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </article>

                            @endforeach

                        </div>

                        {{-- Total pesanan --}}
                        <div
                            class="border-t px-6 py-6"
                            style="
                                background-color: #fff9b0;
                                border-color: #f1e7a4;
                            "
                        >

                            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                                <div>

                                    <p class="text-sm font-bold text-gray-700">
                                        Total Pesanan
                                    </p>

                                    <p class="mt-1 text-xs text-gray-500">
                                        {{ $totalQuantity }} barang dalam pesanan
                                    </p>

                                </div>

                                <p class="text-3xl font-extrabold text-maloppo-red">
                                    Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                </p>

                            </div>

                        </div>

                    </section>

                    {{-- Informasi pengiriman --}}
                    <section class="card-maloppo overflow-hidden">

                        <div
                            class="border-b px-6 py-5"
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
                                    📍
                                </div>

                                <div>

                                    <h2 class="text-xl font-extrabold text-gray-900">
                                        Alamat dan Catatan
                                    </h2>

                                    <p class="mt-1 text-sm text-gray-500">
                                        Informasi pengiriman yang diberikan pelanggan.
                                    </p>

                                </div>

                            </div>

                        </div>

                        <div class="grid grid-cols-1 gap-5 p-6 md:grid-cols-2">

                            <div
                                class="rounded-2xl border p-5"
                                style="
                                    background-color: #fffdf0;
                                    border-color: #f1e7a4;
                                "
                            >

                                <p class="text-xs font-bold uppercase tracking-wider text-gray-400">
                                    Alamat Pengiriman
                                </p>

                                <p class="mt-3 whitespace-pre-line text-sm leading-7 text-gray-700">{{ $order->customer_address }}</p>

                            </div>

                            <div
                                class="rounded-2xl border p-5"
                                style="
                                    background-color: #fffdf0;
                                    border-color: #f1e7a4;
                                "
                            >

                                <p class="text-xs font-bold uppercase tracking-wider text-gray-400">
                                    Catatan Pelanggan
                                </p>

                                <p class="mt-3 whitespace-pre-line text-sm leading-7 text-gray-700">{{ $order->customer_notes ?: 'Tidak ada catatan tambahan.' }}</p>

                            </div>

                        </div>

                    </section>

                </div>

                {{-- Sidebar --}}
                <aside class="space-y-8">

                    {{-- Data pelanggan --}}
                    <section class="card-maloppo overflow-hidden">

                        <div
                            class="border-b px-6 py-5"
                            style="
                                background-color: #fffdf0;
                                border-color: #f1e7a4;
                            "
                        >

                            <div class="flex items-center gap-3">

                                <div
                                    class="flex h-11 w-11 items-center justify-center rounded-full text-sm font-extrabold text-white"
                                    style="background-color: #be0000;"
                                >
                                    {{ strtoupper(substr($order->customer_name, 0, 1)) }}
                                </div>

                                <div>

                                    <h2 class="font-extrabold text-gray-900">
                                        Data Pelanggan
                                    </h2>

                                    <p class="mt-1 text-xs text-gray-500">
                                        Informasi pemesan
                                    </p>

                                </div>

                            </div>

                        </div>

                        <div class="space-y-5 p-6">

                            <div>

                                <p class="text-xs font-bold uppercase tracking-wider text-gray-400">
                                    Nama
                                </p>

                                <p class="mt-2 font-bold text-gray-900">
                                    {{ $order->customer_name }}
                                </p>

                            </div>

                            <div>

                                <p class="text-xs font-bold uppercase tracking-wider text-gray-400">
                                    Nomor WhatsApp
                                </p>

                                <p class="mt-2 font-bold text-gray-900">
                                    {{ $order->customer_phone }}
                                </p>

                            </div>

                            <a
                                href="{{ $whatsappUrl }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="inline-flex w-full items-center justify-center gap-2 rounded-xl px-5 py-3 text-sm font-bold text-white shadow-sm"
                                style="background-color: #16a34a;"
                            >
                                <span>💬</span>
                                Hubungi Pelanggan
                            </a>

                        </div>

                    </section>

                    {{-- Form ubah status --}}
                    <section class="card-maloppo overflow-hidden">

                        <div
                            class="border-b px-6 py-5"
                            style="
                                background-color: #fffdf0;
                                border-color: #f1e7a4;
                            "
                        >

                            <div class="flex items-center gap-3">

                                <div
                                    class="flex h-11 w-11 items-center justify-center rounded-xl text-lg"
                                    style="background-color: #f7e900;"
                                >
                                    ⚙️
                                </div>

                                <div>

                                    <h2 class="font-extrabold text-gray-900">
                                        Ubah Status
                                    </h2>

                                    <p class="mt-1 text-xs text-gray-500">
                                        Perbarui proses pesanan
                                    </p>

                                </div>

                            </div>

                        </div>

                        <form
                            action="{{ route('admin.orders.update-status', $order) }}"
                            method="POST"
                            class="space-y-5 p-6"
                        >
                            @csrf
                            @method('PATCH')

                            <div>

                                <label
                                    for="status"
                                    class="block text-sm font-bold text-gray-700"
                                >
                                    Status Pesanan
                                </label>

                                <select
                                    name="status"
                                    id="status"
                                    class="input-maloppo mt-2"
                                    required
                                >
                                    <option
                                        value="pending"
                                        @selected(old('status', $order->status) === 'pending')
                                    >
                                        Menunggu
                                    </option>

                                    <option
                                        value="confirmed"
                                        @selected(old('status', $order->status) === 'confirmed')
                                    >
                                        Dikonfirmasi
                                    </option>

                                    <option
                                        value="processing"
                                        @selected(old('status', $order->status) === 'processing')
                                    >
                                        Diproses
                                    </option>

                                    <option
                                        value="completed"
                                        @selected(old('status', $order->status) === 'completed')
                                    >
                                        Selesai
                                    </option>

                                    <option
                                        value="cancelled"
                                        @selected(old('status', $order->status) === 'cancelled')
                                    >
                                        Dibatalkan
                                    </option>
                                </select>

                                @error('status')
                                    <p class="mt-2 text-sm font-medium text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                            <button
                                type="submit"
                                class="btn-maloppo-primary w-full py-3"
                                onclick="return confirm('Yakin ingin mengubah status pesanan ini?')"
                            >
                                <span>💾</span>
                                Simpan Status
                            </button>

                        </form>

                    </section>

                    {{-- Informasi pencatatan --}}
                    <section
                        class="rounded-2xl border p-6"
                        style="
                            background-color: #fff9b0;
                            border-color: #f7e900;
                        "
                    >

                        <div class="flex items-center gap-3">

                            <div
                                class="flex h-10 w-10 items-center justify-center rounded-xl text-lg text-white"
                                style="background-color: #be0000;"
                            >
                                ℹ️
                            </div>

                            <h2 class="font-extrabold text-gray-900">
                                Informasi Pesanan
                            </h2>

                        </div>

                        <div class="mt-5 space-y-4">

                            <div class="flex items-center justify-between gap-4 text-sm">

                                <span class="text-gray-600">
                                    Status
                                </span>

                                <span
                                    class="inline-flex items-center gap-1 rounded-full px-3 py-1 text-xs font-bold"
                                    style="{{ $statusStyle }}"
                                >
                                    {{ $statusIcon }}
                                    {{ $statusLabel }}
                                </span>

                            </div>

                            <div class="flex items-center justify-between gap-4 text-sm">

                                <span class="text-gray-600">
                                    Jenis produk
                                </span>

                                <span class="font-extrabold text-gray-900">
                                    {{ $order->items->count() }}
                                </span>

                            </div>

                            <div class="flex items-center justify-between gap-4 text-sm">

                                <span class="text-gray-600">
                                    Total barang
                                </span>

                                <span class="font-extrabold text-gray-900">
                                    {{ $totalQuantity }}
                                </span>

                            </div>

                            <div class="flex items-center justify-between gap-4 text-sm">

                                <span class="text-gray-600">
                                    WhatsApp
                                </span>

                                <span class="font-extrabold text-gray-900">
                                    {{ $order->whatsapp_redirected_at ? 'Sudah' : 'Belum' }}
                                </span>

                            </div>

                            <div class="flex items-center justify-between gap-4 text-sm">

                                <span class="text-gray-600">
                                    Terakhir diperbarui
                                </span>

                                <span class="text-right font-semibold text-gray-900">
                                    {{ $order->updated_at->format('d/m/Y H:i') }}
                                </span>

                            </div>

                        </div>

                    </section>

                </aside>

            </div>

        </div>

    </div>

</x-app-layout>