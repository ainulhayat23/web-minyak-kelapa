<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Menampilkan halaman keranjang.
     */
    public function index()
    {
        $cart = session()->get('cart', []);

        $totalQuantity = collect($cart)->sum('quantity');

        $totalPrice = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        return view('cart.index', compact(
            'cart',
            'totalQuantity',
            'totalPrice'
        ));
    }

    /**
     * Menambahkan produk ke keranjang.
     */
    public function add(Request $request, Product $product)
    {
        if (! $product->is_active) {
            return back()->with(
                'error',
                'Produk tersebut sedang tidak tersedia.'
            );
        }

        if ($product->stock < 1) {
            return back()->with(
                'error',
                'Stok produk sedang habis.'
            );
        }

        $validated = $request->validate([
            'quantity' => [
                'nullable',
                'integer',
                'min:1',
                'max:' . $product->stock,
            ],
        ]);

        $quantity = $validated['quantity'] ?? 1;

        $cart = session()->get('cart', []);

        $currentQuantity = isset($cart[$product->id])
            ? $cart[$product->id]['quantity']
            : 0;

        $newQuantity = $currentQuantity + $quantity;

        if ($newQuantity > $product->stock) {
            return back()->with(
                'error',
                'Jumlah pesanan melebihi stok yang tersedia.'
            );
        }

        $cart[$product->id] = [
            'product_id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'size' => $product->size,
            'price' => $product->price,
            'stock' => $product->stock,
            'image' => $product->image,
            'quantity' => $newQuantity,
        ];

        session()->put('cart', $cart);

        return back()->with(
            'success',
            'Produk berhasil ditambahkan ke keranjang.'
        );
    }

    /**
     * Mengubah jumlah produk dalam keranjang.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'quantity' => [
                'required',
                'integer',
                'min:1',
                'max:' . $product->stock,
            ],
        ]);

        $cart = session()->get('cart', []);

        if (! isset($cart[$product->id])) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Produk tidak ditemukan di keranjang.');
        }

        $cart[$product->id]['quantity'] = $validated['quantity'];

        /*
        | Memperbarui harga dan stok dari database agar data keranjang
        | tetap sesuai dengan informasi produk terbaru.
        */
        $cart[$product->id]['price'] = $product->price;
        $cart[$product->id]['stock'] = $product->stock;

        session()->put('cart', $cart);

        return redirect()
            ->route('cart.index')
            ->with('success', 'Jumlah produk berhasil diperbarui.');
    }

    /**
     * Menghapus satu produk dari keranjang.
     */
    public function remove(Product $product)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            unset($cart[$product->id]);

            session()->put('cart', $cart);
        }

        return redirect()
            ->route('cart.index')
            ->with('success', 'Produk berhasil dihapus dari keranjang.');
    }

    /**
     * Mengosongkan seluruh isi keranjang.
     */
    public function clear()
    {
        session()->forget('cart');

        return redirect()
            ->route('cart.index')
            ->with('success', 'Keranjang berhasil dikosongkan.');
    }
}