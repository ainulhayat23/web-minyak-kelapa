<x-app-layout>

    <x-slot name="header">

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.20em] text-red-700">
                    Riwayat Pesanan
                </p>

                <h1 class="mt-2 text-3xl font-bold tracking-tight text-gray-900">
                    Riwayat Pesanan
                </h1>

                <p class="mt-2 text-sm leading-6 text-gray-500">
                    Lihat pesanan yang telah selesai atau dibatalkan.
                </p>
            </div>

            <a
                href="{{ route('admin.orders.index') }}"
                class="inline-flex items-center justify-center rounded-lg border border-red-200 bg-white px-5 py-3 text-sm font-semibold text-red-700 shadow-sm transition hover:bg-red-50"
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

            $whatsappNumber = preg_replace('/[^0-9]/', '', $order->customer_phone);

            if (str_starts_with($whatsappNumber, '0')) {
                $whatsappNumber = '62' . substr($whatsappNumber, 1);
            } elseif (str_starts_with($whatsappNumber, '8')) {
                $whatsappNumber = '62' . $whatsappNumber;
            }

            $messageLines = [
                'Halo Bapak/Ibu ' . $order->customer_name . ',',
                '',
                'Kami dari UMKM Maloppo ingin menyampaikan informasi mengenai pesanan Anda.',
                '',
                'Kode Pesanan: ' . $order->order_code,
                'Status Pesanan: ' . $statusLabel,
                'Tanggal Pesanan: ' . $order->created_at->format('d/m/Y H:i') . ' WITA',
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

            $messageLines[] = '';

            if ($order->status === 'completed') {
                $messageLines[] = 'Pesanan Anda telah selesai. Terima kasih telah berbelanja di UMKM Maloppo.';
            } else {
                $messageLines[] = 'Pesanan Anda telah dibatalkan. Silakan hubungi kami apabila membutuhkan informasi lebih lanjut.';
            }

            return [
                'statusLabel' => $statusLabel,
                'statusClass' => $statusClass,
                'whatsappNumber' => $whatsappNumber,
                'whatsappMessage' => implode("\n", $messageLines),
            ];
        };
    @endphp

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

            {{-- Ringkasan kecil --}}
            <section class="grid grid-cols-1 gap-4 sm:grid-cols-3">

                <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-semibold text-gray-500">
                        Total Riwayat
                    </p>

                    <p class="mt-2 text-3xl font-bold text-gray-900">
                        {{ $orders->total() }}
                    </p>

                    <p class="mt-1 text-xs text-gray-500">
                        Pesanan ditemukan berdasarkan filter.
                    </p>
                </div>

                <div class="rounded-2xl border border-green-100 bg-green-50 p-5 shadow-sm">
                    <p class="text-sm font-semibold text-green-700">
                        Status Selesai
                    </p>

                    <p class="mt-2 text-lg font-bold text-gray-900">
                        Pesanan Berhasil
                    </p>

                    <p class="mt-1 text-xs text-gray-600">
                        Pesanan yang telah selesai dapat dicek kembali di halaman ini.
                    </p>
                </div>

                <div class="rounded-2xl border border-red-100 bg-red-50 p-5 shadow-sm">
                    <p class="text-sm font-semibold text-red-700">
                        Status Dibatalkan
                    </p>

                    <p class="mt-2 text-lg font-bold text-gray-900">
                        Pesanan Batal
                    </p>

                    <p class="mt-1 text-xs text-gray-600">
                        Pesanan yang dibatalkan tetap tersimpan sebagai riwayat.
                    </p>
                </div>

            </section>

            {{-- Filter --}}
            <section class="rounded-3xl border border-gray-200 bg-white p-5 shadow-sm sm:p-6">

                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.20em] text-red-700">
                            Filter
                        </p>

                        <h2 class="mt-2 text-xl font-bold text-gray-900">
                            Filter Riwayat
                        </h2>

                        <p class="mt-1 text-sm text-gray-500">
                            Pilih status pesanan yang ingin ditampilkan.
                        </p>
                    </div>

                    <div class="flex flex-wrap gap-2">

                        <a
                            href="{{ route('admin.orders.history') }}"
                            class="inline-flex items-center justify-center rounded-lg border px-4 py-2.5 text-sm font-semibold transition
                                {{ $status === null
                                    ? 'border-red-700 bg-red-700 text-white shadow-sm'
                                    : 'border-gray-300 bg-white text-gray-700 hover:bg-gray-50' }}"
                        >
                            Semua
                        </a>

                        <a
                            href="{{ route('admin.orders.history', ['status' => 'completed']) }}"
                            class="inline-flex items-center justify-center rounded-lg border px-4 py-2.5 text-sm font-semibold transition
                                {{ $status === 'completed'
                                    ? 'border-green-700 bg-green-700 text-white shadow-sm'
                                    : 'border-gray-300 bg-white text-gray-700 hover:bg-gray-50' }}"
                        >
                            Selesai
                        </a>

                        <a
                            href="{{ route('admin.orders.history', ['status' => 'cancelled']) }}"
                            class="inline-flex items-center justify-center rounded-lg border px-4 py-2.5 text-sm font-semibold transition
                                {{ $status === 'cancelled'
                                    ? 'border-red-700 bg-red-700 text-white shadow-sm'
                                    : 'border-gray-300 bg-white text-gray-700 hover:bg-gray-50' }}"
                        >
                            Dibatalkan
                        </a>

                    </div>

                </div>

            </section>

            {{-- Daftar riwayat --}}
            <section class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">

                {{-- Header daftar --}}
                <div class="flex flex-col gap-3 border-b border-gray-200 bg-white px-6 py-5 sm:flex-row sm:items-center sm:justify-between">

                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">
                            Daftar Riwayat
                        </h2>

                        <p class="mt-1 text-sm text-gray-500">
                            {{ $orders->total() }} pesanan ditemukan berdasarkan filter.
                        </p>
                    </div>

                    <div class="flex flex-wrap items-center gap-3">

                        @if ($status === 'completed')

                            <span class="inline-flex rounded-full bg-green-50 px-3 py-1 text-xs font-bold text-green-700">
                                Selesai
                            </span>

                        @elseif ($status === 'cancelled')

                            <span class="inline-flex rounded-full bg-red-50 px-3 py-1 text-xs font-bold text-red-700">
                                Dibatalkan
                            </span>

                        @else

                            <span class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-xs font-bold text-gray-600">
                                Semua Status
                            </span>

                        @endif

                        @if ($orders->hasPages())

                            <span class="rounded-full bg-gray-100 px-4 py-2 text-xs font-semibold text-gray-600">
                                Halaman {{ $orders->currentPage() }} dari {{ $orders->lastPage() }}
                            </span>

                        @endif

                    </div>

                </div>

                @if ($orders->count() > 0)

                    {{-- Tampilan desktop --}}
                    <div class="hidden overflow-x-auto lg:block">

                        <table class="min-w-full divide-y divide-gray-200">

                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">
                                        Pesanan
                                    </th>

                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">
                                        Pelanggan
                                    </th>

                                    <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider text-gray-500">
                                        Produk
                                    </th>

                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">
                                        Total
                                    </th>

                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">
                                        Status
                                    </th>

                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">
                                        Tanggal
                                    </th>

                                    <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-gray-500">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-100 bg-white">

                                @foreach ($orders as $order)

                                    @php
                                        $orderData = $prepareHistoryOrder($order);
                                    @endphp

                                    <tr class="transition hover:bg-gray-50">

                                        {{-- Pesanan --}}
                                        <td class="px-6 py-4">

                                            <a
                                                href="{{ route('admin.orders.show', $order) }}"
                                                class="font-bold text-gray-900 transition hover:text-red-700"
                                            >
                                                {{ $order->order_code }}
                                            </a>

                                        </td>

                                        {{-- Pelanggan --}}
                                        <td class="px-6 py-4">

                                            <p class="font-semibold text-gray-900">
                                                {{ $order->customer_name }}
                                            </p>

                                            <p class="mt-1 text-xs text-gray-500">
                                                {{ $order->customer_phone }}
                                            </p>

                                        </td>

                                        {{-- Jumlah produk --}}
                                        <td class="px-6 py-4 text-center">

                                            <span class="inline-flex rounded-full bg-yellow-50 px-3 py-1 text-xs font-bold text-red-700">
                                                {{ $order->items_count }} produk
                                            </span>

                                        </td>

                                        {{-- Total --}}
                                        <td class="px-6 py-4 text-sm font-bold text-gray-900">
                                            Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                        </td>

                                        {{-- Status --}}
                                        <td class="px-6 py-4">

                                            <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold {{ $orderData['statusClass'] }}">
                                                {{ $orderData['statusLabel'] }}
                                            </span>

                                        </td>

                                        {{-- Tanggal --}}
                                        <td class="px-6 py-4">

                                            <p class="text-sm font-semibold text-gray-700">
                                                {{ $order->created_at->format('d M Y') }}
                                            </p>

                                            <p class="mt-1 text-xs text-gray-400">
                                                {{ $order->created_at->format('H:i') }} WITA
                                            </p>

                                        </td>

                                        {{-- Aksi --}}
                                        <td class="px-6 py-4">

                                            <div class="flex items-center justify-end gap-3">

                                                <a
                                                    href="{{ route('admin.orders.show', $order) }}"
                                                    class="inline-flex items-center justify-center rounded-lg border border-gray-200 px-3 py-2 text-sm font-semibold text-gray-700 transition hover:bg-gray-50 hover:text-red-700"
                                                >
                                                    Detail
                                                </a>

                                                <a
                                                    href="https://wa.me/{{ $orderData['whatsappNumber'] }}?text={{ urlencode($orderData['whatsappMessage']) }}"
                                                    target="_blank"
                                                    rel="noopener noreferrer"
                                                    class="inline-flex items-center justify-center rounded-lg border border-green-200 px-3 py-2 text-sm font-semibold text-green-700 transition hover:bg-green-50 hover:text-green-900"
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
                                $orderData = $prepareHistoryOrder($order);
                            @endphp

                            <article class="p-5">

                                {{-- Kode dan status --}}
                                <div class="flex items-start justify-between gap-3">

                                    <div class="min-w-0">

                                        <h3 class="text-sm font-bold text-gray-900">
                                            {{ $order->order_code }}
                                        </h3>

                                        <p class="mt-1 text-xs text-gray-500">
                                            {{ $order->created_at->format('d M Y, H:i') }} WITA
                                        </p>

                                    </div>

                                    <span class="shrink-0 rounded-full px-2.5 py-1 text-[10px] font-bold {{ $orderData['statusClass'] }}">
                                        {{ $orderData['statusLabel'] }}
                                    </span>

                                </div>

                                {{-- Pelanggan --}}
                                <div class="mt-4">

                                    <p class="text-sm font-bold text-gray-900">
                                        {{ $order->customer_name }}
                                    </p>

                                    <p class="mt-1 text-xs text-gray-500">
                                        {{ $order->customer_phone }}
                                    </p>

                                </div>

                                {{-- Informasi ringkas --}}
                                <div class="mt-4 grid grid-cols-2 gap-3 rounded-2xl border border-gray-200 bg-gray-50 p-4">

                                    <div>
                                        <p class="text-xs text-gray-500">
                                            Jumlah Produk
                                        </p>

                                        <p class="mt-1 text-sm font-bold text-gray-900">
                                            {{ $order->items_count }} produk
                                        </p>
                                    </div>

                                    <div>
                                        <p class="text-xs text-gray-500">
                                            Total
                                        </p>

                                        <p class="mt-1 text-sm font-bold text-red-700">
                                            Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                        </p>
                                    </div>

                                </div>

                                {{-- Aksi --}}
                                <div class="mt-4 flex items-center justify-end gap-3 border-t border-gray-100 pt-4">

                                    <a
                                        href="{{ route('admin.orders.show', $order) }}"
                                        class="inline-flex items-center justify-center rounded-lg border border-gray-200 px-4 py-2 text-sm font-semibold text-gray-700"
                                    >
                                        Detail
                                    </a>

                                    <a
                                        href="https://wa.me/{{ $orderData['whatsappNumber'] }}?text={{ urlencode($orderData['whatsappMessage']) }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="inline-flex items-center justify-center rounded-lg border border-green-200 px-4 py-2 text-sm font-semibold text-green-700"
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
                    <div class="px-5 py-16 text-center">

                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-red-50 text-2xl">
                            📦
                        </div>

                        <p class="mt-4 text-lg font-bold text-gray-800">
                            Riwayat pesanan belum tersedia
                        </p>

                        <p class="mx-auto mt-1 max-w-md text-sm leading-6 text-gray-500">
                            Pesanan yang selesai atau dibatalkan akan ditampilkan pada halaman ini.
                        </p>

                        <a
                            href="{{ route('admin.orders.index') }}"
                            class="mt-5 inline-flex items-center justify-center rounded-lg border border-red-200 bg-white px-5 py-3 text-sm font-semibold text-red-700 shadow-sm transition hover:bg-red-50"
                        >
                            Lihat Pesanan Aktif
                        </a>

                    </div>

                @endif

            </section>

        </div>

    </div>

</x-app-layout>