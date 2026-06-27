<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(Request $request): View
    {
        $locale = $this->locale($request);

        $posts = Post::published()
            ->latest('published_at')
            ->paginate(12);

        $siteUrl = rtrim(config('tract.website'), '/');

        return view('blog.index', compact('posts', 'locale', 'siteUrl'));
    }

    public function show(Request $request, string $slug): View
    {
        $locale = $this->locale($request);

        $post = Post::published()->where('slug', $slug)->firstOrFail();
        $post->increment('views');

        $related = Post::published()
            ->where('id', '!=', $post->id)
            ->latest('published_at')
            ->take(3)
            ->get();

        $siteUrl = rtrim(config('tract.website'), '/');

        return view('blog.show', compact('post', 'related', 'locale', 'siteUrl'));
    }

    protected function locale(Request $request): string
    {
        $locale = $request->query('lang', 'ar');

        return in_array($locale, ['ar', 'en', 'ur'], true) ? $locale : 'ar';
    }
}
