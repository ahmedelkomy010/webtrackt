<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PostController extends Controller
{
    public function index(): View
    {
        $posts = Post::latest('published_at')->latest('created_at')->paginate(15);

        return view('admin.posts.index', compact('posts'));
    }

    public function create(): View
    {
        return view('admin.posts.form', ['post' => new Post()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['featured_image'] = $this->storeImage($request);

        Post::create($data);

        return redirect()->route('admin.posts.index')->with('success', 'تم نشر المقال بنجاح.');
    }

    public function edit(Post $post): View
    {
        return view('admin.posts.form', compact('post'));
    }

    public function update(Request $request, Post $post): RedirectResponse
    {
        $data = $this->validated($request, $post);

        if ($request->hasFile('featured_image_file')) {
            if ($post->featured_image) {
                Storage::disk('public')->delete($post->featured_image);
            }
            $data['featured_image'] = $this->storeImage($request);
        }

        $post->update($data);

        return redirect()->route('admin.posts.index')->with('success', 'تم تحديث المقال.');
    }

    public function destroy(Post $post): RedirectResponse
    {
        if ($post->featured_image) {
            Storage::disk('public')->delete($post->featured_image);
        }

        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'تم حذف المقال.');
    }

    protected function validated(Request $request, ?Post $post = null): array
    {
        $data = $request->validate([
            'slug' => ['nullable', 'string', 'max:255', 'unique:posts,slug,'.($post?->id ?? 'NULL')],
            'title_ar' => ['required', 'string', 'max:255'],
            'title_en' => ['required', 'string', 'max:255'],
            'title_ur' => ['required', 'string', 'max:255'],
            'excerpt_ar' => ['required', 'string', 'max:500'],
            'excerpt_en' => ['required', 'string', 'max:500'],
            'excerpt_ur' => ['required', 'string', 'max:500'],
            'content_ar' => ['required', 'string'],
            'content_en' => ['required', 'string'],
            'content_ur' => ['required', 'string'],
            'meta_title_ar' => ['nullable', 'string', 'max:70'],
            'meta_title_en' => ['nullable', 'string', 'max:70'],
            'meta_title_ur' => ['nullable', 'string', 'max:70'],
            'meta_description_ar' => ['nullable', 'string', 'max:160'],
            'meta_description_en' => ['nullable', 'string', 'max:160'],
            'meta_description_ur' => ['nullable', 'string', 'max:160'],
            'meta_keywords_ar' => ['nullable', 'string', 'max:500'],
            'meta_keywords_en' => ['nullable', 'string', 'max:500'],
            'meta_keywords_ur' => ['nullable', 'string', 'max:500'],
            'featured_image_file' => ['nullable', 'image', 'max:2048'],
            'is_published' => ['nullable', 'boolean'],
            'published_at' => ['nullable', 'date'],
        ]);

        $slug = $data['slug'] ?? Post::generateSlug($data['title_ar']);

        return [
            'slug' => $slug,
            'title' => ['ar' => $data['title_ar'], 'en' => $data['title_en'], 'ur' => $data['title_ur']],
            'excerpt' => ['ar' => $data['excerpt_ar'], 'en' => $data['excerpt_en'], 'ur' => $data['excerpt_ur']],
            'content' => ['ar' => $data['content_ar'], 'en' => $data['content_en'], 'ur' => $data['content_ur']],
            'meta_title' => ['ar' => $data['meta_title_ar'] ?? '', 'en' => $data['meta_title_en'] ?? '', 'ur' => $data['meta_title_ur'] ?? ''],
            'meta_description' => ['ar' => $data['meta_description_ar'] ?? '', 'en' => $data['meta_description_en'] ?? '', 'ur' => $data['meta_description_ur'] ?? ''],
            'meta_keywords' => ['ar' => $data['meta_keywords_ar'] ?? '', 'en' => $data['meta_keywords_en'] ?? '', 'ur' => $data['meta_keywords_ur'] ?? ''],
            'is_published' => $request->boolean('is_published'),
            'published_at' => $request->boolean('is_published')
                ? ($data['published_at'] ?? now())
                : null,
        ];
    }

    protected function storeImage(Request $request): ?string
    {
        if (! $request->hasFile('featured_image_file')) {
            return null;
        }

        return $request->file('featured_image_file')->store('blog', 'public');
    }
}
