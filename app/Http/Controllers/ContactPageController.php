<?php

namespace App\Http\Controllers;

use App\Services\ContactSettingsService;
use App\Services\PageContentService;
use App\Support\Locale;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactPageController extends Controller
{
    public function __invoke(Request $request, ContactSettingsService $contact, PageContentService $pages): View
    {
        $locale = Locale::fromRequest($request);
        $siteUrl = rtrim(config('tract.website'), '/');
        $contactSettings = $contact->all();
        $page = $pages->page('contact');

        return view('pages.contact', compact('locale', 'siteUrl', 'contactSettings', 'page'));
    }
}
