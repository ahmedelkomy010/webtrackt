@php
    use App\Models\Service;
    use App\Services\ContactSettingsService;
    use App\Services\PageContentService;
    use App\Support\Locale;
    use App\Support\PageCopy;
    use App\Support\SiteUrl;

    $loc = $locale ?? Locale::AR;
    $cty = $country ?? SiteUrl::DEFAULT_COUNTRY;
    $contact = app(ContactSettingsService::class)->all();
    $aboutBody = PageCopy::localized(app(PageContentService::class)->page('about'), 'body', $loc);
    $aboutExcerpt = \Illuminate\Support\Str::limit(strip_tags($aboutBody), 160);

    $labels = match ($loc) {
        'en' => [
            'quickLinks' => 'Quick links',
            'ourServices' => 'Our services',
            'companyInfo' => 'Company info',
            'registered' => 'Registered company',
            'taxCard' => 'Tax registration',
            'rights' => 'All rights reserved.',
            'privacy' => 'Privacy',
        ],
        'ur' => [
            'quickLinks' => 'فوری لنکس',
            'ourServices' => 'ہماری خدمات',
            'companyInfo' => 'کمپنی کی معلومات',
            'registered' => 'رجسٹرڈ کمپنی',
            'taxCard' => 'ٹیکس رجسٹریشن',
            'rights' => 'جملہ حقوق محفوظ ہیں۔',
            'privacy' => 'رازداری',
        ],
        default => [
            'quickLinks' => 'روابط سريعة',
            'ourServices' => 'خدماتنا',
            'companyInfo' => 'معلومات الشركة',
            'registered' => 'شركة مسجلة — سجل تجاري',
            'taxCard' => 'بطاقة ضريبية',
            'rights' => 'جميع الحقوق محفوظة.',
            'privacy' => 'الخصوصية',
        ],
    };

    $navLinks = [
        ['href' => Locale::path('services', $loc, $cty), 'label' => $loc === 'en' ? 'Services' : ($loc === 'ur' ? 'خدمات' : 'خدماتنا')],
        ['href' => Locale::path('about', $loc, $cty), 'label' => $loc === 'en' ? 'About us' : ($loc === 'ur' ? 'ہمارے بارے' : 'من نحن')],
        ['href' => Locale::path('blog', $loc, $cty), 'label' => $loc === 'en' ? 'Blog' : ($loc === 'ur' ? 'بلاگ' : 'المدونة')],
        ['href' => Locale::path('contact', $loc, $cty), 'label' => $loc === 'en' ? 'Contact' : ($loc === 'ur' ? 'رابطہ' : 'تواصل معنا')],
        ['href' => Locale::path('privacy', $loc, $cty), 'label' => $labels['privacy']],
    ];

    $services = Service::where('is_active', true)->orderBy('sort_order')->get();
    $email = $contact['email'] ?? config('tract.email');
    $phone = $contact['phone_intl'] ?? config('tract.phone_intl');
    $website = rtrim(config('tract.website'), '/');
    $countryName = config('tract.location');
@endphp

<footer class="site-footer mt-auto">
    <div class="site-footer__inner max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="site-footer__grid">
            <div class="site-footer__brand">
                <div class="site-footer__logo">
                    <img src="{{ asset('images/logo.png') }}" alt="{{ config('tract.name') }}" width="40" height="40" loading="lazy">
                    <div>
                        <span class="site-footer__name">{{ config('tract.name') }}</span>
                        <span class="site-footer__name-en">{{ config('tract.name_en') }}</span>
                    </div>
                </div>
                <p class="site-footer__desc">{{ $aboutExcerpt ?: PageCopy::about($loc)['description'] }}</p>
                <p class="site-footer__tagline" dir="ltr">{{ config('tract.tagline') }}</p>
            </div>

            <div class="site-footer__col">
                <h3 class="site-footer__title">{{ $labels['quickLinks'] }}</h3>
                <ul class="site-footer__list">
                    @foreach ($navLinks as $link)
                        <li><a href="{{ $link['href'] }}">{{ $link['label'] }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div class="site-footer__col">
                <h3 class="site-footer__title">{{ $labels['ourServices'] }}</h3>
                <ul class="site-footer__list">
                    @forelse ($services as $service)
                        <li><a href="{{ Locale::path('services/'.$service->slug, $loc, $cty) }}">{{ $service->localized('title', $loc) }}</a></li>
                    @empty
                        <li>{{ $loc === 'en' ? 'ERP Systems' : 'أنظمة ERP' }}</li>
                        <li>{{ $loc === 'en' ? 'Websites' : 'المواقع الإلكترونية' }}</li>
                    @endforelse
                </ul>
            </div>

            <div class="site-footer__col">
                <h3 class="site-footer__title">{{ $labels['companyInfo'] }}</h3>
                <ul class="site-footer__list">
                    <li><a href="{{ $website }}" target="_blank" rel="noopener" dir="ltr">{{ str_replace('https://', '', $website) }}</a></li>
                    <li>{{ $countryName }}</li>
                    <li dir="ltr">SAR (ر.س)</li>
                    <li>{{ $labels['registered'] }}</li>
                    <li>{{ $labels['taxCard'] }}</li>
                    <li dir="ltr"><a href="mailto:{{ $email }}">{{ $email }}</a></li>
                    <li dir="ltr"><a href="tel:{{ $phone }}">{{ $phone }}</a></li>
                </ul>
            </div>
        </div>

        <div class="site-footer__bar">
            <p class="site-footer__copy">&copy; {{ date('Y') }} {{ config('tract.name') }} — {{ config('tract.name_en') }}. {{ $labels['rights'] }}</p>
            <p class="site-footer__motto" dir="ltr">{{ config('tract.tagline') }}</p>
            <div class="site-footer__langs">
                <a href="{{ Locale::switchUrl(request(), Locale::AR) }}" class="{{ $loc === 'ar' ? 'is-active' : '' }}">العربية</a>
                <a href="{{ Locale::switchUrl(request(), Locale::EN) }}" class="{{ $loc === 'en' ? 'is-active' : '' }}">English</a>
                <a href="{{ Locale::switchUrl(request(), Locale::UR) }}" class="{{ $loc === 'ur' ? 'is-active' : '' }}">اردو</a>
            </div>
        </div>
    </div>
</footer>
