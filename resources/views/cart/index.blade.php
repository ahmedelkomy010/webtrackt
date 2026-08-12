@extends('layouts.site')

@php
    use App\Support\Locale;
    use App\Support\SiteUrl;

    $cty = $country ?? SiteUrl::DEFAULT_COUNTRY;
    $pageTitle = $locale === 'en' ? 'Shopping Cart' : ($locale === 'ur' ? 'شاپنگ کارٹ' : 'سلة التسوق');
    $canonical = $siteUrl.Locale::path('cart', $locale, $cty);
@endphp

@section('title', $pageTitle)
@section('meta_description', $pageTitle)
@section('canonical', $canonical)

@section('content')
<section class="py-10 sm:py-14 bg-white border-b">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 mb-6">{{ $pageTitle }}</h1>
        @include('partials.checkout-steps', ['step' => 1, 'locale' => $locale])

        @if (session('success'))
            <div class="mt-6 px-4 py-3 rounded-xl bg-emerald-50 text-emerald-800 border border-emerald-200 text-sm">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="mt-6 px-4 py-3 rounded-xl bg-red-50 text-red-800 border border-red-200 text-sm">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
    </div>
</section>

<section class="py-10 sm:py-14 bg-slate-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        @if ($items->isEmpty())
            <div class="checkout-empty">
                <p>{{ $locale === 'en' ? 'Your cart is empty.' : ($locale === 'ur' ? 'آپ کا کارٹ خالی ہے۔' : 'سلتك فارغة.') }}</p>
                <a href="{{ Locale::path('services', $locale, $cty) }}" class="checkout-btn checkout-btn--primary">
                    {{ $locale === 'en' ? 'Browse services' : ($locale === 'ur' ? 'خدمات دیکھیں' : 'تصفح الخدمات') }}
                </a>
            </div>
        @else
            <div class="checkout-panel">
                <ul class="checkout-items">
                    @foreach ($items as $item)
                        <li class="checkout-item">
                            <div class="checkout-item__info">
                                <p class="checkout-item__service">{{ $item['service_title'] }}</p>
                                <h2 class="checkout-item__name">{{ $item['name'] }}</h2>
                                @if ($item['price_label'])
                                    <p class="checkout-item__label">{{ $item['price_label'] }}</p>
                                @endif
                            </div>
                            <div class="checkout-item__actions">
                                <p class="checkout-item__price">{{ number_format($item['amount'] / 100, 2) }} {{ $item['currency'] }}</p>
                                <form method="POST" action="{{ Locale::path('cart/remove/'.$item['key'], $locale, $cty) }}">
                                    @csrf
                                    <button type="submit" class="checkout-link-danger">
                                        {{ $locale === 'en' ? 'Remove' : ($locale === 'ur' ? 'ہٹائیں' : 'إزالة') }}
                                    </button>
                                </form>
                            </div>
                        </li>
                    @endforeach
                </ul>

                <div class="checkout-summary">
                    <div class="checkout-summary__row">
                        <span>{{ $locale === 'en' ? 'Total' : ($locale === 'ur' ? 'کل' : 'الإجمالي') }}</span>
                        <strong>{{ $formattedTotal }}</strong>
                    </div>
                    <a href="{{ Locale::path('checkout', $locale, $cty) }}" class="checkout-btn checkout-btn--primary checkout-btn--block">
                        {{ $locale === 'en' ? 'Proceed to checkout' : ($locale === 'ur' ? 'چیک آؤٹ پر جائیں' : 'متابعة إلى الدفع') }}
                    </a>
                </div>
            </div>
        @endif
    </div>
</section>
@endsection
