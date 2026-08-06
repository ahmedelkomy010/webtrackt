<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Support\Locale;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(Request $request): View
    {
        $locale = Locale::fromRequest($request);

        $posts = Post::published()
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->paginate(12);

        $siteUrl = rtrim(config('tract.website'), '/');

        return view('blog.index', compact('posts', 'locale', 'siteUrl'));
    }

    public function show(Request $request, string $slug): View
    {
        $locale = Locale::fromRequest($request);

        $post = Post::published()->where('slug', $slug)->firstOrFail();
        $post->increment('views');

        $related = Post::published()
            ->where('id', '!=', $post->id)
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->take(3)
            ->get();

        $siteUrl = rtrim(config('tract.website'), '/');

        return view('blog.show', compact('post', 'related', 'locale', 'siteUrl'));
    }
}
