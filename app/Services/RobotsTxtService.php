<?php

namespace App\Services;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Cache;

class RobotsTxtService
{
    public const CACHE_KEY = 'tract.robots_txt';

    public function path(): string
    {
        return public_path('robots.txt');
    }

    public function exists(): bool
    {
        $content = $this->read();

        return $content !== null && trim($content) !== '';
    }

    public function read(): ?string
    {
        return Cache::rememberForever(self::CACHE_KEY, function () {
            $stored = SiteSetting::where('key', 'robots_txt')->value('value');

            if (is_array($stored) && ! empty($stored['content'])) {
                return $stored['content'];
            }

            if (is_file($this->path())) {
                $content = file_get_contents($this->path());

                return $content === false ? null : $content;
            }

            return null;
        });
    }

    public function save(string $content): void
    {
        $content = rtrim($content)."\n";

        SiteSetting::updateOrCreate(
            ['key' => 'robots_txt'],
            ['value' => ['content' => $content]]
        );

        Cache::forget(self::CACHE_KEY);

        if (@file_put_contents($this->path(), $content) === false && is_file($this->path()) && ! is_writable($this->path())) {
            // DB save succeeded — file sync is optional on shared hosting.
        }
    }

    public function delete(): bool
    {
        SiteSetting::where('key', 'robots_txt')->delete();
        Cache::forget(self::CACHE_KEY);

        if (is_file($this->path())) {
            @unlink($this->path());
        }

        return true;
    }

    public function defaultContent(): string
    {
        $siteUrl = rtrim(config('tract.website'), '/');

        return implode("\n", [
            'User-agent: *',
            'Allow: /',
            '',
            'Disallow: /admin/',
            'Disallow: /dashboard/',
            '',
            "Sitemap: {$siteUrl}/sitemap.xml",
        ]);
    }

    public function invalidate(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
