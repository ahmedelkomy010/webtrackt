<script setup>
import { computed } from 'vue';
import { useSite } from '../composables/useSite';
import { useContent, loc } from '../composables/useContent';
import { storageUrl } from '../utils/storage';

const { locale, t } = useSite();
const { content } = useContent();

const partners = computed(() => {
    if (!content.value?.partners?.length) return [];

    return content.value.partners.map((partner) => ({
        id: partner.id,
        logoUrl: storageUrl(partner.logo),
        name: loc(partner.name, locale.value),
        url: partner.url,
    }));
});
</script>

<template>
    <section v-if="partners.length" id="partners" class="py-16 lg:py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-12 lg:mb-16">
                <span class="inline-block px-4 py-1.5 rounded-full bg-tract-50 text-tract-700 text-sm font-semibold mb-4">{{ t('partners.badge') }}</span>
                <h2 class="text-3xl sm:text-4xl font-bold text-slate-900 mb-4">{{ t('partners.title') }}</h2>
                <p class="text-lg text-slate-600">{{ t('partners.subtitle') }}</p>
            </div>

            <div class="partners-grid">
                <component
                    :is="partner.url ? 'a' : 'div'"
                    v-for="partner in partners"
                    :key="partner.id"
                    :href="partner.url || undefined"
                    :target="partner.url ? '_blank' : undefined"
                    :rel="partner.url ? 'noopener noreferrer' : undefined"
                    class="partners-grid__item group"
                    :aria-label="partner.name || t('partners.logoAlt')"
                >
                    <img
                        :src="partner.logoUrl"
                        :alt="partner.name || t('partners.logoAlt')"
                        loading="lazy"
                        class="partners-grid__logo"
                    >
                </component>
            </div>
        </div>
    </section>
</template>
