<?php

namespace App\Http\Controllers;

use App\Services\ContentService;

class HomeController extends Controller
{
    public function __invoke(ContentService $content)
    {
        return view('app', [
            'ssrContent' => $content->all(),
        ]);
    }
}
