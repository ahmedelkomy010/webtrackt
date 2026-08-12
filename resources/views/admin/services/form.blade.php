@php
    $isEdit = $service->exists;
    $featuresAr = collect($service->features ?? [])->map(fn($f) => is_array($f) ? ($f['ar'] ?? '') : $f)->implode("\n");
    $featuresEn = collect($service->features ?? [])->map(fn($f) => is_array($f) ? ($f['en'] ?? '') : $f)->implode("\n");
    $featuresUr = collect($service->features ?? [])->map(fn($f) => is_array($f) ? ($f['ur'] ?? '') : $f)->implode("\n");
    $offers = collect($service->offers ?? [])->values();
@endphp

@extends('layouts.admin')

@section('title', $isEdit ? 'تعديل خدمة' : 'إضافة خدمة')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.services.index') }}" class="text-sm text-tract-600 hover:text-tract-700">← العودة للخدمات</a>
    <h1 class="text-2xl font-bold text-slate-900 mt-2">{{ $isEdit ? 'تعديل خدمة' : 'إضافة خدمة جديدة' }}</h1>
    @if ($isEdit && $service->slug)
        <p class="text-sm text-slate-500 mt-1">صفحة العميل: <a href="{{ route('services.show', $service->slug) }}" target="_blank" class="text-tract-600 hover:underline">/services/{{ $service->slug }}</a></p>
    @endif
    @if ($isEdit)
        <p class="text-sm text-slate-600 mt-2">
            الباقات والعروض: {{ count($service->offers ?? []) }} باقة —
            <a href="#service-packages" class="text-tract-600 font-medium hover:underline">انتقل لتعديل الباقات ↓</a>
        </p>
    @endif
</div>

