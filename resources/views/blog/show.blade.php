@extends('layouts.blog')

@php
    $title = $post->seoTitle($locale);
    $description = $post->seoDescription($locale);
    $keywords = $post->seoKeywords($locale);
    $canonical = $siteUrl.'/blog/'.$post->slug.($locale !== 'ar' ? '?lang='.$locale : '');
    $image = $post->featured_image ? $siteUrl.'/storage/'.$post->featured_image : app(\App\Services\SeoService::class)->ogImageUrl();
@endphp

@section('title', $title)
@section('meta_description', $description)
@section('meta_keywords', $keywords)
@section('canonical', $canonical)
@section('og_type', 'article')
@section('og_image', $image)

@section('schema')
@php
    $articleSchema = [
        '@context' => 'https://schema.org',
        '@graph' => [
            [
                '@type' => 'BreadcrumbList',
                'itemListElement' => [
                    ['@type' => 'ListItem', 'position' => 1, 'name' => config('tract.name'), 'item' => $siteUrl.'/'],
                    ['@type' => 'ListItem', 'position' => 2, 'name' => $locale === 'en' ? 'Blog' : ($locale === 'ur' ? 'بلاگ' : 'المدونة'), 'item' => $siteUrl.'/blog'],
                    ['@type' => 'ListItem', 'position' => 3, 'name' => $title, 'item' => $canonical],
                ],
            ],
            [
                '@type' => 'BlogPosting',
                'headline' => $title,
                'description' => $description,
                'keywords' => $keywords,
                'image' => $image,
                'url' => $canonical,
                'datePublished' => $post->published_at?->toIso8601String(),
                'dateModified' => $post->updated_at->toIso8601String(),
                'author' => ['@type' => 'Organization', 'name' => config('tract.name_en'), 'url' => $siteUrl],
                'publisher' => [
                    '@type' => 'Organization',
                    'name' => config('tract.name_en'),
                    'logo' => ['@type' => 'ImageObject', 'url' => app(\App\Services\SeoService::class)->logoUrl(), 'width' => 512, 'height' => 512],
                ],
                'mainEntityOfPage' => ['@type' => 'WebPage', '@id' => $canonical],
                'inLanguage' => $locale === 'ar' ? 'ar-SA' : ($locale === 'ur' ? 'ur' : 'en'),
            ],
        ],
    ];
@endphp
<script type="application/ld+json">{!! json_encode($articleSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
@endsection

@section('content')
<article class="py-12 lg:py-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="text-sm text-slate-500 mb-8" aria-label="Breadcrumb">
            <a href="/" class="hover:text-tract-600">{{ $locale === 'en' ? 'Home' : ($locale === 'ur' ? 'ہوم' : 'الرئيسية') }}</a>
            <span class="mx-2">/</span>
            <a href="{{ route('blog.index', ['lang' => $locale !== 'ar' ? $locale : null]) }}" class="hover:text-tract-600">{{ $locale === 'en' ? 'Blog' : ($locale === 'ur' ? 'بلاگ' : 'المدونة') }}</a>
            <span class="mx-2">/</span>
            <span class="text-slate-700">{{ $title }}</span>
        </nav>

        <header class="mb-10">
            <time datetime="{{ $post->published_at?->toIso8601String() }}" class="text-sm text-tract-600 font-medium">{{ $post->published_at?->format('d M Y') }}</time>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-slate-900 mt-3 mb-4 leading-tight">{{ $title }}</h1>
            <p class="text-lg text-slate-600 leading-relaxed">{{ $post->localized('excerpt', $locale) }}</p>
        </header>

        @if ($post->featured_image)
            <img src="{{ asset('storage/'.$post->featured_image) }}" alt="{{ $title }}" class="w-full rounded-2xl mb-10 shadow-lg">
        @endif

        <div class="prose prose-lg max-w-none prose-headings:text-slate-900 prose-a:text-tract-600 prose-strong:text-slate-900">
            {!! $post->localized('content', $locale) !!}
        </div>

        @if ($keywords)
            <div class="mt-10 pt-8 border-t border-slate-200">
                <p class="text-sm font-semibold text-slate-700 mb-2">{{ $locale === 'en' ? 'Keywords:' : ($locale === 'ur' ? 'کلیدی الفاظ:' : 'الكلمات المفتاحية:') }}</p>
                <div class="flex flex-wrap gap-2">
                    @foreach (array_filter(array_map('trim', explode(',', $keywords))) as $tag)
                        <span class="px-3 py-1 rounded-full bg-tract-50 text-tract-700 text-xs font-medium">{{ $tag }}</span>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="mt-10 p-6 rounded-2xl bg-gradient-to-r from-tract-600 to-tract-800 text-white">
            <h3 class="text-xl font-bold mb-2">{{ $locale === 'en' ? 'Ready to start your project?' : ($locale === 'ur' ? 'اپنا پروجیکٹ شروع کریں؟' : 'جاهز لبدء مشروعك؟') }}</h3>
            <p class="text-tract-100 mb-4 text-sm">{{ $locale === 'en' ? 'Contact Trackkt for ERP, web development, and digital marketing.' : ($locale === 'ur' ? 'ERP، ویب ڈvelopment اور ڈیجیٹل مارکیٹنگ کے لیے Trackkt سے رابطہ کریں۔' : 'تواصل مع تراكت لحلول ERP والمواقع والتسويق الإلكتروني.') }}</p>
            <a href="/#contact" class="inline-flex px-5 py-2.5 rounded-xl bg-white text-tract-700 font-semibold text-sm hover:bg-tract-50 transition-colors">{{ $locale === 'en' ? 'Contact us' : ($locale === 'ur' ? 'رابطہ کریں' : 'تواصل معنا') }}</a>
        </div>
    </div>
</article>

@if ($related->isNotEmpty())
<section class="py-12 bg-white border-t border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold text-slate-900 mb-8">{{ $locale === 'en' ? 'Related articles' : ($locale === 'ur' ? 'متعلقہ مضامین' : 'مقالات ذات صلة') }}</h2>
        <div class="grid sm:grid-cols-3 gap-6">
            @foreach ($related as $item)
                <a href="{{ route('blog.show', ['slug' => $item->slug, 'lang' => $locale !== 'ar' ? $locale : null]) }}" class="p-5 rounded-2xl border border-slate-100 hover:border-tract-200 hover:shadow-lg transition-all">
                    <h3 class="font-bold text-slate-900 hover:text-tract-700">{{ $item->localized('title', $locale) }}</h3>
                    <p class="text-sm text-slate-500 mt-2 line-clamp-2">{{ $item->localized('excerpt', $locale) }}</p>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
