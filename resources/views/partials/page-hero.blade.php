@php
    use App\Support\Locale;

    $loc = $locale ?? Locale::AR;
    $countryCode = $country ?? ($cty ?? \App\Support\SiteUrl::DEFAULT_COUNTRY);
    $homeLabel = $loc === 'en' ? 'Home' : ($loc === 'ur' ? 'ہوم' : 'الرئيسية');
@endphp

<section class="page-hero">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="page-hero__breadcrumb" aria-label="Breadcrumb">
            <a href="{{ Locale::home($loc, $countryCode) }}" class="hover:text-white">{{ $homeLabel }}</a>
            <span class="mx-2" aria-hidden="true">/</span>
            <span>{{ $pageTitle }}</span>
        </nav>

        @if (!empty($badge))
            <span class="page-hero__badge">{{ $badge }}</span>
        @endif

        <h1 class="page-hero__title">{{ $headline }}</h1>

        @if (!empty($lead))
            <p class="page-hero__lead">{{ $lead }}</p>
        @endif
    </div>
</section>