<form method="POST" action="{{ $isEdit ? route('admin.services.update', $service) : route('admin.services.store') }}" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @if ($isEdit) @method('PUT') @endif

    <div class="bg-white rounded-2xl border border-slate-200 p-6 grid sm:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium mb-1">Slug (رابط الصفحة)</label>
            <input type="text" name="slug" value="{{ old('slug', $service->slug) }}" placeholder="erp-systems" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 font-mono text-sm" dir="ltr">
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">الأيقونة</label>
            <select name="icon" class="w-full px-4 py-2.5 rounded-xl border border-slate-200">
                @foreach (['erp', 'web', 'store', 'marketing'] as $icon)
                    <option value="{{ $icon }}" @selected(old('icon', $service->icon) === $icon)>{{ $icon }}</option>
                @endforeach
            </select>
        </div>
        <div class="sm:col-span-2">
            <label class="block text-sm font-medium mb-1">صورة الخدمة (كارت + صفحة الخدمة)</label>
            @if ($service->image)
                <img src="{{ asset('storage/'.$service->image) }}" alt="" class="w-full max-w-xs h-32 object-cover rounded-xl mb-2 border">
            @endif
            <input type="file" name="image_file" accept="image/*" class="w-full text-sm">
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">الترتيب</label>
            <input type="number" name="sort_order" value="{{ old('sort_order', $service->sort_order ?? 0) }}" min="0" class="w-full px-4 py-2.5 rounded-xl border border-slate-200">
        </div>
        <label class="flex items-center gap-2">
            <input type="checkbox" name="highlight" value="1" @checked(old('highlight', $service->highlight)) class="rounded text-tract-600">
            <span class="text-sm">خدمة مميزة</span>
        </label>
        <label class="flex items-center gap-2 sm:col-span-2">
            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $service->is_active ?? true)) class="rounded text-tract-600">
            <span class="text-sm">نشط — يظهر في الموقع</span>
        </label>
    </div>

    @foreach (['ar' => 'العربية', 'en' => 'English', 'ur' => 'اردو'] as $lang => $langLabel)
        <div class="bg-white rounded-2xl border border-slate-200 p-6 space-y-4">
            <h3 class="font-bold text-slate-900 border-b pb-2">{{ $langLabel }}</h3>
            <div>
                <label class="block text-sm font-medium mb-1">العنوان *</label>
                <input type="text" name="title_{{ $lang }}" value="{{ old('title_'.$lang, data_get($service->title, $lang, '')) }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">الوصف المختصر *</label>
                <textarea name="description_{{ $lang }}" rows="3" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200">{{ old('description_'.$lang, data_get($service->description, $lang, '')) }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium mb-2">محتوى صفحة الخدمة</label>
                <p class="text-xs text-slate-500 mb-2">استخدم العناوين (H2/H3)، القوائم، والجداول لتنسيق المقال — يظهر بشكل منظم في صفحة الخدمة</p>
                <textarea
                    id="body_{{ $lang }}"
                    name="body_{{ $lang }}"
                    class="service-body-editor"
                    data-lang="{{ $lang }}"
                    data-dir="{{ in_array($lang, ['ar', 'ur']) ? 'rtl' : 'ltr' }}"
                >{{ old('body_'.$lang, data_get($service->body, $lang, '')) }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">المميزات (سطر لكل ميزة) *</label>
                <textarea name="features_{{ $lang }}" rows="4" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200">{{ old('features_'.$lang, $lang === 'ar' ? $featuresAr : ($lang === 'en' ? $featuresEn : $featuresUr)) }}</textarea>
            </div>
        </div>
    @endforeach

    <div id="service-packages" class="space-y-4 scroll-mt-8">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h2 class="text-xl font-bold text-slate-900">عروض وباقات الخدمة</h2>
                <p class="text-sm text-slate-500 mt-1">حتى 3 باقات — تظهر في صفحة الخدمة للعملاء. اترك اسم العرض فارغاً لحذف الباقة.</p>
            </div>
            @if ($isEdit && count($service->offers ?? []) > 0)
                <span class="px-3 py-1 rounded-full bg-tract-50 text-tract-700 text-sm font-medium">{{ count($service->offers) }} باقة نشطة</span>
            @endif
        </div>
        @for ($i = 1; $i <= 3; $i++)
            @php $offer = $offers->get($i - 1); @endphp
            <div class="bg-white rounded-2xl border border-slate-200 p-6 space-y-4 {{ data_get($offer, 'highlight') ? 'ring-2 ring-tract-200' : '' }}">
                <h3 class="font-semibold text-tract-700 flex items-center gap-2">
                    الباقة {{ $i }}
                    @if (data_get($offer, 'name.ar'))
                        <span class="text-slate-500 font-normal text-sm">— {{ data_get($offer, 'name.ar') }}</span>
                    @endif
                    @if (data_get($offer, 'highlight'))
                        <span class="px-2 py-0.5 rounded-full bg-tract-600 text-white text-xs">الأكثر طلباً</span>
                    @endif
                </h3>
                <div class="grid sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-medium mb-1">اسم الباقة (عربي) *</label>
                        <input type="text" name="offer_{{ $i }}_name_ar" value="{{ old('offer_'.$i.'_name_ar', data_get($offer, 'name.ar', '')) }}" class="w-full px-3 py-2 rounded-lg border text-sm" placeholder="مثال: باقة المؤسسات">
                    </div>
                    <div>
                        <label class="block text-xs font-medium mb-1">Package name (English)</label>
                        <input type="text" name="offer_{{ $i }}_name_en" value="{{ old('offer_'.$i.'_name_en', data_get($offer, 'name.en', '')) }}" class="w-full px-3 py-2 rounded-lg border text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium mb-1">نام (اردو)</label>
                        <input type="text" name="offer_{{ $i }}_name_ur" value="{{ old('offer_'.$i.'_name_ur', data_get($offer, 'name.ur', '')) }}" class="w-full px-3 py-2 rounded-lg border text-sm">
                    </div>
                </div>
                <div class="grid sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-medium mb-1">السعر (عربي)</label>
                        <input type="text" name="offer_{{ $i }}_price_ar" value="{{ old('offer_'.$i.'_price_ar', data_get($offer, 'price.ar', '')) }}" placeholder="من 5,000 ر.س" class="w-full px-3 py-2 rounded-lg border text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium mb-1">Price (English)</label>
                        <input type="text" name="offer_{{ $i }}_price_en" value="{{ old('offer_'.$i.'_price_en', data_get($offer, 'price.en', '')) }}" class="w-full px-3 py-2 rounded-lg border text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium mb-1">قیمت (اردو)</label>
                        <input type="text" name="offer_{{ $i }}_price_ur" value="{{ old('offer_'.$i.'_price_ur', data_get($offer, 'price.ur', '')) }}" class="w-full px-3 py-2 rounded-lg border text-sm">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1">السعر للدفع الإلكتروني (ر.س) *</label>
                    <input type="number" step="0.01" min="0" name="offer_{{ $i }}_amount_sar" value="{{ old('offer_'.$i.'_amount_sar', data_get($offer, 'amount') ? number_format(data_get($offer, 'amount') / 100, 2, '.', '') : '') }}" placeholder="8500.00" class="w-full max-w-xs px-3 py-2 rounded-lg border text-sm" dir="ltr">
                    <p class="text-xs text-slate-500 mt-1">مطلوب لتفعيل «اطلب هذا العرض» والدفع. اتركه فارغاً لعرض زر التواصل فقط.</p>
                </div>
                <div class="grid sm:grid-cols-3 gap-4">
                    @foreach (['ar' => 'مميزات الباقة', 'en' => 'Features', 'ur' => 'خصوصیات'] as $lang => $label)
                        <div>
                            <label class="block text-xs font-medium mb-1">{{ $label }} (سطر لكل ميزة)</label>
                            <textarea name="offer_{{ $i }}_features_{{ $lang }}" rows="3" class="w-full px-3 py-2 rounded-lg border text-sm" placeholder="ميزة 1&#10;ميزة 2">{{ old('offer_'.$i.'_features_'.$lang, collect(data_get($offer, 'features', []))->map(fn($f) => is_array($f) ? ($f[$lang] ?? '') : $f)->filter()->implode("\n")) }}</textarea>
                        </div>
                    @endforeach
                </div>
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="offer_{{ $i }}_highlight" value="1" @checked(old('offer_'.$i.'_highlight', data_get($offer, 'highlight', false))) class="rounded text-tract-600">
                    <span class="text-sm">باقة مميزة (الأكثر طلباً)</span>
                </label>
            </div>
        @endfor
    </div>

    <button type="submit" class="px-6 py-3 rounded-xl bg-tract-600 text-white font-semibold hover:bg-tract-700 transition-colors">
        {{ $isEdit ? 'حفظ التعديلات' : 'إضافة الخدمة' }}
    </button>
</form>

<style>
.tox-tinymce {
    border-radius: 0.75rem !important;
    border-color: #e2e8f0 !important;
    overflow: hidden;
}
.tox .tox-toolbar-overlord,
.tox .tox-toolbar,
.tox .tox-toolbar__primary {
    background: #f8fafc !important;
}
.tox .tox-edit-area__iframe {
    background: #fff !important;
}
.tox .tox-statusbar {
    border-top: 1px solid #e2e8f0 !important;
    background: #f8fafc !important;
}
</style>

<script src="https://cdn.jsdelivr.net/npm/tinymce@7/tinymce.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/tinymce@7/langs/ar.js"></script>
<script>
(function () {
    const uploadUrl = @json(route('admin.posts.upload-image'));
    const csrf = @json(csrf_token());

    const initTinyMce = () => {
        if (!window.tinymce) return;

        document.querySelectorAll('.service-body-editor').forEach((ta) => {
            const lang = ta.dataset.lang;
            const isRtl = ta.dataset.dir === 'rtl';

            window.tinymce.init({
                target: ta,
                base_url: 'https://cdn.jsdelivr.net/npm/tinymce@7',
                suffix: '.min',
                height: 420,
                min_height: 320,
                menubar: 'edit view insert format table',
                plugins: 'lists link image table code directionality autoresize advlist',
                toolbar: 'undo redo | blocks | bold italic underline | alignleft aligncenter alignright | bullist numlist | link image | table | code',
                block_formats: 'Paragraph=p; Heading 2=h2; Heading 3=h3; Heading 4=h4',
                branding: false,
                promotion: false,
                resize: true,
                statusbar: true,
                directionality: isRtl ? 'rtl' : 'ltr',
                language: lang === 'ar' ? 'ar' : undefined,
                content_style: `
                    body {
                        font-family: system-ui, -apple-system, "Segoe UI", Tahoma, sans-serif;
                        font-size: 16px;
                        line-height: 1.7;
                        color: #1e293b;
                        ${isRtl ? 'direction: rtl; text-align: right;' : 'direction: ltr; text-align: left;'}
                    }
                    h2 { font-size: 1.5rem; font-weight: 700; margin: 1.25rem 0 0.75rem; color: #0f172a; }
                    h3 { font-size: 1.25rem; font-weight: 700; margin: 1rem 0 0.5rem; color: #0f172a; }
                    p { margin: 0 0 0.75rem; }
                    ul, ol { margin: 0 0 0.75rem; padding-${isRtl ? 'right' : 'left'}: 1.5rem; }
                    img { max-width: 100%; height: auto; border-radius: 0.75rem; }
                    a { color: #2a5f9e; text-decoration: underline; }
                `,
                automatic_uploads: true,
                file_picker_types: 'image',
                images_upload_handler: (blobInfo) => new Promise((resolve, reject) => {
                    const fd = new FormData();
                    fd.append('image', blobInfo.blob(), blobInfo.filename());
                    fd.append('_token', csrf);
                    fetch(uploadUrl, {
                        method: 'POST',
                        body: fd,
                        headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    })
                        .then((res) => res.json())
                        .then((data) => data.url ? resolve(data.url) : reject('فشل رفع الصورة'))
                        .catch(() => reject('فشل رفع الصورة'));
                }),
            });
        });
    };

    document.querySelector('form')?.addEventListener('submit', () => {
        window.tinymce?.triggerSave();
    });

    if (window.tinymce) {
        initTinyMce();
    } else {
        document.querySelector('script[src*="tinymce.min.js"]')?.addEventListener('load', initTinyMce);
    }
})();
</script>
@endsection
