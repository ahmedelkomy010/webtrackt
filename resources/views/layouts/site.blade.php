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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('partials.favicon')
    <title>@yield('title') — {{ config('tract.name_en') }}</title>
    <meta name="description" content="@yield('meta_description', config('tract.seo.description'))">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="@yield('canonical', $siteUrl ?? config('tract.website'))">
    @vite(['resources/css/app.css'])
    @yield('schema')
</head>
<body class="antialiased bg-slate-50 text-slate-800">
    <header class="sticky top-0 z-50 bg-white/90 backdrop-blur border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 lg:h-20">
                <a href="/" class="flex items-center gap-3">
                    <img src="{{ asset('images/logo.png') }}" alt="{{ config('tract.name') }}" class="h-10 w-10 object-contain">
                    <div class="hidden sm:block">
                        <span class="block font-bold text-slate-900">{{ config('tract.name') }}</span>
                        <span class="block text-xs text-tract-600">{{ config('tract.name_en') }}</span>
                    </div>
                </a>
                <nav class="flex items-center gap-3 sm:gap-4 text-sm font-medium">
                    <a href="/" class="text-slate-600 hover:text-tract-700">{{ $loc === 'en' ? 'Home' : ($loc === 'ur' ? 'ہوم' : 'الرئيسية') }}</a>
                    <a href="{{ route('services.index') }}" class="text-slate-600 hover:text-tract-700 {{ request()->routeIs('services.*') ? 'text-tract-700 font-semibold' : '' }}">{{ $loc === 'en' ? 'Services' : ($loc === 'ur' ? 'خدمات' : 'خدماتنا') }}</a>
                    <a href="{{ route('blog.index') }}" class="text-slate-600 hover:text-tract-700">{{ $loc === 'en' ? 'Blog' : ($loc === 'ur' ? 'بلاگ' : 'المدونة') }}</a>
                    <a href="/#contact" class="hidden sm:inline-flex px-4 py-2 rounded-xl bg-tract-600 text-white hover:bg-tract-700">{{ $loc === 'en' ? 'Contact' : ($loc === 'ur' ? 'رابطہ' : 'تواصل') }}</a>
                </nav>
            </div>
        </div>
    </header>
    <main>@yield('content')</main>
    <footer class="bg-slate-900 text-slate-400 py-10 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-sm">
            <p>&copy; {{ date('Y') }} {{ config('tract.name') }} — {{ config('tract.name_en') }}</p>
            <div class="flex gap-4">
                <a href="?lang=ar" class="hover:text-white {{ $loc === 'ar' ? 'text-white font-semibold' : '' }}">العربية</a>
                <a href="?lang=en" class="hover:text-white {{ $loc === 'en' ? 'text-white font-semibold' : '' }}">English</a>
                <a href="?lang=ur" class="hover:text-white {{ $loc === 'ur' ? 'text-white font-semibold' : '' }}">اردو</a>
            </div>
        </div>
    </footer>
</body>
</html>
