<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'slug',
        'icon',
        'image',
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

    public function getOffer(int $index): ?array
    {
        $offers = $this->offers ?? [];

        return $offers[$index] ?? null;
    }

    public function offerAmount(int $index): int
    {
        $offer = $this->getOffer($index);

        if (! $offer) {
            return 0;
        }

        $amount = (int) ($offer['amount'] ?? 0);

        if ($amount > 0) {
            return $amount;
        }

        $prices = is_array($offer['price'] ?? null)
            ? ($offer['price'] ?? [])
            : [($offer['price'] ?? '')];

        foreach ($prices as $price) {
            $parsed = self::parseAmountFromPrice(is_string($price) ? $price : '');
            if ($parsed > 0) {
                return $parsed;
            }
        }

        return 0;
    }

    public static function parseAmountFromPrice(?string $priceText): int
    {
        if (! filled($priceText)) {
            return 0;
        }

        $text = self::normalizeDigits($priceText);

        if (! preg_match('/(\d[\d,.\s]*)/u', $text, $match)) {
            return 0;
        }

        $numeric = str_replace([',', ' ', '٬', '،'], '', trim($match[1]));

        if ($numeric === '' || ! is_numeric($numeric)) {
            return 0;
        }

        $value = (float) $numeric;

        return $value > 0 ? (int) round($value * 100) : 0;
    }

    protected static function normalizeDigits(string $text): string
    {
        return str_replace(
            ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'],
            ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'],
            $text
        );
    }

    public function localizedOffer(int $index, string $locale = 'ar'): ?array
    {
        $offer = $this->getOffer($index);

        if (! $offer) {
            return null;
        }

        $amount = $this->offerAmount($index);

        return [
            'name' => is_array($offer['name'] ?? null) ? ($offer['name'][$locale] ?? $offer['name']['ar'] ?? '') : ($offer['name'] ?? ''),
            'price' => is_array($offer['price'] ?? null) ? ($offer['price'][$locale] ?? $offer['price']['ar'] ?? '') : ($offer['price'] ?? ''),
            'features' => array_map(
                fn ($f) => is_array($f) ? ($f[$locale] ?? $f['ar'] ?? '') : $f,
                $offer['features'] ?? []
            ),
            'highlight' => $offer['highlight'] ?? false,
            'amount' => $amount,
            'currency' => $offer['currency'] ?? config('payments.currency', 'SAR'),
            'purchasable' => $amount > 0,
        ];
    }

    public function localizedOffers(string $locale = 'ar'): array
    {
        return collect($this->offers ?? [])
            ->values()
            ->map(fn ($offer, $index) => $this->localizedOffer($index, $locale))
            ->filter()
            ->all();
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
