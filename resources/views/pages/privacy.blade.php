@extends('layouts.site')

@php
    use App\Support\Locale;
    use App\Support\PageCopy;
    use App\Support\SiteUrl;

    $cty = $country ?? SiteUrl::DEFAULT_COUNTRY;
    $canonical = $siteUrl.Locale::path('privacy', $locale, $cty);
    $title = PageCopy::localized($page, 'title', $locale);
    $badge = PageCopy::localized($page, 'badge', $locale);
    $subtitle = PageCopy::localized($page, 'subtitle', $locale);
    $body = PageCopy::localized($page, 'body', $locale);
@endphp

@section('title', $title)
@section('meta_description', strip_tags($body))
@section('canonical', $canonical)

@section('content')
<section class="py-10 sm:py-14 lg:py-16 bg-gradient-to-br from-tract-600 to-tract-900 text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="text-sm text-tract-200 mb-8">
            <a href="{{ Locale::home($locale, $cty) }}" class="hover:text-white">{{ $locale === 'en' ? 'Home' : ($locale === 'ur' ? 'ہوم' : 'الرئيسية') }}</a>
            <span class="mx-2">/</span>
            <span class="text-white">{{ $title }}</span>
        </nav>
        <span class="inline-block px-4 py-1.5 rounded-full bg-white/10 text-tract-100 text-sm font-bold mb-4">{{ $badge }}</span>
        <h1 class="text-3xl sm:text-4xl font-bold mb-3">{{ $subtitle }}</h1>
    </div>
</section>

<section class="py-12 lg:py-16 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        @include('partials.rich-content', ['content' => $body, 'locale' => $locale])
    </div>
</section>
@endsection
