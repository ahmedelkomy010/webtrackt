@php
    $step = $step ?? 1;
    $labels = [
        1 => ['ar' => 'السلة', 'en' => 'Cart', 'ur' => 'کارٹ'],
        2 => ['ar' => 'بيانات الطلب', 'en' => 'Checkout', 'ur' => 'چیک آؤٹ'],
        3 => ['ar' => 'الدفع', 'en' => 'Payment', 'ur' => 'ادائیگی'],
    ];
@endphp
<nav class="checkout-steps" aria-label="Checkout progress">
    @foreach ($labels as $num => $label)
        <div class="checkout-steps__item {{ $step >= $num ? 'checkout-steps__item--active' : '' }} {{ $step === $num ? 'checkout-steps__item--current' : '' }}">
            <span class="checkout-steps__num">{{ $num }}</span>
            <span class="checkout-steps__label">{{ $label[$locale] ?? $label['ar'] }}</span>
        </div>
        @if ($num < 3)
            <span class="checkout-steps__line {{ $step > $num ? 'checkout-steps__line--active' : '' }}" aria-hidden="true"></span>
        @endif
    @endforeach
</nav>
