<?php

namespace App\Http\Controllers;

use App\Services\AboutSettingsService;
use App\Support\Locale;
use App\Support\PageCopy;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AboutPageController extends Controller
{
    public function __invoke(Request $request, AboutSettingsService $about): View
    {
        $locale = Locale::fromRequest($request);
        $siteUrl = rtrim(config('tract.website'), '/');
        $copy = PageCopy::about($locale);
        $aboutSettings = $about->all();

        return view('pages.about', compact('locale', 'siteUrl', 'copy', 'aboutSettings'));
    }
}
