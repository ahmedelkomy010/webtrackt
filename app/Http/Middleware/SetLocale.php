<?php

namespace App\Http\Middleware;

use App\Support\Locale;
use App\Support\SiteUrl;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next, string $locale = Locale::AR, string $country = SiteUrl::DEFAULT_COUNTRY): Response
    {
        if (! Locale::isValid($locale)) {
            $locale = Locale::AR;
        }

        if (! SiteUrl::isValidCountry($country)) {
            $country = SiteUrl::DEFAULT_COUNTRY;
        }

        if ($request->has('lang') || $request->has('country')) {
            $requestedLocale = $request->query('lang', $locale);
            $requestedCountry = $request->query('country', $country);

            if (Locale::isValid($requestedLocale) || SiteUrl::isValidCountry($requestedCountry)) {
                return redirect(
                    SiteUrl::path(
                        SiteUrl::stripContext($request->path()),
                        Locale::isValid($requestedLocale) ? $requestedLocale : $locale,
                        SiteUrl::isValidCountry($requestedCountry) ? $requestedCountry : $country
                    ),
                    301
                );
            }
        }

        App::setLocale($locale);
        app()->instance('locale', $locale);
        app()->instance('country', $country);
        $request->attributes->set('locale', $locale);
        $request->attributes->set('country', $country);
        $request->attributes->set('site_locale', $locale);
        $request->attributes->set('site_country', $country);
        View::share('locale', $locale);
        View::share('country', $country);

        return $next($request);
    }
}
