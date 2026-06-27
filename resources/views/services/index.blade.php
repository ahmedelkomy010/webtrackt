@extends('layouts.site')

@php
    $pageTitle = $locale === 'en' ? 'Our Services' : ($locale === 'ur' ? 'ہماری خدمات' : 'خدماتنا');
    $pageDesc = $locale === 'en' ? 'Integrated digital solutions — ERP, websites, e-commerce, and digital marketing by Trakkt.' : ($locale === 'ur' ? 'مکمل ڈیجیٹل حل — ERP، ویب سائٹس، ای کامرس اور ڈیجیٹل مارکیٹنگ۔' : 'حلول رقمية متكاملة — ERP، مواقع، متاجر إلكترونية، وتسويق رقمي من Trakkt.');
@endphp

@section('title', $pageTitle)
@section('meta_description', $pageDesc)
@section('canonical', $siteUrl.'/services'.($locale !== 'ar' ? '?lang='.$locale : ''))

@section('content')
<section class="py-16 lg:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-14">
            <span class="inline-block px-4 py-1.5 rounded-full bg-tract-50 text-tract-700 text-sm font-semibold mb-4">{{ $locale === 'en' ? 'Services' : ($locale === 'ur' ? 'خدمات' : 'خدماتنا') }}</span>
            <h1 class="text-3xl sm:text-4xl font-bold text-slate-900 mb-4">{{ $pageTitle }}</h1>
            <p class="text-lg text-slate-600">{{ $pageDesc }}</p>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-2 gap-8">
            @foreach ($services as $service)
                <a href="{{ route('services.show', ['slug' => $service->slug, 'lang' => $locale !== 'ar' ? $locale : null]) }}" class="group p-8 rounded-2xl bg-white border border-slate-100 hover:border-tract-200 hover:shadow-xl transition-all">
                    <div class="mb-6 group-hover:scale-105 transition-transform w-fit">@include('partials.service-icon', ['icon' => $service->icon])</div>
                    <h2 class="text-2xl font-bold text-slate-900 group-hover:text-tract-700 mb-3">{{ $service->localized('title', $locale) }}</h2>
                    <p class="text-slate-600 mb-4">{{ $service->localized('description', $locale) }}</p>
                    <span class="text-tract-600 font-semibold text-sm">{{ $locale === 'en' ? 'View details & offers →' : ($locale === 'ur' ? 'تفصیلات اور پیشکشیں ←' : 'عرض التفاصيل والعروض ←') }}</span>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endsection
