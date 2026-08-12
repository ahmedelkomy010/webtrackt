<script setup>
import { computed } from 'vue';
import { useSite } from '../composables/useSite';
import { useContent } from '../composables/useContent';
import { storageUrl } from '../utils/storage';

const { config, country, countryName, t } = useSite();
const { content } = useContent();

const currencyLabel = computed(() => `${country.value.currency.code} (${country.value.currency.symbol})`);

const aboutImages = computed(() => content.value?.about ?? config.about ?? {});

const aboutImage = computed(() => storageUrl(
    aboutImages.value.about_image
    || aboutImages.value.middle_image
    || aboutImages.value.marketing_image
));
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

                <div class="rounded-2xl bg-white/5 overflow-hidden relative min-h-[400px]">
                    <img
                        v-if="aboutImage"
                        :src="aboutImage"
                        alt=""
                        class="w-full h-full min-h-[400px] object-cover"
                    >
                    <div
                        v-else
                        class="flex flex-col items-center justify-center min-h-[400px] p-8 text-center border-2 border-dashed border-white/20 rounded-2xl m-3"
                    >
                        <svg class="w-12 h-12 text-slate-500 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <p class="text-slate-400 text-sm">صورة — ارفعها من لوحة التحكم</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
