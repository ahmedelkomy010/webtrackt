<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServicePageController extends Controller
{
    public function index(Request $request): View
    {
        $locale = $this->locale($request);
        $siteUrl = rtrim(config('tract.website'), '/');

        $services = Service::where('is_active', true)->orderBy('sort_order')->get();

        return view('services.index', compact('services', 'locale', 'siteUrl'));
    }

    public function show(Request $request, string $slug): View
    {
        $locale = $this->locale($request);
        $siteUrl = rtrim(config('tract.website'), '/');

        $service = Service::where('is_active', true)->where('slug', $slug)->firstOrFail();

        $others = Service::where('is_active', true)
            ->where('id', '!=', $service->id)
            ->orderBy('sort_order')
            ->get();

        return view('services.show', compact('service', 'others', 'locale', 'siteUrl'));
    }

    protected function locale(Request $request): string
    {
        $locale = $request->query('lang', 'ar');

        return in_array($locale, ['ar', 'en', 'ur'], true) ? $locale : 'ar';
    }
}
