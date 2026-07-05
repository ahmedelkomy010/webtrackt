<!DOCTYPE html>
<html lang="ar-SA" dir="rtl">
<head>
    <meta charset="utf-8">
    @include('partials.mobile-meta')

    @include('partials.favicon')

    @php
        $seo = app(\App\Services\SeoService::class);
        $siteUrl = $seo->siteUrl();
        $phoneIntl = config('tract.phone_intl');
        $whatsapp = config('tract.whatsapp');
        $email = config('tract.email');

        $tractConfig = [
            'name' => config('tract.name'),
            'nameEn' => config('tract.name_en'),
            'tagline' => config('tract.tagline'),
            'taglineAr' => config('tract.tagline_ar'),
            'description' => config('tract.description'),
            'location' => config('tract.location'),
            'website' => $siteUrl,
            'commercialRegister' => config('tract.commercial_register'),
            'taxNumber' => config('tract.tax_number'),
            'email' => $email,
            'phone' => $phoneIntl,
            'phoneLocal' => config('tract.phone'),
            'whatsapp' => $whatsapp,
            'csrfToken' => csrf_token(),
        ];

        $jsonLd = [
            '@context' => 'https://schema.org',
            '@graph' => [
                $seo->organizationSchema(),
                [
                    '@type' => 'WebSite',
                    '@id' => $siteUrl.'/#website',
                    'url' => $siteUrl,
                    'name' => config('tract.name').' — '.config('tract.name_en'),
                    'description' => $seo->description('ar'),
                    'publisher' => ['@id' => $siteUrl.'/#organization'],
                    'inLanguage' => ['ar-SA', 'en', 'ur'],
                ],
                [
                    '@type' => 'ProfessionalService',
                    '@id' => $siteUrl.'/#service',
                    'name' => config('tract.name'),
                    'url' => $siteUrl,
                    'telephone' => $phoneIntl,
                    'email' => $email,
                    'description' => 'أول نظام مقاولات متخصص في العقد الموحد. ERP، تسويق إلكتروني، مواقع ومتاجر.',
                    'areaServed' => ['SA', 'AE', 'KW', 'BH', 'OM', 'QA', 'EG'],
                    'serviceType' => ['ERP Systems', 'Unified Contract Management', 'Turnkey Projects', 'Digital Marketing', 'Web Development', 'E-Commerce'],
                    'provider' => ['@id' => $siteUrl.'/#organization'],
                ],
            ],
        ];
    @endphp

    @include('partials.seo-head', [
        'title' => $seo->title('ar'),
        'description' => $seo->description('ar'),
        'keywords' => $seo->keywords('ar').', '.$seo->keywords('en'),
        'canonical' => $siteUrl.'/',
        'ogImage' => $seo->ogImageUrl(),
        'jsonLd' => $jsonLd,
    ])

    <meta name="geo.region" content="SA">
    <meta name="geo.placename" content="{{ config('tract.location') }}">

    {{-- Preload LCP image (logo) — tells browser to fetch it ASAP --}}
    <link rel="preload" as="image" href="/images/logo.png" fetchpriority="high">

    {{-- Non-blocking Google Fonts — prevents 750ms render block --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" as="style"
          href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
          onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    </noscript>
    {{-- Urdu font loaded only when needed (heavy — load deferred) --}}
    <script>
        if (localStorage.getItem('tract_locale') === 'ur') {
            var l = document.createElement('link');
            l.rel = 'stylesheet';
            l.href = 'https://fonts.googleapis.com/css2?family=Noto+Nastaliq+Urdu:wght@400;500;600;700&display=swap';
            document.head.appendChild(l);
        }
    </script>

    <script>
        window.__TRACT__ = @json($tractConfig);
        window.__TRACT_CONTENT__ = @json($ssrContent);
    </script>
    {{-- Inline style hides SSR shell immediately BEFORE body renders — no build needed --}}
    <style>#ssr-shell{position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0;pointer-events:none}</style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-slate-50 text-slate-800">

    {{--
        LCP prerender: Logo in initial HTML so browser discovers & loads it immediately.
        Vue's Navbar replaces this after mount — hidden via inline style instantly.
    --}}
    <div id="lcp-logo" style="position:absolute;width:1px;height:1px;overflow:hidden;opacity:0;pointer-events:none" aria-hidden="true">
        <picture>
            <source srcset="/images/logo.webp" type="image/webp">
            <img src="/images/logo.png"
                 alt="{{ config('tract.name') }}"
                 width="48" height="48"
                 fetchpriority="high"
                 decoding="async">
        </picture>
    </div>

    {{-- SSR Shell: Google reads this immediately, hidden for JS users --}}
    @include('partials.ssr-shell', ['content' => $ssrContent])

    <div id="app" class="app-shell"></div>
</body>
</html>
