<?php

namespace App\Http\Controllers;

use App\Services\PageContentService;
use App\Support\Locale;
use App\Support\PageCopy;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PrivacyPageController extends Controller
{
    public function __invoke(Request $request, PageContentService $pages): View
    {
        $locale = Locale::fromRequest($request);
        $siteUrl = rtrim(config('tract.website'), '/');
        $page = $pages->page('privacy');

        return view('pages.privacy', compact('locale', 'siteUrl', 'page'));
    }
}
