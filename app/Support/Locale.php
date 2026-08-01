<?php

namespace App\Support;

use Illuminate\Http\Request;

class Locale
{
    public const AR = 'ar';

    public const EN = 'en';

    public const UR = 'ur';

    /** @var array<string, string> */
    public const PREFIX = [
        self::AR => '',
        self::EN => 'en',
        self::UR => 'or',
    ];

    public static function isValid(string $locale): bool
    {
        return in_array($locale, [self::AR, self::EN, self::UR], true);
    }

    public static function prefix(string $locale): string
    {
        return self::PREFIX[$locale] ?? '';
    }

    public static function fromPrefix(?string $prefix): string
    {
        return match ($prefix) {
            'en' => self::EN,
            'or' => self::UR,
            default => self::AR,
        };
    }

    public static function fromRequest(Request $request): string
    {
        return SiteUrl::fromRequest($request)['locale'];
    }

    public static function countryFromRequest(Request $request): string
    {
        return SiteUrl::fromRequest($request)['country'];
    }

    public static function path(string $path = '', string $locale = self::AR, string $country = SiteUrl::DEFAULT_COUNTRY): string
    {
        return SiteUrl::path($path, $locale, $country);
    }

    public static function home(string $locale = self::AR, string $country = SiteUrl::DEFAULT_COUNTRY): string
    {
        return SiteUrl::home($locale, $country);
    }

    public static function stripPrefix(string $path): string
    {
        return SiteUrl::stripContext($path);
    }

    public static function switchUrl(Request $request, string $newLocale): string
    {
        return SiteUrl::switchLocale($request, $newLocale);
    }

    public static function switchCountry(Request $request, string $newCountry): string
    {
        return SiteUrl::switchCountry($request, $newCountry);
    }

    public static function htmlLang(string $locale): string
    {
        return match ($locale) {
            self::EN => 'en',
            self::UR => 'ur',
            default => 'ar-SA',
        };
    }

    public static function dir(string $locale): string
    {
        return $locale === self::EN ? 'ltr' : 'rtl';
    }
}
