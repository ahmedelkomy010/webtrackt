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
        'menu' => $loc === 'en' ? 'Menu' : ($loc === 'ur' ? 'مینو' : 'القائمة'),
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

    $mobileLinks = [
        ['href' => Locale::home($loc, $cty), 'label' => $labels['home'], 'active' => $isHome],
        ['href' => Locale::path('services', $loc, $cty), 'label' => $labels['services'], 'active' => $isServices],
        ['href' => Locale::path('about', $loc, $cty), 'label' => $labels['about'], 'active' => $isAbout],
        ['href' => Locale::path('blog', $loc, $cty), 'label' => $labels['blog'], 'active' => $isBlog],
        ['href' => Locale::path('works', $loc, $cty), 'label' => $labels['works'], 'active' => $isWorks],
        ['href' => Locale::path('privacy', $loc, $cty), 'label' => $labels['privacy'], 'active' => $isPrivacy],
    ];
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

            <button type="button" class="site-header__toggle lg:hidden touch-target" aria-label="{{ $labels['menu'] }}" data-mobile-menu-toggle aria-expanded="false">
                <svg class="site-header__toggle-icon site-header__toggle-icon--open" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
                <svg class="site-header__toggle-icon site-header__toggle-icon--close" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>
    </div>
</header>

<div class="mobile-drawer lg:hidden" data-mobile-menu hidden>
    <div class="mobile-drawer__backdrop" data-mobile-menu-close></div>
    <div class="mobile-drawer__panel safe-bottom">
        <div class="mobile-drawer__head">
            <p class="font-bold text-slate-900">{{ $labels['menu'] }}</p>
            <button type="button" class="touch-target p-2 rounded-xl hover:bg-slate-100" data-mobile-menu-close aria-label="Close">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>
        <div class="mobile-drawer__links">
            @foreach ($mobileLinks as $link)
                <a href="{{ $link['href'] }}" class="mobile-drawer__link {{ $link['active'] ? 'is-active' : '' }}">{{ $link['label'] }}</a>
            @endforeach
            <a href="{{ Locale::path('contact', $loc, $cty) }}" class="mobile-drawer__cta">{{ $labels['startProject'] }}</a>
        </div>
        <div class="mobile-drawer__langs">
            <a href="{{ Locale::switchUrl(request(), Locale::AR) }}" class="mobile-drawer__lang {{ $loc === 'ar' ? 'is-active' : '' }}">العربية</a>
            <a href="{{ Locale::switchUrl(request(), Locale::EN) }}" class="mobile-drawer__lang {{ $loc === 'en' ? 'is-active' : '' }}">English</a>
            <a href="{{ Locale::switchUrl(request(), Locale::UR) }}" class="mobile-drawer__lang {{ $loc === 'ur' ? 'is-active' : '' }}">اردو</a>
        </div>
    </div>
</div>
