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
@include('partials.page-hero', [
    'locale' => $locale,
    'cty' => $cty,
    'pageTitle' => $title,
    'badge' => $badge,
    'headline' => $subtitle,
    'lead' => config('tract.name').' — '.config('tract.name_en'),
])

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
