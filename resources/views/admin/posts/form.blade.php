@php $isEdit = $post->exists; $minWords = $minWords ?? 800; @endphp

@extends('layouts.admin')

@section('title', $isEdit ? 'تعديل مقال' : 'مقال جديد')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.posts.index') }}" class="text-sm text-tract-600">← العودة للمقالات</a>
    <h1 class="text-2xl font-bold mt-2">{{ $isEdit ? 'تعديل مقال SEO' : 'إضافة مقال SEO جديد' }}</h1>
    <p class="text-slate-600 text-sm mt-1">أدوات مساعدة: عداد كلمات، معاينة Google، شريط تنسيق، رفع صور</p>
</div>

<form method="POST" action="{{ $isEdit ? route('admin.posts.update', $post) : route('admin.posts.store') }}" enctype="multipart/form-data" class="space-y-6" id="post-form">
    @csrf @if ($isEdit) @method('PUT') @endif

    <div class="bg-white rounded-2xl border p-6 grid sm:grid-cols-2 gap-4">
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
            <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $post->is_published)) class="rounded text-tract-600">
            <span class="text-sm font-medium">نشر المقال — يظهر في المدونة و sitemap</span>
        </label>
    </div>

    @foreach (['ar' => 'العربية', 'en' => 'English', 'ur' => 'اردو'] as $lang => $langLabel)
        <div class="bg-white rounded-2xl border p-6 space-y-4 post-lang-block" data-lang="{{ $lang }}">
            <h3 class="font-bold text-slate-900 border-b pb-2 flex items-center gap-2">
                {{ $langLabel }}
                @if ($lang === 'ar')<span class="text-xs font-normal text-tract-600 bg-tract-50 px-2 py-0.5 rounded-full">SEO رئيسي</span>@endif
            </h3>

            {{-- Google preview --}}
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                <p class="text-xs text-slate-500 mb-2">معاينة Google</p>
                <p class="text-blue-700 text-lg font-medium truncate seo-preview-title" data-for="meta_title_{{ $lang }}">{{ old('meta_title_'.$lang, $post->meta_title[$lang] ?? $post->title[$lang] ?? 'عنوان المقال') }}</p>
                <p class="text-green-700 text-sm truncate">{{ config('tract.website') }}/blog/{{ old('slug', $post->slug ?: 'slug') }}</p>
                <p class="text-slate-600 text-sm line-clamp-2 seo-preview-desc" data-for="meta_description_{{ $lang }}">{{ old('meta_description_'.$lang, $post->meta_description[$lang] ?? $post->excerpt[$lang] ?? '') }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">عنوان المقال (H1) *</label>
                <input type="text" name="title_{{ $lang }}" value="{{ old('title_'.$lang, $post->title[$lang] ?? '') }}" required maxlength="255" class="w-full px-4 py-2.5 rounded-xl border post-field" data-sync-meta="meta_title_{{ $lang }}">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1 flex justify-between">
                    <span>Meta Title</span>
                    <span class="text-xs char-count" data-max="70" data-for="meta_title_{{ $lang }}">0/70</span>
                </label>
                <input type="text" name="meta_title_{{ $lang }}" value="{{ old('meta_title_'.$lang, $post->meta_title[$lang] ?? '') }}" maxlength="70" class="w-full px-4 py-2.5 rounded-xl border post-field char-track" data-for="meta_title_{{ $lang }}">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1 flex justify-between">
                    <span>Meta Description</span>
                    <span class="text-xs char-count" data-max="160" data-for="meta_description_{{ $lang }}">0/160</span>
                </label>
                <textarea name="meta_description_{{ $lang }}" rows="2" maxlength="160" class="w-full px-4 py-2.5 rounded-xl border char-track post-field" data-for="meta_description_{{ $lang }}">{{ old('meta_description_'.$lang, $post->meta_description[$lang] ?? '') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">كلمات مفتاحية</label>
                <input type="text" name="meta_keywords_{{ $lang }}" value="{{ old('meta_keywords_'.$lang, $post->meta_keywords[$lang] ?? '') }}" class="w-full px-4 py-2.5 rounded-xl border" placeholder="ERP, تسويق, trakkt">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1 flex justify-between">
                    <span>مقتطف *</span>
                    <span class="text-xs char-count" data-max="500" data-for="excerpt_{{ $lang }}">0/500</span>
                </label>
                <textarea name="excerpt_{{ $lang }}" rows="2" required maxlength="500" class="w-full px-4 py-2.5 rounded-xl border char-track post-field" data-for="excerpt_{{ $lang }}">{{ old('excerpt_'.$lang, $post->excerpt[$lang] ?? '') }}</textarea>
            </div>

            <div>
                <div class="flex flex-wrap items-center justify-between gap-2 mb-2">
                    <label class="block text-sm font-medium">محتوى المقال *</label>
                    <div class="flex flex-wrap gap-1">
                        <button type="button" class="editor-btn px-2 py-1 text-xs rounded-lg bg-slate-100 hover:bg-tract-50" data-action="h2" data-lang="{{ $lang }}">H2</button>
                        <button type="button" class="editor-btn px-2 py-1 text-xs rounded-lg bg-slate-100 hover:bg-tract-50" data-action="h3" data-lang="{{ $lang }}">H3</button>
                        <button type="button" class="editor-btn px-2 py-1 text-xs rounded-lg bg-slate-100 hover:bg-tract-50" data-action="p" data-lang="{{ $lang }}">فقرة</button>
                        <button type="button" class="editor-btn px-2 py-1 text-xs rounded-lg bg-slate-100 hover:bg-tract-50" data-action="ul" data-lang="{{ $lang }}">قائمة</button>
                        <button type="button" class="editor-btn px-2 py-1 text-xs rounded-lg bg-slate-100 hover:bg-tract-50" data-action="strong" data-lang="{{ $lang }}">عريض</button>
                        <button type="button" class="editor-btn px-2 py-1 text-xs rounded-lg bg-slate-100 hover:bg-tract-50" data-action="link" data-lang="{{ $lang }}">رابط</button>
                        <label class="editor-btn px-2 py-1 text-xs rounded-lg bg-tract-50 text-tract-700 cursor-pointer hover:bg-tract-100">
                            صورة
                            <input type="file" accept="image/*" class="hidden editor-image-input" data-lang="{{ $lang }}">
                        </label>
                    </div>
                </div>
                <textarea name="content_{{ $lang }}" rows="14" required class="w-full px-4 py-2.5 rounded-xl border font-mono text-sm content-editor" data-lang="{{ $lang }}" placeholder="<h2>عنوان فرعي</h2><p>محتوى...</p>">{{ old('content_'.$lang, $post->content[$lang] ?? '') }}</textarea>
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

    <button type="submit" class="px-6 py-3 rounded-xl bg-tract-600 text-white font-semibold hover:bg-tract-700">
        {{ $isEdit ? 'حفظ التعديلات' : 'نشر المقال' }}
    </button>
</form>

<script>
(function () {
    const minWords = {{ (int) $minWords }};
    const uploadUrl = @json(route('admin.posts.upload-image'));
    const csrf = @json(csrf_token());

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

    const updatePreview = (name, value) => {
        document.querySelectorAll(`.seo-preview-title[data-for="${name}"], .seo-preview-desc[data-for="${name}"]`).forEach((el) => {
            if (el.classList.contains('seo-preview-title') || el.classList.contains('seo-preview-desc')) {
                if (el.dataset.for === name) el.textContent = value || el.textContent;
            }
        });
        const preview = document.querySelector(`.seo-preview-${name.includes('title') ? 'title' : 'desc'}[data-for="${name}"]`);
        if (preview) preview.textContent = value || '—';
    };

    const wrapSelection = (textarea, before, after = '') => {
        const start = textarea.selectionStart;
        const end = textarea.selectionEnd;
        const selected = textarea.value.substring(start, end) || 'نص';
        const replacement = before + selected + after;
        textarea.setAttribute('value', textarea.value);
        textarea.value = textarea.value.substring(0, start) + replacement + textarea.value.substring(end);
        textarea.focus();
        textarea.selectionStart = start + before.length;
        textarea.selectionEnd = start + before.length + selected.length;
        textarea.dispatchEvent(new Event('input'));
    };

    const updateContentStats = (lang) => {
        const ta = document.querySelector(`.content-editor[data-lang="${lang}"]`);
        if (!ta) return;
        const words = countWords(ta.value);
        const block = ta.closest('.post-lang-block');
        block.querySelector('.word-count').textContent = words;
        block.querySelector('.reading-time').textContent = `وقت القراءة: ~${Math.max(1, Math.ceil(words / 200))} د`;

        const checks = [];
        const h2 = (ta.value.match(/<h2/gi) || []).length;
        const metaTitle = block.querySelector(`[name="meta_title_${lang}"]`)?.value || block.querySelector(`[name="title_${lang}"]`)?.value;
        const metaDesc = block.querySelector(`[name="meta_description_${lang}"]`)?.value;
        const hasImage = /<img/i.test(ta.value) || document.querySelector('[name="featured_image_file"]')?.files?.length;

        if (words >= minWords) checks.push(['✅', `عدد الكلمات مناسب (${words})`]); else checks.push(['⚠️', `أضف ${minWords - words} كلمة (${words}/${minWords})`]);
        if (h2 >= 1) checks.push(['✅', 'يحتوي عنوان H2']); else checks.push(['⚠️', 'أضف عنوان H2 على الأقل']);
        if (metaTitle && metaTitle.length <= 70) checks.push(['✅', 'Meta Title مناسب']); else checks.push(['⚠️', 'Meta Title طويل أو فارغ']);
        if (metaDesc && metaDesc.length >= 120 && metaDesc.length <= 160) checks.push(['✅', 'Meta Description ممتاز']); else if (metaDesc) checks.push(['⚠️', 'Meta Description يفضل 120-160 حرف']);
        if (hasImage) checks.push(['✅', 'يحتوي صورة']); else checks.push(['⚠️', 'أضف صورة بارزة أو داخل المحتوى']);

        const score = Math.round((checks.filter(c => c[0] === '✅').length / checks.length) * 100);
        block.querySelector('.seo-score').textContent = `SEO: ${score}%`;
        block.querySelector('.seo-checklist').innerHTML = checks.map(([icon, text]) => `<li>${icon} ${text}</li>`).join('');
    };

    document.querySelectorAll('.char-track, .post-field').forEach((field) => {
        field.addEventListener('input', () => {
            updateCharCount(field);
            updatePreview(field.name, field.value);
            if (field.dataset.syncMeta) {
                const meta = document.querySelector(`[name="${field.dataset.syncMeta}"]`);
                if (meta && !meta.dataset.userEdited) meta.value = field.value.slice(0, 70);
            }
            const lang = field.closest('.post-lang-block')?.dataset.lang;
            if (lang) updateContentStats(lang);
        });
        updateCharCount(field);
    });

    document.querySelectorAll('[name^="meta_title_"]').forEach((el) => {
        el.addEventListener('input', () => { el.dataset.userEdited = '1'; });
    });

    document.querySelectorAll('.content-editor').forEach((ta) => {
        ta.addEventListener('input', () => updateContentStats(ta.dataset.lang));
        updateContentStats(ta.dataset.lang);
    });

    document.querySelectorAll('.editor-btn[data-action]').forEach((btn) => {
        btn.addEventListener('click', () => {
            const lang = btn.dataset.lang;
            const ta = document.querySelector(`.content-editor[data-lang="${lang}"]`);
            const map = {
                h2: ['<h2>', '</h2>'], h3: ['<h3>', '</h3>'], p: ['<p>', '</p>'],
                ul: ['<ul>\n<li>', '</li>\n</ul>'], strong: ['<strong>', '</strong>'],
            };
            if (btn.dataset.action === 'link') {
                const url = prompt('الرابط (URL):', 'https://');
                if (url) wrapSelection(ta, `<a href="${url}">`, '</a>');
                return;
            }
            const [b, a] = map[btn.dataset.action] || ['', ''];
            wrapSelection(ta, b, a);
        });
    });

    document.querySelectorAll('.editor-image-input').forEach((input) => {
        input.addEventListener('change', async () => {
            const file = input.files[0];
            if (!file) return;
            const lang = input.dataset.lang;
            const ta = document.querySelector(`.content-editor[data-lang="${lang}"]`);
            const fd = new FormData();
            fd.append('image', file);
            fd.append('_token', csrf);
            try {
                const res = await fetch(uploadUrl, { method: 'POST', body: fd, headers: { 'X-Requested-With': 'XMLHttpRequest' } });
                const data = await res.json();
                if (data.url) wrapSelection(ta, `<img src="${data.url}" alt="${file.name}" class="rounded-xl my-4 max-w-full" />`, '');
            } catch (e) {
                alert('فشل رفع الصورة');
            }
            input.value = '';
        });
    });
})();
</script>
@endsection
