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
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-10 mb-12">
            <div class="sm:col-span-2 lg:col-span-1">
                <div class="flex items-center gap-3 mb-4">
                    <img src="{{ asset('images/logo.png') }}" alt="{{ config('tract.name') }}" width="40" height="40" class="h-10 w-10 object-contain" loading="lazy">
                    <div>
                        <span class="block font-bold text-white">{{ config('tract.name') }}</span>
                        <span class="block text-xs text-tract-300">{{ config('tract.name_en') }}</span>
                    </div>
                </div>
                <p class="text-sm leading-relaxed mb-4 text-slate-300 font-semibold">{{ $aboutExcerpt ?: PageCopy::about($loc)['description'] }}</p>
                <p class="text-sm font-bold text-gold-400 italic" dir="ltr">{{ config('tract.tagline') }}</p>
            </div>

            <div>
                <h3 class="font-bold text-white mb-4 text-base">{{ $labels['quickLinks'] }}</h3>
                <ul class="space-y-2">
                    @foreach ($navLinks as $link)
                        <li>
                            <a href="{{ $link['href'] }}" class="text-sm text-slate-300 font-semibold hover:text-tract-300 transition-colors">{{ $link['label'] }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div>
                <h3 class="font-bold text-white mb-4 text-base">{{ $labels['ourServices'] }}</h3>
                <ul class="space-y-2 text-sm text-slate-300 font-semibold">
                    @forelse ($services as $service)
                        <li>
                            <a href="{{ Locale::path('services/'.$service->slug, $loc, $cty) }}" class="hover:text-tract-300 transition-colors">
                                {{ $service->localized('title', $loc) }}
                            </a>
                        </li>
                    @empty
                        <li>{{ $loc === 'en' ? 'ERP Systems' : 'أنظمة ERP' }}</li>
                        <li>{{ $loc === 'en' ? 'Websites' : 'المواقع الإلكترونية' }}</li>
                    @endforelse
                </ul>
            </div>

            <div>
                <h3 class="font-bold text-white mb-4 text-base">{{ $labels['companyInfo'] }}</h3>
                <ul class="space-y-2 text-sm text-slate-300 font-semibold">
                    <li><a href="{{ $website }}" target="_blank" rel="noopener" class="hover:text-tract-300 transition-colors" dir="ltr">{{ str_replace('https://', '', $website) }}</a></li>
                    <li>{{ $countryName }}</li>
                    <li dir="ltr">SAR (ر.س)</li>
                    <li>{{ $labels['registered'] }}</li>
                    <li>{{ $labels['taxCard'] }}</li>
                    <li dir="ltr">{{ $email }}</li>
                    <li dir="ltr">{{ $phone }}</li>
                </ul>
            </div>
        </div>

        <div class="site-footer__bar flex flex-col sm:flex-row items-center justify-between gap-4 text-sm">
            <p class="text-slate-400 font-semibold">&copy; {{ date('Y') }} {{ config('tract.name') }} — {{ config('tract.name_en') }}. {{ $labels['rights'] }}</p>
            <p class="text-tract-400 font-bold" dir="ltr">{{ config('tract.tagline') }}</p>
            <div class="flex gap-4">
                <a href="{{ Locale::switchUrl(request(), Locale::AR) }}" class="hover:text-white font-semibold {{ $loc === 'ar' ? 'text-white' : 'text-slate-400' }}">العربية</a>
                <a href="{{ Locale::switchUrl(request(), Locale::EN) }}" class="hover:text-white font-semibold {{ $loc === 'en' ? 'text-white' : 'text-slate-400' }}">English</a>
                <a href="{{ Locale::switchUrl(request(), Locale::UR) }}" class="hover:text-white font-semibold {{ $loc === 'ur' ? 'text-white' : 'text-slate-400' }}">اردو</a>
            </div>
        </div>
    </div>
</footer>
