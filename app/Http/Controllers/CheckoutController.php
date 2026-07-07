<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /**
     * Menampilkan formulir checkout.
     */
    public function create()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()
                ->route('catalog.index')
                ->with(
                    'error',
                    'Keranjang masih kosong. Silakan pilih produk terlebih dahulu.'
                );
        }

        $totalQuantity = collect($cart)->sum('quantity');

        $totalPrice = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        return view('checkout.create', compact(
            'cart',
            'totalQuantity',
            'totalPrice'
        ));
    }

    /**
     * Menyimpan pesanan dan mengarahkan pelanggan ke WhatsApp.
     */
    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Validasi data pelanggan
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'customer_name' => [
                'required',
                'string',
                'max:255',
            ],
            'customer_phone' => [
                'required',
                'string',
                'min:8',
                'max:20',
                'regex:/^[0-9+\-\s]+$/',
            ],
            'customer_address' => [
                'required',
                'string',
                'max:1000',
            ],
            'customer_notes' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ], [
            'customer_name.required' => 'Nama pelanggan wajib diisi.',
            'customer_phone.required' => 'Nomor WhatsApp wajib diisi.',
            'customer_phone.regex' => 'Format nomor WhatsApp tidak valid.',
            'customer_address.required' => 'Alamat pelanggan wajib diisi.',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Membaca keranjang
        |--------------------------------------------------------------------------
        */

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()
                ->route('catalog.index')
                ->with(
                    'error',
                    'Keranjang masih kosong. Silakan pilih produk terlebih dahulu.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Memeriksa ulang produk dan stok dari database
        |--------------------------------------------------------------------------
        */

        $orderItems = [];
        $totalAmount = 0;

        foreach ($cart as $cartItem) {
            $product = Product::query()
                ->whereKey($cartItem['product_id'])
                ->where('is_active', true)
                ->first();

            if (! $product) {
                return redirect()
                    ->route('cart.index')
                    ->with(
                        'error',
                        'Salah satu produk sudah tidak tersedia.'
                    );
            }

            $quantity = (int) $cartItem['quantity'];

            if ($quantity < 1) {
                return redirect()
                    ->route('cart.index')
                    ->with(
                        'error',
                        'Jumlah produk di keranjang tidak valid.'
                    );
            }

            if ($quantity > $product->stock) {
                return redirect()
                    ->route('cart.index')
                    ->with(
                        'error',
                        'Jumlah pesanan untuk produk ' .
                        $product->name .
                        ' melebihi stok yang tersedia.'
                    );
            }

            $subtotal = $product->price * $quantity;

            $orderItems[] = [
                'product_id' => $product->id,
                'product_name' => $product->name,
                'product_size' => $product->size,
                'price' => $product->price,
                'quantity' => $quantity,
                'subtotal' => $subtotal,
            ];

            $totalAmount += $subtotal;
        }

        /*
        |--------------------------------------------------------------------------
        | Menormalkan nomor WhatsApp pelanggan
        |--------------------------------------------------------------------------
        */

        $customerPhone = preg_replace(
            '/[^0-9]/',
            '',
            $validated['customer_phone']
        );

        if (str_starts_with($customerPhone, '0')) {
            $customerPhone = '62' . substr($customerPhone, 1);
        } elseif (str_starts_with($customerPhone, '8')) {
            $customerPhone = '62' . $customerPhone;
        }

        /*
        |--------------------------------------------------------------------------
        | Menyimpan pesanan dengan transaksi database
        |--------------------------------------------------------------------------
        */

        $order = DB::transaction(function () use (
            $validated,
            $customerPhone,
            $orderItems,
            $totalAmount
        ) {
            do {
                $orderCode =
                    'ORD-' .
                    now()->format('Ymd') .
                    '-' .
                    Str::upper(Str::random(6));
            } while (
                Order::where('order_code', $orderCode)->exists()
            );

            $order = Order::create([
                'order_code' => $orderCode,
                'customer_name' => $validated['customer_name'],
                'customer_phone' => $customerPhone,
                'customer_address' => $validated['customer_address'],
                'customer_notes' => $validated['customer_notes'] ?? null,
                'total_amount' => $totalAmount,
                'status' => 'pending',
                'whatsapp_redirected_at' => now(),
            ]);

            foreach ($orderItems as $item) {
                $order->items()->create($item);
            }

            return $order;
        });

        /*
        |--------------------------------------------------------------------------
        | Membuat pesan WhatsApp
        |--------------------------------------------------------------------------
        */

        // Ganti dengan nomor WhatsApp UMKM yang sebenarnya.
        $whatsappNumber = '6281244354328';

        $messageLines = [
            'Halo, saya ingin mengonfirmasi pesanan berikut:',
            '',
            'Kode Pesanan: ' . $order->order_code,
            'Nama: ' . $order->customer_name,
            'Nomor WhatsApp: ' . $order->customer_phone,
            'Alamat: ' . $order->customer_address,
            '',
            'Daftar Produk:',
        ];

        foreach ($orderItems as $item) {
            $messageLines[] =
                '- ' .
                $item['product_name'] .
                ' (' .
                ($item['product_size'] ?? '-') .
                ')';

            $messageLines[] =
                '  ' .
                $item['quantity'] .
                ' × Rp ' .
                number_format(
                    $item['price'],
                    0,
                    ',',
                    '.'
                );

            $messageLines[] =
                '  Subtotal: Rp ' .
                number_format(
                    $item['subtotal'],
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

        if ($order->customer_notes) {
            $messageLines[] = '';
            $messageLines[] =
                'Catatan: ' .
                $order->customer_notes;
        }

        $messageLines[] = '';
        $messageLines[] =
            'Mohon konfirmasi ketersediaan dan proses pesanan ini.';

        $whatsappMessage = implode("\n", $messageLines);

        $whatsappUrl =
            'https://wa.me/' .
            $whatsappNumber .
            '?text=' .
            urlencode($whatsappMessage);

        /*
        |--------------------------------------------------------------------------
        | Mengosongkan keranjang dan membuka WhatsApp
        |--------------------------------------------------------------------------
        */

        session()->forget('cart');

        return redirect()->away($whatsappUrl);
    }
}