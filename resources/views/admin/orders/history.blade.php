<x-app-layout>

    <x-slot name="header">

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h1 class="text-2xl font-extrabold leading-tight text-gray-900">
                    Riwayat Pesanan
                </h1>

                <p class="mt-2 text-sm font-normal text-gray-600">
                    Lihat pesanan yang telah selesai atau dibatalkan.
                </p>
            </div>

            <a
                href="{{ route('admin.orders.index') }}"
                class="btn-maloppo-secondary"
            >
                <span aria-hidden="true">←</span>
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

            $statusStyle = match ($order->status) {
                'completed' => 'background-color: #dcfce7; color: #166534;',
                'cancelled' => 'background-color: #fee2e2; color: #991b1b;',
                default => 'background-color: #f3f4f6; color: #374151;',
            };

            $statusIcon = match ($order->status) {
                'completed' => '✅',
                'cancelled' => '✕',
                default => '•',
            };

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
                'statusStyle' => $statusStyle,
                'statusIcon' => $statusIcon,
                'whatsappNumber' => $whatsappNumber,
                'whatsappMessage' => implode("\n", $messageLines),
            ];
        };
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

            {{-- Filter status --}}
            <section class="card-maloppo mb-7 overflow-hidden">

                <div
                    class="flex flex-col gap-5 p-5 sm:flex-row sm:items-center sm:justify-between sm:p-6"
                >

                    <div class="flex items-center gap-4">

                        <div
                            class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl text-xl"
                            style="background-color: #f7e900;"
                        >
                            🔎
                        </div>

                        <div>
                            <h2 class="text-lg font-extrabold text-gray-900">
                                Filter Riwayat
                            </h2>

                            <p class="mt-1 text-sm text-gray-500">
                                Pilih jenis riwayat pesanan yang ingin ditampilkan.
                            </p>
                        </div>

                    </div>

                    <div class="flex flex-wrap gap-2">

                        {{-- Semua --}}
                        <a
                            href="{{ route('admin.orders.history') }}"
                            class="inline-flex items-center justify-center gap-2 rounded-xl px-4 py-2.5 text-sm font-bold transition"
                            style="{{ $status === null
                                ? 'background-color: #be0000; color: white;'
                                : 'background-color: #fffdf0; color: #4b5563; border: 1px solid #f1e7a4;' }}"
                        >
                            <span>🗂️</span>
                            Semua
                        </a>

                        {{-- Selesai --}}
                        <a
                            href="{{ route('admin.orders.history', ['status' => 'completed']) }}"
                            class="inline-flex items-center justify-center gap-2 rounded-xl px-4 py-2.5 text-sm font-bold transition"
                            style="{{ $status === 'completed'
                                ? 'background-color: #166534; color: white;'
                                : 'background-color: #dcfce7; color: #166534;' }}"
                        >
                            <span>✅</span>
                            Selesai
                        </a>

                        {{-- Dibatalkan --}}
                        <a
                            href="{{ route('admin.orders.history', ['status' => 'cancelled']) }}"
                            class="inline-flex items-center justify-center gap-2 rounded-xl px-4 py-2.5 text-sm font-bold transition"
                            style="{{ $status === 'cancelled'
                                ? 'background-color: #991b1b; color: white;'
                                : 'background-color: #fee2e2; color: #991b1b;' }}"
                        >
                            <span>✕</span>
                            Dibatalkan
                        </a>

                    </div>

                </div>

            </section>

            {{-- Statistik --}}
            <section class="mb-7 grid grid-cols-1 gap-4 sm:grid-cols-3">

                <article class="card-maloppo p-5">

                    <div class="flex items-center justify-between gap-4">

                        <div>
                            <p class="text-sm font-semibold text-gray-500">
                                Total Riwayat
                            </p>

                            <p class="mt-2 text-3xl font-extrabold text-gray-900">
                                {{ $orders->total() }}
                            </p>

                            <p class="mt-1 text-xs text-gray-500">
                                Berdasarkan filter aktif
                            </p>
                        </div>

                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-xl text-xl"
                            style="background-color: #fff9b0;"
                        >
                            🗂️
                        </div>

                    </div>

                </article>

                <article class="card-maloppo p-5">

                    <div class="flex items-center justify-between gap-4">

                        <div>
                            <p class="text-sm font-semibold text-gray-500">
                                Ditampilkan
                            </p>

                            <p class="mt-2 text-3xl font-extrabold text-gray-900">
                                {{ $orders->count() }}
                            </p>

                            <p class="mt-1 text-xs text-gray-500">
                                Pesanan pada halaman ini
                            </p>
                        </div>

                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-xl text-xl"
                            style="
                                background-color: #dcfce7;
                                color: #166534;
                            "
                        >
                            ✓
                        </div>

                    </div>

                </article>

                <article class="card-maloppo p-5">

                    <div class="flex items-center justify-between gap-4">

                        <div>
                            <p class="text-sm font-semibold text-gray-500">
                                Halaman Aktif
                            </p>

                            <p class="mt-2 text-3xl font-extrabold text-gray-900">
                                {{ $orders->currentPage() }}
                            </p>

                            <p class="mt-1 text-xs text-gray-500">
                                Dari {{ $orders->lastPage() }} halaman
                            </p>
                        </div>

                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-xl text-xl"
                            style="
                                background-color: #fee2e2;
                                color: #991b1b;
                            "
                        >
                            📄
                        </div>

                    </div>

                </article>

            </section>

            {{-- Daftar riwayat --}}
            <section class="card-maloppo overflow-hidden">

                {{-- Header --}}
                <div
                    class="flex flex-col gap-4 border-b px-6 py-5 sm:flex-row sm:items-center sm:justify-between"
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
                            🕘
                        </div>

                        <div>
                            <h2 class="text-xl font-extrabold text-gray-900">
                                Daftar Riwayat Pesanan
                            </h2>

                            <p class="mt-1 text-sm text-gray-500">
                                Pesanan yang sudah tidak termasuk proses aktif.
                            </p>
                        </div>

                    </div>

                    @if ($status === 'completed')

                        <span
                            class="inline-flex w-fit items-center gap-2 rounded-full px-4 py-2 text-xs font-bold"
                            style="
                                background-color: #dcfce7;
                                color: #166534;
                            "
                        >
                            <span>✅</span>
                            Filter Selesai
                        </span>

                    @elseif ($status === 'cancelled')

                        <span
                            class="inline-flex w-fit items-center gap-2 rounded-full px-4 py-2 text-xs font-bold"
                            style="
                                background-color: #fee2e2;
                                color: #991b1b;
                            "
                        >
                            <span>✕</span>
                            Filter Dibatalkan
                        </span>

                    @else

                        <span
                            class="inline-flex w-fit items-center gap-2 rounded-full px-4 py-2 text-xs font-bold"
                            style="
                                background-color: #fff9b0;
                                color: #990100;
                            "
                        >
                            <span>🗂️</span>
                            Semua Riwayat
                        </span>

                    @endif

                </div>

                @if ($orders->count() > 0)

                    {{-- Tampilan desktop --}}
                    <div class="hidden overflow-x-auto lg:block">

                        <table class="min-w-full">

                            <thead>

                                <tr
                                    class="border-b"
                                    style="
                                        background-color: #fff9b0;
                                        border-color: #f1e7a4;
                                    "
                                >

                                    <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700">
                                        Kode Pesanan
                                    </th>

                                    <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700">
                                        Pelanggan
                                    </th>

                                    <th class="px-5 py-4 text-center text-xs font-bold uppercase tracking-wider text-gray-700">
                                        Produk
                                    </th>

                                    <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700">
                                        Total
                                    </th>

                                    <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700">
                                        Status
                                    </th>

                                    <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700">
                                        Tanggal
                                    </th>

                                    <th class="px-5 py-4 text-center text-xs font-bold uppercase tracking-wider text-gray-700">
                                        Aksi
                                    </th>

                                </tr>

                            </thead>

                            <tbody>

                                @foreach ($orders as $order)

                                    @php
                                        $orderData = $prepareHistoryOrder($order);
                                    @endphp

                                    <tr
                                        class="border-b transition last:border-b-0 hover:bg-yellow-50/40"
                                        style="border-color: #f1e7a4;"
                                    >

                                        {{-- Kode --}}
                                        <td class="whitespace-nowrap px-5 py-5">

                                            <span
                                                class="inline-flex rounded-lg px-3 py-2 text-xs font-extrabold"
                                                style="
                                                    background-color: #fff9b0;
                                                    color: #990100;
                                                "
                                            >
                                                {{ $order->order_code }}
                                            </span>

                                        </td>

                                        {{-- Pelanggan --}}
                                        <td class="px-5 py-5">

                                            <div class="flex items-center gap-3">

                                                <div
                                                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full text-sm font-extrabold text-white"
                                                    style="background-color: #be0000;"
                                                >
                                                    {{ strtoupper(substr($order->customer_name, 0, 1)) }}
                                                </div>

                                                <div>

                                                    <p class="font-bold text-gray-900">
                                                        {{ $order->customer_name }}
                                                    </p>

                                                    <p class="mt-1 text-xs text-gray-500">
                                                        {{ $order->customer_phone }}
                                                    </p>

                                                </div>

                                            </div>

                                        </td>

                                        {{-- Produk --}}
                                        <td class="whitespace-nowrap px-5 py-5 text-center">

                                            <span
                                                class="inline-flex min-w-10 items-center justify-center rounded-full px-3 py-1.5 text-xs font-bold"
                                                style="
                                                    background-color: #fff9b0;
                                                    color: #990100;
                                                "
                                            >
                                                {{ $order->items_count }}
                                            </span>

                                        </td>

                                        {{-- Total --}}
                                        <td class="whitespace-nowrap px-5 py-5">

                                            <p class="font-extrabold text-maloppo-red">
                                                Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                            </p>

                                        </td>

                                        {{-- Status --}}
                                        <td class="whitespace-nowrap px-5 py-5">

                                            <span
                                                class="inline-flex items-center gap-1.5 rounded-full px-3 py-1.5 text-xs font-bold"
                                                style="{{ $orderData['statusStyle'] }}"
                                            >
                                                <span>{{ $orderData['statusIcon'] }}</span>
                                                {{ $orderData['statusLabel'] }}
                                            </span>

                                        </td>

                                        {{-- Tanggal --}}
                                        <td class="whitespace-nowrap px-5 py-5">

                                            <p class="text-sm font-semibold text-gray-700">
                                                {{ $order->created_at->format('d/m/Y') }}
                                            </p>

                                            <p class="mt-1 text-xs text-gray-500">
                                                {{ $order->created_at->format('H:i') }} WITA
                                            </p>

                                        </td>

                                        {{-- Aksi --}}
                                        <td class="whitespace-nowrap px-5 py-5">

                                            <div class="flex items-center justify-center gap-2">

                                                <a
                                                    href="{{ route('admin.orders.show', $order) }}"
                                                    class="inline-flex items-center justify-center gap-1.5 rounded-lg px-4 py-2 text-xs font-bold"
                                                    style="
                                                        background-color: #f7e900;
                                                        color: #990100;
                                                    "
                                                >
                                                    <span>👁️</span>
                                                    Detail
                                                </a>

                                                <a
                                                    href="https://wa.me/{{ $orderData['whatsappNumber'] }}?text={{ urlencode($orderData['whatsappMessage']) }}"
                                                    target="_blank"
                                                    rel="noopener noreferrer"
                                                    class="inline-flex items-center justify-center gap-1.5 rounded-lg px-4 py-2 text-xs font-bold"
                                                    style="
                                                        background-color: #dcfce7;
                                                        color: #166534;
                                                    "
                                                >
                                                    <span>💬</span>
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
                    <div
                        class="divide-y lg:hidden"
                        style="border-color: #f1e7a4;"
                    >

                        @foreach ($orders as $order)

                            @php
                                $orderData = $prepareHistoryOrder($order);
                            @endphp

                            <article class="p-5 sm:p-6">

                                {{-- Kode dan status --}}
                                <div class="flex items-start justify-between gap-4">

                                    <div>

                                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">
                                            Kode Pesanan
                                        </p>

                                        <h3 class="mt-1 font-extrabold text-gray-900">
                                            {{ $order->order_code }}
                                        </h3>

                                    </div>

                                    <span
                                        class="inline-flex shrink-0 items-center gap-1 rounded-full px-3 py-1 text-xs font-bold"
                                        style="{{ $orderData['statusStyle'] }}"
                                    >
                                        <span>{{ $orderData['statusIcon'] }}</span>
                                        {{ $orderData['statusLabel'] }}
                                    </span>

                                </div>

                                {{-- Pelanggan --}}
                                <div
                                    class="mt-5 flex items-center gap-3 rounded-xl border p-4"
                                    style="
                                        background-color: #fffdf0;
                                        border-color: #f1e7a4;
                                    "
                                >

                                    <div
                                        class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full text-sm font-extrabold text-white"
                                        style="background-color: #be0000;"
                                    >
                                        {{ strtoupper(substr($order->customer_name, 0, 1)) }}
                                    </div>

                                    <div class="min-w-0">

                                        <p class="truncate font-bold text-gray-900">
                                            {{ $order->customer_name }}
                                        </p>

                                        <p class="mt-1 text-xs text-gray-500">
                                            {{ $order->customer_phone }}
                                        </p>

                                    </div>

                                </div>

                                {{-- Informasi --}}
                                <div class="mt-5 grid grid-cols-2 gap-3">

                                    <div
                                        class="rounded-xl p-4"
                                        style="background-color: #fff9b0;"
                                    >
                                        <p class="text-xs text-gray-500">
                                            Jumlah Produk
                                        </p>

                                        <p class="mt-1 text-sm font-extrabold text-gray-900">
                                            {{ $order->items_count }} produk
                                        </p>
                                    </div>

                                    <div
                                        class="rounded-xl p-4"
                                        style="background-color: #fff9b0;"
                                    >
                                        <p class="text-xs text-gray-500">
                                            Tanggal
                                        </p>

                                        <p class="mt-1 text-sm font-extrabold text-gray-900">
                                            {{ $order->created_at->format('d/m/Y') }}
                                        </p>

                                        <p class="mt-1 text-xs text-gray-500">
                                            {{ $order->created_at->format('H:i') }} WITA
                                        </p>
                                    </div>

                                </div>

                                {{-- Total --}}
                                <div
                                    class="mt-4 flex items-center justify-between gap-4 rounded-xl border p-4"
                                    style="
                                        background-color: #fffdf0;
                                        border-color: #f1e7a4;
                                    "
                                >
                                    <span class="text-sm font-semibold text-gray-500">
                                        Total Pesanan
                                    </span>

                                    <span class="text-lg font-extrabold text-maloppo-red">
                                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                    </span>
                                </div>

                                {{-- Tombol --}}
                                <div class="mt-5 grid grid-cols-2 gap-3">

                                    <a
                                        href="{{ route('admin.orders.show', $order) }}"
                                        class="inline-flex items-center justify-center gap-2 rounded-xl px-4 py-3 text-sm font-bold"
                                        style="
                                            background-color: #f7e900;
                                            color: #990100;
                                        "
                                    >
                                        <span>👁️</span>
                                        Detail
                                    </a>

                                    <a
                                        href="https://wa.me/{{ $orderData['whatsappNumber'] }}?text={{ urlencode($orderData['whatsappMessage']) }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="inline-flex items-center justify-center gap-2 rounded-xl px-4 py-3 text-sm font-bold"
                                        style="
                                            background-color: #dcfce7;
                                            color: #166534;
                                        "
                                    >
                                        <span>💬</span>
                                        WhatsApp
                                    </a>

                                </div>

                            </article>

                        @endforeach

                    </div>

                    {{-- Pagination --}}
                    @if ($orders->hasPages())

                        <div
                            class="border-t px-5 py-5"
                            style="
                                background-color: #fffdf0;
                                border-color: #f1e7a4;
                            "
                        >
                            {{ $orders->links() }}
                        </div>

                    @endif

                @else

                    {{-- Riwayat kosong --}}
                    <div class="px-6 py-20 text-center">

                        <div
                            class="mx-auto flex h-24 w-24 items-center justify-center rounded-full text-5xl"
                            style="background-color: #fff9b0;"
                        >
                            🗂️
                        </div>

                        <h3 class="mt-6 text-xl font-extrabold text-gray-900">
                            Riwayat Pesanan Belum Tersedia
                        </h3>

                        <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-gray-500">
                            Pesanan dengan status selesai atau dibatalkan akan
                            ditampilkan pada halaman ini.
                        </p>

                        <a
                            href="{{ route('admin.orders.index') }}"
                            class="btn-maloppo-primary mt-6"
                        >
                            <span>📦</span>
                            Lihat Pesanan Aktif
                        </a>

                    </div>

                @endif

            </section>

        </div>

    </div>

</x-app-layout>