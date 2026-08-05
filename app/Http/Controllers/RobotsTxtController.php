<?php

namespace App\Http\Controllers;

use App\Services\RobotsTxtService;
use Illuminate\Http\Response;

class RobotsTxtController extends Controller
{
    public function __invoke(RobotsTxtService $robots): Response
    {
        $content = $robots->read();

        if ($content === null || trim($content) === '') {
            abort(404);
        }

        return response($content, 200, [
            'Content-Type' => 'text/plain; charset=UTF-8',
        ]);
    }
}
