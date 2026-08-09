@extends('layouts.site')

@php
    use App\Support\Locale;
    use App\Support\SiteUrl;

    $cty = $country ?? SiteUrl::DEFAULT_COUNTRY;

    $pageTitle = $locale === 'en' ? 'Our Work' : ($locale === 'ur' ? 'ہمارے کام' : 'أعمالنا');
    $pageDesc = $locale === 'en'
        ? 'Explore our portfolio of completed projects — websites, stores, ERP systems, and digital marketing.'
        : ($locale === 'ur'
            ? 'مکمل شدہ منصوبوں کا پورٹ فولیو — ویب سائٹس، اسٹورز، ERP اور ڈیجیٹل مارکیٹنگ۔'
            : 'استكشف مجموعة مشاريعنا المنفذة — مواقع، متاجر، أنظمة ERP، وتسويق رقمي.');
@endphp

@section('title', $pageTitle)
@section('meta_description', $pageDesc)
@section('canonical', $siteUrl.Locale::path('works', $locale, $cty))

@section('content')
<section class="py-10 sm:py-14 lg:py-20 bg-gradient-to-br from-tract-700 to-tract-900 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="text-sm text-tract-200 mb-8">
            <a href="{{ Locale::home($locale, $cty) }}" class="hover:text-white">{{ $locale === 'en' ? 'Home' : ($locale === 'ur' ? 'ہوم' : 'الرئيسية') }}</a>
            <span class="mx-2">/</span>
            <span class="text-white">{{ $pageTitle }}</span>
        </nav>
        <span class="inline-block px-4 py-1.5 rounded-full bg-white/10 text-tract-200 text-sm font-semibold mb-4">{{ $pageTitle }}</span>
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold max-w-3xl">{{ $pageDesc }}</h1>
    </div>
</section>

<section class="py-12 lg:py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if ($works->isEmpty())
            <p class="text-center text-slate-500 py-16">{{ $locale === 'en' ? 'No projects yet.' : ($locale === 'ur' ? 'ابھی کوئی منصوبہ نہیں۔' : 'لا توجد أعمال بعد.') }}</p>
        @else
            <div class="works-grid">
                @foreach ($works as $work)
                    <a href="{{ $work->url }}" target="_blank" rel="noopener noreferrer" class="works-card group">
                        <div class="works-card__media">
                            <img src="{{ asset('storage/'.$work->image) }}" alt="{{ $work->localized('title', $locale) }}" loading="lazy" class="works-card__image">
                        </div>
                        <div class="works-card__body">
                            <h2 class="works-card__title">{{ $work->localized('title', $locale) }}</h2>
                            <p class="works-card__desc">{{ $work->localized('description', $locale) }}</p>
                            <span class="works-card__link">{{ $locale === 'en' ? 'View project →' : ($locale === 'ur' ? 'منصوبہ دیکھیں ←' : 'عرض المشروع ←') }}</span>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection
