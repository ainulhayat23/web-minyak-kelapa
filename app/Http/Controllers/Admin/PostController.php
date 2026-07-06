<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $posts = Post::with('user')
        ->latest()
        ->paginate(10);

    return view('admin.posts.index', compact('posts'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'title' => ['required', 'string', 'max:255'],
        'excerpt' => ['nullable', 'string', 'max:500'],
        'content' => ['required', 'string'],
        'image' => [
            'nullable',
            'image',
            'mimes:jpg,jpeg,png,webp',
            'max:2048',
        ],
        'is_published' => ['nullable', 'boolean'],
    ]);

    /*
    |--------------------------------------------------------------------------
    | Membuat slug unik
    |--------------------------------------------------------------------------
    */

    $baseSlug = Str::slug($validated['title']);

    if ($baseSlug === '') {
        $baseSlug = 'kegiatan';
    }

    $slug = $baseSlug;
    $number = 1;

    while (Post::where('slug', $slug)->exists()) {
        $slug = $baseSlug . '-' . $number;
        $number++;
    }

    $validated['slug'] = $slug;

    /*
    |--------------------------------------------------------------------------
    | Menyimpan informasi penulis dan status publikasi
    |--------------------------------------------------------------------------
    */

    $validated['user_id'] = auth()->id();

    $validated['is_published'] =
        $request->boolean('is_published');

    $validated['published_at'] =
        $validated['is_published'] ? now() : null;

    /*
    |--------------------------------------------------------------------------
    | Menyimpan gambar utama
    |--------------------------------------------------------------------------
    */

    if ($request->hasFile('image')) {
        $validated['image'] = $request
            ->file('image')
            ->store('posts', 'public');
    }

    /*
    |--------------------------------------------------------------------------
    | Menyimpan kegiatan
    |--------------------------------------------------------------------------
    */

    Post::create($validated);

    return redirect()
        ->route('admin.posts.index')
        ->with('success', 'Blog atau kegiatan berhasil disimpan.');
}

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
         return view('admin.posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
{
    $validated = $request->validate([
        'title' => ['required', 'string', 'max:255'],
        'excerpt' => ['nullable', 'string', 'max:500'],
        'content' => ['required', 'string'],
        'image' => [
            'nullable',
            'image',
            'mimes:jpg,jpeg,png,webp',
            'max:2048',
        ],
        'is_published' => ['nullable', 'boolean'],
    ]);

    /*
    |--------------------------------------------------------------------------
    | Membuat slug yang unik
    |--------------------------------------------------------------------------
    */

    $baseSlug = Str::slug($validated['title']);

    if ($baseSlug === '') {
        $baseSlug = 'kegiatan';
    }

    $slug = $baseSlug;
    $number = 1;

    while (
        Post::where('slug', $slug)
            ->where('id', '!=', $post->id)
            ->exists()
    ) {
        $slug = $baseSlug . '-' . $number;
        $number++;
    }

    $validated['slug'] = $slug;

    /*
    |--------------------------------------------------------------------------
    | Mengatur status dan tanggal publikasi
    |--------------------------------------------------------------------------
    */

    $isPublished = $request->boolean('is_published');

    $validated['is_published'] = $isPublished;

    if ($isPublished) {
        // Pertahankan tanggal lama jika sebelumnya sudah diterbitkan
        $validated['published_at'] = $post->published_at ?? now();
    } else {
        // Kosongkan tanggal jika dikembalikan menjadi draf
        $validated['published_at'] = null;
    }

    /*
    |--------------------------------------------------------------------------
    | Mengganti gambar utama
    |--------------------------------------------------------------------------
    */

    if ($request->hasFile('image')) {
        if (
            $post->image &&
            Storage::disk('public')->exists($post->image)
        ) {
            Storage::disk('public')->delete($post->image);
        }

        $validated['image'] = $request
            ->file('image')
            ->store('posts', 'public');
    }

    /*
    |--------------------------------------------------------------------------
    | Memperbarui data kegiatan
    |--------------------------------------------------------------------------
    */

    $post->update($validated);

    return redirect()
        ->route('admin.posts.index')
        ->with('success', 'Blog atau kegiatan berhasil diperbarui.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
{
    // Hapus gambar kegiatan jika tersedia
    if (
        $post->image &&
        Storage::disk('public')->exists($post->image)
    ) {
        Storage::disk('public')->delete($post->image);
    }

    // Hapus data kegiatan dari database
    $post->delete();

    return redirect()
        ->route('admin.posts.index')
        ->with('success', 'Blog atau kegiatan berhasil dihapus.');
}
}
