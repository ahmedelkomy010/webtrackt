@extends('layouts.site')

@php
    use App\Support\Locale;
    use App\Support\SiteUrl;

    $cty = $country ?? SiteUrl::DEFAULT_COUNTRY;
    $pageTitle = $locale === 'en' ? 'Payment' : ($locale === 'ur' ? 'ادائیگی' : 'الدفع');
    $canonical = $siteUrl.Locale::path('checkout/payment/'.$order->uuid, $locale, $cty);
    $methodLabels = fn (string $key) => config("payments.methods.{$key}.label_{$locale}") ?? config("payments.methods.{$key}.label_ar");
@endphp

@section('title', $pageTitle)
@section('meta_description', $pageTitle)
@section('canonical', $canonical)

@section('content')
<section class="py-10 sm:py-14 bg-white border-b">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 mb-2">{{ $pageTitle }}</h1>
        <p class="text-slate-500 text-sm">{{ $locale === 'en' ? 'Order' : ($locale === 'ur' ? 'آرڈر' : 'الطلب') }}: <span dir="ltr">{{ $order->reference }}</span></p>
        @include('partials.checkout-steps', ['step' => 3, 'locale' => $locale])
    </div>
</section>

<section class="py-10 sm:py-14 bg-slate-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 grid lg:grid-cols-5 gap-8">
        <div class="lg:col-span-3 space-y-6">
            @if ($usesLiveGateway)
                @push('head')
                    <link rel="stylesheet" href="https://cdn.moyasar.com/mpf/1.14.0/moyasar.css">
                @endpush

                <div class="checkout-panel">
                    <h2 class="text-lg font-bold text-slate-900 mb-2">{{ $locale === 'en' ? 'Choose payment method' : ($locale === 'ur' ? 'ادائیگی کا طریقہ منتخب کریں' : 'اختر طريقة الدفع') }}</h2>
                    <p class="text-sm text-slate-500 mb-4">{{ $locale === 'en' ? 'Visa, Mada, Apple Pay, and STC Pay are supported.' : ($locale === 'ur' ? 'Visa، Mada، Apple Pay اور STC Pay دستیاب ہیں۔' : 'يدعم فيزا ومدى وApple Pay وSTC Pay.') }}</p>
                    <div class="payment-methods" aria-hidden="true">
                        @foreach ($methods as $key => $method)
                            <span class="payment-method-badge">{{ $methodLabels($key) }}</span>
                        @endforeach
                    </div>
                    <div class="mysr-form mt-6"></div>
                </div>

                @push('scripts')
                    <script src="https://cdn.moyasar.com/mpf/1.14.0/moyasar.js"></script>
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            if (typeof Moyasar === 'undefined') return;
                            Moyasar.init({
                                element: '.mysr-form',
                                amount: {{ (int) $paymentConfig['amount'] }},
                                currency: @json($paymentConfig['currency']),
                                description: @json($paymentConfig['description']),
                                publishable_api_key: @json($paymentConfig['publishable_key']),
                                callback_url: @json($paymentConfig['callback_url']),
                                methods: @json($paymentConfig['methods']),
                                metadata: @json($paymentConfig['metadata']),
                            });
                        });
                    </script>
                @endpush
            @else
                <div class="checkout-panel">
                    <div class="sandbox-banner">
                        {{ $locale === 'en' ? 'Sandbox mode — add Moyasar keys in .env to enable live payments.' : ($locale === 'ur' ? 'سینڈباکس موڈ — حقیقی ادائیگی کے لیے Moyasar keys شامل کریں۔' : 'وضع تجريبي — أضف مفاتيح Moyasar في .env لتفعيل الدفع الحقيقي.') }}
                    </div>

                    <h2 class="text-lg font-bold text-slate-900 mb-4">{{ $locale === 'en' ? 'Choose payment method' : ($locale === 'ur' ? 'ادائیگی کا طریقہ منتخب کریں' : 'اختر طريقة الدفع') }}</h2>

                    <form method="POST" action="{{ Locale::path('checkout/payment/'.$order->uuid, $locale, $cty) }}" class="space-y-4">
                        @csrf
                        <div class="payment-method-grid">
                            @foreach ($methods as $key => $method)
                                <label class="payment-method-option">
                                    <input type="radio" name="payment_method" value="{{ $key }}" @checked(old('payment_method', 'creditcard') === $key) required>
                                    <span>{{ $methodLabels($key) }}</span>
                                </label>
                            @endforeach
                        </div>

                        @if ($errors->any())
                            <div class="px-4 py-3 rounded-xl bg-red-50 text-red-800 border border-red-200 text-sm">
                                @foreach ($errors->all() as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif

                        <div class="flex flex-col sm:flex-row gap-3">
                            <button type="submit" name="simulate_result" value="success" class="checkout-btn checkout-btn--primary flex-1">
                                {{ $locale === 'en' ? 'Simulate successful payment' : ($locale === 'ur' ? 'کامیاب ادائیگی کی نقل' : 'محاكاة دفع ناجح') }}
                            </button>
                            <button type="submit" name="simulate_result" value="failed" class="checkout-btn checkout-btn--ghost flex-1">
                                {{ $locale === 'en' ? 'Simulate failed payment' : ($locale === 'ur' ? 'ناکام ادائیگی simulating' : 'محاكاة دفع فاشل') }}
                            </button>
                        </div>
                    </form>
                </div>
            @endif
        </div>

        <aside class="lg:col-span-2 checkout-panel">
            <h2 class="text-lg font-bold text-slate-900 mb-4">{{ $locale === 'en' ? 'Order summary' : ($locale === 'ur' ? 'آرڈر خلاصہ' : 'ملخص الطلب') }}</h2>
            <ul class="space-y-3 mb-4">
                @foreach ($order->items as $item)
                    <li class="text-sm">
                        <p class="font-semibold text-slate-900">{{ $item->name }}</p>
                        @if ($item->price_label)
                            <p class="text-slate-500">{{ $item->price_label }}</p>
                        @endif
                        <p class="text-tract-700 font-medium mt-1">{{ $item->formattedAmount() }}</p>
                    </li>
                @endforeach
            </ul>
            <div class="checkout-summary__row border-t pt-4">
                <span>{{ $locale === 'en' ? 'Total due' : ($locale === 'ur' ? 'کل واجب الادا' : 'المبلغ المستحق') }}</span>
                <strong>{{ $order->formattedAmount() }}</strong>
            </div>
            <p class="text-xs text-slate-500 mt-4">{{ $order->customer_name }} · {{ $order->customer_email }}</p>
        </aside>
    </div>
</section>
@endsection
