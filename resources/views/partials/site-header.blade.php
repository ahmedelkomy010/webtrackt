@php
    use App\Support\Locale;
    use App\Support\SiteUrl;

    $loc = $locale ?? Locale::AR;
    $cty = $country ?? SiteUrl::DEFAULT_COUNTRY;
    $labels = [
        'home' => $loc === 'en' ? 'Home' : ($loc === 'ur' ? 'ہوم' : 'الرئيسية'),
        'services' => $loc === 'en' ? 'Services' : ($loc === 'ur' ? 'خدمات' : 'خدماتنا'),
        'about' => $loc === 'en' ? 'About' : ($loc === 'ur' ? 'ہمارے بارے' : 'من نحن'),
        'blog' => $loc === 'en' ? 'Blog' : ($loc === 'ur' ? 'بلاگ' : 'المدونة'),
        'works' => $loc === 'en' ? 'Our Work' : ($loc === 'ur' ? 'ہمارے کام' : 'أعمالنا'),
        'contact' => $loc === 'en' ? 'Contact' : ($loc === 'ur' ? 'رابطہ' : 'تواصل'),
        'privacy' => $loc === 'en' ? 'Privacy' : ($loc === 'ur' ? 'رازداری' : 'الخصوصية'),
        'startProject' => $loc === 'en' ? 'Start your project' : ($loc === 'ur' ? 'اپنا پروجیکٹ شروع کریں' : 'ابدأ مشروعك'),
    ];
    $basePath = SiteUrl::stripContext(request()->path());
    $isHome = $basePath === '';
    $isServices = str_starts_with($basePath, 'services');
    $isBlog = str_starts_with($basePath, 'blog');
    $isWorks = str_starts_with($basePath, 'works');
    $isAbout = str_starts_with($basePath, 'about');
    $isContact = str_starts_with($basePath, 'contact');
    $isPrivacy = str_starts_with($basePath, 'privacy');
@endphp

<header class="site-header sticky top-0 safe-top">
    <div class="site-header__inner max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between gap-3 h-14 sm:h-16 lg:h-20">
            <a href="{{ Locale::home($loc, $cty) }}" class="site-header__brand flex items-center gap-2.5 min-w-0">
                <img src="{{ asset('images/logo.png') }}" alt="{{ config('tract.name') }}" class="h-9 w-9 sm:h-10 sm:w-10 object-contain shrink-0" width="40" height="40">
                <div class="min-w-0">
                    <span class="block font-bold text-slate-900 text-sm sm:text-base truncate">{{ config('tract.name') }}</span>
                    <span class="block text-[10px] sm:text-xs text-tract-600 truncate">{{ config('tract.name_en') }}</span>
                </div>
            </a>

            <nav class="hidden lg:flex items-center gap-3 xl:gap-4 text-sm font-semibold">
                <a href="{{ Locale::home($loc, $cty) }}" class="site-header__link {{ $isHome ? 'is-active' : '' }}">{{ $labels['home'] }}</a>
                <a href="{{ Locale::path('services', $loc, $cty) }}" class="site-header__link {{ $isServices ? 'is-active' : '' }}">{{ $labels['services'] }}</a>
                <a href="{{ Locale::path('about', $loc, $cty) }}" class="site-header__link {{ $isAbout ? 'is-active' : '' }}">{{ $labels['about'] }}</a>
                <a href="{{ Locale::path('blog', $loc, $cty) }}" class="site-header__link {{ $isBlog ? 'is-active' : '' }}">{{ $labels['blog'] }}</a>
                <a href="{{ Locale::path('works', $loc, $cty) }}" class="site-header__link {{ $isWorks ? 'is-active' : '' }}">{{ $labels['works'] }}</a>
                <a href="{{ Locale::path('privacy', $loc, $cty) }}" class="site-header__link {{ $isPrivacy ? 'is-active' : '' }}">{{ $labels['privacy'] }}</a>
                <a href="{{ Locale::path('contact', $loc, $cty) }}" class="site-header__cta {{ $isContact ? 'is-active' : '' }}">{{ $labels['contact'] }}</a>
            </nav>
        </div>
    </div>
</header>
