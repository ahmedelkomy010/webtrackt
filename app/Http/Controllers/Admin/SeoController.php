<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SeoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SeoController extends Controller
{
    public function __construct(protected SeoService $seo) {}

    public function edit(): View
    {
        $settings = $this->seo->all();

        return view('admin.seo.edit', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'meta_title_ar' => ['nullable', 'string', 'max:70'],
            'meta_title_en' => ['nullable', 'string', 'max:70'],
            'meta_title_ur' => ['nullable', 'string', 'max:70'],
            'meta_description_ar' => ['nullable', 'string', 'max:160'],
            'meta_description_en' => ['nullable', 'string', 'max:160'],
            'meta_description_ur' => ['nullable', 'string', 'max:160'],
            'meta_keywords_ar' => ['nullable', 'string', 'max:500'],
            'meta_keywords_en' => ['nullable', 'string', 'max:500'],
            'meta_keywords_ur' => ['nullable', 'string', 'max:500'],
            'robots' => ['nullable', 'string', 'max:255'],
            'google_analytics_id' => ['nullable', 'string', 'max:50'],
            'google_tag_manager_id' => ['nullable', 'string', 'max:50'],
            'facebook_url' => ['nullable', 'url', 'max:255'],
            'twitter_url' => ['nullable', 'url', 'max:255'],
            'linkedin_url' => ['nullable', 'url', 'max:255'],
            'min_article_words' => ['nullable', 'integer', 'min:300', 'max:5000'],
            'logo_file' => ['nullable', 'image', 'max:2048'],
            'og_image_file' => ['nullable', 'image', 'max:4096'],
            'enable_json_ld' => ['nullable', 'boolean'],
            'enable_sitemap' => ['nullable', 'boolean'],
        ]);

        $current = $this->seo->all();

        $payload = [
            'meta_title' => [
                'ar' => $data['meta_title_ar'] ?? '',
                'en' => $data['meta_title_en'] ?? '',
                'ur' => $data['meta_title_ur'] ?? '',
            ],
            'meta_description' => [
                'ar' => $data['meta_description_ar'] ?? '',
                'en' => $data['meta_description_en'] ?? '',
                'ur' => $data['meta_description_ur'] ?? '',
            ],
            'meta_keywords' => [
                'ar' => $data['meta_keywords_ar'] ?? '',
                'en' => $data['meta_keywords_en'] ?? '',
                'ur' => $data['meta_keywords_ur'] ?? '',
            ],
            'robots' => $data['robots'] ?? $current['robots'],
            'google_analytics_id' => $data['google_analytics_id'] ?? '',
            'google_tag_manager_id' => $data['google_tag_manager_id'] ?? '',
            'facebook_url' => $data['facebook_url'] ?? '',
            'twitter_url' => $data['twitter_url'] ?? '',
            'linkedin_url' => $data['linkedin_url'] ?? '',
            'min_article_words' => $data['min_article_words'] ?? 800,
            'enable_json_ld' => $request->boolean('enable_json_ld', true),
            'enable_sitemap' => $request->boolean('enable_sitemap', true),
            'logo_path' => $this->seo->storeUploadedImage(
                $request->file('logo_file'),
                $current['logo_path'] ?? null,
                'seo'
            ),
            'og_image_path' => $this->seo->storeUploadedImage(
                $request->file('og_image_file'),
                $current['og_image_path'] ?? null,
                'seo'
            ),
        ];

        $this->seo->save($payload);

        return redirect()->route('admin.seo.edit')->with('success', 'تم حفظ إعدادات SEO بنجاح.');
    }
}
