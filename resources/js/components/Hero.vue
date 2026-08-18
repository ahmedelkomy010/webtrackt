<script setup>
import { computed } from 'vue';
import { useSite } from '../composables/useSite';
import { useContent } from '../composables/useContent';
import { localizedPath } from '../utils/locale';
import { storageUrl } from '../utils/storage';

const { config, country, countryName, locale, countryCode, t } = useSite();
const { content } = useContent();

const homePage = computed(() => content.value?.pages?.home ?? config.pages?.home ?? {});

const heroBadge = computed(() => homePage.value.hero_badge?.[locale.value] ?? t('hero.specialty'));
const heroHeadline = computed(() => homePage.value.hero_headline?.[locale.value] ?? t('hero.headline'));
const heroHeadlineHighlight = computed(() => homePage.value.hero_headline_highlight?.[locale.value] ?? t('hero.headlineHighlight'));
const heroDescription = computed(() => {
    const descriptions = {
        ar: config.description,
        en: 'A company specialized in digital marketing, ERP systems, websites, and e-commerce stores.',
        ur: 'ڈیجیٹل مارکیٹنگ، ERP سسٹمز، ویب سائٹس اور ای کامرس میں مہارت رکھنے والی کمپنی۔',
    };
    return descriptions[locale.value] || config.description;
});

const siteImages = computed(() => content.value?.about ?? config.about ?? {});
const heroSideImage = computed(() => storageUrl(siteImages.value.hero_side_image));
</script>

<template>
    <section class="relative pt-24 pb-16 sm:pt-28 sm:pb-20 lg:pt-36 lg:pb-32 overflow-hidden">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-20 start-1/4 w-72 h-72 bg-tract-300/18 rounded-full blur-3xl animate-float" />
            <div class="absolute bottom-10 end-1/4 w-96 h-96 bg-tract-400/10 rounded-full blur-3xl animate-float" style="animation-delay: -3s" />
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                <div class="fade-in-up text-center lg:text-start">
                    <!-- Specialty badge -->
                    <div class="inline-flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-gradient-to-r from-tract-600 to-tract-700 text-white text-sm font-semibold mb-4 shadow-lg shadow-tract-600/20">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                        {{ heroBadge }}
                    </div>

                    <!-- Selected country with flag -->
                    <div
                        class="inline-flex items-center gap-3 px-4 py-2.5 rounded-2xl bg-white border border-slate-200 shadow-sm mb-6 transition-all duration-300"
                        :key="country.code"
                    >
                        <img
                            :src="country.flagImg"
                            :alt="countryName"
                            width="32" height="24"
                            class="w-8 h-6 object-cover rounded shadow-sm shrink-0"
                            loading="lazy"
                        >
                        <div class="text-start">
                            <p class="text-xs text-slate-500">{{ t('nav.country') }}</p>
                            <p class="text-sm font-semibold text-slate-800">{{ countryName }}</p>
                        </div>
                    </div>

                    <h1 class="text-3xl sm:text-5xl lg:text-6xl font-bold text-slate-900 leading-tight mb-6">
                        {{ heroHeadline }}
                        <span class="text-gradient block sm:inline">{{ heroHeadlineHighlight }}</span>
                    </h1>

                    <p class="text-lg sm:text-xl text-slate-600 mb-6 leading-relaxed max-w-xl mx-auto lg:mx-0">
                        {{ heroDescription }}
                    </p>

                    <!-- Tagline block -->
                    <div class="mb-8 p-5 rounded-2xl bg-white/60 border border-slate-200/80 backdrop-blur-sm max-w-xl mx-auto lg:mx-0">
                        <p class="text-base sm:text-lg font-semibold text-slate-800 italic mb-1" dir="ltr">
                            "{{ config.tagline }}"
                        </p>
                        <p class="text-sm text-tract-500">{{ config.taglineAr }}</p>
                        <p class="mt-3 text-xs text-slate-500 flex items-center gap-2 justify-center lg:justify-start">
                            <img :src="country.flagImg" :alt="countryName" width="20" height="15" class="w-5 h-4 object-cover rounded shrink-0" loading="lazy">
                            <span>{{ countryName }}</span>
                            <span class="text-slate-300">|</span>
                            <span>{{ country.currency.code }} ({{ country.currency.symbol }})</span>
                        </p>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a
                            :href="localizedPath('contact', locale, countryCode)"
                            class="inline-flex items-center justify-center px-8 py-4 rounded-2xl bg-tract-600 text-white font-semibold hover:bg-tract-700 shadow-xl shadow-tract-600/20 transition-all hover:-translate-y-1"
                        >
                            {{ t('hero.ctaPrimary') }}
                        </a>
                        <a
                            href="#services"
                            class="inline-flex items-center justify-center px-8 py-4 rounded-2xl bg-white border-2 border-slate-200 text-slate-700 font-semibold hover:border-tract-300 hover:text-tract-700 transition-all"
                        >
                            {{ t('hero.ctaSecondary') }}
                        </a>
                    </div>

                    <div class="flex flex-wrap gap-6 mt-10 justify-center lg:justify-start text-sm text-slate-500">
                        <span class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-tract-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                            {{ t('hero.trustCommercial') }}
                        </span>
                        <span class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-tract-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                            {{ t('hero.trustTax') }}
                        </span>
                        <span class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-tract-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                            {{ t('hero.trustSupport') }}
                        </span>
                    </div>
                </div>

                <div class="relative mt-8 lg:mt-0 w-full">
                    <div class="relative mx-auto w-full max-w-xl sm:max-w-2xl lg:max-w-none">
                        <div class="absolute inset-0 bg-gradient-to-br from-tract-500/15 to-tract-300/8 rounded-3xl blur-2xl transform rotate-3 pointer-events-none" />
                        <img
                            v-if="heroSideImage"
                            :src="heroSideImage"
                            alt="Trackkt"
                            class="relative w-full h-auto max-w-full object-contain"
                            loading="eager"
                            fetchpriority="high"
                        >
                        <div
                            v-else
                            class="relative flex flex-col items-center justify-center min-h-[280px] sm:min-h-[360px] p-8 text-center border-2 border-dashed border-slate-300 rounded-2xl"
                        >
                            <svg class="w-12 h-12 text-slate-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="text-slate-500 text-sm">صورة Hero — ارفعها من لوحة التحكم</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
