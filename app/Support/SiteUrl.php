<?php

namespace App\Support;

use Illuminate\Http\Request;

class SiteUrl
{
    public const DEFAULT_COUNTRY = 'sa';

    /** @var list<string> */
    public const COUNTRIES = ['sa', 'ae', 'kw', 'bh', 'om', 'qa', 'eg'];

    /** @var list<string> */
    public const COUNTRY_PREFIXES = ['ae', 'kw', 'bh', 'om', 'qa', 'eg'];

    public static function isValidCountry(string $country): bool
    {
        return in_array($country, self::COUNTRIES, true);
    }

    /**
     * @return array{locale: string, country: string, path: string}
     */
    public static function parsePath(string $path): array
    {
        $path = trim($path, '/');
        $segments = $path === '' ? [] : explode('/', $path);
        $locale = Locale::AR;
        $country = self::DEFAULT_COUNTRY;

        if (isset($segments[0]) && in_array($segments[0], ['en', 'or'], true)) {
            $locale = Locale::fromPrefix($segments[0]);
            array_shift($segments);
        }

        if (isset($segments[0]) && in_array($segments[0], self::COUNTRY_PREFIXES, true)) {
            $country = $segments[0];
            array_shift($segments);
        }

        return [
            'locale' => $locale,
            'country' => $country,
            'path' => implode('/', $segments),
        ];
    }

    public static function buildPrefix(string $locale, string $country): string
    {
        $parts = [];

        if ($locale !== Locale::AR) {
            $parts[] = Locale::prefix($locale);
        }

        if ($country !== self::DEFAULT_COUNTRY) {
            $parts[] = $country;
        }

        return implode('/', $parts);
    }

    public static function path(string $path = '', string $locale = Locale::AR, string $country = self::DEFAULT_COUNTRY): string
    {
        if (! Locale::isValid($locale)) {
            $locale = Locale::AR;
        }

        if (! self::isValidCountry($country)) {
            $country = self::DEFAULT_COUNTRY;
        }

        $path = trim($path, '/');
        $prefix = self::buildPrefix($locale, $country);

        if ($prefix === '') {
            return $path === '' ? '/' : '/'.$path;
        }

        return $path === '' ? '/'.$prefix : '/'.$prefix.'/'.$path;
    }

    public static function home(string $locale = Locale::AR, string $country = self::DEFAULT_COUNTRY): string
    {
        return self::path('', $locale, $country);
    }

    public static function stripContext(string $path): string
    {
        return self::parsePath($path)['path'];
    }

    public static function fromRequest(Request $request): array
    {
        if ($request->attributes->has('site_locale') && $request->attributes->has('site_country')) {
            return [
                'locale' => $request->attributes->get('site_locale'),
                'country' => $request->attributes->get('site_country'),
                'path' => self::stripContext($request->path()),
            ];
        }

        return self::parsePath($request->path());
    }

    public static function switchLocale(Request $request, string $newLocale): string
    {
        $context = self::fromRequest($request);

        return self::path($context['path'], $newLocale, $context['country']);
    }

    public static function switchCountry(Request $request, string $newCountry): string
    {
        $context = self::fromRequest($request);

        return self::path($context['path'], $context['locale'], $newCountry);
    }
}
