@extends('layouts.site')

@php
    use App\Support\Locale;
    use App\Support\SiteUrl;

    $cty = $country ?? SiteUrl::DEFAULT_COUNTRY;
    $pageTitle = $locale === 'en' ? 'Payment failed' : ($locale === 'ur' ? 'ادائیگی ناکام' : 'فشل الدفع');
    $canonical = $siteUrl.Locale::path('checkout/cancel/'.$order->uuid, $locale, $cty);
@endphp

@section('title', $pageTitle)
@section('meta_description', $pageTitle)
@section('canonical', $canonical)

@section('content')
<section class="py-16 sm:py-24 bg-slate-50">
    <div class="max-w-xl mx-auto px-4 text-center">
        <div class="checkout-result checkout-result--failed">
            <div class="checkout-result__icon checkout-result__icon--failed" aria-hidden="true">!</div>
            <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 mb-3">{{ $pageTitle }}</h1>
            <p class="text-slate-600 mb-6">{{ $locale === 'en' ? 'Payment was not completed. You can try again or contact us for assistance.' : ($locale === 'ur' ? 'ادائیگی مکمل نہیں ہوئی۔ دوبارہ کوشش کریں یا ہم سے رابطہ کریں۔' : 'لم يكتمل الدفع. يمكنك المحاولة مرة أخرى أو التواصل معنا.') }}</p>
            <p class="text-sm text-slate-500 mb-8">{{ $locale === 'en' ? 'Reference' : ($locale === 'ur' ? 'حوالہ' : 'رقم الطلب') }}: <strong dir="ltr">{{ $order->reference }}</strong></p>
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="{{ Locale::path('checkout/payment/'.$order->uuid, $locale, $cty) }}" class="checkout-btn checkout-btn--primary">{{ $locale === 'en' ? 'Try again' : ($locale === 'ur' ? 'دوبارہ کوشش' : 'إعادة المحاولة') }}</a>
                <a href="{{ Locale::path('contact', $locale, $cty) }}" class="checkout-btn checkout-btn--ghost">{{ $locale === 'en' ? 'Contact support' : ($locale === 'ur' ? 'سپورٹ سے رابطہ' : 'تواصل مع الدعم') }}</a>
            </div>
        </div>
    </div>
</section>
@endsection
