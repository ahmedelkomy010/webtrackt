<?php

namespace App\Http\Controllers;

use App\Services\AboutSettingsService;
use App\Services\PageContentService;
use App\Support\Locale;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AboutPageController extends Controller
{
    public function __invoke(Request $request, AboutSettingsService $about, PageContentService $pages): View
    {
        $locale = Locale::fromRequest($request);
        $siteUrl = rtrim(config('tract.website'), '/');
        $aboutSettings = $about->all();
        $page = $pages->page('about');

        return view('pages.about', compact('locale', 'siteUrl', 'aboutSettings', 'page'));
    }
}
