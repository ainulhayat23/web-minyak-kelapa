<?php

namespace App\Http\Controllers;

use App\Models\Post;

class BlogController extends Controller
{
    public function index()
    {
        $posts = Post::with('user')
            ->where('is_published', true)
            ->whereNotNull('published_at')
            ->latest('published_at')
            ->paginate(6);

        return view('blog.index', compact('posts'));
    }

    public function show(Post $post)
    {
        if (! $post->is_published || ! $post->published_at) {
            abort(404);
        }

        return view('blog.show', compact('post'));
    }
}