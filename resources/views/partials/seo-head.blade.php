@php
    /** @var \App\Services\SeoService $seo */
    $seo = app(\App\Services\SeoService::class);
    $siteUrl = $seo->siteUrl();
    $title = $title ?? $seo->title('ar');
    $description = $description ?? $seo->description('ar');
    $keywords = $keywords ?? $seo->keywords('ar');
    $canonical = $canonical ?? $siteUrl.'/';
    $ogType = $ogType ?? 'website';
    $ogImage = $ogImage ?? $seo->ogImageUrl();
@endphp

<title>{{ $title }}</title>
<meta name="description" content="{{ $description }}">
@if ($keywords)
<meta name="keywords" content="{{ $keywords }}">
@endif
<meta name="author" content="{{ config('tract.name') }} — {{ config('tract.name_en') }}">
<meta name="robots" content="{{ $seo->robots() }}">
<link rel="canonical" href="{{ $canonical }}">

<meta property="og:type" content="{{ $ogType }}">
<meta property="og:url" content="{{ $canonical }}">
<meta property="og:title" content="{{ $title }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:site_name" content="{{ config('tract.name') }}">
<meta property="og:image" content="{{ $ogImage }}">
<meta property="og:image:alt" content="{{ config('tract.name_en') }} Logo">
<meta property="og:locale" content="ar_SA">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $title }}">
<meta name="twitter:description" content="{{ $description }}">
<meta name="twitter:image" content="{{ $ogImage }}">

@if ($seo->get('enable_json_ld', true) && ! empty($jsonLd ?? null))
<script type="application/ld+json">@json($jsonLd)</script>
@endif

@include('partials.analytics')
