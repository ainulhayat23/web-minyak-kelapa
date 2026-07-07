<x-app-layout>

    <x-slot name="header">

        <div
            class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"
        >
            <div>
                <h1 class="page-title-maloppo">
                    Riwayat Pesanan
                </h1>

                <p class="page-description-maloppo">
                    Lihat pesanan yang telah selesai atau dibatalkan.
                </p>
            </div>

            <a
                href="{{ route('admin.orders.index') }}"
                class="btn-maloppo-secondary"
            >
                Pesanan Aktif
            </a>
        </div>

    </x-slot>

    @php
        $prepareHistoryOrder = function ($order) {
            $statusLabel = match ($order->status) {
                'completed' => 'Selesai',
                'cancelled' => 'Dibatalkan',
                default => ucfirst($order->status),
            };

            $statusClass = match ($order->status) {
                'completed' => 'bg-green-50 text-green-700',
                'cancelled' => 'bg-red-50 text-red-700',
                default => 'bg-gray-100 text-gray-600',
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
                'Kami dari UMKM Maloppo ingin menyampaikan informasi mengenai pesanan Anda.',
                '',
                'Kode Pesanan: ' . $order->order_code,
                'Status Pesanan: ' . $statusLabel,
                'Tanggal Pesanan: ' .
                    $order->created_at->format('d/m/Y H:i') .
                    ' WITA',
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

            $messageLines[] = '';

            if ($order->status === 'completed') {
                $messageLines[] =
                    'Pesanan Anda telah selesai. Terima kasih telah berbelanja di UMKM Maloppo.';
            } else {
                $messageLines[] =
                    'Pesanan Anda telah dibatalkan. Silakan hubungi kami apabila membutuhkan informasi lebih lanjut.';
            }

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

            {{-- Filter --}}
            <section class="panel-maloppo p-4 sm:p-5">

                <div
                    class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"
                >
                    <div>
                        <h2 class="text-sm font-semibold text-gray-900">
                            Filter Riwayat
                        </h2>

                        <p class="mt-1 text-xs text-gray-500">
                            Pilih status pesanan yang ingin ditampilkan.
                        </p>
                    </div>

                    <div class="flex flex-wrap gap-2">

                        <a
                            href="{{ route('admin.orders.history') }}"
                            class="inline-flex items-center justify-center rounded-lg border px-4 py-2 text-sm font-medium transition
                                {{ $status === null
                                    ? 'border-red-700 bg-red-700 text-white'
                                    : 'border-gray-300 bg-white text-gray-700 hover:bg-gray-50' }}"
                        >
                            Semua
                        </a>

                        <a
                            href="{{ route('admin.orders.history', ['status' => 'completed']) }}"
                            class="inline-flex items-center justify-center rounded-lg border px-4 py-2 text-sm font-medium transition
                                {{ $status === 'completed'
                                    ? 'border-green-700 bg-green-700 text-white'
                                    : 'border-gray-300 bg-white text-gray-700 hover:bg-gray-50' }}"
                        >
                            Selesai
                        </a>

                        <a
                            href="{{ route('admin.orders.history', ['status' => 'cancelled']) }}"
                            class="inline-flex items-center justify-center rounded-lg border px-4 py-2 text-sm font-medium transition
                                {{ $status === 'cancelled'
                                    ? 'border-red-700 bg-red-700 text-white'
                                    : 'border-gray-300 bg-white text-gray-700 hover:bg-gray-50' }}"
                        >
                            Dibatalkan
                        </a>

                    </div>
                </div>

            </section>

            {{-- Daftar riwayat --}}
            <section class="panel-maloppo overflow-hidden">

                {{-- Header daftar --}}
                <div
                    class="flex flex-col gap-3 border-b border-gray-200 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6"
                >
                    <div>
                        <h2 class="section-title-maloppo">
                            Daftar Riwayat
                        </h2>

                        <p class="section-description-maloppo">
                            {{ $orders->total() }} pesanan ditemukan berdasarkan filter.
                        </p>
                    </div>

                    <div class="flex items-center gap-3">

                        @if ($status === 'completed')

                            <span
                                class="inline-flex rounded-full bg-green-50 px-2.5 py-1 text-xs font-medium text-green-700"
                            >
                                Selesai
                            </span>

                        @elseif ($status === 'cancelled')

                            <span
                                class="inline-flex rounded-full bg-red-50 px-2.5 py-1 text-xs font-medium text-red-700"
                            >
                                Dibatalkan
                            </span>

                        @else

                            <span
                                class="inline-flex rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-600"
                            >
                                Semua Status
                            </span>

                        @endif

                        @if ($orders->hasPages())

                            <span class="text-xs text-gray-500">
                                Halaman {{ $orders->currentPage() }}
                                dari {{ $orders->lastPage() }}
                            </span>

                        @endif

                    </div>
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
                                        Tanggal
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
                                            $prepareHistoryOrder($order);
                                    @endphp

                                    <tr>

                                        {{-- Pesanan --}}
                                        <td>

                                            <a
                                                href="{{ route('admin.orders.show', $order) }}"
                                                class="font-medium text-gray-900 transition hover:text-red-700"
                                            >
                                                {{ $order->order_code }}
                                            </a>

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

                                        {{-- Tanggal --}}
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
                                    $prepareHistoryOrder($order);
                            @endphp

                            <article class="p-4 sm:p-5">

                                {{-- Kode dan status --}}
                                <div class="flex items-start justify-between gap-3">

                                    <div class="min-w-0">

                                        <h3 class="text-sm font-semibold text-gray-900">
                                            {{ $order->order_code }}
                                        </h3>

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

                                {{-- Informasi ringkas --}}
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

                                {{-- Aksi --}}
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

                    {{-- Riwayat kosong --}}
                    <div class="px-5 py-14 text-center">

                        <p class="font-medium text-gray-700">
                            Riwayat pesanan belum tersedia
                        </p>

                        <p class="mx-auto mt-1 max-w-md text-sm leading-6 text-gray-500">
                            Pesanan yang selesai atau dibatalkan akan ditampilkan
                            pada halaman ini.
                        </p>

                        <a
                            href="{{ route('admin.orders.index') }}"
                            class="btn-maloppo-secondary mt-4"
                        >
                            Lihat Pesanan Aktif
                        </a>

                    </div>

                @endif

            </section>

        </div>

    </div>

</x-app-layout>