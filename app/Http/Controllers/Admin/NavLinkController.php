<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NavLink;
use App\Services\ContentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NavLinkController extends Controller
{
    public function __construct(protected ContentService $content) {}

    public function index(): View
    {
        $links = NavLink::orderBy('sort_order')->get();

        return view('admin.nav-links.index', compact('links'));
    }

    public function create(): View
    {
        return view('admin.nav-links.form', ['link' => new NavLink()]);
    }

    public function store(Request $request): RedirectResponse
    {
        NavLink::create($this->validated($request));
        $this->content->invalidate();

        return redirect()->route('admin.nav-links.index')->with('success', 'تمت إضافة الرابط.');
    }

    public function edit(NavLink $nav_link): View
    {
        return view('admin.nav-links.form', compact('nav_link'));
    }

    public function update(Request $request, NavLink $nav_link): RedirectResponse
    {
        $nav_link->update($this->validated($request));
        $this->content->invalidate();

        return redirect()->route('admin.nav-links.index')->with('success', 'تم تحديث الرابط.');
    }

    public function destroy(NavLink $nav_link): RedirectResponse
    {
        $nav_link->delete();
        $this->content->invalidate();

        return redirect()->route('admin.nav-links.index')->with('success', 'تم حذف الرابط.');
    }

    protected function validated(Request $request): array
    {
        $data = $request->validate([
            'href' => ['required', 'string', 'max:255'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'label_ar' => ['required', 'string', 'max:255'],
            'label_en' => ['required', 'string', 'max:255'],
            'label_ur' => ['required', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        return [
            'href' => $data['href'],
            'sort_order' => $data['sort_order'],
            'label' => ['ar' => $data['label_ar'], 'en' => $data['label_en'], 'ur' => $data['label_ur']],
            'is_active' => $request->boolean('is_active', true),
        ];
    }
}
