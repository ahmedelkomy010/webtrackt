<?php

namespace App\Http\Controllers;

use App\Services\ContactSettingsService;
use App\Support\Locale;
use App\Support\PageCopy;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactPageController extends Controller
{
    public function __invoke(Request $request, ContactSettingsService $contact): View
    {
        $locale = Locale::fromRequest($request);
        $siteUrl = rtrim(config('tract.website'), '/');
        $copy = PageCopy::contact($locale);
        $contactSettings = $contact->all();

        return view('pages.contact', compact('locale', 'siteUrl', 'copy', 'contactSettings'));
    }
}
