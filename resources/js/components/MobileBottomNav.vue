<script setup>
import { computed } from 'vue';
import { useSite } from '../composables/useSite';
import { localizedHome, localizedPath } from '../utils/locale';

const { locale, countryCode, t } = useSite();

const path = computed(() => window.location.pathname);

const tabs = computed(() => [
    {
        id: 'home',
        href: localizedHome(locale.value, countryCode.value),
        label: t('nav.home'),
        active: (() => {
            const p = path.value.replace(/\/$/, '') || '/';
            return ['/', '/en', '/or', '/ae', '/kw', '/bh', '/om', '/qa', '/eg'].includes(p)
                || /^\/(en|or)(\/(ae|kw|bh|om|qa|eg))?$/.test(p);
        })(),
        icon: 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
    },
    {
        id: 'services',
        href: localizedPath('services', locale.value, countryCode.value),
        label: t('nav.services'),
        active: path.value.includes('/services'),
        icon: 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10',
    },
    {
        id: 'blog',
        href: localizedPath('blog', locale.value, countryCode.value),
        label: t('nav.blog'),
        active: path.value.includes('/blog'),
        icon: 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z',
    },
    {
        id: 'contact',
        href: `${localizedHome(locale.value, countryCode.value)}#contact`,
        label: t('nav.contact'),
        active: false,
        icon: 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
    },
]);
</script>

<template>
    <nav class="mobile-bottom-nav lg:hidden" aria-label="Mobile navigation">
        <a
            v-for="tab in tabs"
            :key="tab.id"
            :href="tab.href"
            class="mobile-bottom-nav__item"
            :class="{ 'is-active': tab.active }"
        >
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="tab.icon" />
            </svg>
            <span>{{ tab.label }}</span>
        </a>
    </nav>
</template>
