@extends('layouts.site')

@php
    use App\Support\Locale;
    use App\Support\SiteUrl;

    $cty = $country ?? SiteUrl::DEFAULT_COUNTRY;
    $pageTitle = $locale === 'en' ? 'Payment successful' : ($locale === 'ur' ? 'ادائیگی کامیاب' : 'تم الدفع بنجاح');
    $canonical = $siteUrl.Locale::path('checkout/success/'.$order->uuid, $locale, $cty);
@endphp

@section('title', $pageTitle)
@section('meta_description', $pageTitle)
@section('canonical', $canonical)

@section('content')
<section class="py-16 sm:py-24 bg-slate-50">
    <div class="max-w-xl mx-auto px-4 text-center">
        <div class="checkout-result checkout-result--success">
            <div class="checkout-result__icon" aria-hidden="true">✓</div>
            <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 mb-3">{{ $pageTitle }}</h1>
            <p class="text-slate-600 mb-2">{{ $locale === 'en' ? 'Thank you! Your order has been confirmed.' : ($locale === 'ur' ? 'شکریہ! آپ کا آرڈر تصدیق ہو گیا۔' : 'شكراً لك! تم تأكيد طلبك.') }}</p>
            <p class="text-sm text-slate-500 mb-6">{{ $locale === 'en' ? 'Reference' : ($locale === 'ur' ? 'حوالہ' : 'رقم الطلب') }}: <strong dir="ltr">{{ $order->reference }}</strong></p>
            <p class="text-lg font-bold text-tract-700 mb-8">{{ $order->formattedAmount() }}</p>
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="{{ Locale::home($locale, $cty) }}" class="checkout-btn checkout-btn--primary">{{ $locale === 'en' ? 'Back to home' : ($locale === 'ur' ? 'ہوم پر واپس' : 'العودة للرئيسية') }}</a>
                <a href="{{ Locale::path('services', $locale, $cty) }}" class="checkout-btn checkout-btn--ghost">{{ $locale === 'en' ? 'Browse services' : ($locale === 'ur' ? 'خدمات' : 'تصفح الخدمات') }}</a>
            </div>
        </div>
    </div>
</section>
@endsection
