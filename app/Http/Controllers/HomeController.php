<?php

namespace App\Http\Controllers;

use App\Services\AboutSettingsService;
use App\Services\ContactSettingsService;
use App\Services\ContentService;

class HomeController extends Controller
{
    public function __invoke(ContentService $content, ContactSettingsService $contact, AboutSettingsService $about)
    {
        return view('app', [
            'ssrContent'      => $content->all(),
            'contactSettings' => $contact->all(),
            'aboutSettings'   => $about->all(),
        ]);
    }
}
