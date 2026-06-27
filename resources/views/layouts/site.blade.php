@php
    $dir = ($locale ?? 'ar') === 'en' ? 'ltr' : 'rtl';
    $lang = match ($locale ?? 'ar') {
        'en' => 'en',
        'ur' => 'ur',
        default => 'ar-SA',
    };
    $loc = $locale ?? 'ar';
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
    @vite(['resources/css/app.css'])
    @yield('schema')
</head>
<body class="antialiased bg-slate-50 text-slate-800 app-shell">
    @include('partials.site-header', ['locale' => $loc])
    <main>@yield('content')</main>
    <footer class="bg-slate-900 text-slate-400 py-10 mt-8 sm:mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-sm text-center sm:text-start">
            <p>&copy; {{ date('Y') }} {{ config('tract.name') }} — {{ config('tract.name_en') }}</p>
            <div class="flex gap-4">
                <a href="?lang=ar" class="hover:text-white {{ $loc === 'ar' ? 'text-white font-semibold' : '' }}">العربية</a>
                <a href="?lang=en" class="hover:text-white {{ $loc === 'en' ? 'text-white font-semibold' : '' }}">English</a>
                <a href="?lang=ur" class="hover:text-white {{ $loc === 'ur' ? 'text-white font-semibold' : '' }}">اردو</a>
            </div>
        </div>
    </footer>
    @include('partials.mobile-bottom-nav', ['locale' => $loc])
</body>
</html>
