<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    @include('partials.mobile-meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('partials.favicon')
    <title>@yield('title', 'لوحة التحكم') — Trakkt Admin</title>
    @vite(['resources/css/app.css'])
</head>
<body class="antialiased bg-slate-100 text-slate-800 min-h-screen">
    @php
        $adminLinks = [
            ['route' => 'admin.dashboard', 'label' => 'الرئيسية', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
            ['route' => 'admin.services.index', 'label' => 'الخدمات', 'icon' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'],
            ['route' => 'admin.stats.index', 'label' => 'الإحصائيات', 'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
            ['route' => 'admin.why-us.index', 'label' => 'لماذا تراكت', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
            ['route' => 'admin.nav-links.index', 'label' => 'روابط القائمة', 'icon' => 'M4 6h16M4 12h16M4 18h16'],
            ['route' => 'admin.posts.index', 'label' => 'المدونة SEO', 'icon' => 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z'],
            ['route' => 'admin.seo.edit', 'label' => 'إعدادات SEO', 'icon' => 'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z'],
            ['route' => 'admin.users.index', 'label' => 'المشرفون', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
            ['route' => 'admin.profile.edit', 'label' => 'حسابي', 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
            ['route' => 'admin.reviews.index', 'label' => 'تقييمات العملاء', 'icon' => 'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z'],
            ['route' => 'admin.messages.index', 'label' => 'رسائل التواصل', 'icon' => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
        ];
    @endphp
    <div class="flex min-h-screen">
        <aside class="w-64 bg-slate-900 text-white shrink-0 hidden lg:flex flex-col">
            <div class="p-6 border-b border-slate-700">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                    <img src="/images/logo.png" alt="Trakkt" class="h-10 w-10 object-contain">
                    <div>
                        <span class="block font-bold text-sm">لوحة التحكم</span>
                        <span class="block text-xs text-slate-400">Trakkt Marketing</span>
                    </div>
                </a>
            </div>
            <nav class="flex-1 p-4 space-y-1">
                @foreach ($adminLinks as $link)
                    <a href="{{ route($link['route']) }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs(str_replace('.index', '.*', $link['route'])) || request()->routeIs($link['route']) ? 'bg-tract-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $link['icon'] }}" /></svg>
                        {{ $link['label'] }}
                    </a>
                @endforeach
            </nav>
            <div class="p-4 border-t border-slate-700">
                <a href="/" target="_blank" class="flex items-center gap-2 px-4 py-2 text-sm text-slate-400 hover:text-white transition-colors mb-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                    عرض الموقع
                </a>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 text-sm text-red-400 hover:text-red-300 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                        تسجيل الخروج
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex-1 flex flex-col min-w-0">
            <header class="bg-white border-b border-slate-200 px-4 lg:px-8 py-3 flex items-center justify-between lg:hidden safe-top">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 min-w-0">
                    <img src="/images/logo.png" alt="Trakkt" class="h-8 w-8 shrink-0">
                    <span class="font-bold text-sm truncate">لوحة التحكم</span>
                </a>
                <button type="button" class="touch-target p-2 rounded-xl hover:bg-slate-100" data-mobile-menu-toggle aria-label="Menu">
                    <svg class="w-6 h-6 mobile-menu-icon-open" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
                    <svg class="w-6 h-6 mobile-menu-icon-close hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </header>

            <div class="mobile-drawer lg:hidden" data-mobile-menu hidden>
                <div class="mobile-drawer__backdrop" data-mobile-menu-close></div>
                <div class="mobile-drawer__panel safe-bottom">
                    <div class="p-3 space-y-1 max-h-[70dvh] overflow-y-auto">
                        @foreach ($adminLinks as $link)
                            <a href="{{ route($link['route']) }}" class="mobile-drawer__link">{{ $link['label'] }}</a>
                        @endforeach
                        <a href="/" target="_blank" class="mobile-drawer__link">عرض الموقع</a>
                        <form method="POST" action="{{ route('admin.logout') }}" class="px-3 pt-2">
                            @csrf
                            <button type="submit" class="w-full py-3 rounded-xl bg-red-50 text-red-600 font-semibold text-sm">تسجيل الخروج</button>
                        </form>
                    </div>
                </div>
            </div>

            <main class="flex-1 p-4 lg:p-8 pb-6">
                @if (session('success'))
                    <div class="mb-6 px-4 py-3 rounded-xl bg-emerald-50 text-emerald-800 border border-emerald-200 text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 px-4 py-3 rounded-xl bg-red-50 text-red-800 border border-red-200 text-sm">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
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
</body>
</html>
