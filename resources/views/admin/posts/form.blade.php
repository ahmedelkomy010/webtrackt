@php $isEdit = $post->exists; @endphp

@extends('layouts.admin')

@section('title', $isEdit ? 'تعديل مقال' : 'مقال جديد')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.posts.index') }}" class="text-sm text-tract-600">← العودة للمقالات</a>
    <h1 class="text-2xl font-bold mt-2">{{ $isEdit ? 'تعديل مقال SEO' : 'إضافة مقال SEO جديد' }}</h1>
    <p class="text-slate-600 text-sm mt-1">املأ حقول SEO بعناية — العنوان (70 حرف)، الوصف (160 حرف)، كلمات مفتاحية قوية</p>
</div>

<form method="POST" action="{{ $isEdit ? route('admin.posts.update', $post) : route('admin.posts.store') }}" enctype="multipart/form-data" class="space-y-6">
    @csrf @if ($isEdit) @method('PUT') @endif

    <div class="bg-white rounded-2xl border p-6 grid sm:grid-cols-2 gap-4">
        <div class="sm:col-span-2">
            <label class="block text-sm font-medium mb-1">Slug (رابط SEO) — اتركه فارغاً للتوليد التلقائي</label>
            <input type="text" name="slug" value="{{ old('slug', $post->slug) }}" placeholder="erp-saudi-arabia" class="w-full px-4 py-2.5 rounded-xl border font-mono text-sm" dir="ltr">
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">تاريخ النشر</label>
            <input type="datetime-local" name="published_at" value="{{ old('published_at', $post->published_at?->format('Y-m-d\TH:i')) }}" class="w-full px-4 py-2.5 rounded-xl border">
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">صورة بارزة (Open Graph)</label>
            <input type="file" name="featured_image_file" accept="image/*" class="w-full text-sm">
            @if ($post->featured_image)
                <img src="{{ asset('storage/'.$post->featured_image) }}" alt="" class="mt-2 h-20 rounded-lg object-cover">
            @endif
        </div>
        <label class="flex items-center gap-2 sm:col-span-2">
            <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $post->is_published)) class="rounded text-tract-600">
            <span class="text-sm font-medium">نشر المقال — يظهر فوراً في المدونة و sitemap.xml</span>
        </label>
    </div>

    @foreach (['ar' => 'العربية', 'en' => 'English', 'ur' => 'اردو'] as $lang => $langLabel)
        <div class="bg-white rounded-2xl border p-6 space-y-4">
            <h3 class="font-bold text-slate-900 border-b pb-2 flex items-center gap-2">
                {{ $langLabel }}
                @if ($lang === 'ar')<span class="text-xs font-normal text-tract-600 bg-tract-50 px-2 py-0.5 rounded-full">SEO رئيسي</span>@endif
            </h3>

            <div>
                <label class="block text-sm font-medium mb-1">عنوان المقال *</label>
                <input type="text" name="title_{{ $lang }}" value="{{ old('title_'.$lang, $post->title[$lang] ?? '') }}" required maxlength="255" class="w-full px-4 py-2.5 rounded-xl border">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Meta Title (SEO) — max 70</label>
                <input type="text" name="meta_title_{{ $lang }}" value="{{ old('meta_title_'.$lang, $post->meta_title[$lang] ?? '') }}" maxlength="70" class="w-full px-4 py-2.5 rounded-xl border" placeholder="عنوان يظهر في Google">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Meta Description (SEO) — max 160</label>
                <textarea name="meta_description_{{ $lang }}" rows="2" maxlength="160" class="w-full px-4 py-2.5 rounded-xl border" placeholder="وصف يظهر في نتائج البحث">{{ old('meta_description_'.$lang, $post->meta_description[$lang] ?? '') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">كلمات مفتاحية (SEO) — مفصولة بفاصلة</label>
                <input type="text" name="meta_keywords_{{ $lang }}" value="{{ old('meta_keywords_'.$lang, $post->meta_keywords[$lang] ?? '') }}" class="w-full px-4 py-2.5 rounded-xl border" placeholder="ERP, تسويق إلكتروني, السعودية, trakkt">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">مقتطف (Excerpt) *</label>
                <textarea name="excerpt_{{ $lang }}" rows="2" required maxlength="500" class="w-full px-4 py-2.5 rounded-xl border">{{ old('excerpt_'.$lang, $post->excerpt[$lang] ?? '') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">المحتوى (HTML مسموح) *</label>
                <textarea name="content_{{ $lang }}" rows="12" required class="w-full px-4 py-2.5 rounded-xl border font-mono text-sm" placeholder="<h2>عنوان فرعي</h2><p>محتوى المقال...</p>">{{ old('content_'.$lang, $post->content[$lang] ?? '') }}</textarea>
            </div>
        </div>
    @endforeach

    <button type="submit" class="px-6 py-3 rounded-xl bg-tract-600 text-white font-semibold hover:bg-tract-700">
        {{ $isEdit ? 'حفظ التعديلات' : 'نشر المقال' }}
    </button>
</form>
@endsection
