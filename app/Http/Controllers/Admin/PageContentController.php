<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\PageContentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageContentController extends Controller
{
    public function __construct(protected PageContentService $pages) {}

    public function index(): View
    {
        return view('admin.pages.index', [
            'pages' => $this->pageLabels(),
        ]);
    }

    public function edit(string $page): View
    {
        abort_unless(in_array($page, PageContentService::PAGES, true), 404);

        return view('admin.pages.edit', [
            'page' => $page,
            'content' => $this->pages->page($page),
            'pageLabels' => $this->pageLabels(),
        ]);
    }

    public function update(Request $request, string $page): RedirectResponse
    {
        abort_unless(in_array($page, PageContentService::PAGES, true), 404);

        $rules = [];
        foreach (['ar', 'en', 'ur'] as $lang) {
            if ($page === 'home') {
                $rules["hero_badge_{$lang}"] = ['nullable', 'string', 'max:255'];
                $rules["hero_headline_{$lang}"] = ['nullable', 'string', 'max:255'];
                $rules["hero_headline_highlight_{$lang}"] = ['nullable', 'string', 'max:255'];
            } else {
                $rules["title_{$lang}"] = ['nullable', 'string', 'max:255'];
                $rules["badge_{$lang}"] = ['nullable', 'string', 'max:255'];
                $rules["subtitle_{$lang}"] = ['nullable', 'string', 'max:500'];
            }
            $rules["body_{$lang}"] = ['nullable', 'string'];
        }

        $data = $request->validate($rules);
        $payload = [];

        foreach (['ar', 'en', 'ur'] as $lang) {
            if ($page === 'home') {
                $payload['hero_badge'][$lang] = $data["hero_badge_{$lang}"] ?? '';
                $payload['hero_headline'][$lang] = $data["hero_headline_{$lang}"] ?? '';
                $payload['hero_headline_highlight'][$lang] = $data["hero_headline_highlight_{$lang}"] ?? '';
            } else {
                $payload['title'][$lang] = $data["title_{$lang}"] ?? '';
                $payload['badge'][$lang] = $data["badge_{$lang}"] ?? '';
                $payload['subtitle'][$lang] = $data["subtitle_{$lang}"] ?? '';
            }
            $payload['body'][$lang] = $data["body_{$lang}"] ?? '';
        }

        $this->pages->savePage($page, $payload);

        return redirect()
            ->route('admin.pages.edit', $page)
            ->with('success', 'تم حفظ محتوى الصفحة بنجاح.');
    }

    protected function pageLabels(): array
    {
        return [
            'home' => 'الصفحة الرئيسية',
            'about' => 'من نحن',
            'contact' => 'تواصل معنا',
            'privacy' => 'سياسة الخصوصية',
            'works' => 'أعمالنا',
        ];
    }
}
