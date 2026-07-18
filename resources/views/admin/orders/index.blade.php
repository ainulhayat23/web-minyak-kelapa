<x-app-layout>

    <x-slot name="header">

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.20em] text-red-700">
                    Pesanan Maloppo
                </p>

                <h1 class="mt-2 text-3xl font-bold tracking-tight text-gray-900">
                    Pesanan Aktif
                </h1>

                <p class="mt-2 text-sm leading-6 text-gray-500">
                    Periksa dan proses pesanan pelanggan yang masuk melalui website.
                </p>
            </div>

            <div class="flex flex-wrap gap-2">

                <a
                    href="{{ route('admin.orders.history') }}"
                    class="inline-flex items-center justify-center rounded-lg border border-red-200 bg-white px-5 py-3 text-sm font-semibold text-red-700 shadow-sm transition hover:bg-red-50"
                >
                    Riwayat Pesanan
                </a>

                <a
                    href="{{ route('catalog.index') }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-5 py-3 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50"
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
                'pending' => 'bg-amber-50 text-amber-700',
                'confirmed' => 'bg-blue-50 text-blue-700',
                'processing' => 'bg-indigo-50 text-indigo-700',
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
                        Total Pesanan Aktif
                    </p>

                    <p class="mt-2 text-3xl font-bold text-gray-900">
                        {{ $orders->total() }}
                    </p>

                    <p class="mt-1 text-xs text-gray-500">
                        Pesanan yang perlu dipantau admin.
                    </p>
                </div>

                <div class="rounded-2xl border border-yellow-200 bg-yellow-50 p-5 shadow-sm">
                    <p class="text-sm font-semibold text-red-700">
                        Konfirmasi Pelanggan
                    </p>

                    <p class="mt-2 text-lg font-bold text-gray-900">
                        Via WhatsApp
                    </p>

                    <p class="mt-1 text-xs text-gray-600">
                        Admin dapat menghubungi pelanggan langsung dari tombol WhatsApp.
                    </p>
                </div>

                <div class="rounded-2xl border border-red-100 bg-red-50 p-5 shadow-sm">
                    <p class="text-sm font-semibold text-red-700">
                        Status Pesanan
                    </p>

                    <p class="mt-2 text-lg font-bold text-gray-900">
                        Diproses Bertahap
                    </p>

                    <p class="mt-1 text-xs text-gray-600">
                        Periksa detail pesanan untuk mengubah status pesanan.
                    </p>
                </div>

            </section>

            {{-- Daftar pesanan --}}
            <section class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">

                {{-- Header daftar --}}
                <div class="flex flex-col gap-3 border-b border-gray-200 bg-white px-6 py-5 sm:flex-row sm:items-center sm:justify-between">

                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">
                            Data Pesanan
                        </h2>

                        <p class="mt-1 text-sm text-gray-500">
                            {{ $orders->total() }} pesanan sedang menunggu atau diproses.
                        </p>
                    </div>

                    @if ($orders->hasPages())

                        <div class="rounded-full bg-gray-100 px-4 py-2 text-xs font-semibold text-gray-600">
                            Halaman {{ $orders->currentPage() }} dari {{ $orders->lastPage() }}
                        </div>

                    @endif

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
                                        Waktu
                                    </th>

                                    <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-gray-500">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-100 bg-white">

                                @foreach ($orders as $order)

                                    @php
                                        $orderData = $prepareOrderData($order);
                                    @endphp

                                    <tr class="transition hover:bg-gray-50 {{ $order->isUnread() ? 'bg-red-50/40' : '' }}">

                                        {{-- Pesanan --}}
                                        <td class="px-6 py-4">

                                            <div class="flex items-center gap-2">

                                                <a
                                                    href="{{ route('admin.orders.show', $order) }}"
                                                    class="font-bold text-gray-900 transition hover:text-red-700"
                                                >
                                                    {{ $order->order_code }}
                                                </a>

                                                @if ($order->isUnread())

                                                    <span class="inline-flex rounded-full bg-red-600 px-2 py-0.5 text-[10px] font-bold text-white">
                                                        Baru
                                                    </span>

                                                @endif

                                            </div>

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

                                        {{-- Waktu --}}
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
                                $orderData = $prepareOrderData($order);
                            @endphp

                            <article class="p-5 {{ $order->isUnread() ? 'bg-red-50/40' : '' }}">

                                {{-- Kode dan status --}}
                                <div class="flex items-start justify-between gap-3">

                                    <div class="min-w-0">

                                        <div class="flex flex-wrap items-center gap-2">

                                            <h3 class="text-sm font-bold text-gray-900">
                                                {{ $order->order_code }}
                                            </h3>

                                            @if ($order->isUnread())

                                                <span class="inline-flex rounded-full bg-red-600 px-2 py-0.5 text-[10px] font-bold text-white">
                                                    Baru
                                                </span>

                                            @endif

                                        </div>

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

                                {{-- Ringkasan --}}
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

                                {{-- Tombol --}}
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

                    {{-- Belum ada pesanan --}}
                    <div class="px-5 py-16 text-center">

                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-red-50 text-2xl">
                            🛒
                        </div>

                        <p class="mt-4 text-lg font-bold text-gray-800">
                            Belum ada pesanan aktif
                        </p>

                        <p class="mx-auto mt-1 max-w-md text-sm leading-6 text-gray-500">
                            Pesanan baru dari pelanggan akan tampil secara otomatis pada halaman ini.
                        </p>

                        <a
                            href="{{ route('catalog.index') }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="mt-5 inline-flex items-center justify-center rounded-lg border border-red-200 bg-white px-5 py-3 text-sm font-semibold text-red-700 shadow-sm transition hover:bg-red-50"
                        >
                            Buka Katalog
                        </a>

                    </div>

                @endif

            </section>

        </div>

    </div>

</x-app-layout>