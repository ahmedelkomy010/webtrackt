<script setup>
import { computed } from 'vue';
import { useSite } from '../composables/useSite';

const { config, country, countryName, t } = useSite();

const currencyLabel = computed(() => `${country.value.currency.code} (${country.value.currency.symbol})`);
</script>

<template>
    <section id="about" class="py-20 lg:py-28 bg-slate-900 text-white relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 end-0 w-96 h-96 bg-tract-500 rounded-full blur-3xl" />
            <div class="absolute bottom-0 start-0 w-96 h-96 bg-gold-500 rounded-full blur-3xl" />
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center">
                <div>
                    <span class="inline-block px-4 py-1.5 rounded-full bg-tract-600/20 text-tract-300 text-sm font-semibold mb-4 border border-tract-500/30">{{ t('about.badge') }}</span>
                    <h2 class="text-3xl sm:text-4xl font-bold mb-6">
                        <span class="text-tract-400">{{ config.name }}</span> — {{ t('about.title') }} {{ countryName }}
                    </h2>
                    <p class="text-slate-300 text-lg leading-relaxed mb-6">
                        {{ t('about.description') }}
                    </p>
                    <p class="text-slate-400 leading-relaxed mb-8" dir="ltr">
                        <span class="text-gold-400 font-semibold">{{ config.tagline }}</span>
                    </p>

                    <div class="grid sm:grid-cols-3 gap-4">
                        <div class="p-5 rounded-2xl bg-white/5 border border-white/10">
                            <p class="text-tract-400 text-sm mb-1">{{ t('about.location') }}</p>
                            <p class="font-semibold text-sm">{{ countryName }}</p>
                        </div>
                        <div class="p-5 rounded-2xl bg-white/5 border border-white/10">
                            <p class="text-tract-400 text-sm mb-1">{{ t('about.currency') }}</p>
                            <p class="font-semibold text-sm">{{ currencyLabel }}</p>
                        </div>
                        <div class="p-5 rounded-2xl bg-white/5 border border-white/10">
                            <p class="text-tract-400 text-sm mb-1">{{ t('about.legalStatus') }}</p>
                            <p class="font-semibold text-sm">{{ t('about.legalValue') }}</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="p-6 rounded-2xl bg-gradient-to-br from-tract-600 to-tract-800 col-span-2">
                        <p class="text-4xl font-bold mb-2">360°</p>
                        <p class="text-tract-100">{{ t('about.fullSolutions') }}</p>
                    </div>
                    <div class="p-6 rounded-2xl bg-white/5 border border-white/10">
                        <p class="text-2xl font-bold text-gold-400 mb-1">ERP</p>
                        <p class="text-sm text-slate-400">{{ t('about.erpLabel') }}</p>
                    </div>
                    <div class="p-6 rounded-2xl bg-white/5 border border-white/10">
                        <p class="text-2xl font-bold text-tract-400 mb-1">Web</p>
                        <p class="text-sm text-slate-400">{{ t('about.webLabel') }}</p>
                    </div>
                    <div class="p-6 rounded-2xl bg-white/5 border border-white/10 col-span-2">
                        <p class="text-2xl font-bold text-white mb-1">Marketing</p>
                        <p class="text-sm text-slate-400">{{ t('about.marketingLabel') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
