@extends('layouts.site')

@php
    use App\Support\Locale;
    use App\Support\SiteUrl;

    $cty = $country ?? SiteUrl::DEFAULT_COUNTRY;

    $pageTitle = $locale === 'en' ? 'Our Services' : ($locale === 'ur' ? 'ہماری خدمات' : 'خدماتنا');
    $pageDesc = $locale === 'en' ? 'Integrated digital solutions — ERP, websites, e-commerce, and digital marketing by Trackkt.' : ($locale === 'ur' ? 'مکمل ڈیجیٹل حل — ERP، ویب سائٹس، ای کامرس اور ڈیجیٹل مارکیٹنگ۔' : 'حلول رقمية متكاملة — ERP، مواقع، متاجر إلكترونية، وتسويق رقمي من Trackkt.');
@endphp

@section('title', $pageTitle)
@section('meta_description', $pageDesc)
@section('canonical', $siteUrl.Locale::path('services', $locale, $cty))

@section('content')
<section class="py-16 lg:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-14">
            <span class="inline-block px-4 py-1.5 rounded-full bg-tract-50 text-tract-700 text-sm font-semibold mb-4">{{ $locale === 'en' ? 'Services' : ($locale === 'ur' ? 'خدمات' : 'خدماتنا') }}</span>
            <h1 class="text-3xl sm:text-4xl font-bold text-slate-900 mb-4">{{ $pageTitle }}</h1>
            <p class="text-lg text-slate-600">{{ $pageDesc }}</p>
        </div>
        <div class="grid gap-8">
            @foreach ($services as $service)
                <a href="{{ Locale::path('services/'.$service->slug, $locale, $cty) }}" class="group flex flex-col sm:flex-row gap-6 p-6 sm:p-8 rounded-2xl bg-white border border-slate-100 hover:border-tract-200 hover:shadow-xl transition-all overflow-hidden">
                    @if ($service->image)
                        <div class="shrink-0 w-full sm:w-56 lg:w-64">
                            <img src="{{ asset('storage/'.$service->image) }}" alt="{{ $service->localized('title', $locale) }}" class="w-full h-48 sm:h-full sm:min-h-[12rem] object-cover rounded-xl group-hover:scale-[1.02] transition-transform">
                        </div>
                    @else
                        <div class="shrink-0 w-full sm:w-56 lg:w-64 h-48 sm:min-h-[12rem] rounded-xl bg-gradient-to-br from-tract-50 to-tract-100 flex items-center justify-center group-hover:scale-[1.02] transition-transform">
                            @include('partials.service-icon', ['icon' => $service->icon])
                        </div>
                    @endif
                    <div class="flex-1 min-w-0 flex flex-col justify-center">
                        <h2 class="text-2xl font-bold text-slate-900 group-hover:text-tract-700 mb-3">{{ $service->localized('title', $locale) }}</h2>
                        <p class="text-slate-600 mb-4 leading-relaxed">{{ $service->localized('description', $locale) }}</p>
                        <span class="text-tract-600 font-semibold text-sm mt-auto">{{ $locale === 'en' ? 'View details & offers →' : ($locale === 'ur' ? 'تفصیلات اور پیشکشیں ←' : 'عرض التفاصيل والعروض ←') }}</span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endsection
