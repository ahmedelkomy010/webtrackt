<script setup>
import { computed } from 'vue';
import { useSite } from '../composables/useSite';
import { useContent, loc } from '../composables/useContent';

const { config, locale, t } = useSite();
const { content } = useContent();

const staticReasons = computed(() => [
    { title: t('whyUs.local.title'), description: t('whyUs.local.description') },
    { title: t('whyUs.track.title'), description: t('whyUs.track.description') },
    { title: t('whyUs.results.title'), description: t('whyUs.results.description') },
    { title: t('whyUs.support.title'), description: t('whyUs.support.description') },
    { title: t('whyUs.tech.title'), description: t('whyUs.tech.description') },
    { title: t('whyUs.trust.title'), description: t('whyUs.trust.description') },
]);

const reasons = computed(() => {
    if (content.value?.whyUs?.length) {
        return content.value.whyUs.map((item) => ({
            title: loc(item.title, locale.value),
            description: loc(item.description, locale.value),
        }));
    }

    return staticReasons.value;
});
</script>

<template>
    <section id="why-us" class="py-20 lg:py-28">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="inline-block px-4 py-1.5 rounded-full bg-gold-500/10 text-gold-600 text-sm font-semibold mb-4">{{ t('whyUs.badge') }}</span>
                <h2 class="text-3xl sm:text-4xl font-bold text-slate-900 mb-4">{{ t('whyUs.title') }}</h2>
                <p class="text-lg text-slate-600" dir="ltr">"{{ config.tagline }}"</p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                <div
                    v-for="reason in reasons"
                    :key="reason.title"
                    class="p-6 lg:p-8 rounded-2xl bg-white border border-slate-100 shadow-sm hover:shadow-lg hover:border-tract-200 transition-all"
                >
                    <div class="w-12 h-12 rounded-xl bg-tract-50 flex items-center justify-center mb-5">
                        <svg class="w-6 h-6 text-tract-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">{{ reason.title }}</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">{{ reason.description }}</p>
                </div>
            </div>
        </div>
    </section>
</template>
