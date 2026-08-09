@extends('layouts.site')

@php
    use App\Support\Locale;
    use App\Support\PageCopy;
    use App\Support\SiteUrl;

    $cty = $country ?? SiteUrl::DEFAULT_COUNTRY;
    $title = PageCopy::localized($page, 'title', $locale);
    $badge = PageCopy::localized($page, 'badge', $locale);
    $headline = PageCopy::localized($page, 'subtitle', $locale);
    $lead = strip_tags(PageCopy::localized($page, 'body', $locale));
@endphp

@section('title', $title)
@section('meta_description', strip_tags($lead))
@section('canonical', $siteUrl.Locale::path('works', $locale, $cty))

@section('content')
@include('partials.page-hero', [
    'locale' => $locale,
    'cty' => $cty,
    'pageTitle' => $title,
    'badge' => $badge,
    'headline' => $headline,
    'lead' => $lead,
])

<section class="py-12 lg:py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if ($works->isEmpty())
            <div class="text-center py-16 px-6 rounded-2xl border border-dashed border-slate-200 bg-slate-50">
                <p class="text-slate-600 text-lg font-semibold mb-2">{{ $locale === 'en' ? 'No projects yet.' : ($locale === 'ur' ? 'ابھی کوئی منصوبہ نہیں۔' : 'لا توجد أعمال بعد.') }}</p>
                <p class="text-slate-500 text-sm">{{ $locale === 'en' ? 'Projects will appear here once added from the dashboard.' : ($locale === 'ur' ? 'ڈیش بورڈ سے منصوبے شامل کرنے کے بعد یہاں ظاہر ہوں گے۔' : 'ستظهر المشاريع هنا بعد إضافتها من لوحة التحكم.') }}</p>
            </div>
        @else
            <div class="works-grid">
                @foreach ($works as $work)
                    <a href="{{ $work->url }}" target="_blank" rel="noopener noreferrer" class="works-card group">
                        <div class="works-card__media">
                            <img src="{{ asset('storage/'.$work->image) }}" alt="{{ $work->localized('title', $locale) }}" loading="lazy" class="works-card__image">
                        </div>
                        <div class="works-card__body">
                            <h2 class="works-card__title">{{ $work->localized('title', $locale) }}</h2>
                            <p class="works-card__desc">{{ $work->localized('description', $locale) }}</p>
                            <span class="works-card__link">{{ $locale === 'en' ? 'View project →' : ($locale === 'ur' ? 'منصوبہ دیکھیں ←' : 'عرض المشروع ←') }}</span>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection
