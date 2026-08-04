<?php

namespace App\Services;

class RobotsTxtService
{
    public function path(): string
    {
        return public_path('robots.txt');
    }

    public function exists(): bool
    {
        return is_file($this->path());
    }

    public function read(): ?string
    {
        if (! $this->exists()) {
            return null;
        }

        $content = file_get_contents($this->path());

        return $content === false ? null : $content;
    }

    public function save(string $content): void
    {
        file_put_contents($this->path(), rtrim($content)."\n");
    }

    public function delete(): bool
    {
        if (! $this->exists()) {
            return false;
        }

        return unlink($this->path());
    }

    public function defaultContent(): string
    {
        $siteUrl = rtrim(config('tract.website'), '/');

        return implode("\n", [
            'User-agent: *',
            'Allow: /',
            '',
            "Sitemap: {$siteUrl}/sitemap.xml",
        ]);
    }
}
