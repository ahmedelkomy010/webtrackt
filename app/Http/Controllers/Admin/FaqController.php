<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FaqItem;
use App\Services\ContentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FaqController extends Controller
{
    public function __construct(protected ContentService $content) {}

    public function index(): View
    {
        $items = FaqItem::orderBy('sort_order')->get();

        return view('admin.faqs.index', compact('items'));
    }

    public function create(): View
    {
        return view('admin.faqs.form', ['item' => new FaqItem()]);
    }

    public function store(Request $request): RedirectResponse
    {
        FaqItem::create($this->validated($request));
        $this->content->invalidate();

        return redirect()->route('admin.faqs.index')->with('success', 'تمت إضافة السؤال.');
    }

    public function edit(FaqItem $faq): View
    {
        return view('admin.faqs.form', ['item' => $faq]);
    }

    public function update(Request $request, FaqItem $faq): RedirectResponse
    {
        $faq->update($this->validated($request));
        $this->content->invalidate();

        return redirect()->route('admin.faqs.index')->with('success', 'تم تحديث السؤال.');
    }

    public function destroy(FaqItem $faq): RedirectResponse
    {
        $faq->delete();
        $this->content->invalidate();

        return redirect()->route('admin.faqs.index')->with('success', 'تم حذف السؤال.');
    }

    protected function validated(Request $request): array
    {
        $data = $request->validate([
            'sort_order' => ['required', 'integer', 'min:0'],
            'question_ar' => ['required', 'string', 'max:500'],
            'question_en' => ['required', 'string', 'max:500'],
            'question_ur' => ['required', 'string', 'max:500'],
            'answer_ar' => ['required', 'string'],
            'answer_en' => ['required', 'string'],
            'answer_ur' => ['required', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        return [
            'sort_order' => $data['sort_order'],
            'question' => [
                'ar' => $data['question_ar'],
                'en' => $data['question_en'],
                'ur' => $data['question_ur'],
            ],
            'answer' => [
                'ar' => $data['answer_ar'],
                'en' => $data['answer_en'],
                'ur' => $data['answer_ur'],
            ],
            'is_active' => $request->boolean('is_active', true),
        ];
    }
}
