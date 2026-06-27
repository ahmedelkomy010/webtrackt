@php $isEdit = $review->exists; @endphp

@extends('layouts.admin')

@section('title', $isEdit ? 'تعديل تقييم' : 'إضافة تقييم')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.reviews.index') }}" class="text-sm text-tract-600">← العودة للتقييمات</a>
    <h1 class="text-2xl font-bold mt-2">{{ $isEdit ? 'تعديل تقييم' : 'إضافة تقييم عميل' }}</h1>
</div>

<form method="POST" action="{{ $isEdit ? route('admin.reviews.update', $review) : route('admin.reviews.store') }}" class="space-y-6">
    @csrf @if ($isEdit) @method('PUT') @endif

    <div class="bg-white rounded-2xl border p-6 grid sm:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium mb-1">اسم العميل *</label>
            <input type="text" name="name" value="{{ old('name', $review->name) }}" required class="w-full px-4 py-2.5 rounded-xl border">
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">الشركة</label>
            <input type="text" name="company" value="{{ old('company', $review->company) }}" class="w-full px-4 py-2.5 rounded-xl border">
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">التقييم (1-5) *</label>
            <select name="rating" required class="w-full px-4 py-2.5 rounded-xl border">
                @for ($i = 5; $i >= 1; $i--)
                    <option value="{{ $i }}" @selected(old('rating', $review->rating ?? 5) == $i)>{{ str_repeat('★', $i) }} ({{ $i }})</option>
                @endfor
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">الترتيب</label>
            <input type="number" name="sort_order" value="{{ old('sort_order', $review->sort_order ?? 0) }}" min="0" class="w-full px-4 py-2.5 rounded-xl border">
        </div>
        <label class="flex items-center gap-2">
            <input type="checkbox" name="is_approved" value="1" @checked(old('is_approved', $review->is_approved ?? true)) class="rounded text-tract-600">
            <span class="text-sm">منشور — يظهر في الموقع</span>
        </label>
        <label class="flex items-center gap-2">
            <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $review->is_featured)) class="rounded text-tract-600">
            <span class="text-sm">تقييم مميز</span>
        </label>
    </div>

    @foreach (['ar' => 'العربية', 'en' => 'English', 'ur' => 'اردو'] as $lang => $langLabel)
        <div class="bg-white rounded-2xl border p-6">
            <label class="block text-sm font-medium mb-1">{{ $langLabel }} — رأي العميل *</label>
            <textarea name="comment_{{ $lang }}" rows="4" required maxlength="2000" class="w-full px-4 py-2.5 rounded-xl border">{{ old('comment_'.$lang, $review->comment[$lang] ?? '') }}</textarea>
        </div>
    @endforeach

    <button type="submit" class="px-6 py-3 rounded-xl bg-tract-600 text-white font-semibold hover:bg-tract-700">حفظ</button>
</form>
@endsection
