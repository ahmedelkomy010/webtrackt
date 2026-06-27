<?php

namespace App\Http\Controllers;

use App\Services\ContentService;
use Illuminate\Http\JsonResponse;

class ContentController extends Controller
{
    public function __construct(protected ContentService $content) {}

    public function index(): JsonResponse
    {
        return response()->json($this->content->all());
    }
}
