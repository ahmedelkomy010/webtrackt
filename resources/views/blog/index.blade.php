@extends('layouts.blog')

@php
    $pageTitle = match ($locale) {
        'en' => 'Blog — Digital Marketing & ERP Insights',
        'ur' => 'بلاگ — ڈیجیٹل مارکیٹنگ اور ERP',
        default => 'المدونة — مقالات SEO وتسويق إلكتروني',
    };
    $pageDesc = match ($locale) {
        'en' => 'Expert articles on ERP systems, unified contracts, digital marketing, and web development in Saudi Arabia and GCC.',
        'ur' => 'ERP، ڈیجیٹل مارکیٹنگ اور ویب ڈvelopment پر ماہر مضامین۔',
        default => 'مقالات متخصصة في أنظمة ERP، العقد الموحد، التسويق الإلكتروني، وتطوير المواقع في السعودية والخليج — تراكت Trackkt.com',
    };
    $pageKeywords = match ($locale) {
        'en' => 'Trackkt blog, ERP Saudi Arabia, digital marketing, SEO articles, contracting system',
        'ur' => 'Trackkt بلاگ, ERP, ڈیجیٹل مارکیٹنگ, SEO',
        default => 'مدونة تراكت, مقالات SEO, تسويق إلكتروني, ERP السعودية, نظام مقاولات, العقد الموحد, Trackkt, تحسين محركات البحث',
    };
@endphp

@section('title', $pageTitle)
@section('meta_description', $pageDesc)
@section('meta_keywords', $pageKeywords)
@section('canonical', $siteUrl.'/blog'.($locale !== 'ar' ? '?lang='.$locale : ''))

@section('schema')
@php
    $blogSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'Blog',
        'name' => $pageTitle,
        'description' => $pageDesc,
        'url' => $siteUrl.'/blog',
        'publisher' => [
            '@type' => 'Organization',
            'name' => config('tract.name_en'),
            'logo' => ['@type' => 'ImageObject', 'url' => $siteUrl.'/images/logo.png'],
        ],
        'blogPost' => $posts->map(function ($p) use ($siteUrl, $locale) {
            return [
                '@type' => 'BlogPosting',
                'headline' => $p->localized('title', $locale),
                'url' => $siteUrl.'/blog/'.$p->slug,
                'datePublished' => $p->published_at?->toIso8601String(),
            ];
        })->values()->all(),
    ];
@endphp
<script type="application/ld+json">{!! json_encode($blogSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
@endsection

@section('content')
<section class="py-16 lg:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-14">
            <span class="inline-block px-4 py-1.5 rounded-full bg-tract-50 text-tract-700 text-sm font-semibold mb-4">
                {{ $locale === 'en' ? 'SEO Blog' : ($locale === 'ur' ? 'SEO بلاگ' : 'مدونة SEO') }}
            </span>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-slate-900 mb-4">{{ $pageTitle }}</h1>
            <p class="text-lg text-slate-600">{{ $pageDesc }}</p>
        </div>

        @if ($posts->isEmpty())
            <p class="text-center text-slate-500 py-16">{{ $locale === 'en' ? 'No articles yet.' : ($locale === 'ur' ? 'ابھی کوئی مضمون نہیں۔' : 'لا توجد مقالات بعد.') }}</p>
        @else
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($posts as $post)
                    <article class="group bg-white rounded-2xl border border-slate-100 overflow-hidden shadow-sm hover:shadow-xl hover:border-tract-200 transition-all">
                        @if ($post->featured_image)
                            <a href="{{ route('blog.show', ['slug' => $post->slug, 'lang' => $locale !== 'ar' ? $locale : null]) }}">
                                <img src="{{ asset('storage/'.$post->featured_image) }}" alt="{{ $post->localized('title', $locale) }}" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                            </a>
                        @else
                            <div class="h-48 bg-gradient-to-br from-tract-600 to-tract-900 flex items-center justify-center">
                                <img src="{{ asset('images/logo.png') }}" alt="" class="h-16 w-16 opacity-80">
                            </div>
                        @endif
                        <div class="p-6">
                            <time datetime="{{ $post->published_at?->toIso8601String() }}" class="text-xs text-slate-400">{{ $post->published_at?->format('Y-m-d') }}</time>
                            <h2 class="text-xl font-bold text-slate-900 mt-2 mb-3 group-hover:text-tract-700 transition-colors">
                                <a href="{{ route('blog.show', ['slug' => $post->slug, 'lang' => $locale !== 'ar' ? $locale : null]) }}">
                                    {{ $post->localized('title', $locale) }}
                                </a>
                            </h2>
                            <p class="text-slate-600 text-sm leading-relaxed mb-4 line-clamp-3">{{ $post->localized('excerpt', $locale) }}</p>
                            <a href="{{ route('blog.show', ['slug' => $post->slug, 'lang' => $locale !== 'ar' ? $locale : null]) }}" class="text-tract-600 text-sm font-semibold hover:text-tract-700">
                                {{ $locale === 'en' ? 'Read more →' : ($locale === 'ur' ? 'مزید پڑھیں ←' : 'اقرأ المزيد ←') }}
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-12">{{ $posts->withQueryString()->links() }}</div>
        @endif
    </div>
</section>
@endsection
