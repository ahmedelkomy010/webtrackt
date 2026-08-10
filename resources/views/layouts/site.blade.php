@php
    use App\Support\Locale;

    $dir = Locale::dir($locale ?? Locale::AR);
    $lang = Locale::htmlLang($locale ?? Locale::AR);
    $loc = $locale ?? Locale::AR;
@endphp
<!DOCTYPE html>
<html lang="{{ $lang }}" dir="{{ $dir }}">
<head>
    <meta charset="utf-8">
    @include('partials.mobile-meta')
    @include('partials.favicon')
    <title>@yield('title') — {{ config('tract.name_en') }}</title>
    <meta name="description" content="@yield('meta_description', config('tract.seo.description'))">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="@yield('canonical', $siteUrl ?? config('tract.website'))">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @if ($lang === 'ur')
        <link href="https://fonts.googleapis.com/css2?family=Noto+Nastaliq+Urdu:wght@400;500;600;700&display=swap" rel="stylesheet">
    @endif
    @vite(['resources/css/app.css', 'resources/js/mobile-menu.js'])
    @yield('schema')
</head>
<body class="antialiased bg-slate-50 text-slate-800 min-h-dvh flex flex-col app-shell">
    @include('partials.top-ticker', ['locale' => $loc])
    @include('partials.site-header', ['locale' => $loc])
    <main class="flex-1 w-full">@yield('content')</main>
    @include('partials.site-footer', ['locale' => $loc])
    @include('partials.mobile-bottom-nav', ['locale' => $loc])
</body>
</html>
