@extends('layouts.site')

@php
    use App\Support\Locale;
    use App\Support\PageCopy;
    use App\Support\SiteUrl;

    $cty = $country ?? SiteUrl::DEFAULT_COUNTRY;
    $canonical = $siteUrl.Locale::path('about', $locale, $cty);
    $countryName = config('tract.location');
    $aboutImage = $aboutSettings['about_image'] ?? null;
    $title = PageCopy::localized($page, 'title', $locale);
    $badge = PageCopy::localized($page, 'badge', $locale);
    $subtitle = PageCopy::localized($page, 'subtitle', $locale);
    $body = PageCopy::localized($page, 'body', $locale);
@endphp

@section('title', $title)
@section('meta_description', strip_tags($body))
@section('canonical', $canonical)

@section('content')
<section class="py-10 sm:py-14 lg:py-20 bg-gradient-to-br from-tract-700 to-tract-900 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="text-sm text-tract-200 mb-8">
            <a href="{{ Locale::home($locale, $cty) }}" class="hover:text-white">{{ $locale === 'en' ? 'Home' : ($locale === 'ur' ? 'ہوم' : 'الرئيسية') }}</a>
            <span class="mx-2">/</span>
            <span class="text-white">{{ $title }}</span>
        </nav>
        <span class="inline-block px-4 py-1.5 rounded-full bg-white/10 text-tract-200 text-sm font-semibold mb-4">{{ $badge }}</span>
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold max-w-3xl">
            <span class="text-tract-300">{{ config('tract.name') }}</span>@if($subtitle) — {{ $subtitle }} {{ $countryName }}@endif
        </h1>
    </div>
</section>

<section class="py-12 lg:py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-start">
            <div class="max-w-none">
                @include('partials.rich-content', ['content' => $body, 'locale' => $locale])
                <p class="text-slate-500 leading-relaxed mt-8" dir="ltr">
                    <span class="text-tract-600 font-semibold">{{ config('tract.tagline') }}</span>
                </p>
            </div>
            <div class="rounded-2xl overflow-hidden border border-slate-100 shadow-lg min-h-[320px] bg-slate-50 sticky top-24">
                @if ($aboutImage)
                    <img src="{{ asset('storage/'.$aboutImage) }}" alt="{{ $title }}" class="w-full h-full min-h-[320px] object-cover">
                @else
                    <div class="flex items-center justify-center min-h-[320px] text-slate-400 text-sm">{{ $locale === 'en' ? 'About image' : ($locale === 'ur' ? 'تصویر' : 'صورة من نحن') }}</div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
