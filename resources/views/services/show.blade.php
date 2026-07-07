@extends('layouts.site')

@php
    $title = $service->localized('title', $locale);
    $description = $service->localized('description', $locale);
    $canonical = $siteUrl.'/services/'.$service->slug.($locale !== 'ar' ? '?lang='.$locale : '');
    $body = $service->localized('body', $locale);
    $features = $service->localizedFeatures($locale);
    $offers = $service->localizedOffers($locale);
@endphp

@section('title', $title)
@section('meta_description', $description)
@section('canonical', $canonical)

@section('content')
<section class="py-10 sm:py-12 lg:py-20 bg-gradient-to-br from-tract-600 to-tract-900 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="text-sm text-tract-200 mb-8">
            <a href="/" class="hover:text-white">{{ $locale === 'en' ? 'Home' : ($locale === 'ur' ? 'ہوم' : 'الرئيسية') }}</a>
            <span class="mx-2">/</span>
            <a href="{{ route('services.index', $locale !== 'ar' ? ['lang' => $locale] : []) }}" class="hover:text-white">{{ $locale === 'en' ? 'Services' : ($locale === 'ur' ? 'خدمات' : 'خدماتنا') }}</a>
            <span class="mx-2">/</span>
            <span class="text-white">{{ $title }}</span>
        </nav>
        <div class="flex flex-col lg:flex-row lg:items-center gap-8">
            <div class="shrink-0">@include('partials.service-icon', ['icon' => $service->icon])</div>
            <div class="max-w-3xl">
                @if ($service->highlight)
                    <span class="inline-block px-3 py-1 rounded-full bg-white/20 text-sm font-semibold mb-4">{{ $locale === 'en' ? 'Featured Service' : ($locale === 'ur' ? 'نمایاں خدمت' : 'خدمة مميزة') }}</span>
                @endif
                <h1 class="text-2xl sm:text-4xl lg:text-5xl font-bold mb-4">{{ $title }}</h1>
                <p class="text-lg text-tract-100 leading-relaxed">{{ $description }}</p>
            </div>
        </div>
    </div>
</section>

@if ($body)
<section class="py-12 lg:py-16 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 prose prose-lg max-w-none prose-headings:text-slate-900 prose-a:text-tract-600">
        {!! $body !!}
    </div>
</section>
@endif

<section class="py-12 {{ $body ? 'bg-slate-50' : 'bg-white' }}">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold text-slate-900 mb-8">{{ $locale === 'en' ? 'What we offer' : ($locale === 'ur' ? 'ہم کیا پیش کرتے ہیں' : 'ما نقدمه في هذه الخدمة') }}</h2>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($features as $feature)
                <div class="flex items-start gap-3 p-5 rounded-2xl bg-white border border-slate-100 shadow-sm">
                    <svg class="w-5 h-5 text-tract-600 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                    <span class="text-slate-700 text-sm">{{ $feature }}</span>
                </div>
            @endforeach
        </div>
    </div>
</section>

