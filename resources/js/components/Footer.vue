<script setup>
import { computed } from 'vue';
import { useSite } from '../composables/useSite';
import { useContent, loc } from '../composables/useContent';

const { config, country, countryName, locale, t } = useSite();
const { content } = useContent();
const year = new Date().getFullYear();

const defaultLinks = computed(() => [
    { href: '#services', label: t('nav.services') },
    { href: '#about', label: t('nav.about') },
    { href: '#why-us', label: t('nav.whyUs') },
    { href: '#contact', label: t('nav.contact') },
]);

const links = computed(() => {
    if (content.value?.navLinks?.length) {
        return content.value.navLinks.map((link) => ({
            href: link.href,
            label: loc(link.label, locale.value),
        }));
    }

    return defaultLinks.value;
});

const serviceList = computed(() => {
    if (content.value?.services?.length) {
        return content.value.services.map((s) => loc(s.title, locale.value));
    }

    return [
        t('services.erp.title'),
        t('services.web.title'),
        t('services.store.title'),
        t('services.marketing.title'),
    ];
});
</script>

<template>
    <footer class="bg-slate-900 text-slate-300 pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-10 mb-12">
                <div class="sm:col-span-2 lg:col-span-1">
                    <div class="flex items-center gap-3 mb-4">
                        <img src="/images/logo.png" :alt="config.name" width="40" height="40" loading="lazy" class="h-10 w-10 object-contain">
                        <div>
                            <span class="block font-bold text-white">{{ config.name }}</span>
                            <span class="block text-xs text-tract-400">{{ config.nameEn }}</span>
                        </div>
                    </div>
                    <p class="text-sm leading-relaxed mb-4">{{ t('about.description') }}</p>
                    <p class="text-sm font-medium text-gold-400 italic" dir="ltr">{{ config.tagline }}</p>
                </div>

                <div>
                    <h3 class="font-semibold text-white mb-4 text-base">{{ t('footer.quickLinks') }}</h3>
                    <ul class="space-y-2">
                        <li v-for="link in links" :key="link.href">
                            <a :href="link.href" class="text-sm hover:text-tract-400 transition-colors">{{ link.label }}</a>
                        </li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-semibold text-white mb-4 text-base">{{ t('footer.ourServices') }}</h3>
                    <ul class="space-y-2 text-sm">
                        <li v-for="service in serviceList" :key="service">{{ service }}</li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-semibold text-white mb-4 text-base">{{ t('footer.companyInfo') }}</h3>
                    <ul class="space-y-2 text-sm">
                        <li>
                            <a :href="config.website" target="_blank" rel="noopener" class="hover:text-tract-400 transition-colors" dir="ltr">{{ config.website?.replace('https://', '') }}</a>
                        </li>
                        <li>{{ countryName }}</li>
                        <li>{{ country.currency.code }} ({{ country.currency.symbol }})</li>
                        <li>{{ t('footer.registered') }}</li>
                        <li>{{ t('footer.taxCard') }}</li>
                        <li dir="ltr">{{ country.email }}</li>
                        <li dir="ltr">{{ country.phone }}</li>
                    </ul>
                </div>
            </div>

            <div class="pt-8 border-t border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-4 text-sm">
                <p>&copy; {{ year }} {{ config.name }} — {{ config.nameEn }}. {{ t('footer.rights') }}</p>
                <p class="text-tract-500 font-medium" dir="ltr">{{ config.tagline }}</p>
            </div>
        </div>
    </footer>
</template>
