@php
    $loc = $locale ?? 'ar';
    $labels = [
        'home' => $loc === 'en' ? 'Home' : ($loc === 'ur' ? 'ہوم' : 'الرئيسية'),
        'services' => $loc === 'en' ? 'Services' : ($loc === 'ur' ? 'خدمات' : 'خدماتنا'),
        'blog' => $loc === 'en' ? 'Blog' : ($loc === 'ur' ? 'بلاگ' : 'المدونة'),
        'contact' => $loc === 'en' ? 'Contact' : ($loc === 'ur' ? 'رابطہ' : 'تواصل'),
    ];
    $path = request()->path();
    $isHome = $path === '' || $path === '/';
    $isServices = str_starts_with($path, 'services');
    $isBlog = str_starts_with($path, 'blog');
@endphp

<nav class="mobile-bottom-nav lg:hidden" aria-label="Mobile navigation">
    <a href="/" class="mobile-bottom-nav__item {{ $isHome ? 'is-active' : '' }}">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
        <span>{{ $labels['home'] }}</span>
    </a>
    <a href="{{ $isHome ? '/#services' : route('services.index', $loc !== 'ar' ? ['lang' => $loc] : []) }}" class="mobile-bottom-nav__item {{ $isServices ? 'is-active' : '' }}">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
        <span>{{ $labels['services'] }}</span>
    </a>
    <a href="{{ route('blog.index', $loc !== 'ar' ? ['lang' => $loc] : []) }}" class="mobile-bottom-nav__item {{ $isBlog ? 'is-active' : '' }}">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" /></svg>
        <span>{{ $labels['blog'] }}</span>
    </a>
    <a href="/#contact" class="mobile-bottom-nav__item">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
        <span>{{ $labels['contact'] }}</span>
    </a>
</nav>