@if (count($offers))
<section class="py-16 lg:py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="inline-block px-4 py-1.5 rounded-full bg-gold-500/10 text-gold-600 text-sm font-semibold mb-4">{{ $locale === 'en' ? 'Our Offers' : ($locale === 'ur' ? 'ہماری پیشکشیں' : 'عروضنا') }}</span>
            <h2 class="text-3xl font-bold text-slate-900 mb-3">{{ $locale === 'en' ? 'Choose the plan that fits you' : ($locale === 'ur' ? 'اپنے لیے مناسب پلان منتخب کریں' : 'اختر الباقة المناسبة لك') }}</h2>
            <p class="text-slate-600">{{ $locale === 'en' ? 'Flexible packages designed for your business needs' : ($locale === 'ur' ? 'آپ کے کاروبار کے لیے لچکدار پیکجز' : 'باقات مرنة مصممة لاحتياجات عملك') }}</p>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($offers as $offer)
                <article class="relative p-6 sm:p-8 rounded-2xl border transition-all hover:shadow-xl {{ ($offer['highlight'] ?? false) ? 'border-tract-400 ring-2 ring-tract-200 bg-gradient-to-b from-tract-50 to-white shadow-lg lg:scale-[1.02]' : 'border-slate-200 bg-slate-50 hover:border-tract-200' }}">
                    @if ($offer['highlight'] ?? false)
                        <span class="absolute -top-3 start-1/2 -translate-x-1/2 px-4 py-1 rounded-full bg-tract-600 text-white text-xs font-bold">{{ $locale === 'en' ? 'Most Popular' : ($locale === 'ur' ? 'سب سے مقبول' : 'الأكثر طلباً') }}</span>
                    @endif
                    <h3 class="text-xl font-bold text-slate-900 mb-2">{{ $offer['name'] }}</h3>
                    <p class="text-2xl font-bold text-tract-700 mb-6">{{ $offer['price'] }}</p>
                    <ul class="space-y-3 mb-8">
                        @foreach ($offer['features'] as $f)
                            <li class="flex items-center gap-2 text-sm text-slate-600">
                                <svg class="w-4 h-4 text-tract-600 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                                {{ $f }}
                            </li>
                        @endforeach
                    </ul>
                    <a href="/#contact" class="block w-full text-center py-3 rounded-xl font-semibold text-sm transition-colors {{ ($offer['highlight'] ?? false) ? 'bg-tract-600 text-white hover:bg-tract-700' : 'bg-white border border-tract-200 text-tract-700 hover:bg-tract-50' }}">
                        {{ $locale === 'en' ? 'Request this offer' : ($locale === 'ur' ? 'یہ پیشکش طلب کریں' : 'اطلب هذا العرض') }}
                    </a>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endif

@if ($others->isNotEmpty())
<section class="py-12 bg-slate-50 border-t">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold text-slate-900 mb-8">{{ $locale === 'en' ? 'Other services' : ($locale === 'ur' ? 'دیگر خدمات' : 'خدمات أخرى') }}</h2>
        <div class="grid sm:grid-cols-3 gap-6">
            @foreach ($others as $other)
                <a href="{{ route('services.show', ['slug' => $other->slug, 'lang' => $locale !== 'ar' ? $locale : null]) }}" class="p-6 rounded-2xl bg-white border hover:border-tract-200 hover:shadow-lg transition-all group">
                    <h3 class="font-bold text-slate-900 group-hover:text-tract-700">{{ $other->localized('title', $locale) }}</h3>
                    <p class="text-sm text-slate-500 mt-2 line-clamp-2">{{ $other->localized('description', $locale) }}</p>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<section class="py-16 bg-gradient-to-r from-tract-600 to-tract-800">
    <div class="max-w-3xl mx-auto px-4 text-center text-white">
        <h2 class="text-2xl sm:text-3xl font-bold mb-4">{{ $locale === 'en' ? 'Ready to get started?' : ($locale === 'ur' ? 'شروع کرنے کے لیے تیار ہیں؟' : 'جاهز لبدء مشروعك؟') }}</h2>
        <p class="text-tract-100 mb-6">{{ $locale === 'en' ? 'Contact Trackkt for a free consultation about '.$title : ($locale === 'ur' ? 'مفت مشاورت کے لیے Trackkt سے رابطہ کریں' : 'تواصل مع Trackkt للحصول على استشارة مجانية حول '.$title) }}</p>
        <a href="/#contact" class="inline-flex px-8 py-3 rounded-xl bg-white text-tract-700 font-semibold hover:bg-tract-50 transition-colors">{{ $locale === 'en' ? 'Contact us now' : ($locale === 'ur' ? 'ابھی رابطہ کریں' : 'تواصل معنا الآن') }}</a>
    </div>
</section>
@endsection
