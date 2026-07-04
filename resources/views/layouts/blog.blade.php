@php
    $dir = $locale === 'en' ? 'ltr' : 'rtl';
    $lang = match ($locale) {
        'en' => 'en',
        'ur' => 'ur',
        default => 'ar-SA',
    };
@endphp
<!DOCTYPE html>
<html lang="{{ $lang }}" dir="{{ $dir }}">
<head>
    <meta charset="utf-8">
    @include('partials.mobile-meta')
    @include('partials.favicon')
    <title>@yield('title') — {{ config('tract.name_en') }}</title>
    <meta name="description" content="@yield('meta_description', config('tract.seo.description'))">
    <meta name="keywords" content="@yield('meta_keywords', config('tract.seo.keywords'))">
    <meta name="robots" content="index, follow, max-image-preview:large">
    <link rel="canonical" href="@yield('canonical', $siteUrl.'/blog')">

    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="@yield('canonical', $siteUrl.'/blog')">
    <meta property="og:title" content="@yield('title') — {{ config('tract.name') }}">
    <meta property="og:description" content="@yield('meta_description', config('tract.seo.description'))">
    <meta property="og:site_name" content="{{ config('tract.name') }}">
    <meta property="og:locale" content="{{ $locale === 'ar' ? 'ar_SA' : ($locale === 'ur' ? 'ur_PK' : 'en_US') }}">
    @hasSection('og_image')
        <meta property="og:image" content="@yield('og_image')">
    @endif

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title') — {{ config('tract.name') }}">
    <meta name="twitter:description" content="@yield('meta_description', config('tract.seo.description'))">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css'])
    @include('partials.analytics')
    @yield('schema')
</head>
<body class="antialiased bg-slate-50 text-slate-800 app-shell">
    @include('partials.site-header', ['locale' => $locale])
    <main>@yield('content')</main>

    <footer class="bg-slate-900 text-slate-400 py-10 mt-8 sm:mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-sm text-center sm:text-start">
            <p>&copy; {{ date('Y') }} {{ config('tract.name') }} — {{ config('tract.name_en') }}</p>
            <div class="flex gap-4">
                <a href="{{ route('blog.index', ['lang' => 'ar']) }}" class="hover:text-white {{ $locale === 'ar' ? 'text-white font-semibold' : '' }}">العربية</a>
                <a href="{{ route('blog.index', ['lang' => 'en']) }}" class="hover:text-white {{ $locale === 'en' ? 'text-white font-semibold' : '' }}">English</a>
                <a href="{{ route('blog.index', ['lang' => 'ur']) }}" class="hover:text-white {{ $locale === 'ur' ? 'text-white font-semibold' : '' }}">اردو</a>
            </div>
        </div>
    </footer>
    @include('partials.mobile-bottom-nav', ['locale' => $locale])
</body>
</html>
