<x-app-layout>

    @php
        $statusLabel = match ($order->status) {
            'pending' => 'Menunggu',
            'confirmed' => 'Dikonfirmasi',
            'processing' => 'Diproses',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            default => ucfirst($order->status),
        };

        $statusClass = match ($order->status) {
            'pending' => 'bg-amber-50 text-amber-700',
            'confirmed' => 'bg-blue-50 text-blue-700',
            'processing' => 'bg-indigo-50 text-indigo-700',
            'completed' => 'bg-green-50 text-green-700',
            'cancelled' => 'bg-red-50 text-red-700',
            default => 'bg-gray-100 text-gray-600',
        };

        $totalQuantity = $order->items->sum('quantity');

        $whatsappNumber = preg_replace('/[^0-9]/', '', $order->customer_phone);

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
            $messageLines[] = '- ' . $item->product_name . ' (' . ($item->product_size ?? '-') . ')';

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

        $messageLines[] = 'Status Pesanan: ' . $statusLabel;

        if ($order->customer_notes) {
            $messageLines[] = '';
            $messageLines[] = 'Catatan Pelanggan:';
            $messageLines[] = $order->customer_notes;
        }

        $messageLines[] = '';
        $messageLines[] = 'Mohon konfirmasi apakah rincian pesanan dan alamat pengiriman tersebut sudah benar.';
        $messageLines[] = 'Setelah dikonfirmasi, pesanan akan segera kami proses.';
        $messageLines[] = '';
        $messageLines[] = 'Terima kasih telah berbelanja di UMKM Maloppo.';

        $whatsappMessage = implode("\n", $messageLines);

        $whatsappUrl =
            'https://wa.me/' .
            $whatsappNumber .
            '?text=' .
            urlencode($whatsappMessage);
    @endphp

    <x-slot name="header">

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>

                <p class="text-sm font-semibold uppercase tracking-[0.20em] text-red-700">
                    Detail Pesanan
                </p>

                <div class="mt-2 flex flex-wrap items-center gap-3">

                    <h1 class="text-3xl font-bold tracking-tight text-gray-900">
                        {{ $order->order_code }}
                    </h1>

                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold {{ $statusClass }}">
                        {{ $statusLabel }}
                    </span>

                </div>

                <p class="mt-2 text-sm leading-6 text-gray-500">
                    Pesanan dibuat pada {{ $order->created_at->format('d M Y, H:i') }} WITA.
                </p>

            </div>

            <div class="flex flex-wrap gap-2">

                <a
                    href="{{ $whatsappUrl }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="inline-flex items-center justify-center rounded-lg bg-green-700 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-green-800"
                >
                    Hubungi Pelanggan
                </a>

                <a
                    href="{{ route('admin.orders.index') }}"
                    class="inline-flex items-center justify-center rounded-lg border border-red-200 bg-white px-5 py-3 text-sm font-semibold text-red-700 shadow-sm transition hover:bg-red-50"
                >
                    Kembali
                </a>

            </div>

        </div>

    </x-slot>

    <div class="py-8">

        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">

            {{-- Notifikasi berhasil --}}
            @if (session('success'))

                <div class="rounded-2xl border border-green-200 bg-green-50 px-5 py-4 text-sm font-semibold text-green-800 shadow-sm">
                    {{ session('success') }}
                </div>

            @endif

            {{-- Notifikasi kesalahan --}}
            @if (session('error'))

                <div class="rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm font-semibold text-red-800 shadow-sm">
                    {{ session('error') }}
                </div>

            @endif

            {{-- Kesalahan validasi --}}
            @if ($errors->any())

                <div class="rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-800 shadow-sm">

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

            {{-- Ringkasan utama --}}
            <section class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">

                <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-semibold text-gray-500">
                        Kode Pesanan
                    </p>

                    <p class="mt-2 text-lg font-bold text-gray-900">
                        {{ $order->order_code }}
                    </p>

                    <p class="mt-1 text-xs text-gray-500">
                        Nomor identitas pesanan.
                    </p>
                </div>

                <div class="rounded-2xl border border-yellow-200 bg-yellow-50 p-5 shadow-sm">
                    <p class="text-sm font-semibold text-red-700">
                        Jumlah Barang
                    </p>

                    <p class="mt-2 text-3xl font-bold text-gray-900">
                        {{ $totalQuantity }}
                    </p>

                    <p class="mt-1 text-xs text-gray-600">
                        Total barang dipesan.
                    </p>
                </div>

                <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-semibold text-gray-500">
                        Status Pesanan
                    </p>

                    <span class="mt-3 inline-flex rounded-full px-3 py-1 text-xs font-bold {{ $statusClass }}">
                        {{ $statusLabel }}
                    </span>

                    <p class="mt-2 text-xs text-gray-500">
                        Status proses saat ini.
                    </p>
                </div>

                <div class="rounded-2xl border border-red-100 bg-red-50 p-5 shadow-sm">
                    <p class="text-sm font-semibold text-red-700">
                        Total Pesanan
                    </p>

                    <p class="mt-2 text-2xl font-bold text-red-700">
                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                    </p>

                    <p class="mt-1 text-xs text-gray-600">
                        Total pembayaran pelanggan.
                    </p>
                </div>

            </section>

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

                {{-- Bagian utama --}}
                <div class="space-y-6 lg:col-span-2">

                    {{-- Produk yang dipesan --}}
                    <section class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">

                        <div class="border-b border-gray-200 bg-white px-6 py-5">

                            <p class="text-sm font-semibold uppercase tracking-[0.20em] text-red-700">
                                Rincian Produk
                            </p>

                            <h2 class="mt-2 text-2xl font-bold text-gray-900">
                                Produk yang Dipesan
                            </h2>

                            <p class="mt-1 text-sm text-gray-500">
                                {{ $order->items->count() }} jenis produk dengan total {{ $totalQuantity }} barang.
                            </p>

                        </div>

                        <div class="divide-y divide-gray-100">

                            @foreach ($order->items as $item)

                                <article class="p-5 sm:p-6">

                                    <div class="flex items-start gap-4">

                                        {{-- Gambar produk --}}
                                        <div class="flex h-20 w-20 shrink-0 items-center justify-center overflow-hidden rounded-2xl border border-yellow-200 bg-yellow-50 p-2">

                                            @if ($item->product && $item->product->image)

                                                <img
                                                    src="{{ asset('storage/' . $item->product->image) }}"
                                                    alt="{{ $item->product_name }}"
                                                    class="h-full w-full object-contain"
                                                >

                                            @else

                                                <span class="text-xs font-semibold text-gray-400">
                                                    Foto
                                                </span>

                                            @endif

                                        </div>

                                        {{-- Detail produk --}}
                                        <div class="min-w-0 flex-1">

                                            <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">

                                                <div class="min-w-0">

                                                    <h3 class="font-bold text-gray-900">
                                                        {{ $item->product_name }}
                                                    </h3>

                                                    <div class="mt-2 flex flex-wrap gap-x-4 gap-y-1 text-xs text-gray-500">

                                                        <span>
                                                            Ukuran {{ $item->product_size ?? '-' }}
                                                        </span>

                                                        <span>
                                                            {{ $item->quantity }} barang
                                                        </span>

                                                    </div>

                                                    <p class="mt-3 text-sm font-semibold text-gray-700">
                                                        {{ $item->quantity }}
                                                        × Rp {{ number_format($item->price, 0, ',', '.') }}
                                                    </p>

                                                </div>

                                                <div class="sm:text-right">

                                                    <p class="text-xs text-gray-500">
                                                        Subtotal
                                                    </p>

                                                    <p class="mt-1 text-lg font-bold text-gray-900">
                                                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                                    </p>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </article>

                            @endforeach

                        </div>

                        {{-- Total --}}
                        <div class="flex flex-col gap-3 border-t border-gray-200 bg-red-50 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">

                            <div>

                                <p class="text-sm font-bold text-gray-900">
                                    Total Pesanan
                                </p>

                                <p class="mt-1 text-xs text-gray-600">
                                    {{ $totalQuantity }} barang dalam pesanan ini.
                                </p>

                            </div>

                            <p class="text-2xl font-bold text-red-700">
                                Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                            </p>

                        </div>

                    </section>

                    {{-- Alamat dan catatan --}}
                    <section class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">

                        <div class="border-b border-gray-200 px-6 py-5">

                            <p class="text-sm font-semibold uppercase tracking-[0.20em] text-red-700">
                                Pengiriman
                            </p>

                            <h2 class="mt-2 text-2xl font-bold text-gray-900">
                                Alamat dan Catatan
                            </h2>

                            <p class="mt-1 text-sm text-gray-500">
                                Informasi pengiriman dari pelanggan.
                            </p>

                        </div>

                        <div class="grid grid-cols-1 divide-y divide-gray-100 md:grid-cols-2 md:divide-x md:divide-y-0">

                            <div class="p-6">

                                <p class="text-xs font-bold uppercase tracking-wide text-gray-500">
                                    Alamat Pengiriman
                                </p>

                                <p class="mt-3 whitespace-pre-line text-sm leading-6 text-gray-700">{{ $order->customer_address }}</p>

                            </div>

                            <div class="p-6">

                                <p class="text-xs font-bold uppercase tracking-wide text-gray-500">
                                    Catatan Pelanggan
                                </p>

                                <p class="mt-3 whitespace-pre-line text-sm leading-6 text-gray-700">{{ $order->customer_notes ?: 'Tidak ada catatan tambahan.' }}</p>

                            </div>

                        </div>

                    </section>

                </div>

                {{-- Sidebar --}}
                <aside class="space-y-6">

                    {{-- Data pelanggan --}}
                    <section class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">

                        <div class="border-b border-gray-200 px-6 py-5">

                            <h2 class="text-xl font-bold text-gray-900">
                                Data Pelanggan
                            </h2>

                            <p class="mt-1 text-sm text-gray-500">
                                Informasi pemesan.
                            </p>

                        </div>

                        <div class="space-y-4 p-6">

                            <div>

                                <p class="text-xs font-semibold text-gray-500">
                                    Nama
                                </p>

                                <p class="mt-1 text-sm font-bold text-gray-900">
                                    {{ $order->customer_name }}
                                </p>

                            </div>

                            <div>

                                <p class="text-xs font-semibold text-gray-500">
                                    Nomor WhatsApp
                                </p>

                                <p class="mt-1 text-sm font-bold text-gray-900">
                                    {{ $order->customer_phone }}
                                </p>

                            </div>

                            <a
                                href="{{ $whatsappUrl }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="inline-flex w-full items-center justify-center rounded-lg bg-green-700 px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-green-800"
                            >
                                Hubungi melalui WhatsApp
                            </a>

                        </div>

                    </section>

                    {{-- Ubah status --}}
                    <section class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">

                        <div class="border-b border-gray-200 bg-yellow-50 px-6 py-5">

                            <h2 class="text-xl font-bold text-gray-900">
                                Ubah Status
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                Perbarui proses pesanan pelanggan.
                            </p>

                        </div>

                        <form
                            action="{{ route('admin.orders.update-status', $order) }}"
                            method="POST"
                            class="space-y-4 p-6"
                        >
                            @csrf
                            @method('PATCH')

                            <div>

                                <label
                                    for="status"
                                    class="block text-sm font-semibold text-gray-700"
                                >
                                    Status Pesanan
                                </label>

                                <select
                                    name="status"
                                    id="status"
                                    class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm transition focus:border-red-500 focus:ring-red-500"
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
                                    <p class="mt-2 text-sm font-medium text-red-700">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                            <button
                                type="submit"
                                class="inline-flex w-full items-center justify-center rounded-lg bg-red-700 px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-red-800"
                                onclick="return confirm('Yakin ingin mengubah status pesanan ini?')"
                            >
                                Simpan Status
                            </button>

                        </form>

                    </section>

                    {{-- Informasi pesanan --}}
                    <section class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">

                        <div class="border-b border-gray-200 px-6 py-5">

                            <h2 class="text-xl font-bold text-gray-900">
                                Informasi Pesanan
                            </h2>

                            <p class="mt-1 text-sm text-gray-500">
                                Ringkasan data pesanan.
                            </p>

                        </div>

                        <dl class="divide-y divide-gray-100 px-6">

                            <div class="flex items-center justify-between gap-4 py-4 text-sm">

                                <dt class="text-gray-500">
                                    Status
                                </dt>

                                <dd>
                                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold {{ $statusClass }}">
                                        {{ $statusLabel }}
                                    </span>
                                </dd>

                            </div>

                            <div class="flex items-center justify-between gap-4 py-4 text-sm">

                                <dt class="text-gray-500">
                                    Jenis produk
                                </dt>

                                <dd class="font-bold text-gray-900">
                                    {{ $order->items->count() }}
                                </dd>

                            </div>

                            <div class="flex items-center justify-between gap-4 py-4 text-sm">

                                <dt class="text-gray-500">
                                    Total barang
                                </dt>

                                <dd class="font-bold text-gray-900">
                                    {{ $totalQuantity }}
                                </dd>

                            </div>

                            <div class="flex items-center justify-between gap-4 py-4 text-sm">

                                <dt class="text-gray-500">
                                    Dialihkan ke WhatsApp
                                </dt>

                                <dd class="font-bold text-gray-900">
                                    {{ $order->whatsapp_redirected_at ? 'Sudah' : 'Belum' }}
                                </dd>

                            </div>

                            <div class="flex items-start justify-between gap-4 py-4 text-sm">

                                <dt class="text-gray-500">
                                    Dibuat
                                </dt>

                                <dd class="text-right font-bold text-gray-900">
                                    {{ $order->created_at->format('d M Y H:i') }}
                                </dd>

                            </div>

                            <div class="flex items-start justify-between gap-4 py-4 text-sm">

                                <dt class="text-gray-500">
                                    Diperbarui
                                </dt>

                                <dd class="text-right font-bold text-gray-900">
                                    {{ $order->updated_at->format('d M Y H:i') }}
                                </dd>

                            </div>

                        </dl>

                    </section>

                </aside>

            </div>

        </div>

    </div>

</x-app-layout>