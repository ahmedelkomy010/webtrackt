@extends('layouts.site')

@php
    use App\Support\Locale;
    use App\Support\SiteUrl;

    $cty = $country ?? SiteUrl::DEFAULT_COUNTRY;
    $title = $service->localized('title', $locale);
    $description = $service->localized('description', $locale);
    $canonical = $siteUrl.Locale::path('services/'.$service->slug, $locale, $cty);
    $body = $service->localized('body', $locale);
    $features = $service->localizedFeatures($locale);
    $offers = $service->localizedOffers($locale);
@endphp

@section('title', $title)
@section('meta_description', $description)
@section('canonical', $canonical)

@section('content')
<section class="py-10 sm:py-12 lg:py-20 hero-surface">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="text-sm text-tract-200 mb-8">
            <a href="{{ Locale::home($locale, $cty) }}" class="hover:text-white">{{ $locale === 'en' ? 'Home' : ($locale === 'ur' ? 'ہوم' : 'الرئيسية') }}</a>
            <span class="mx-2">/</span>
            <a href="{{ Locale::path('services', $locale, $cty) }}" class="hover:text-white">{{ $locale === 'en' ? 'Services' : ($locale === 'ur' ? 'خدمات' : 'خدماتنا') }}</a>
            <span class="mx-2">/</span>
            <span class="text-white">{{ $title }}</span>
        </nav>
        <div class="flex flex-col lg:flex-row lg:items-center gap-8">
            <div class="shrink-0">
                @if ($service->image)
                    <img src="{{ asset('storage/'.$service->image) }}" alt="{{ $title }}" class="w-full max-w-sm lg:max-w-md h-56 lg:h-64 object-cover rounded-2xl shadow-2xl ring-4 ring-white/20">
                @else
                    @include('partials.service-icon', ['icon' => $service->icon])
                @endif
            </div>
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
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        @include('partials.rich-content', ['content' => $body, 'locale' => $locale])
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
<section class="pricing-section" aria-labelledby="pricing-heading">
    <div class="pricing-section__bg" aria-hidden="true"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <header class="pricing-section__header">
            <span class="pricing-section__eyebrow">{{ $locale === 'en' ? 'Our Offers' : ($locale === 'ur' ? 'ہماری پیشکشیں' : 'عروضنا') }}</span>
            <h2 id="pricing-heading" class="pricing-section__title">{{ $locale === 'en' ? 'Choose the plan that fits you' : ($locale === 'ur' ? 'اپنے لیے مناسب پلان منتخب کریں' : 'اختر الباقة المناسبة لك') }}</h2>
            <p class="pricing-section__subtitle">{{ $locale === 'en' ? 'Flexible packages designed for your business needs' : ($locale === 'ur' ? 'آپ کے کاروبار کے لیے لچکدار پیکجز' : 'باقات مرنة مصممة لاحتياجات عملك') }}</p>
        </header>

        <div class="pricing-grid">
            @foreach ($offers as $index => $offer)
                @php $featured = $offer['highlight'] ?? false; @endphp
                <article class="pricing-card {{ $featured ? 'pricing-card--featured' : '' }}" style="--pricing-delay: {{ $index * 80 }}ms">
                    @if ($featured)
                        <span class="pricing-card__badge">{{ $locale === 'en' ? 'Most Popular' : ($locale === 'ur' ? 'سب سے مقبول' : 'الأكثر طلباً') }}</span>
                    @endif

                    <div class="pricing-card__body">
                        <header class="pricing-card__head">
                            <h3 class="pricing-card__name">{{ $offer['name'] }}</h3>
                            @if ($offer['price'])
                                <p class="pricing-card__price">{{ $offer['price'] }}</p>
                            @endif
                        </header>

                        @if (count($offer['features']))
                            <ul class="pricing-card__features">
                                @foreach ($offer['features'] as $f)
                                    @if ($f)
                                        <li class="pricing-card__feature">
                                            <span class="pricing-card__check" aria-hidden="true">
                                                <svg viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                                            </span>
                                            <span>{{ $f }}</span>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        @endif

                        @if ($offer['purchasable'] ?? false)
                            <form method="POST" action="{{ Locale::path('cart/add', $locale, $cty) }}" class="pricing-card__cta-form">
                                @csrf
                                <input type="hidden" name="service_id" value="{{ $service->id }}">
                                <input type="hidden" name="offer_index" value="{{ $index }}">
                                <button type="submit" class="pricing-card__cta {{ $featured ? 'pricing-card__cta--primary' : '' }} w-full">
                                    {{ $locale === 'en' ? 'Request this offer' : ($locale === 'ur' ? 'یہ پیشکش طلب کریں' : 'اطلب هذا العرض') }}
                                    <svg class="pricing-card__cta-icon" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                </button>
                            </form>
                        @else
                            <a href="{{ Locale::path('contact', $locale, $cty) }}" class="pricing-card__cta {{ $featured ? 'pricing-card__cta--primary' : '' }}">
                                {{ $locale === 'en' ? 'Request this offer' : ($locale === 'ur' ? 'یہ پیشکش طلب کریں' : 'اطلب هذا العرض') }}
                                <svg class="pricing-card__cta-icon" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                            </a>
                        @endif
                    </div>
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
                <a href="{{ Locale::path('services/'.$other->slug, $locale, $cty) }}" class="flex gap-4 p-4 rounded-2xl bg-white border hover:border-tract-200 hover:shadow-lg transition-all group overflow-hidden">
                    @if ($other->image)
                        <img src="{{ asset('storage/'.$other->image) }}" alt="{{ $other->localized('title', $locale) }}" class="w-20 h-20 shrink-0 object-cover rounded-xl">
                    @else
                        <div class="w-20 h-20 shrink-0 rounded-xl bg-tract-50 flex items-center justify-center scale-75">@include('partials.service-icon', ['icon' => $other->icon])</div>
                    @endif
                    <div class="min-w-0">
                        <h3 class="font-bold text-slate-900 group-hover:text-tract-700">{{ $other->localized('title', $locale) }}</h3>
                        <p class="text-sm text-slate-500 mt-2 line-clamp-2">{{ $other->localized('description', $locale) }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<section class="py-16 bg-gradient-to-r from-tract-600 to-tract-700">
    <div class="max-w-3xl mx-auto px-4 text-center text-white">
        <h2 class="text-2xl sm:text-3xl font-bold mb-4">{{ $locale === 'en' ? 'Ready to get started?' : ($locale === 'ur' ? 'شروع کرنے کے لیے تیار ہیں؟' : 'جاهز لبدء مشروعك؟') }}</h2>
        <p class="text-tract-100 mb-6">{{ $locale === 'en' ? 'Contact Trackkt for a free consultation about '.$title : ($locale === 'ur' ? 'مفت مشاورت کے لیے Trackkt سے رابطہ کریں' : 'تواصل مع Trackkt للحصول على استشارة مجانية حول '.$title) }}</p>
        <a href="{{ Locale::path('contact', $locale, $cty) }}" class="inline-flex px-8 py-3 rounded-xl bg-white text-tract-700 font-semibold hover:bg-tract-50 transition-colors">{{ $locale === 'en' ? 'Contact us now' : ($locale === 'ur' ? 'ابھی رابطہ کریں' : 'تواصل معنا الآن') }}</a>
    </div>
</section>
@endsection
