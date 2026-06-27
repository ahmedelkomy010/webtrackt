<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WhyUsItem;
use App\Services\ContentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WhyUsController extends Controller
{
    public function __construct(protected ContentService $content) {}

    public function index(): View
    {
        $items = WhyUsItem::orderBy('sort_order')->get();

        return view('admin.why-us.index', compact('items'));
    }

    public function create(): View
    {
        return view('admin.why-us.form', ['item' => new WhyUsItem()]);
    }

    public function store(Request $request): RedirectResponse
    {
        WhyUsItem::create($this->validated($request));
        $this->content->invalidate();

        return redirect()->route('admin.why-us.index')->with('success', 'تمت إضافة العنصر.');
    }

    public function edit(WhyUsItem $why_u): View
    {
        return view('admin.why-us.form', ['item' => $why_u]);
    }

    public function update(Request $request, WhyUsItem $why_u): RedirectResponse
    {
        $why_u->update($this->validated($request));
        $this->content->invalidate();

        return redirect()->route('admin.why-us.index')->with('success', 'تم تحديث العنصر.');
    }

    public function destroy(WhyUsItem $why_u): RedirectResponse
    {
        $why_u->delete();
        $this->content->invalidate();

        return redirect()->route('admin.why-us.index')->with('success', 'تم حذف العنصر.');
    }

    protected function validated(Request $request): array
    {
        $data = $request->validate([
            'sort_order' => ['required', 'integer', 'min:0'],
            'title_ar' => ['required', 'string', 'max:255'],
            'title_en' => ['required', 'string', 'max:255'],
            'title_ur' => ['required', 'string', 'max:255'],
            'description_ar' => ['required', 'string'],
            'description_en' => ['required', 'string'],
            'description_ur' => ['required', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        return [
            'sort_order' => $data['sort_order'],
            'title' => ['ar' => $data['title_ar'], 'en' => $data['title_en'], 'ur' => $data['title_ur']],
            'description' => ['ar' => $data['description_ar'], 'en' => $data['description_en'], 'ur' => $data['description_ur']],
            'is_active' => $request->boolean('is_active', true),
        ];
    }
}
