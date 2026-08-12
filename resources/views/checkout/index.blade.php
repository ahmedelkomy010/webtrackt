@extends('layouts.site')

@php
    use App\Support\Locale;
    use App\Support\SiteUrl;

    $cty = $country ?? SiteUrl::DEFAULT_COUNTRY;
    $pageTitle = $locale === 'en' ? 'Checkout' : ($locale === 'ur' ? 'چیک آؤٹ' : 'إتمام الطلب');
    $canonical = $siteUrl.Locale::path('checkout', $locale, $cty);
@endphp

@section('title', $pageTitle)
@section('meta_description', $pageTitle)
@section('canonical', $canonical)

@section('content')
<section class="py-10 sm:py-14 bg-white border-b">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 mb-6">{{ $pageTitle }}</h1>
        @include('partials.checkout-steps', ['step' => 2, 'locale' => $locale])
    </div>
</section>

<section class="py-10 sm:py-14 bg-slate-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 grid lg:grid-cols-5 gap-8">
        <form method="POST" action="{{ Locale::path('checkout', $locale, $cty) }}" class="lg:col-span-3 checkout-panel space-y-4">
            @csrf
            <h2 class="text-lg font-bold text-slate-900">{{ $locale === 'en' ? 'Contact details' : ($locale === 'ur' ? 'رابطے کی تفصیلات' : 'بيانات التواصل') }}</h2>

            <div>
                <label class="checkout-label">{{ $locale === 'en' ? 'Full name' : ($locale === 'ur' ? 'مکمل نام' : 'الاسم الكامل') }} *</label>
                <input type="text" name="customer_name" value="{{ old('customer_name') }}" required class="checkout-input">
            </div>
            <div>
                <label class="checkout-label">{{ $locale === 'en' ? 'Email' : ($locale === 'ur' ? 'ای میل' : 'البريد الإلكتروني') }} *</label>
                <input type="email" name="customer_email" value="{{ old('customer_email') }}" required class="checkout-input">
            </div>
            <div>
                <label class="checkout-label">{{ $locale === 'en' ? 'Phone' : ($locale === 'ur' ? 'فون' : 'رقم الجوال') }} *</label>
                <input type="tel" name="customer_phone" value="{{ old('customer_phone') }}" required class="checkout-input" dir="ltr">
            </div>
            <div>
                <label class="checkout-label">{{ $locale === 'en' ? 'Company (optional)' : ($locale === 'ur' ? 'کمپنی (اختیاری)' : 'الشركة (اختياري)') }}</label>
                <input type="text" name="customer_company" value="{{ old('customer_company') }}" class="checkout-input">
            </div>
            <div>
                <label class="checkout-label">{{ $locale === 'en' ? 'Notes (optional)' : ($locale === 'ur' ? 'نوٹس (اختیاری)' : 'ملاحظات (اختياري)') }}</label>
                <textarea name="customer_notes" rows="3" class="checkout-input">{{ old('customer_notes') }}</textarea>
            </div>

            <button type="submit" class="checkout-btn checkout-btn--primary checkout-btn--block">
                {{ $locale === 'en' ? 'Continue to payment' : ($locale === 'ur' ? 'ادائیگی کی طرف جائیں' : 'المتابعة للدفع') }}
            </button>
        </form>

        <aside class="lg:col-span-2 checkout-panel">
            <h2 class="text-lg font-bold text-slate-900 mb-4">{{ $locale === 'en' ? 'Order summary' : ($locale === 'ur' ? 'آرڈر خلاصہ' : 'ملخص الطلب') }}</h2>
            <ul class="space-y-3 mb-4">
                @foreach ($items as $item)
                    <li class="text-sm">
                        <p class="font-semibold text-slate-900">{{ $item['name'] }}</p>
                        <p class="text-slate-500">{{ $item['service_title'] }}</p>
                        <p class="text-tract-700 font-medium mt-1">{{ number_format($item['amount'] / 100, 2) }} {{ $item['currency'] }}</p>
                    </li>
                @endforeach
            </ul>
            <div class="checkout-summary__row border-t pt-4">
                <span>{{ $locale === 'en' ? 'Total' : ($locale === 'ur' ? 'کل' : 'الإجمالي') }}</span>
                <strong>{{ $formattedTotal }}</strong>
            </div>
        </aside>
    </div>
</section>
@endsection
