@extends('layouts.admin')

@section('title', 'إعدادات SEO')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-900">إعدادات SEO</h1>
    <p class="text-slate-600 text-sm mt-1">تحكم في اللوجو، Open Graph، Google Analytics، وإعدادات محركات البحث</p>
</div>

<form method="POST" action="{{ route('admin.seo.update') }}" enctype="multipart/form-data" class="space-y-6">
    @csrf @method('PUT')

    <div class="bg-white rounded-2xl border p-6 space-y-4">
        <h2 class="font-bold text-lg">اللوجو وصورة المشاركة (Google / Facebook)</h2>
        <p class="text-sm text-slate-500">اللوجو يظهر في نتائج Google عبر Schema.org — يُفضّل صورة مربعة 512×512</p>
        <div class="grid sm:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium mb-2">لوجو الموقع (Organization Logo)</label>
                <input type="file" name="logo_file" accept="image/*" class="w-full text-sm">
                @if ($settings['logo_path'] ?? null)
                    <img src="{{ asset('storage/'.$settings['logo_path']) }}" alt="Logo" class="mt-3 h-20 w-20 rounded-xl object-contain border bg-white p-1">
                @else
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="mt-3 h-20 w-20 rounded-xl object-contain border bg-white p-1">
                @endif
            </div>
            <div>
                <label class="block text-sm font-medium mb-2">صورة Open Graph (مشاركة روابط)</label>
                <input type="file" name="og_image_file" accept="image/*" class="w-full text-sm">
                @if ($settings['og_image_path'] ?? null)
                    <img src="{{ asset('storage/'.$settings['og_image_path']) }}" alt="OG" class="mt-3 h-20 rounded-xl object-cover border">
                @else
                    <img src="{{ asset('images/logo.png') }}" alt="OG" class="mt-3 h-20 rounded-xl object-cover border">
                @endif
            </div>
        </div>
    </div>

    @foreach (['ar' => 'العربية', 'en' => 'English', 'ur' => 'اردو'] as $lang => $label)
        <div class="bg-white rounded-2xl border p-6 space-y-4">
            <h3 class="font-bold">{{ $label }} — Meta Tags</h3>
            <div>
                <label class="block text-sm font-medium mb-1">Meta Title (70 حرف)</label>
                <input type="text" name="meta_title_{{ $lang }}" value="{{ old('meta_title_'.$lang, $settings['meta_title'][$lang] ?? '') }}" maxlength="70" class="w-full px-4 py-2.5 rounded-xl border">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Meta Description (160 حرف)</label>
                <textarea name="meta_description_{{ $lang }}" rows="2" maxlength="160" class="w-full px-4 py-2.5 rounded-xl border">{{ old('meta_description_'.$lang, $settings['meta_description'][$lang] ?? '') }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Keywords</label>
                <input type="text" name="meta_keywords_{{ $lang }}" value="{{ old('meta_keywords_'.$lang, $settings['meta_keywords'][$lang] ?? '') }}" class="w-full px-4 py-2.5 rounded-xl border">
            </div>
        </div>
    @endforeach

    <div class="bg-white rounded-2xl border p-6 grid sm:grid-cols-2 gap-4">
        <h2 class="font-bold text-lg sm:col-span-2">أدوات SEO إضافية</h2>
        <div>
            <label class="block text-sm font-medium mb-1">Google Analytics ID</label>
            <input type="text" name="google_analytics_id" value="{{ old('google_analytics_id', $settings['google_analytics_id'] ?? '') }}" placeholder="G-XXXXXXXXXX" class="w-full px-4 py-2.5 rounded-xl border font-mono text-sm" dir="ltr">
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Google Tag Manager ID</label>
            <input type="text" name="google_tag_manager_id" value="{{ old('google_tag_manager_id', $settings['google_tag_manager_id'] ?? '') }}" placeholder="GTM-XXXXXXX" class="w-full px-4 py-2.5 rounded-xl border font-mono text-sm" dir="ltr">
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Facebook URL</label>
            <input type="url" name="facebook_url" value="{{ old('facebook_url', $settings['facebook_url'] ?? '') }}" class="w-full px-4 py-2.5 rounded-xl border" dir="ltr">
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Twitter / X URL</label>
            <input type="url" name="twitter_url" value="{{ old('twitter_url', $settings['twitter_url'] ?? '') }}" class="w-full px-4 py-2.5 rounded-xl border" dir="ltr">
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">LinkedIn URL</label>
            <input type="url" name="linkedin_url" value="{{ old('linkedin_url', $settings['linkedin_url'] ?? '') }}" class="w-full px-4 py-2.5 rounded-xl border" dir="ltr">
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Robots Meta</label>
            <input type="text" name="robots" value="{{ old('robots', $settings['robots'] ?? '') }}" class="w-full px-4 py-2.5 rounded-xl border text-sm" dir="ltr">
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">الحد الأدنى لكلمات المقال (SEO)</label>
            <input type="number" name="min_article_words" value="{{ old('min_article_words', $settings['min_article_words'] ?? 800) }}" min="300" max="5000" class="w-full px-4 py-2.5 rounded-xl border">
        </div>
        <label class="flex items-center gap-2">
            <input type="checkbox" name="enable_json_ld" value="1" @checked(old('enable_json_ld', $settings['enable_json_ld'] ?? true)) class="rounded text-tract-600">
            <span class="text-sm">تفعيل JSON-LD (Schema.org)</span>
        </label>
        <label class="flex items-center gap-2">
            <input type="checkbox" name="enable_sitemap" value="1" @checked(old('enable_sitemap', $settings['enable_sitemap'] ?? true)) class="rounded text-tract-600">
            <span class="text-sm">تفعيل sitemap.xml</span>
        </label>
    </div>

    <button type="submit" class="px-6 py-3 rounded-xl bg-tract-600 text-white font-semibold hover:bg-tract-700">حفظ إعدادات SEO</button>
</form>
@endsection
