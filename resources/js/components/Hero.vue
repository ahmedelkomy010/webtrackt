<script setup>
import { computed } from 'vue';
import { useSite } from '../composables/useSite';

const { config, country, countryName, locale, t } = useSite();

const heroDescription = computed(() => {
    const descriptions = {
        ar: config.description,
        en: 'A company specialized in digital marketing, ERP systems, websites, and e-commerce stores.',
        ur: 'ڈیجیٹل مارکیٹنگ، ERP سسٹمز، ویب سائٹس اور ای کامرس میں مہارت رکھنے والی کمپنی۔',
    };
    return descriptions[locale.value] || config.description;
});
</script>

<template>
    <section class="relative pt-28 pb-20 lg:pt-36 lg:pb-32 overflow-hidden">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-20 start-1/4 w-72 h-72 bg-tract-400/20 rounded-full blur-3xl animate-float" />
            <div class="absolute bottom-10 end-1/4 w-96 h-96 bg-gold-500/10 rounded-full blur-3xl animate-float" style="animation-delay: -3s" />
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                <div class="fade-in-up text-center lg:text-start">
                    <!-- Specialty badge -->
                    <div class="inline-flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-gradient-to-r from-tract-600 to-tract-700 text-white text-sm font-semibold mb-6 shadow-lg shadow-tract-600/25">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                        {{ t('hero.specialty') }}
                    </div>

                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-slate-900 leading-tight mb-6">
                        {{ t('hero.headline') }}
                        <span class="text-gradient block sm:inline">{{ t('hero.headlineHighlight') }}</span>
                    </h1>

                    <p class="text-lg sm:text-xl text-slate-600 mb-6 leading-relaxed max-w-xl mx-auto lg:mx-0">
                        {{ heroDescription }}
                    </p>

                    <!-- Tagline block -->
                    <div class="mb-8 p-5 rounded-2xl bg-white/60 border border-slate-200/80 backdrop-blur-sm max-w-xl mx-auto lg:mx-0">
                        <p class="text-base sm:text-lg font-semibold text-slate-800 italic mb-1" dir="ltr">
                            "{{ config.tagline }}"
                        </p>
                        <p class="text-sm text-tract-700">{{ config.taglineAr }}</p>
                        <p class="mt-3 text-xs text-slate-500 flex items-center gap-2 justify-center lg:justify-start">
                            <span>{{ countryName }}</span>
                            <span class="text-slate-300">|</span>
                            <span>{{ country.currency.code }} ({{ country.currency.symbol }})</span>
                        </p>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a
                            href="#contact"
                            class="inline-flex items-center justify-center px-8 py-4 rounded-2xl bg-tract-600 text-white font-semibold hover:bg-tract-700 shadow-xl shadow-tract-600/30 transition-all hover:-translate-y-1"
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

                <div class="relative hidden sm:block">
                    <div class="relative mx-auto max-w-md lg:max-w-none">
                        <div class="absolute inset-0 bg-gradient-to-br from-tract-500/20 to-gold-500/20 rounded-3xl blur-2xl transform rotate-3" />
                        <div class="relative bg-white/80 backdrop-blur rounded-3xl shadow-2xl border border-white/50 p-8 space-y-5">
                            <div class="flex items-start gap-4 p-5 rounded-2xl bg-tract-50 border border-tract-200 ring-1 ring-tract-100">
                                <div class="w-12 h-12 rounded-xl bg-tract-600 flex items-center justify-center shrink-0">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                                </div>
                                <div>
                                    <p class="font-bold text-slate-900 mb-1">{{ t('hero.cardErpTitle') }}</p>
                                    <p class="text-sm text-tract-700 leading-relaxed">{{ t('hero.cardErpDesc') }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 p-4 rounded-2xl bg-slate-50 border border-slate-100">
                                <div class="w-12 h-12 rounded-xl bg-gold-500 flex items-center justify-center shrink-0">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" /></svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-slate-900">{{ t('hero.cardWebTitle') }}</p>
                                    <p class="text-sm text-slate-500">{{ t('hero.cardWebDesc') }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 p-4 rounded-2xl bg-slate-50 border border-slate-100">
                                <div class="w-12 h-12 rounded-xl bg-slate-800 flex items-center justify-center shrink-0">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-slate-900">{{ t('hero.cardMarketingTitle') }}</p>
                                    <p class="text-sm text-slate-500">{{ t('hero.cardMarketingDesc') }}</p>
                                </div>
                            </div>
                            <div class="pt-4 border-t border-slate-100">
                                <p class="text-center text-sm font-medium text-tract-700" dir="ltr">{{ config.tagline }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
