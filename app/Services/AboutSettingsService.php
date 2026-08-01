<?php

namespace App\Services;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Cache;

class AboutSettingsService
{
    public const CACHE_KEY = 'tract.about.settings';

    public function all(): array
    {
        return Cache::rememberForever(self::CACHE_KEY, function () {
            $stored = SiteSetting::where('key', 'about')->value('value');
            $merged = array_merge($this->defaults(), is_array($stored) ? $stored : []);

            if (empty($merged['hero_side_image']) && ! empty($merged['hero_image'])) {
                $merged['hero_side_image'] = $merged['hero_image'];
            }

            if (empty($merged['about_image'])) {
                $merged['about_image'] = $merged['middle_image'] ?? $merged['marketing_image'] ?? '';
            }

            unset($merged['hero_image'], $merged['middle_image'], $merged['marketing_image']);

            return $merged;
        });
    }

    public function save(array $data): void
    {
        unset($data['hero_image'], $data['middle_image'], $data['marketing_image']);

        SiteSetting::updateOrCreate(
            ['key' => 'about'],
            ['value' => $data]
        );

        $this->invalidate();
    }

    public function invalidate(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    protected function defaults(): array
    {
        return [
            'hero_side_image' => '',
            'about_image' => '',
        ];
    }
}
