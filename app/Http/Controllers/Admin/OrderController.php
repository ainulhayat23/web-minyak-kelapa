<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    /**
     * Menampilkan pesanan yang masih aktif.
     */
    public function index()
    {
        $orders = Order::with('items')
            ->withCount('items')
            ->whereIn('status', [
                'pending',
                'confirmed',
                'processing',
            ])
            ->latest()
            ->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Memberikan data pesanan yang belum dibaca untuk notifikasi admin.
     */
    public function notificationSummary(): JsonResponse
    {
        $unreadCount = Order::unread()->count();

        $unreadOrders = Order::unread()
            ->latest()
            ->limit(5)
            ->get([
                'id',
                'order_code',
                'customer_name',
                'customer_phone',
                'total_amount',
                'status',
                'created_at',
            ]);

        $notifications = $unreadOrders
            ->map(function (Order $unreadOrder): array {
                return [
                    'id' => $unreadOrder->id,
                    'order_code' => $unreadOrder->order_code,
                    'customer_name' => $unreadOrder->customer_name,
                    'customer_phone' => $unreadOrder->customer_phone,
                    'total_amount' => (int) $unreadOrder->total_amount,
                    'total_formatted' =>
                        'Rp ' .
                        number_format(
                            $unreadOrder->total_amount,
                            0,
                            ',',
                            '.'
                        ),
                    'status' => $unreadOrder->status,
                    'created_at' =>
                        $unreadOrder->created_at?->toIso8601String(),
                    'time_label' =>
                        $unreadOrder->created_at?->diffForHumans(),
                    'url' => route(
                        'admin.orders.show',
                        $unreadOrder
                    ),
                ];
            })
            ->values();

        return response()->json([
            'unread_count' => $unreadCount,
            'latest_order' => $notifications->first(),
            'orders' => $notifications,
        ]);
    }

    /**
     * Menampilkan riwayat pesanan selesai dan dibatalkan.
     */
    public function history(Request $request)
    {
        $status = $request->query('status');

        $allowedStatuses = [
            'completed',
            'cancelled',
        ];

        /*
        |--------------------------------------------------------------------------
        | Memastikan filter status valid
        |--------------------------------------------------------------------------
        */

        if (! in_array($status, $allowedStatuses, true)) {
            $status = null;
        }

        /*
        |--------------------------------------------------------------------------
        | Mengambil data riwayat pesanan
        |--------------------------------------------------------------------------
        */

        $orders = Order::with('items')
            ->withCount('items')
            ->whereIn('status', $allowedStatuses)
            ->when($status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.orders.history', compact(
            'orders',
            'status'
        ));
    }

    /**
     * Menampilkan detail satu pesanan.
     */
    public function show(Order $order)
    {
        /*
         * Saat detail pesanan dibuka, pesanan dianggap
         * sudah dilihat oleh administrator.
         */
        $order->markAsRead();

        $order->load([
            'items.product',
        ]);

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Mengubah status pesanan dan menyesuaikan stok produk.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => [
                'required',
                'in:pending,confirmed,processing,completed,cancelled',
            ],
        ], [
            'status.required' => 'Status pesanan wajib dipilih.',
            'status.in' => 'Status pesanan yang dipilih tidak valid.',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Status yang menggunakan stok
        |--------------------------------------------------------------------------
        |
        | Saat pesanan berada pada status Dikonfirmasi, Diproses, atau Selesai,
        | stok produk dianggap sudah digunakan.
        |
        */

        $statusesUsingStock = [
            'confirmed',
            'processing',
            'completed',
        ];

        $result = DB::transaction(function () use (
            $order,
            $validated,
            $statusesUsingStock
        ) {
            /*
            |--------------------------------------------------------------------------
            | Mengunci data pesanan
            |--------------------------------------------------------------------------
            */

            $lockedOrder = Order::query()
                ->whereKey($order->id)
                ->lockForUpdate()
                ->firstOrFail();

            $lockedOrder->load('items');

            $oldStatus = $lockedOrder->status;
            $newStatus = $validated['status'];

            $stockAlreadyDeducted =
                $lockedOrder->stock_deducted_at !== null;

            $newStatusUsesStock = in_array(
                $newStatus,
                $statusesUsingStock,
                true
            );

            /*
            |--------------------------------------------------------------------------
            | Memastikan pesanan memiliki produk
            |--------------------------------------------------------------------------
            */

            if ($lockedOrder->items->isEmpty()) {
                throw ValidationException::withMessages([
                    'status' =>
                        'Status tidak dapat diubah karena pesanan tidak memiliki produk.',
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Mengelompokkan jumlah produk
            |--------------------------------------------------------------------------
            */

            $hasDeletedProduct = $lockedOrder->items->contains(
                function ($item) {
                    return empty($item->product_id);
                }
            );

            if ($hasDeletedProduct) {
                throw ValidationException::withMessages([
                    'status' =>
                        'Status tidak dapat diubah karena salah satu produk pada pesanan sudah dihapus.',
                ]);
            }

            $quantitiesByProduct = $lockedOrder->items
                ->groupBy('product_id')
                ->map(function ($items) {
                    return (int) $items->sum('quantity');
                });

            $productIds = $quantitiesByProduct
                ->keys()
                ->map(function ($productId) {
                    return (int) $productId;
                })
                ->sort()
                ->values();

            /*
            |--------------------------------------------------------------------------
            | Mengurangi stok
            |--------------------------------------------------------------------------
            |
            | Stok hanya dikurangi apabila status baru menggunakan stok dan stok
            | pesanan belum pernah dikurangi.
            |
            */

            if ($newStatusUsesStock && ! $stockAlreadyDeducted) {
                $products = Product::query()
                    ->whereIn('id', $productIds)
                    ->orderBy('id')
                    ->lockForUpdate()
                    ->get()
                    ->keyBy('id');

                foreach ($quantitiesByProduct as $productId => $quantity) {
                    $product = $products->get((int) $productId);

                    if (! $product) {
                        throw ValidationException::withMessages([
                            'status' =>
                                'Salah satu produk pada pesanan tidak ditemukan.',
                        ]);
                    }

                    if ($product->stock < $quantity) {
                        throw ValidationException::withMessages([
                            'status' =>
                                'Stok produk "' .
                                $product->name .
                                '" tidak mencukupi. Stok tersedia: ' .
                                $product->stock .
                                ', sedangkan pesanan membutuhkan: ' .
                                $quantity .
                                '.',
                        ]);
                    }
                }

                foreach ($quantitiesByProduct as $productId => $quantity) {
                    $product = $products->get((int) $productId);

                    $product->stock =
                        (int) $product->stock - (int) $quantity;

                    $product->save();
                }

                $lockedOrder->stock_deducted_at = now();
            }

            /*
            |--------------------------------------------------------------------------
            | Mengembalikan stok
            |--------------------------------------------------------------------------
            |
            | Stok dikembalikan apabila status berubah menjadi Menunggu atau
            | Dibatalkan dan stok sebelumnya sudah pernah dikurangi.
            |
            */

            if (! $newStatusUsesStock && $stockAlreadyDeducted) {
                $products = Product::query()
                    ->whereIn('id', $productIds)
                    ->orderBy('id')
                    ->lockForUpdate()
                    ->get()
                    ->keyBy('id');

                foreach ($quantitiesByProduct as $productId => $quantity) {
                    $product = $products->get((int) $productId);

                    if (! $product) {
                        throw ValidationException::withMessages([
                            'status' =>
                                'Stok tidak dapat dikembalikan karena salah satu produk tidak ditemukan.',
                        ]);
                    }

                    $product->stock =
                        (int) $product->stock + (int) $quantity;

                    $product->save();
                }

                $lockedOrder->stock_deducted_at = null;
            }

            /*
            |--------------------------------------------------------------------------
            | Menyimpan status baru
            |--------------------------------------------------------------------------
            */

            $lockedOrder->status = $newStatus;
            $lockedOrder->save();

            return [
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
            ];
        }, 3);

        /*
        |--------------------------------------------------------------------------
        | Nama status dalam bahasa Indonesia
        |--------------------------------------------------------------------------
        */

        $statusLabels = [
            'pending' => 'Menunggu',
            'confirmed' => 'Dikonfirmasi',
            'processing' => 'Diproses',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
        ];

        $oldStatusLabel =
            $statusLabels[$result['old_status']]
            ?? ucfirst($result['old_status']);

        $newStatusLabel =
            $statusLabels[$result['new_status']]
            ?? ucfirst($result['new_status']);

        return redirect()
            ->route('admin.orders.show', $order)
            ->with(
                'success',
                'Status pesanan berhasil diubah dari ' .
                $oldStatusLabel .
                ' menjadi ' .
                $newStatusLabel .
                '.'
            );
    }
}