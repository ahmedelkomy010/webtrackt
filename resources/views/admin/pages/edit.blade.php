@php
    $label = $pageLabels[$page] ?? $page;
@endphp

@extends('layouts.admin')

@section('title', 'تعديل '.$label)

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.pages.index') }}" class="text-sm text-tract-600 hover:text-tract-700">← العودة للصفحات</a>
    <h1 class="text-2xl font-bold text-slate-900 mt-2">{{ $label }}</h1>
    @if ($page !== 'home')
        <p class="text-sm text-slate-500 mt-1">صفحة العميل: <a href="{{ url('/'.$page) }}" target="_blank" class="text-tract-600 hover:underline">/{{ $page }}</a></p>
    @else
        <p class="text-sm text-slate-500 mt-1">نصوص قسم Hero في الصفحة الرئيسية</p>
    @endif
</div>

<form method="POST" action="{{ route('admin.pages.update', $page) }}" class="space-y-6" id="page-form">
    @csrf @method('PUT')

    @foreach (['ar' => 'العربية', 'en' => 'English', 'ur' => 'اردو'] as $lang => $langLabel)
        <div class="bg-white rounded-2xl border border-slate-200 p-6 space-y-4">
            <h3 class="font-bold text-slate-900 border-b pb-2">{{ $langLabel }}</h3>

            @if ($page === 'home')
                <div>
                    <label class="block text-sm font-medium mb-1">شارة Hero</label>
                    <input type="text" name="hero_badge_{{ $lang }}" value="{{ old('hero_badge_'.$lang, $content['hero_badge'][$lang] ?? '') }}" class="w-full px-4 py-2.5 rounded-xl border">
                </div>
                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">العنوان الرئيسي</label>
                        <input type="text" name="hero_headline_{{ $lang }}" value="{{ old('hero_headline_'.$lang, $content['hero_headline'][$lang] ?? '') }}" class="w-full px-4 py-2.5 rounded-xl border">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">الجزء المميز (ملون)</label>
                        <input type="text" name="hero_headline_highlight_{{ $lang }}" value="{{ old('hero_headline_highlight_'.$lang, $content['hero_headline_highlight'][$lang] ?? '') }}" class="w-full px-4 py-2.5 rounded-xl border">
                    </div>
                </div>
            @else
                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">عنوان الصفحة</label>
                        <input type="text" name="title_{{ $lang }}" value="{{ old('title_'.$lang, $content['title'][$lang] ?? '') }}" class="w-full px-4 py-2.5 rounded-xl border">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">الشارة (Badge)</label>
                        <input type="text" name="badge_{{ $lang }}" value="{{ old('badge_'.$lang, $content['badge'][$lang] ?? '') }}" class="w-full px-4 py-2.5 rounded-xl border">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">العنوان الفرعي</label>
                    <input type="text" name="subtitle_{{ $lang }}" value="{{ old('subtitle_'.$lang, $content['subtitle'][$lang] ?? '') }}" class="w-full px-4 py-2.5 rounded-xl border">
                </div>
            @endif

            @if ($page !== 'home')
                <div>
                    <label class="block text-sm font-medium mb-2">محتوى الصفحة (HTML)</label>
                    <textarea
                        id="body_{{ $lang }}"
                        name="body_{{ $lang }}"
                        class="page-body-editor"
                        data-lang="{{ $lang }}"
                        data-dir="{{ in_array($lang, ['ar', 'ur']) ? 'rtl' : 'ltr' }}"
                    >{{ old('body_'.$lang, $content['body'][$lang] ?? '') }}</textarea>
                </div>
            @endif
        </div>
    @endforeach

    <button type="submit" class="px-6 py-3 rounded-xl bg-tract-600 text-white font-semibold hover:bg-tract-700">حفظ المحتوى</button>
</form>

<style>
.tox-tinymce { border-radius: 0.75rem !important; border-color: #e2e8f0 !important; overflow: hidden; }
</style>

<script src="https://cdn.jsdelivr.net/npm/tinymce@7/tinymce.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/tinymce@7/langs/ar.js"></script>
<script>
(function () {
    const uploadUrl = @json(route('admin.posts.upload-image'));
    const csrf = @json(csrf_token());

    const initTinyMce = () => {
        if (!window.tinymce) return;
        document.querySelectorAll('.page-body-editor').forEach((ta) => {
            const lang = ta.dataset.lang;
            const isRtl = ta.dataset.dir === 'rtl';
            window.tinymce.init({
                target: ta,
                base_url: 'https://cdn.jsdelivr.net/npm/tinymce@7',
                suffix: '.min',
                height: 400,
                menubar: 'edit view insert format',
                plugins: 'lists link table code directionality autoresize advlist',
                toolbar: 'undo redo | blocks | bold italic | bullist numlist | link | table | code',
                block_formats: 'Paragraph=p; Heading 2=h2; Heading 3=h3',
                branding: false,
                promotion: false,
                directionality: isRtl ? 'rtl' : 'ltr',
                language: lang === 'ar' ? 'ar' : undefined,
            });
        });
    };

    document.getElementById('page-form')?.addEventListener('submit', () => window.tinymce?.triggerSave());
    if (window.tinymce) initTinyMce();
    else document.querySelector('script[src*="tinymce.min.js"]')?.addEventListener('load', initTinyMce);
})();
</script>
@endsection
