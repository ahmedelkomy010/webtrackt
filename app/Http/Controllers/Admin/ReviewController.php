<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Services\ContentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReviewController extends Controller
{
    public function __construct(protected ContentService $content) {}

    public function index(): View
    {
        $reviews = Review::orderByDesc('is_approved')
            ->orderBy('sort_order')
            ->latest()
            ->paginate(20);

        $pendingCount = Review::where('is_approved', false)->count();

        return view('admin.reviews.index', compact('reviews', 'pendingCount'));
    }

    public function create(): View
    {
        return view('admin.reviews.form', ['review' => new Review()]);
    }

    public function store(Request $request): RedirectResponse
    {
        Review::create($this->validated($request));
        $this->content->invalidate();

        return redirect()->route('admin.reviews.index')->with('success', 'تمت إضافة التقييم.');
    }

    public function edit(Review $review): View
    {
        return view('admin.reviews.form', compact('review'));
    }

    public function update(Request $request, Review $review): RedirectResponse
    {
        $review->update($this->validated($request));
        $this->content->invalidate();

        return redirect()->route('admin.reviews.index')->with('success', 'تم تحديث التقييم.');
    }

    public function approve(Review $review): RedirectResponse
    {
        $review->update(['is_approved' => true]);
        $this->content->invalidate();

        return back()->with('success', 'تمت الموافقة على التقييم — يظهر الآن في الموقع.');
    }

    public function destroy(Review $review): RedirectResponse
    {
        $review->delete();
        $this->content->invalidate();

        return redirect()->route('admin.reviews.index')->with('success', 'تم حذف التقييم.');
    }

    protected function validated(Request $request): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'company' => ['nullable', 'string', 'max:255'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'comment_ar' => ['required', 'string', 'max:2000'],
            'comment_en' => ['required', 'string', 'max:2000'],
            'comment_ur' => ['required', 'string', 'max:2000'],
            'is_approved' => ['nullable', 'boolean'],
            'is_featured' => ['nullable', 'boolean'],
        ]);

        return [
            'name' => $data['name'],
            'company' => $data['company'] ?? null,
            'rating' => $data['rating'],
            'sort_order' => $data['sort_order'],
            'comment' => [
                'ar' => $data['comment_ar'],
                'en' => $data['comment_en'],
                'ur' => $data['comment_ur'],
            ],
            'is_approved' => $request->boolean('is_approved'),
            'is_featured' => $request->boolean('is_featured'),
        ];
    }
}
