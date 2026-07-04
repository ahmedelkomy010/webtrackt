<?php

namespace App\Services;

use App\Models\SiteSetting;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SeoService
{
    public const CACHE_KEY = 'tract.seo.settings';

    public function all(): array
    {
        return Cache::rememberForever(self::CACHE_KEY, function () {
            $stored = SiteSetting::where('key', 'seo')->value('value');

            return array_merge($this->defaults(), is_array($stored) ? $stored : []);
        });
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return data_get($this->all(), $key, $default);
    }

    public function save(array $data): void
    {
        $merged = array_merge($this->all(), $data);

        SiteSetting::updateOrCreate(
            ['key' => 'seo'],
            ['value' => $merged]
        );

        $this->invalidate();
    }

    public function invalidate(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    public function siteUrl(): string
    {
        return rtrim(config('tract.website'), '/');
    }

    public function logoUrl(): string
    {
        $custom = $this->get('logo_path');

        return $custom
            ? $this->siteUrl().'/storage/'.$custom
            : $this->siteUrl().'/images/logo.png';
    }

    public function ogImageUrl(): string
    {
        $custom = $this->get('og_image_path');

        return $custom
            ? $this->siteUrl().'/storage/'.$custom
            : $this->logoUrl();
    }

    public function title(string $locale = 'ar'): string
    {
        return $this->get("meta_title.{$locale}") ?: config('tract.seo.title');
    }

    public function description(string $locale = 'ar'): string
    {
        return $this->get("meta_description.{$locale}") ?: config('tract.seo.description');
    }

    public function keywords(string $locale = 'ar'): string
    {
        if ($locale === 'en') {
            return $this->get('meta_keywords.en') ?: config('tract.seo.keywords_en');
        }

        return $this->get("meta_keywords.{$locale}") ?: config('tract.seo.keywords');
    }

    public function robots(): string
    {
        return $this->get('robots', 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1');
    }

    public function minArticleWords(): int
    {
        return (int) $this->get('min_article_words', 800);
    }

    public function organizationSchema(): array
    {
        $siteUrl = $this->siteUrl();

        return [
            '@type' => 'Organization',
            '@id' => $siteUrl.'/#organization',
            'name' => config('tract.name_en'),
            'alternateName' => config('tract.name'),
            'url' => $siteUrl,
            'logo' => [
                '@type' => 'ImageObject',
                'url' => $this->logoUrl(),
                'width' => 512,
                'height' => 512,
            ],
            'image' => $this->ogImageUrl(),
            'email' => config('tract.email'),
            'telephone' => config('tract.phone_intl'),
            'description' => $this->description('ar'),
            'address' => [
                '@type' => 'PostalAddress',
                'addressCountry' => 'SA',
                'addressRegion' => config('tract.location'),
            ],
            'sameAs' => array_values(array_filter([
                'https://wa.me/'.config('tract.whatsapp'),
                $this->get('facebook_url'),
                $this->get('twitter_url'),
                $this->get('linkedin_url'),
            ])),
        ];
    }

    public function storeUploadedImage(?UploadedFile $file, ?string $oldPath, string $folder): ?string
    {
        if (! $file) {
            return $oldPath;
        }

        if ($oldPath) {
            Storage::disk('public')->delete($oldPath);
        }

        return $file->store($folder, 'public');
    }

    protected function defaults(): array
    {
        return [
            'meta_title' => ['ar' => '', 'en' => '', 'ur' => ''],
            'meta_description' => ['ar' => '', 'en' => '', 'ur' => ''],
            'meta_keywords' => ['ar' => '', 'en' => '', 'ur' => ''],
            'robots' => 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1',
            'logo_path' => null,
            'og_image_path' => null,
            'google_analytics_id' => '',
            'google_tag_manager_id' => '',
            'facebook_url' => '',
            'twitter_url' => '',
            'linkedin_url' => '',
            'min_article_words' => 800,
            'enable_json_ld' => true,
            'enable_sitemap' => true,
        ];
    }
}
