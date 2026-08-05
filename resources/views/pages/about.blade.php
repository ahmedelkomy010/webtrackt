@extends('layouts.site')

@php
    use App\Support\Locale;
    use App\Support\SiteUrl;

    $cty = $country ?? SiteUrl::DEFAULT_COUNTRY;
    $canonical = $siteUrl.Locale::path('about', $locale, $cty);
    $countryNames = [
        'sa' => ['ar' => 'المملكة العربية السعودية', 'en' => 'Saudi Arabia', 'ur' => 'سعودی عرب'],
        'ae' => ['ar' => 'الإمارات', 'en' => 'UAE', 'ur' => 'متحدہ عرب امارات'],
    ];
    $countryName = $countryNames[$cty][$locale] ?? config('tract.location');
    $aboutImage = $aboutSettings['about_image'] ?? null;
@endphp

@section('title', $copy['title'])
@section('meta_description', $copy['description'])
@section('canonical', $canonical)

@section('content')
<section class="py-10 sm:py-14 lg:py-20 bg-gradient-to-br from-slate-900 to-tract-900 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="text-sm text-tract-200 mb-8">
            <a href="{{ Locale::home($locale, $cty) }}" class="hover:text-white">{{ $locale === 'en' ? 'Home' : ($locale === 'ur' ? 'ہوم' : 'الرئيسية') }}</a>
            <span class="mx-2">/</span>
            <span class="text-white">{{ $copy['title'] }}</span>
        </nav>
        <span class="inline-block px-4 py-1.5 rounded-full bg-white/10 text-tract-200 text-sm font-semibold mb-4">{{ $copy['badge'] }}</span>
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold max-w-3xl">
            <span class="text-tract-300">{{ config('tract.name') }}</span> — {{ $copy['heading'] }} {{ $countryName }}
        </h1>
    </div>
</section>

<section class="py-12 lg:py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center">
            <div>
                <p class="text-lg text-slate-600 leading-relaxed mb-6">{{ $copy['description'] }}</p>
                <p class="text-slate-500 leading-relaxed mb-8" dir="ltr">
                    <span class="text-tract-600 font-semibold">{{ config('tract.tagline') }}</span>
                </p>
                <div class="grid sm:grid-cols-3 gap-4">
                    <div class="p-5 rounded-2xl bg-slate-50 border border-slate-100">
                        <p class="text-tract-600 text-sm mb-1">{{ $copy['location'] }}</p>
                        <p class="font-semibold text-sm text-slate-900">{{ $countryName }}</p>
                    </div>
                    <div class="p-5 rounded-2xl bg-slate-50 border border-slate-100">
                        <p class="text-tract-600 text-sm mb-1">{{ $copy['currency'] }}</p>
                        <p class="font-semibold text-sm text-slate-900">SAR (ر.س)</p>
                    </div>
                    <div class="p-5 rounded-2xl bg-slate-50 border border-slate-100">
                        <p class="text-tract-600 text-sm mb-1">{{ $copy['legalStatus'] }}</p>
                        <p class="font-semibold text-sm text-slate-900">{{ $copy['legalValue'] }}</p>
                    </div>
                </div>
            </div>
            <div class="rounded-2xl overflow-hidden border border-slate-100 shadow-lg min-h-[320px] bg-slate-50">
                @if ($aboutImage)
                    <img src="{{ asset('storage/'.$aboutImage) }}" alt="{{ $copy['title'] }}" class="w-full h-full min-h-[320px] object-cover">
                @else
                    <div class="flex items-center justify-center min-h-[320px] text-slate-400 text-sm">{{ $locale === 'en' ? 'About image' : ($locale === 'ur' ? 'تصویر' : 'صورة من نحن') }}</div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
