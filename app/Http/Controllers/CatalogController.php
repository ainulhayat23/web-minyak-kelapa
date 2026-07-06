<?php

namespace App\Http\Controllers;

use App\Models\Product;

class CatalogController extends Controller
{
    public function index()
    {
        $products = Product::where('is_active', true)
            ->latest()
            ->paginate(8);

        return view('catalog.index', compact('products'));
    }

    public function show(Product $product)
    {
        // Produk yang tidak aktif tidak boleh dilihat pengunjung
        if (! $product->is_active) {
            abort(404);
        }

        return view('catalog.show', compact('product'));
    }
}