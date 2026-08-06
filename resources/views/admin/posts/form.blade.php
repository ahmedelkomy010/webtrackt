@php
    $isEdit = $post->exists;
    $minWords = $minWords ?? 800;
    $schemaAr = old('schema_json_ar', data_get($post->schema_json, 'ar', ''));
    $schemaEn = old('schema_json_en', data_get($post->schema_json, 'en', ''));
    $schemaUr = old('schema_json_ur', data_get($post->schema_json, 'ur', ''));
@endphp

@extends('layouts.admin')

@section('title', $isEdit ? 'تعديل مقال' : 'مقال جديد')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.posts.index') }}" class="text-sm text-tract-600 hover:text-tract-700">← العودة للمقالات</a>
    <h1 class="text-2xl font-bold text-slate-900 mt-2">{{ $isEdit ? 'تعديل مقال SEO' : 'إضافة مقال SEO جديد' }}</h1>
</div>

<form method="POST" action="{{ $isEdit ? route('admin.posts.update', $post) : route('admin.posts.store') }}" enctype="multipart/form-data" class="space-y-6" id="post-form">
    @csrf
    @if ($isEdit) @method('PUT') @endif

    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
        <div class="flex flex-wrap gap-1 p-2 border-b border-slate-200 bg-slate-50" role="tablist">
            <button type="button" class="admin-tab is-active" data-tab="basic">المعلومات الأساسية</button>
            <button type="button" class="admin-tab" data-tab="seo">إعدادات SEO</button>
        </div>

        {{-- Tab: Basic --}}
        <div class="admin-tab-panel is-active p-6 space-y-6" data-panel="basic">
            <div class="grid sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium mb-1">Slug (رابط SEO)</label>
                    <input type="text" name="slug" value="{{ old('slug', $post->slug) }}" placeholder="erp-saudi-arabia" class="w-full px-4 py-2.5 rounded-xl border font-mono text-sm" dir="ltr">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">تاريخ النشر</label>
                    <input type="datetime-local" name="published_at" value="{{ old('published_at', $post->published_at?->format('Y-m-d\TH:i')) }}" class="w-full px-4 py-2.5 rounded-xl border">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">صورة بارزة (Open Graph / Google)</label>
                    <input type="file" name="featured_image_file" accept="image/*" class="w-full text-sm">
                    @if ($post->featured_image)
                        <img src="{{ asset('storage/'.$post->featured_image) }}" alt="" class="mt-2 h-24 rounded-lg object-cover border">
                    @endif
                </div>
                <label class="flex items-center gap-2 sm:col-span-2">
                    <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $post->exists ? $post->is_published : true)) class="rounded text-tract-600">
                    <span class="text-sm font-medium">نشر المقال — يظهر في المدونة و sitemap</span>
                </label>
            </div>

            @foreach (['ar' => 'العربية', 'en' => 'English', 'ur' => 'اردو'] as $lang => $langLabel)
                <div class="rounded-2xl border border-slate-200 p-6 space-y-4 post-lang-block" data-lang="{{ $lang }}">
                    <h3 class="font-bold text-slate-900 border-b pb-2">{{ $langLabel }}</h3>

                    <div>
                        <label class="block text-sm font-medium mb-1">عنوان المقال (H1) *</label>
                        <input type="text" name="title_{{ $lang }}" value="{{ old('title_'.$lang, $post->title[$lang] ?? '') }}" required maxlength="255" class="w-full px-4 py-2.5 rounded-xl border post-field title-sync" data-lang="{{ $lang }}">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1 flex justify-between">
                            <span>مقتطف *</span>
                            <span class="text-xs char-count" data-max="500" data-for="excerpt_{{ $lang }}">0/500</span>
                        </label>
                        <textarea name="excerpt_{{ $lang }}" rows="2" required maxlength="500" class="w-full px-4 py-2.5 rounded-xl border char-track post-field excerpt-sync" data-lang="{{ $lang }}" data-for="excerpt_{{ $lang }}">{{ old('excerpt_'.$lang, $post->excerpt[$lang] ?? '') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">محتوى المقال *</label>
                        <textarea
                            id="content_{{ $lang }}"
                            name="content_{{ $lang }}"
                            required
                            class="content-editor"
                            data-lang="{{ $lang }}"
                            data-dir="{{ in_array($lang, ['ar', 'ur']) ? 'rtl' : 'ltr' }}"
                        >{{ old('content_'.$lang, $post->content[$lang] ?? '') }}</textarea>
                        <div class="mt-2 flex flex-wrap gap-4 text-xs">
                            <span class="word-stat text-slate-600" data-lang="{{ $lang }}">الكلمات: <strong class="word-count">0</strong></span>
                            <span class="text-slate-500">الهدف: {{ $minWords }}+ كلمة</span>
                            <span class="reading-time text-slate-500" data-lang="{{ $lang }}">وقت القراءة: ~0 د</span>
                            <span class="seo-score text-slate-600 font-medium" data-lang="{{ $lang }}">SEO: —</span>
                        </div>
                        <ul class="mt-2 text-xs space-y-1 seo-checklist" data-lang="{{ $lang }}"></ul>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Tab: SEO --}}
        <div class="admin-tab-panel p-6 space-y-6 hidden" data-panel="seo">
            <p class="text-sm text-slate-500">حقول Meta و Schema — اختيارية. اتركها فارغة لاستخدام العنوان والمقتطف تلقائياً.</p>

            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1 flex justify-between">
                        <span>عنوان الميتا (Meta Title) بالعربية <span class="text-xs text-slate-400 font-normal">اختياري</span></span>
                        <span class="text-xs char-count" data-max="70" data-for="meta_title_ar">0/70</span>
                    </label>
                    <input type="text" name="meta_title_ar" value="{{ old('meta_title_ar', $post->meta_title['ar'] ?? '') }}" maxlength="70" class="w-full px-4 py-2.5 rounded-xl border char-track seo-field" data-for="meta_title_ar">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1 flex justify-between">
                        <span>Meta Title (English) <span class="text-xs text-slate-400 font-normal">Optional</span></span>
                        <span class="text-xs char-count" data-max="70" data-for="meta_title_en">0/70</span>
                    </label>
                    <input type="text" name="meta_title_en" value="{{ old('meta_title_en', $post->meta_title['en'] ?? '') }}" maxlength="70" class="w-full px-4 py-2.5 rounded-xl border char-track seo-field" data-for="meta_title_en" dir="ltr">
                </div>
            </div>

            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">الكلمات المفتاحية (Meta Keywords) بالعربية <span class="text-xs text-slate-400 font-normal">اختياري</span></label>
                    <input type="text" name="meta_keywords_ar" value="{{ old('meta_keywords_ar', $post->meta_keywords['ar'] ?? '') }}" class="w-full px-4 py-2.5 rounded-xl border seo-field" placeholder="ERP, تسويق, trakkt">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Meta Keywords (English) <span class="text-xs text-slate-400 font-normal">Optional</span></label>
                    <input type="text" name="meta_keywords_en" value="{{ old('meta_keywords_en', $post->meta_keywords['en'] ?? '') }}" class="w-full px-4 py-2.5 rounded-xl border seo-field" dir="ltr">
                </div>
            </div>

            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1 flex justify-between">
                        <span>وصف الميتا (Meta Description) بالعربية <span class="text-xs text-slate-400 font-normal">اختياري</span></span>
                        <span class="text-xs char-count" data-max="160" data-for="meta_description_ar">0/160</span>
                    </label>
                    <textarea name="meta_description_ar" rows="3" maxlength="160" class="w-full px-4 py-2.5 rounded-xl border char-track seo-field" data-for="meta_description_ar">{{ old('meta_description_ar', $post->meta_description['ar'] ?? '') }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1 flex justify-between">
                        <span>Meta Description (English) <span class="text-xs text-slate-400 font-normal">Optional</span></span>
                        <span class="text-xs char-count" data-max="160" data-for="meta_description_en">0/160</span>
                    </label>
                    <textarea name="meta_description_en" rows="3" maxlength="160" class="w-full px-4 py-2.5 rounded-xl border char-track seo-field" data-for="meta_description_en" dir="ltr">{{ old('meta_description_en', $post->meta_description['en'] ?? '') }}</textarea>
                </div>
            </div>

            <details class="rounded-xl border border-slate-200 p-4">
                <summary class="cursor-pointer text-sm font-medium text-slate-700">حقول SEO — اردو (اختياري)</summary>
                <div class="mt-4 grid sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-medium mb-1">Meta Title</label>
                        <input type="text" name="meta_title_ur" value="{{ old('meta_title_ur', $post->meta_title['ur'] ?? '') }}" maxlength="70" class="w-full px-3 py-2 rounded-lg border text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium mb-1">Meta Keywords</label>
                        <input type="text" name="meta_keywords_ur" value="{{ old('meta_keywords_ur', $post->meta_keywords['ur'] ?? '') }}" class="w-full px-3 py-2 rounded-lg border text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium mb-1">Meta Description</label>
                        <textarea name="meta_description_ur" rows="2" maxlength="160" class="w-full px-3 py-2 rounded-lg border text-sm">{{ old('meta_description_ur', $post->meta_description['ur'] ?? '') }}</textarea>
                    </div>
                </div>
            </details>

            <div>
                <label class="block text-sm font-medium mb-1">الاسكيما بالعربي JSON-LD</label>
                <textarea name="schema_json_ar" rows="6" class="w-full px-4 py-2.5 rounded-xl border font-mono text-sm" dir="ltr" placeholder='{"@@context":"https://schema.org","@@type":"BlogPosting"}'>{{ $schemaAr }}</textarea>
                <p class="text-xs text-slate-500 mt-1">اكتب JSON فقط بدون وسم script</p>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">English Schema JSON-LD</label>
                <textarea name="schema_json_en" rows="6" class="w-full px-4 py-2.5 rounded-xl border font-mono text-sm" dir="ltr" placeholder='{"@@context":"https://schema.org","@@type":"BlogPosting"}'>{{ $schemaEn }}</textarea>
                <p class="text-xs text-slate-500 mt-1">Enter JSON only without the script tag</p>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Schema JSON-LD — اردو (اختياري)</label>
                <textarea name="schema_json_ur" rows="4" class="w-full px-4 py-2.5 rounded-xl border font-mono text-sm" dir="ltr">{{ $schemaUr }}</textarea>
            </div>

            {{-- Google preview --}}
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                <p class="text-xs text-slate-500 mb-3">معاينة Google (عربي)</p>
                <p class="text-blue-700 text-lg font-medium truncate seo-preview-title" id="seo-preview-title">{{ old('meta_title_ar', $post->meta_title['ar'] ?? $post->title['ar'] ?? 'عنوان المقال') }}</p>
                <p class="text-green-700 text-sm truncate">{{ config('tract.website') }}/blog/{{ old('slug', $post->slug ?: 'slug') }}</p>
                <p class="text-slate-600 text-sm line-clamp-2 seo-preview-desc" id="seo-preview-desc">{{ old('meta_description_ar', $post->meta_description['ar'] ?? $post->excerpt['ar'] ?? '') }}</p>
            </div>
        </div>
    </div>

    <button type="submit" class="px-6 py-3 rounded-xl bg-tract-600 text-white font-semibold hover:bg-tract-700">
        {{ $isEdit ? 'تحديث' : 'نشر المقال' }}
    </button>
</form>

<style>
.admin-tab {
    padding: 0.625rem 1rem;
    border-radius: 0.75rem;
    font-size: 0.875rem;
    font-weight: 600;
    color: #64748b;
    transition: background 0.2s, color 0.2s;
}
.admin-tab:hover { background: #fff; color: #047857; }
.admin-tab.is-active { background: #fff; color: #047857; box-shadow: 0 1px 3px rgba(15,23,42,0.08); }
.admin-tab-panel.hidden { display: none; }

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
.tox .tox-mbtn,
.tox .tox-tbtn {
    color: #334155 !important;
}
.tox .tox-tbtn:hover {
    background: #e2e8f0 !important;
}
.tox .tox-tbtn--enabled,
.tox .tox-tbtn--enabled:hover {
    background: #dcfce7 !important;
    color: #047857 !important;
}
</style>

<script src="https://cdn.jsdelivr.net/npm/tinymce@7/tinymce.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/tinymce@7/langs/ar.js"></script>

<script>
(function () {
    const minWords = {{ (int) $minWords }};
    const uploadUrl = @json(route('admin.posts.upload-image'));
    const csrf = @json(csrf_token());

    document.querySelectorAll('.admin-tab').forEach((tab) => {
        tab.addEventListener('click', () => {
            document.querySelectorAll('.admin-tab').forEach((t) => t.classList.remove('is-active'));
            document.querySelectorAll('.admin-tab-panel').forEach((p) => p.classList.add('hidden'));
            tab.classList.add('is-active');
            document.querySelector(`[data-panel="${tab.dataset.tab}"]`)?.classList.remove('hidden');
        });
    });

    const stripHtml = (html) => html.replace(/<[^>]+>/g, ' ').replace(/\s+/g, ' ').trim();
    const countWords = (text) => stripHtml(text).split(/\s+/).filter(Boolean).length;

    const updateCharCount = (field) => {
        const name = field.getAttribute('name');
        const counter = document.querySelector(`.char-count[data-for="${name}"]`);
        if (!counter) return;
        const max = parseInt(counter.dataset.max, 10);
        const len = field.value.length;
        counter.textContent = `${len}/${max}`;
        counter.className = 'text-xs char-count ' + (len > max ? 'text-red-600' : len >= max * 0.9 ? 'text-amber-600' : 'text-slate-400');
    };

    const updateSeoPreview = () => {
        const title = document.querySelector('[name="meta_title_ar"]')?.value
            || document.querySelector('[name="title_ar"]')?.value
            || 'عنوان المقال';
        const desc = document.querySelector('[name="meta_description_ar"]')?.value
            || document.querySelector('[name="excerpt_ar"]')?.value
            || '';
        const previewTitle = document.getElementById('seo-preview-title');
        const previewDesc = document.getElementById('seo-preview-desc');
        if (previewTitle) previewTitle.textContent = title;
        if (previewDesc) previewDesc.textContent = desc;
    };

    const syncSeoFromBasic = (lang) => {
        const metaTitle = document.querySelector(`[name="meta_title_${lang}"]`);
        const metaDesc = document.querySelector(`[name="meta_description_${lang}"]`);
        const title = document.querySelector(`[name="title_${lang}"]`);
        const excerpt = document.querySelector(`[name="excerpt_${lang}"]`);
        if (metaTitle && title && !metaTitle.dataset.userEdited && lang === 'ar') {
            metaTitle.value = title.value.slice(0, 70);
        }
        if (metaDesc && excerpt && !metaDesc.dataset.userEdited && lang === 'ar') {
            metaDesc.value = excerpt.value.slice(0, 160);
        }
        updateSeoPreview();
    };

    const getEditorContent = (lang) => {
        const ta = document.querySelector(`.content-editor[data-lang="${lang}"]`);
        if (!ta) return '';
        const editor = window.tinymce?.get(`content_${lang}`);
        return editor ? editor.getContent() : ta.value;
    };

    const updateContentStats = (lang) => {
        const ta = document.querySelector(`.content-editor[data-lang="${lang}"]`);
        if (!ta) return;
        const html = getEditorContent(lang);
        const words = countWords(html);
        const block = ta.closest('.post-lang-block');
        const metaTitle = document.querySelector(`[name="meta_title_${lang}"]`)?.value || document.querySelector(`[name="title_${lang}"]`)?.value;
        const metaDesc = document.querySelector(`[name="meta_description_${lang}"]`)?.value;
        const h2 = (html.match(/<h2/gi) || []).length;
        const hasImage = /<img/i.test(html) || document.querySelector('[name="featured_image_file"]')?.files?.length;

        block.querySelector('.word-count').textContent = words;
        block.querySelector('.reading-time').textContent = `وقت القراءة: ~${Math.max(1, Math.ceil(words / 200))} د`;

        const checks = [];
        if (words >= minWords) checks.push(['✅', `عدد الكلمات مناسب (${words})`]); else checks.push(['⚠️', `أضف ${minWords - words} كلمة (${words}/${minWords})`]);
        if (h2 >= 1) checks.push(['✅', 'يحتوي عنوان H2']); else checks.push(['⚠️', 'أضف عنوان H2 على الأقل']);
        if (metaTitle && metaTitle.length <= 70) checks.push(['✅', 'Meta Title مناسب']); else checks.push(['⚠️', 'Meta Title طويل أو فارغ']);
        if (metaDesc && metaDesc.length >= 120 && metaDesc.length <= 160) checks.push(['✅', 'Meta Description ممتاز']); else if (metaDesc) checks.push(['⚠️', 'Meta Description يفضل 120-160 حرف']);
        if (hasImage) checks.push(['✅', 'يحتوي صورة']); else checks.push(['⚠️', 'أضف صورة بارزة أو داخل المحتوى']);

        const score = Math.round((checks.filter(c => c[0] === '✅').length / checks.length) * 100);
        block.querySelector('.seo-score').textContent = `SEO: ${score}%`;
        block.querySelector('.seo-checklist').innerHTML = checks.map(([icon, text]) => `<li>${icon} ${text}</li>`).join('');
    };

    document.querySelectorAll('.char-track, .post-field, .seo-field').forEach((field) => {
        field.addEventListener('input', () => {
            updateCharCount(field);
            const lang = field.dataset.lang || field.closest('.post-lang-block')?.dataset.lang;
            if (field.classList.contains('title-sync') || field.classList.contains('excerpt-sync')) {
                syncSeoFromBasic(lang);
            }
            if (field.name?.startsWith('meta_title_') || field.name?.startsWith('meta_description_')) {
                field.dataset.userEdited = '1';
                updateSeoPreview();
            }
            if (lang) updateContentStats(lang);
        });
        updateCharCount(field);
    });

    const initTinyMce = () => {
        if (!window.tinymce) return;

        document.querySelectorAll('.content-editor').forEach((ta) => {
            const lang = ta.dataset.lang;
            const isRtl = ta.dataset.dir === 'rtl';

            window.tinymce.init({
                target: ta,
                base_url: 'https://cdn.jsdelivr.net/npm/tinymce@7',
                suffix: '.min',
                height: 480,
                min_height: 360,
                menubar: 'file edit view insert format table tools',
                plugins: 'lists link image table code directionality autoresize advlist',
                toolbar: 'undo redo | blocks | bold italic underline | alignleft aligncenter alignright alignjustify | table | bullist numlist | link image | code',
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
                    img { max-width: 100%; height: auto; border-radius: 0.75rem; margin: 1rem 0; }
                    a { color: #047857; text-decoration: underline; }
                    ul, ol { margin: 0 0 0.75rem; padding-${isRtl ? 'right' : 'left'}: 1.5rem; }
                `,
                table_default_styles: { width: '100%' },
                table_responsive_width: true,
                image_title: true,
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
                        .then((data) => {
                            if (data.url) resolve(data.url);
                            else reject('فشل رفع الصورة');
                        })
                        .catch(() => reject('فشل رفع الصورة'));
                }),
                setup: (editor) => {
                    editor.on('change keyup undo redo SetContent', () => {
                        editor.save();
                        updateContentStats(lang);
                    });
                },
                init_instance_callback: () => updateContentStats(lang),
            });
        });
    };

    document.getElementById('post-form')?.addEventListener('submit', () => {
        window.tinymce?.triggerSave();
    });

    if (window.tinymce) {
        initTinyMce();
    } else {
        document.querySelector('script[src*="tinymce.min.js"]')?.addEventListener('load', initTinyMce);
    }

    updateSeoPreview();
})();
</script>
@endsection
