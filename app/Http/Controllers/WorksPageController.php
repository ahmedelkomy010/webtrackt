<?php

namespace App\Http\Controllers;

use App\Models\Work;
use App\Services\PageContentService;
use App\Support\Locale;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WorksPageController extends Controller
{
    public function __invoke(Request $request, PageContentService $pages): View
    {
        $locale = Locale::fromRequest($request);
        $siteUrl = rtrim(config('tract.website'), '/');
        $page = $pages->page('works');

        $works = Work::where('is_active', true)->orderBy('sort_order')->get();

        return view('works.index', compact('works', 'locale', 'siteUrl', 'page'));
    }
}
