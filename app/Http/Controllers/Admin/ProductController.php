<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $products = Product::latest()->paginate(10);

    return view('admin.products.index', compact('products'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    return view('admin.products.create');
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'size' => ['nullable', 'string', 'max:100'],
        'price' => ['required', 'integer', 'min:0'],
        'stock' => ['required', 'integer', 'min:0'],
        'short_description' => ['nullable', 'string', 'max:500'],
        'description' => ['nullable', 'string'],
        'composition' => ['nullable', 'string'],
        'image' => [
            'nullable',
            'image',
            'mimes:jpg,jpeg,png,webp',
            'max:2048',
        ],
        'is_active' => ['nullable', 'boolean'],
    ]);

    // Membuat slug unik berdasarkan nama dan ukuran produk
    $baseSlug = Str::slug(
        $validated['name'].'-'.($validated['size'] ?? '')
    );

    $slug = $baseSlug;
    $number = 1;

    while (Product::where('slug', $slug)->exists()) {
        $slug = $baseSlug.'-'.$number;
        $number++;
    }

    $validated['slug'] = $slug;

    // Menyimpan gambar jika pengguna mengunggahnya
    if ($request->hasFile('image')) {
        $validated['image'] = $request
            ->file('image')
            ->store('products', 'public');
    }

    // Checkbox yang tidak dicentang akan disimpan sebagai false
    $validated['is_active'] = $request->boolean('is_active');

    Product::create($validated);

    return redirect()
        ->route('admin.products.index')
        ->with('success', 'Produk berhasil ditambahkan.');
}

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
{
    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'size' => ['nullable', 'string', 'max:100'],
        'price' => ['required', 'integer', 'min:0'],
        'stock' => ['required', 'integer', 'min:0'],
        'short_description' => ['nullable', 'string', 'max:500'],
        'description' => ['nullable', 'string'],
        'composition' => ['nullable', 'string'],
        'image' => [
            'nullable',
            'image',
            'mimes:jpg,jpeg,png,webp',
            'max:2048',
        ],
        'is_active' => ['nullable', 'boolean'],
    ]);

    /*
    |--------------------------------------------------------------------------
    | Membuat slug produk yang unik
    |--------------------------------------------------------------------------
    */

    $baseSlug = Str::slug(
        $validated['name'].' '.($validated['size'] ?? '')
    );

    $slug = $baseSlug;
    $number = 1;

    while (
        Product::where('slug', $slug)
            ->where('id', '!=', $product->id)
            ->exists()
    ) {
        $slug = $baseSlug.'-'.$number;
        $number++;
    }

    $validated['slug'] = $slug;

    /*
    |--------------------------------------------------------------------------
    | Mengganti gambar produk
    |--------------------------------------------------------------------------
    */

    if ($request->hasFile('image')) {

        // Hapus gambar lama apabila tersedia
        if (
            $product->image &&
            Storage::disk('public')->exists($product->image)
        ) {
            Storage::disk('public')->delete($product->image);
        }

        // Simpan gambar baru
        $validated['image'] = $request
            ->file('image')
            ->store('products', 'public');
    }

    /*
    |--------------------------------------------------------------------------
    | Mengatur status produk
    |--------------------------------------------------------------------------
    */

    $validated['is_active'] = $request->boolean('is_active');

    /*
    |--------------------------------------------------------------------------
    | Memperbarui data produk
    |--------------------------------------------------------------------------
    */

    $product->update($validated);

    return redirect()
        ->route('admin.products.index')
        ->with('success', 'Produk berhasil diperbarui.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
{
    // Menghapus gambar produk dari penyimpanan
    if (
        $product->image &&
        Storage::disk('public')->exists($product->image)
    ) {
        Storage::disk('public')->delete($product->image);
    }

    // Menghapus data produk dari database
    $product->delete();

    return redirect()
        ->route('admin.products.index')
        ->with('success', 'Produk berhasil dihapus.');
}
}
