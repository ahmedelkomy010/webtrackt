@php
    $loc = $locale ?? 'ar';
    $labels = [
        'home' => $loc === 'en' ? 'Home' : ($loc === 'ur' ? 'ہوم' : 'الرئيسية'),
        'services' => $loc === 'en' ? 'Services' : ($loc === 'ur' ? 'خدمات' : 'خدماتنا'),
        'blog' => $loc === 'en' ? 'Blog' : ($loc === 'ur' ? 'بلاگ' : 'المدونة'),
        'contact' => $loc === 'en' ? 'Contact' : ($loc === 'ur' ? 'رابطہ' : 'تواصل'),
    ];
    $langQuery = $loc !== 'ar' ? ['lang' => $loc] : [];
@endphp

<header class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-slate-200 safe-top">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-14 sm:h-16 lg:h-20">
            <a href="/" class="flex items-center gap-2.5 min-w-0">
                <img src="{{ asset('images/logo.png') }}" alt="{{ config('tract.name') }}" class="h-9 w-9 sm:h-10 sm:w-10 object-contain shrink-0">
                <div class="min-w-0">
                    <span class="block font-bold text-slate-900 text-sm sm:text-base truncate">{{ config('tract.name') }}</span>
                    <span class="block text-[10px] sm:text-xs text-tract-600 truncate">{{ config('tract.name_en') }}</span>
                </div>
            </a>

            <nav class="hidden lg:flex items-center gap-4 text-sm font-medium">
                <a href="/" class="text-slate-600 hover:text-tract-700 {{ request()->path() === '/' ? 'text-tract-700 font-semibold' : '' }}">{{ $labels['home'] }}</a>
                <a href="{{ route('services.index', $langQuery) }}" class="text-slate-600 hover:text-tract-700 {{ request()->routeIs('services.*') ? 'text-tract-700 font-semibold' : '' }}">{{ $labels['services'] }}</a>
                <a href="{{ route('blog.index', $langQuery) }}" class="text-slate-600 hover:text-tract-700 {{ request()->routeIs('blog.*') ? 'text-tract-700 font-semibold' : '' }}">{{ $labels['blog'] }}</a>
                <a href="/#contact" class="inline-flex px-4 py-2 rounded-xl bg-tract-600 text-white hover:bg-tract-700">{{ $labels['contact'] }}</a>
            </nav>

            <button type="button" class="lg:hidden touch-target p-2 rounded-xl text-slate-600 hover:bg-slate-100" aria-label="Menu" data-mobile-menu-toggle>
                <svg class="w-6 h-6 mobile-menu-icon-open" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
                <svg class="w-6 h-6 mobile-menu-icon-close hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>
    </div>

    <div class="mobile-drawer lg:hidden" data-mobile-menu hidden>
        <div class="mobile-drawer__backdrop" data-mobile-menu-close></div>
        <div class="mobile-drawer__panel safe-bottom">
            <div class="p-4 space-y-1">
                <a href="/" class="mobile-drawer__link">{{ $labels['home'] }}</a>
                <a href="{{ route('services.index', $langQuery) }}" class="mobile-drawer__link">{{ $labels['services'] }}</a>
                <a href="{{ route('blog.index', $langQuery) }}" class="mobile-drawer__link">{{ $labels['blog'] }}</a>
                <a href="/#contact" class="mobile-drawer__link">{{ $labels['contact'] }}</a>
            </div>
            <div class="p-4 border-t border-slate-100 flex gap-3">
                <a href="?lang=ar" class="flex-1 text-center py-3 rounded-xl text-sm font-medium {{ $loc === 'ar' ? 'bg-tract-600 text-white' : 'bg-slate-100 text-slate-700' }}">العربية</a>
                <a href="?lang=en" class="flex-1 text-center py-3 rounded-xl text-sm font-medium {{ $loc === 'en' ? 'bg-tract-600 text-white' : 'bg-slate-100 text-slate-700' }}">English</a>
                <a href="?lang=ur" class="flex-1 text-center py-3 rounded-xl text-sm font-medium {{ $loc === 'ur' ? 'bg-tract-600 text-white' : 'bg-slate-100 text-slate-700' }}">اردو</a>
            </div>
        </div>
    </div>
</header>

<script>
(function () {
    const toggle = document.querySelector('[data-mobile-menu-toggle]');
    const menu = document.querySelector('[data-mobile-menu]');
    if (!toggle || !menu) return;

    const openIcon = toggle.querySelector('.mobile-menu-icon-open');
    const closeIcon = toggle.querySelector('.mobile-menu-icon-close');

    const setOpen = (open) => {
        menu.hidden = !open;
        document.body.classList.toggle('mobile-menu-open', open);
        openIcon?.classList.toggle('hidden', open);
        closeIcon?.classList.toggle('hidden', !open);
    };

    toggle.addEventListener('click', () => setOpen(menu.hidden));
    menu.querySelectorAll('[data-mobile-menu-close], .mobile-drawer__link').forEach((el) => {
        el.addEventListener('click', () => setOpen(false));
    });
})();
</script>
