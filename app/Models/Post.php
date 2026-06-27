<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    protected $fillable = [
        'slug',
        'title',
        'excerpt',
        'content',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'featured_image',
        'is_published',
        'published_at',
        'views',
    ];

    protected function casts(): array
    {
        return [
            'title' => 'array',
            'excerpt' => 'array',
            'content' => 'array',
            'meta_title' => 'array',
            'meta_description' => 'array',
            'meta_keywords' => 'array',
            'is_published' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function localized(string $field, string $locale = 'ar'): string
    {
        $data = $this->{$field};

        if (! is_array($data)) {
            return (string) $data;
        }

        return $data[$locale] ?? $data['ar'] ?? $data['en'] ?? '';
    }

    public function seoTitle(string $locale = 'ar'): string
    {
        $meta = $this->localized('meta_title', $locale);

        return $meta ?: $this->localized('title', $locale);
    }

    public function seoDescription(string $locale = 'ar'): string
    {
        $meta = $this->localized('meta_description', $locale);

        return $meta ?: $this->localized('excerpt', $locale);
    }

    public function seoKeywords(string $locale = 'ar'): string
    {
        return $this->localized('meta_keywords', $locale);
    }

    public function url(): string
    {
        return rtrim(config('tract.website'), '/').'/blog/'.$this->slug;
    }

    public static function generateSlug(string $title): string
    {
        $base = Str::slug($title);

        if ($base === '') {
            $base = 'post-'.Str::lower(Str::random(8));
        }

        $slug = $base;
        $counter = 1;

        while (static::where('slug', $slug)->exists()) {
            $slug = $base.'-'.$counter;
            $counter++;
        }

        return $slug;
    }
}
