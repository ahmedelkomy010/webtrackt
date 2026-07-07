<script setup>
import { ref, computed, onMounted, onUnmounted, watch } from 'vue';
import { useSite } from '../composables/useSite';
import { useContent, loc } from '../composables/useContent';
import { countryList } from '../data/countries';

const { config, locale, countryCode, countryName, t, setLocale, setCountry } = useSite();
const { content } = useContent();

const isScrolled = ref(false);
const mobileOpen = ref(false);
const countryOpen = ref(false);
const langOpen = ref(false);

const defaultLinks = computed(() => [
    { href: '#services', label: t('nav.services') },
    { href: '#about', label: t('nav.about') },
    { href: '#why-us', label: t('nav.whyUs') },
    { href: '#reviews', label: t('nav.reviews') },
    { href: '/blog', label: t('nav.blog'), external: false },
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

const languages = [
    { code: 'ar', label: 'العربية' },
    { code: 'en', label: 'English' },
    { code: 'ur', label: 'اردو' },
];

const currentLang = computed(() => languages.find((l) => l.code === locale.value)?.label || 'العربية');

const currentCountry = computed(() => countryList.find((c) => c.code === countryCode.value));

const handleScroll = () => {
    isScrolled.value = window.scrollY > 20;
};

const closeDropdowns = () => {
    countryOpen.value = false;
    langOpen.value = false;
};

const selectCountry = (code) => {
    setCountry(code);
    countryOpen.value = false;
};

const selectLang = (code) => {
    setLocale(code);
    langOpen.value = false;
};

const closeMobile = () => {
    mobileOpen.value = false;
};

watch(mobileOpen, (open) => {
    document.body.classList.toggle('mobile-menu-open', open);
});

onMounted(() => {
    window.addEventListener('scroll', handleScroll);
    document.addEventListener('click', closeDropdowns);
});

onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll);
    document.removeEventListener('click', closeDropdowns);
    document.body.classList.remove('mobile-menu-open');
});
</script>

