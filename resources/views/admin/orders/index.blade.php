<x-app-layout>

    <x-slot name="header">

        <div
            class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"
        >
            <div>
                <h1 class="page-title-maloppo">
                    Pesanan
                </h1>

                <p class="page-description-maloppo">
                    Periksa dan proses pesanan pelanggan yang masuk melalui website.
                </p>
            </div>

            <div class="flex flex-wrap gap-2">

                <a
                    href="{{ route('admin.orders.history') }}"
                    class="btn-maloppo-secondary"
                >
                    Riwayat Pesanan
                </a>

                <a
                    href="{{ route('catalog.index') }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="btn-maloppo-secondary"
                >
                    Lihat Katalog
                </a>

            </div>
        </div>

    </x-slot>

    @php
        $prepareOrderData = function ($order) {
            $statusLabel = match ($order->status) {
                'pending' => 'Menunggu',
                'confirmed' => 'Dikonfirmasi',
                'processing' => 'Diproses',
                'completed' => 'Selesai',
                'cancelled' => 'Dibatalkan',
                default => ucfirst($order->status),
            };

            $statusClass = match ($order->status) {
                'pending' =>
                    'bg-amber-50 text-amber-700',
                'confirmed' =>
                    'bg-blue-50 text-blue-700',
                'processing' =>
                    'bg-indigo-50 text-indigo-700',
                'completed' =>
                    'bg-green-50 text-green-700',
                'cancelled' =>
                    'bg-red-50 text-red-700',
                default =>
                    'bg-gray-100 text-gray-600',
            };

            $whatsappNumber = preg_replace(
                '/[^0-9]/',
                '',
                $order->customer_phone
            );

            if (str_starts_with($whatsappNumber, '0')) {
                $whatsappNumber =
                    '62' . substr($whatsappNumber, 1);
            } elseif (str_starts_with($whatsappNumber, '8')) {
                $whatsappNumber =
                    '62' . $whatsappNumber;
            }

            $messageLines = [
                'Halo Bapak/Ibu ' . $order->customer_name . ',',
                '',
                'Kami dari UMKM Maloppo ingin mengonfirmasi pesanan Anda.',
                '',
                'Kode Pesanan: ' . $order->order_code,
                'Tanggal Pesanan: ' .
                    $order->created_at->format('d/m/Y H:i') .
                    ' WITA',
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
                    number_format(
                        $item->price,
                        0,
                        ',',
                        '.'
                    ) .
                    ' = Rp ' .
                    number_format(
                        $item->subtotal,
                        0,
                        ',',
                        '.'
                    );
            }

            $messageLines[] = '';

            $messageLines[] =
                'Total Pesanan: Rp ' .
                number_format(
                    $order->total_amount,
                    0,
                    ',',
                    '.'
                );

            $messageLines[] =
                'Status Pesanan: ' . $statusLabel;

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

            return [
                'statusLabel' => $statusLabel,
                'statusClass' => $statusClass,
                'whatsappNumber' => $whatsappNumber,
                'whatsappMessage' => implode(
                    "\n",
                    $messageLines
                ),
            ];
        };
    @endphp

    <div class="py-6 lg:py-8">

        <div class="mx-auto max-w-7xl space-y-5 px-4 sm:px-6 lg:px-8">

            {{-- Notifikasi berhasil --}}
            @if (session('success'))

                <div class="alert-maloppo-success">
                    {{ session('success') }}
                </div>

            @endif

            {{-- Notifikasi kesalahan --}}
            @if (session('error'))

                <div class="alert-maloppo-error">
                    {{ session('error') }}
                </div>

            @endif

            {{-- Daftar pesanan --}}
            <section class="panel-maloppo overflow-hidden">

                {{-- Header daftar --}}
                <div
                    class="flex flex-col gap-3 border-b border-gray-200 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6"
                >
                    <div>
                        <h2 class="section-title-maloppo">
                            Pesanan Aktif
                        </h2>

                        <p class="section-description-maloppo">
                            {{ $orders->total() }} pesanan sedang menunggu atau diproses.
                        </p>
                    </div>

                    @if ($orders->hasPages())

                        <p class="text-xs text-gray-500">
                            Halaman {{ $orders->currentPage() }}
                            dari {{ $orders->lastPage() }}
                        </p>

                    @endif
                </div>

                @if ($orders->count() > 0)

                    {{-- Tampilan desktop --}}
                    <div class="hidden overflow-x-auto lg:block">

                        <table class="table-maloppo">

                            <thead>
                                <tr>
                                    <th>
                                        Pesanan
                                    </th>

                                    <th>
                                        Pelanggan
                                    </th>

                                    <th class="text-center">
                                        Produk
                                    </th>

                                    <th>
                                        Total
                                    </th>

                                    <th>
                                        Status
                                    </th>

                                    <th>
                                        Waktu
                                    </th>

                                    <th class="text-right">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach ($orders as $order)

                                    @php
                                        $orderData =
                                            $prepareOrderData($order);
                                    @endphp

                                    <tr
                                        class="{{ $order->isUnread()
                                            ? 'bg-red-50/30'
                                            : '' }}"
                                    >

                                        {{-- Pesanan --}}
                                        <td>

                                            <div class="flex items-center gap-2">

                                                <a
                                                    href="{{ route('admin.orders.show', $order) }}"
                                                    class="font-medium text-gray-900 transition hover:text-red-700"
                                                >
                                                    {{ $order->order_code }}
                                                </a>

                                                @if ($order->isUnread())

                                                    <span
                                                        class="inline-flex rounded-full bg-red-600 px-2 py-0.5 text-[10px] font-semibold text-white"
                                                    >
                                                        Baru
                                                    </span>

                                                @endif

                                            </div>

                                        </td>

                                        {{-- Pelanggan --}}
                                        <td>

                                            <p class="font-medium text-gray-900">
                                                {{ $order->customer_name }}
                                            </p>

                                            <p class="mt-1 text-xs text-gray-500">
                                                {{ $order->customer_phone }}
                                            </p>

                                        </td>

                                        {{-- Jumlah produk --}}
                                        <td class="text-center">
                                            {{ $order->items_count }}
                                        </td>

                                        {{-- Total --}}
                                        <td class="font-medium text-gray-900">
                                            Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                        </td>

                                        {{-- Status --}}
                                        <td>

                                            <span
                                                class="inline-flex rounded-full px-2.5 py-1 text-xs font-medium {{ $orderData['statusClass'] }}"
                                            >
                                                {{ $orderData['statusLabel'] }}
                                            </span>

                                        </td>

                                        {{-- Waktu --}}
                                        <td>

                                            <p class="text-sm text-gray-700">
                                                {{ $order->created_at->format('d M Y') }}
                                            </p>

                                            <p class="mt-1 text-xs text-gray-400">
                                                {{ $order->created_at->format('H:i') }} WITA
                                            </p>

                                        </td>

                                        {{-- Aksi --}}
                                        <td>

                                            <div class="flex items-center justify-end gap-4">

                                                <a
                                                    href="{{ route('admin.orders.show', $order) }}"
                                                    class="text-sm font-medium text-gray-700 transition hover:text-red-700"
                                                >
                                                    Detail
                                                </a>

                                                <a
                                                    href="https://wa.me/{{ $orderData['whatsappNumber'] }}?text={{ urlencode($orderData['whatsappMessage']) }}"
                                                    target="_blank"
                                                    rel="noopener noreferrer"
                                                    class="text-sm font-medium text-green-700 transition hover:text-green-900"
                                                >
                                                    WhatsApp
                                                </a>

                                            </div>

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                    {{-- Tampilan HP dan tablet --}}
                    <div class="divide-y divide-gray-100 lg:hidden">

                        @foreach ($orders as $order)

                            @php
                                $orderData =
                                    $prepareOrderData($order);
                            @endphp

                            <article
                                class="p-4 sm:p-5
                                    {{ $order->isUnread()
                                        ? 'bg-red-50/30'
                                        : '' }}"
                            >

                                {{-- Kode dan status --}}
                                <div class="flex items-start justify-between gap-3">

                                    <div class="min-w-0">

                                        <div class="flex flex-wrap items-center gap-2">

                                            <h3 class="text-sm font-semibold text-gray-900">
                                                {{ $order->order_code }}
                                            </h3>

                                            @if ($order->isUnread())

                                                <span
                                                    class="inline-flex rounded-full bg-red-600 px-2 py-0.5 text-[10px] font-semibold text-white"
                                                >
                                                    Baru
                                                </span>

                                            @endif

                                        </div>

                                        <p class="mt-1 text-xs text-gray-500">
                                            {{ $order->created_at->format('d M Y, H:i') }}
                                            WITA
                                        </p>

                                    </div>

                                    <span
                                        class="shrink-0 rounded-full px-2.5 py-1 text-[10px] font-medium {{ $orderData['statusClass'] }}"
                                    >
                                        {{ $orderData['statusLabel'] }}
                                    </span>

                                </div>

                                {{-- Pelanggan --}}
                                <div class="mt-4">

                                    <p class="text-sm font-medium text-gray-900">
                                        {{ $order->customer_name }}
                                    </p>

                                    <p class="mt-1 text-xs text-gray-500">
                                        {{ $order->customer_phone }}
                                    </p>

                                </div>

                                {{-- Ringkasan --}}
                                <div
                                    class="mt-4 grid grid-cols-2 gap-3 rounded-lg border border-gray-200 bg-gray-50 p-3"
                                >

                                    <div>
                                        <p class="text-xs text-gray-500">
                                            Jumlah Produk
                                        </p>

                                        <p class="mt-1 text-sm font-medium text-gray-900">
                                            {{ $order->items_count }} produk
                                        </p>
                                    </div>

                                    <div>
                                        <p class="text-xs text-gray-500">
                                            Total
                                        </p>

                                        <p class="mt-1 text-sm font-semibold text-gray-900">
                                            Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                        </p>
                                    </div>

                                </div>

                                {{-- Tombol --}}
                                <div
                                    class="mt-4 flex items-center justify-end gap-4 border-t border-gray-100 pt-3"
                                >

                                    <a
                                        href="{{ route('admin.orders.show', $order) }}"
                                        class="text-sm font-medium text-gray-700"
                                    >
                                        Detail
                                    </a>

                                    <a
                                        href="https://wa.me/{{ $orderData['whatsappNumber'] }}?text={{ urlencode($orderData['whatsappMessage']) }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="text-sm font-medium text-green-700"
                                    >
                                        WhatsApp
                                    </a>

                                </div>

                            </article>

                        @endforeach

                    </div>

                    {{-- Pagination --}}
                    @if ($orders->hasPages())

                        <div class="border-t border-gray-200 bg-gray-50 px-5 py-4">
                            {{ $orders->links() }}
                        </div>

                    @endif

                @else

                    {{-- Belum ada pesanan --}}
                    <div class="px-5 py-14 text-center">

                        <p class="font-medium text-gray-700">
                            Belum ada pesanan aktif
                        </p>

                        <p class="mx-auto mt-1 max-w-md text-sm leading-6 text-gray-500">
                            Pesanan baru dari pelanggan akan tampil secara otomatis
                            pada halaman ini.
                        </p>

                        <a
                            href="{{ route('catalog.index') }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="btn-maloppo-secondary mt-4"
                        >
                            Buka Katalog
                        </a>

                    </div>

                @endif

            </section>

        </div>

    </div>

</x-app-layout>