<script setup>
import { computed } from 'vue';
import { useSite } from '../composables/useSite';
import { useContent, loc } from '../composables/useContent';
import { localizedPath } from '../utils/locale';
import { publicAsset } from '../utils/assets';

const { config, country, countryName, locale, countryCode, t, setLocale } = useSite();
const { content } = useContent();
const year = new Date().getFullYear();

const defaultLinks = computed(() => [
    { href: localizedPath('services', locale.value, countryCode.value), label: t('nav.services') },
    { href: localizedPath('about', locale.value, countryCode.value), label: t('nav.about') },
    { href: localizedPath('blog', locale.value, countryCode.value), label: t('nav.blog') },
    { href: localizedPath('works', locale.value, countryCode.value), label: t('nav.works') },
    { href: localizedPath('contact', locale.value, countryCode.value), label: t('nav.contact') },
    { href: localizedPath('privacy', locale.value, countryCode.value), label: locale.value === 'en' ? 'Privacy' : (locale.value === 'ur' ? 'رازداری' : 'الخصوصية') },
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
        return content.value.services.map((s) => ({
            title: loc(s.title, locale.value),
            href: s.slug ? localizedPath(`services/${s.slug}`, locale.value, countryCode.value) : null,
        }));
    }

    return [
        { title: t('services.erp.title'), href: null },
        { title: t('services.web.title'), href: null },
        { title: t('services.store.title'), href: null },
        { title: t('services.marketing.title'), href: null },
    ];
});

const logoPng = computed(() => publicAsset('images/logo.png'));

const languages = [
    { code: 'ar', label: 'العربية' },
    { code: 'en', label: 'English' },
    { code: 'ur', label: 'اردو' },
];
</script>

<template>
    <footer class="site-footer mt-auto">
        <div class="site-footer__inner max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="site-footer__grid">
                <div class="site-footer__brand">
                    <div class="site-footer__logo">
                        <img :src="logoPng" :alt="config.name" width="40" height="40" loading="lazy">
                        <div>
                            <span class="site-footer__name">{{ config.name }}</span>
                            <span class="site-footer__name-en">{{ config.nameEn }}</span>
                        </div>
                    </div>
                    <p class="site-footer__desc">{{ t('about.description') }}</p>
                    <p class="site-footer__tagline" dir="ltr">{{ config.tagline }}</p>
                </div>

                <div class="site-footer__col">
                    <h3 class="site-footer__title">{{ t('footer.quickLinks') }}</h3>
                    <ul class="site-footer__list">
                        <li v-for="link in links" :key="link.href">
                            <a :href="link.href">{{ link.label }}</a>
                        </li>
                    </ul>
                </div>

                <div class="site-footer__col">
                    <h3 class="site-footer__title">{{ t('footer.ourServices') }}</h3>
                    <ul class="site-footer__list">
                        <li v-for="service in serviceList" :key="service.title">
                            <a v-if="service.href" :href="service.href">{{ service.title }}</a>
                            <span v-else>{{ service.title }}</span>
                        </li>
                    </ul>
                </div>

                <div class="site-footer__col">
                    <h3 class="site-footer__title">{{ t('footer.companyInfo') }}</h3>
                    <ul class="site-footer__list">
                        <li>
                            <a :href="config.website" target="_blank" rel="noopener" dir="ltr">{{ config.website?.replace('https://', '') }}</a>
                        </li>
                        <li>{{ countryName }}</li>
                        <li dir="ltr">{{ country.currency.code }} ({{ country.currency.symbol }})</li>
                        <li>{{ t('footer.registered') }}</li>
                        <li>{{ t('footer.taxCard') }}</li>
                        <li dir="ltr"><a :href="`mailto:${country.email}`">{{ country.email }}</a></li>
                        <li dir="ltr"><a :href="`tel:${country.phone}`">{{ country.phone }}</a></li>
                    </ul>
                </div>
            </div>

            <div class="site-footer__bar">
                <p class="site-footer__copy">&copy; {{ year }} {{ config.name }} — {{ config.nameEn }}. {{ t('footer.rights') }}</p>
                <p class="site-footer__motto" dir="ltr">{{ config.tagline }}</p>
                <div class="site-footer__langs">
                    <button
                        v-for="lang in languages"
                        :key="lang.code"
                        type="button"
                        :class="{ 'is-active': locale === lang.code }"
                        @click="setLocale(lang.code)"
                    >
                        {{ lang.label }}
                    </button>
                </div>
            </div>
        </div>
    </footer>
</template>