<template>
    <header
        :class="[
            'fixed top-0 inset-x-0 z-50 transition-all duration-300 safe-top',
            isScrolled ? 'glass shadow-sm border-b border-emerald-100/50' : 'bg-transparent',
        ]"
    >
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-14 sm:h-16 lg:h-20 gap-2">
                <a href="#" class="flex items-center gap-2.5 group shrink-0 min-w-0">
                    <picture>
                        <source srcset="/images/logo.webp" type="image/webp">
                        <img
                            src="/images/logo.png"
                            :alt="config.name"
                            width="48"
                            height="48"
                            fetchpriority="high"
                            class="h-9 w-9 sm:h-10 sm:w-10 lg:h-12 lg:w-12 object-contain group-hover:scale-105 transition-transform drop-shadow-md shrink-0"
                        />
                    </picture>
                    <div class="min-w-0">
                        <span class="block font-bold text-sm sm:text-lg text-slate-900 truncate">{{ config.name }}</span>
                        <span class="block text-[10px] sm:text-xs text-tract-600 font-medium tracking-wide truncate">{{ config.nameEn }}</span>
                    </div>
                </a>

                <div class="hidden lg:flex items-center gap-6">
                    <a
                        v-for="link in links"
                        :key="link.href"
                        :href="link.href"
                        class="text-sm font-medium text-slate-600 hover:text-tract-700 transition-colors"
                    >
                        {{ link.label }}
                    </a>
                </div>

                <div class="flex items-center gap-2 sm:gap-3">
                    <!-- Country selector -->
                    <div class="relative" @click.stop>
                        <button
                            type="button"
                            :aria-label="`${t('nav.country')}: ${countryName}`"
                            :aria-expanded="countryOpen"
                            aria-haspopup="listbox"
                            class="flex items-center gap-1.5 px-3 py-2 rounded-xl text-sm font-medium text-slate-600 hover:bg-slate-100 border border-slate-200/80 transition-colors"
                            @click="countryOpen = !countryOpen; langOpen = false"
                        >
                            <img :src="currentCountry?.flagImg" :alt="countryName" width="20" height="15" class="w-5 h-4 object-cover rounded shrink-0" aria-hidden="true" loading="lazy">
                            <span class="hidden sm:inline max-w-[80px] truncate">{{ countryName }}</span>
                            <svg class="w-4 h-4 shrink-0" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </button>
                        <div
                            v-show="countryOpen"
                            class="absolute top-full mt-2 end-0 w-56 py-2 bg-white rounded-2xl shadow-xl border border-slate-100 z-50 max-h-72 overflow-y-auto"
                        >
                            <button
                                v-for="c in countryList"
                                :key="c.code"
                                type="button"
                                role="option"
                                :aria-selected="countryCode === c.code"
                                :aria-label="c.location[locale] || c.location.ar"
                                class="w-full flex items-center gap-3 px-4 py-2.5 text-sm hover:bg-tract-50 transition-colors"
                                :class="countryCode === c.code ? 'text-tract-700 font-semibold bg-tract-50/50' : 'text-slate-700'"
                                @click="selectCountry(c.code)"
                            >
                                <img :src="c.flagImg" :alt="c.location[locale] || c.location.ar" width="20" height="15" class="w-5 h-4 object-cover rounded shrink-0" loading="lazy" aria-hidden="true">
                                <span>{{ c.location[locale] || c.location.ar }}</span>
                                <span class="ms-auto text-xs text-slate-400">{{ c.currency.code }}</span>
                            </button>
                        </div>
                    </div>

                    <!-- Language selector -->
                    <div class="relative" @click.stop>
                        <button
                            type="button"
                            :aria-label="`${t('nav.language')}: ${currentLang}`"
                            :aria-expanded="langOpen"
                            aria-haspopup="listbox"
                            class="flex items-center gap-1.5 px-3 py-2 rounded-xl text-sm font-medium text-slate-600 hover:bg-slate-100 border border-slate-200/80 transition-colors"
                            @click="langOpen = !langOpen; countryOpen = false"
                        >
                            <svg class="w-4 h-4" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129" /></svg>
                            <span class="hidden sm:inline">{{ currentLang }}</span>
                            <svg class="w-4 h-4 shrink-0" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </button>
                        <div
                            v-show="langOpen"
                            class="absolute top-full mt-2 end-0 w-40 py-2 bg-white rounded-2xl shadow-xl border border-slate-100 z-50"
                        >
                            <button
                                v-for="lang in languages"
                                :key="lang.code"
                                type="button"
                                class="w-full px-4 py-2.5 text-sm text-start hover:bg-tract-50 transition-colors"
                                :class="locale === lang.code ? 'text-tract-700 font-semibold bg-tract-50/50' : 'text-slate-700'"
                                @click="selectLang(lang.code)"
                            >
                                {{ lang.label }}
                            </button>
                        </div>
                    </div>

                    <a
                        href="#contact"
                        class="hidden lg:inline-flex items-center px-5 py-2.5 rounded-xl bg-tract-700 text-white text-sm font-semibold hover:bg-tract-800 shadow-lg shadow-tract-700/25 transition-all hover:-translate-y-0.5"
                    >
                        {{ t('nav.startProject') }}
                    </a>

                    <button
                        class="lg:hidden touch-target p-2 rounded-xl text-slate-600 hover:bg-slate-100"
                        :aria-label="t('nav.menu')"
                        @click="mobileOpen = !mobileOpen"
                    >
                        <svg v-if="!mobileOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg v-else class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </nav>

        <!-- Full-screen mobile drawer -->
        <div v-show="mobileOpen" class="mobile-drawer lg:hidden">
            <div class="mobile-drawer__backdrop" @click="closeMobile" />
            <div class="mobile-drawer__panel safe-bottom">
                <div class="p-4 border-b border-slate-100 flex items-center justify-between">
                    <p class="font-bold text-slate-900">{{ t('nav.menu') }}</p>
                    <button type="button" class="touch-target p-2 rounded-xl hover:bg-slate-100" @click="closeMobile">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
                <div class="p-3 space-y-1">
                    <a
                        v-for="link in links"
                        :key="link.href"
                        :href="link.href"
                        class="mobile-drawer__link"
                        @click="closeMobile"
                    >
                        {{ link.label }}
                    </a>
                    <a href="#contact" class="mobile-drawer__link text-tract-700" @click="closeMobile">{{ t('nav.startProject') }}</a>
                </div>
                <div class="p-4 border-t border-slate-100 space-y-3">
                    <p class="text-xs font-semibold text-slate-500 px-1">{{ t('nav.country') }}</p>
                    <div class="grid grid-cols-2 gap-2">
                        <button
                            v-for="c in countryList"
                            :key="c.code"
                            type="button"
                            class="flex items-center gap-2 p-3 rounded-xl border text-sm font-medium transition-colors"
                            :class="countryCode === c.code ? 'border-tract-300 bg-tract-50 text-tract-700' : 'border-slate-200 text-slate-700'"
                            @click="selectCountry(c.code)"
                        >
                            <img :src="c.flagImg" :alt="c.location[locale] || c.location.ar" width="24" height="18" class="w-6 h-4 object-cover rounded shrink-0" loading="lazy" aria-hidden="true">
                            <span class="truncate">{{ c.location[locale] || c.location.ar }}</span>
                        </button>
                    </div>
                    <p class="text-xs font-semibold text-slate-500 px-1 pt-2">{{ t('nav.language') }}</p>
                    <div class="grid grid-cols-3 gap-2">
                        <button
                            v-for="lang in languages"
                            :key="lang.code"
                            type="button"
                            class="py-3 rounded-xl text-sm font-semibold transition-colors"
                            :class="locale === lang.code ? 'bg-tract-600 text-white' : 'bg-slate-100 text-slate-700'"
                            @click="selectLang(lang.code)"
                        >
                            {{ lang.label }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </header>
</template>
