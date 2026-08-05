<?php

namespace App\Services;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Cache;

class TickerSettingsService
{
    public const CACHE_KEY = 'tract.ticker.settings';

    public function all(): array
    {
        return Cache::rememberForever(self::CACHE_KEY, function () {
            $stored = SiteSetting::where('key', 'ticker')->value('value');

            return array_merge($this->defaults(), is_array($stored) ? $stored : []);
        });
    }

    public function messages(string $locale): array
    {
        $all = $this->all();
        $key = 'messages_'.$locale;
        $messages = $all[$key] ?? $all['messages_ar'] ?? [];

        return is_array($messages) ? array_values(array_filter($messages)) : [];
    }

    public function save(array $data): void
    {
        SiteSetting::updateOrCreate(
            ['key' => 'ticker'],
            ['value' => array_merge($this->all(), $data)]
        );

        $this->invalidate();
        app(ContentService::class)->invalidate();
    }

    public function invalidate(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    protected function defaults(): array
    {
        return [
            'enabled' => true,
            'messages_ar' => [
                'أول نظام مقاولات متخصص في العقد الموحد',
                'حلول ERP — مواقع — متاجر — تسويق إلكتروني',
                'تواصل معنا للحصول على استشارة مجانية',
            ],
            'messages_en' => [
                'First contracting system specialized in unified contracts',
                'ERP — Websites — E-commerce — Digital Marketing',
                'Contact us for a free consultation',
            ],
            'messages_ur' => [
                'متحد معاہدوں میں مہارت یافتہ پہلا مقاولات نظام',
                'ERP — ویbsites — ای کامرس — ڈیجیٹل مارکیٹنگ',
                'مفت مشاورت کے لیے ہم سے رابطہ کریں',
            ],
        ];
    }
}
