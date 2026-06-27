<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'company' => ['nullable', 'string', 'max:255'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['required', 'string', 'max:2000'],
        ], [
            'name.required' => 'الاسم مطلوب.',
            'rating.required' => 'التقييم مطلوب.',
            'rating.min' => 'التقييم يجب أن يكون من 1 إلى 5.',
            'rating.max' => 'التقييم يجب أن يكون من 1 إلى 5.',
            'comment.required' => 'رأيك مطلوب.',
        ]);

        Review::create([
            'name' => $validated['name'],
            'company' => $validated['company'] ?? null,
            'rating' => $validated['rating'],
            'comment' => [
                'ar' => $validated['comment'],
                'en' => $validated['comment'],
                'ur' => $validated['comment'],
            ],
            'is_approved' => false,
            'is_featured' => false,
            'sort_order' => 0,
        ]);

        return response()->json([
            'message' => 'شكراً! تم إرسال تقييمك وسيظهر بعد المراجعة.',
        ], 201);
    }
}
