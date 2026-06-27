<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ContentService;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(protected ContentService $content) {}

    public function index(): View
    {
        $stats = $this->content->dashboardStats();
        $recentMessages = \App\Models\ContactMessage::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentMessages'));
    }
}
