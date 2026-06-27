<!DOCTYPE html>
<html lang="ar-SA" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @include('partials.favicon')

    @php
        $siteUrl = rtrim(config('tract.website'), '/');
        $seoTitle = config('tract.seo.title');
        $seoDesc = config('tract.seo.description');
        $seoKeywords = config('tract.seo.keywords');
        $seoKeywordsEn = config('tract.seo.keywords_en');
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
                [
                    '@type' => 'Organization',
                    '@id' => $siteUrl . '/#organization',
                    'name' => config('tract.name_en'),
                    'alternateName' => config('tract.name'),
                    'url' => $siteUrl,
                    'logo' => $siteUrl . '/images/logo.png',
                    'email' => $email,
                    'telephone' => $phoneIntl,
                    'description' => $seoDesc,
                    'address' => [
                        '@type' => 'PostalAddress',
                        'addressCountry' => 'SA',
                        'addressRegion' => config('tract.location'),
                    ],
                    'sameAs' => [
                        'https://wa.me/' . $whatsapp,
                    ],
                ],
                [
                    '@type' => 'WebSite',
                    '@id' => $siteUrl . '/#website',
                    'url' => $siteUrl,
                    'name' => config('tract.name') . ' — ' . config('tract.name_en'),
                    'description' => $seoDesc,
                    'publisher' => ['@id' => $siteUrl . '/#organization'],
                    'inLanguage' => ['ar-SA', 'en', 'ur'],
                ],
                [
                    '@type' => 'ProfessionalService',
                    '@id' => $siteUrl . '/#service',
                    'name' => config('tract.name'),
                    'url' => $siteUrl,
                    'telephone' => $phoneIntl,
                    'email' => $email,
                    'description' => 'أول نظام مقاولات متخصص في العقد الموحد. ERP، تسويق إلكتروني، مواقع ومتاجر.',
                    'areaServed' => ['SA', 'AE', 'KW', 'BH', 'OM', 'QA', 'EG'],
                    'serviceType' => [
                        'ERP Systems',
                        'Unified Contract Management',
                        'Turnkey Projects',
                        'Digital Marketing',
                        'Web Development',
                        'E-Commerce',
                    ],
                    'provider' => ['@id' => $siteUrl . '/#organization'],
                ],
            ],
        ];
    @endphp

    <title>{{ $seoTitle }}</title>
    <meta name="description" content="{{ $seoDesc }}">
    <meta name="keywords" content="{{ $seoKeywords }}, {{ $seoKeywordsEn }}">
    <meta name="author" content="{{ config('tract.name') }} — {{ config('tract.name_en') }}">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <link rel="canonical" href="{{ $siteUrl }}/">

    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ $siteUrl }}/">
    <meta property="og:title" content="{{ $seoTitle }}">
    <meta property="og:description" content="{{ $seoDesc }}">
    <meta property="og:site_name" content="{{ config('tract.name') }}">
    <meta property="og:locale" content="ar_SA">
    <meta property="og:locale:alternate" content="en_US">
    <meta property="og:locale:alternate" content="ur_PK">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $seoTitle }}">
    <meta name="twitter:description" content="{{ $seoDesc }}">

    <meta name="geo.region" content="SA">
    <meta name="geo.placename" content="{{ config('tract.location') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;700;800&family=Noto+Nastaliq+Urdu:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <script type="application/ld+json">@json($jsonLd)</script>

    <script>
        window.__TRACT__ = @json($tractConfig);
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-slate-50 text-slate-800">
    <div id="app"></div>
</body>
</html>
