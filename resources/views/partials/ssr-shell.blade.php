{{--
  SSR Shell — Server-rendered HTML for SEO crawlers.
  Hidden instantly for JS users via .js-ready CSS class (added in <head>).
  Google's crawler (without JS) indexes this content immediately.
--}}
@php
    $cfg = config('tract');
    $locale = 'ar';

    /* Helper: get localised value from a translatable array */
    $loc = fn($val) => is_array($val) ? ($val[$locale] ?? $val['ar'] ?? $val['en'] ?? '') : (string) $val;
@endphp

<div id="ssr-shell" aria-hidden="true">

    {{-- ══ HERO ════════════════════════════════════════════════════════════ --}}
    <section>
        <h1>{{ $cfg['name'] }} | {{ $cfg['name_en'] }}</h1>
        <p>{{ $cfg['description'] }}</p>
        <p dir="ltr">"{{ $cfg['tagline'] }}"</p>
        <p>{{ $cfg['tagline_ar'] }}</p>
    </section>

    {{-- ══ SERVICES ════════════════════════════════════════════════════════ --}}
    <section>
        <h2>حلول متكاملة لتحولك الرقمي</h2>
        <p>من الفكرة إلى التنفيذ — نرافقك في كل مرحلة لتحقيق نتائج ملموسة</p>
        @foreach($content['services'] ?? [] as $service)
        <article>
            <h3>{{ $loc($service['title']) }}</h3>
            <p>{{ $loc($service['description']) }}</p>
            @if(!empty($service['features']))
            <ul>
                @foreach($service['features'] as $feature)
                <li>{{ $loc($feature) }}</li>
                @endforeach
            </ul>
            @endif
        </article>
        @endforeach
    </section>

    {{-- ══ ABOUT ════════════════════════════════════════════════════════════ --}}
    <section>
        <h2>من نحن</h2>
        <p>نحن شركة متخصصة في تقديم حلول رقمية متكاملة للشركات والمؤسسات. نجمع بين الخبرة التقنية والفهم العميق للسوق المحلي لنقدّم لك منتجات تخدم أهدافك.</p>
        <ul>
            <li>الموقع: {{ $cfg['location'] }}</li>
            <li>{{ $cfg['name'] }} — {{ $cfg['name_en'] }}</li>
            <li>سجل تجاري وبطاقة ضريبية</li>
        </ul>
    </section>

    {{-- ══ WHY US ═══════════════════════════════════════════════════════════ --}}
    <section>
        <h2>لماذا تراكت؟</h2>
        <p>شريك يستحق ثقتك</p>
        @foreach($content['whyUs'] ?? [] as $item)
        <article>
            <h3>{{ $loc($item['title']) }}</h3>
            <p>{{ $loc($item['description']) }}</p>
        </article>
        @endforeach
    </section>

    {{-- ══ STATS ════════════════════════════════════════════════════════════ --}}
    <section>
        @foreach($content['stats'] ?? [] as $stat)
        <div>
            <strong>{{ $stat['value'] }}</strong>
            <span>{{ $loc($stat['label']) }}</span>
        </div>
        @endforeach
    </section>

    {{-- ══ CONTACT ══════════════════════════════════════════════════════════ --}}
    <section>
        <h2>تواصل معنا</h2>
        <address>
            <p>{{ $cfg['name'] }} — {{ $cfg['name_en'] }}</p>
            <p>{{ $cfg['location'] }}</p>
            <p><a href="mailto:{{ $cfg['email'] }}">{{ $cfg['email'] }}</a></p>
            <p><a href="tel:{{ $cfg['phone_intl'] }}">{{ $cfg['phone'] }}</a></p>
        </address>
    </section>

</div>
