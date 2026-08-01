<?php

namespace App\Services;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Cache;

class ContactSettingsService
{
    public const CACHE_KEY = 'tract.contact.settings';

    public function all(): array
    {
        return Cache::rememberForever(self::CACHE_KEY, function () {
            $stored = SiteSetting::where('key', 'contact')->value('value');

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
            ['key' => 'contact'],
            ['value' => $merged]
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
            'phone'       => config('tract.phone', '0502943846'),
            'phone_intl'  => config('tract.phone_intl', '+966 50 294 3846'),
            'whatsapp'    => config('tract.whatsapp', '966502943846'),
            'email'       => config('tract.email', 'info@trackkt.com'),
            'twitter_url'   => '',
            'instagram_url' => '',
            'facebook_url'  => '',
            'snapchat_url'  => '',
            'linkedin_url'  => '',
            'tiktok_url'    => '',
        ];
    }
}
