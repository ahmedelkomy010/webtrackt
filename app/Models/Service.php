<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'slug',
        'icon',
        'highlight',
        'sort_order',
        'title',
        'description',
        'body',
        'features',
        'offers',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'title' => 'array',
            'description' => 'array',
            'body' => 'array',
            'features' => 'array',
            'offers' => 'array',
            'highlight' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function localized(string $field, string $locale = 'ar'): string
    {
        $data = $this->{$field};

        return $data[$locale] ?? $data['ar'] ?? '';
    }

    public function localizedFeatures(string $locale = 'ar'): array
    {
        $features = $this->features ?? [];

        return array_map(
            fn ($f) => is_array($f) ? ($f[$locale] ?? $f['ar'] ?? '') : $f,
            $features
        );
    }

    public function localizedOffers(string $locale = 'ar'): array
    {
        return collect($this->offers ?? [])->map(function ($offer) use ($locale) {
            return [
                'name' => is_array($offer['name'] ?? null) ? ($offer['name'][$locale] ?? $offer['name']['ar'] ?? '') : ($offer['name'] ?? ''),
                'price' => is_array($offer['price'] ?? null) ? ($offer['price'][$locale] ?? $offer['price']['ar'] ?? '') : ($offer['price'] ?? ''),
                'features' => array_map(
                    fn ($f) => is_array($f) ? ($f[$locale] ?? $f['ar'] ?? '') : $f,
                    $offer['features'] ?? []
                ),
                'highlight' => $offer['highlight'] ?? false,
            ];
        })->all();
    }

    public static function generateSlug(string $title, ?int $exceptId = null): string
    {
        $base = \Illuminate\Support\Str::slug($title);

        if ($base === '') {
            $base = 'service-'.\Illuminate\Support\Str::lower(\Illuminate\Support\Str::random(6));
        }

        $slug = $base;
        $counter = 1;

        while (static::where('slug', $slug)->when($exceptId, fn ($q) => $q->where('id', '!=', $exceptId))->exists()) {
            $slug = $base.'-'.$counter;
            $counter++;
        }

        return $slug;
    }
}
