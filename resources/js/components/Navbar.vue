<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
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

onMounted(() => {
    window.addEventListener('scroll', handleScroll);
    document.addEventListener('click', closeDropdowns);
});

onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll);
    document.removeEventListener('click', closeDropdowns);
});
</script>

<template>
    <header
        :class="[
            'fixed top-0 inset-x-0 z-50 transition-all duration-300',
            isScrolled ? 'glass shadow-sm border-b border-emerald-100/50' : 'bg-transparent',
        ]"
    >
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 lg:h-20 gap-3">
                <a href="#" class="flex items-center gap-3 group shrink-0">
                    <img
                        src="/images/logo.png"
                        :alt="config.name"
                        class="h-10 w-10 lg:h-12 lg:w-12 object-contain group-hover:scale-105 transition-transform drop-shadow-md"
                    />
                    <div class="hidden sm:block">
                        <span class="block font-bold text-lg text-slate-900">{{ config.name }}</span>
                        <span class="block text-xs text-tract-600 font-medium tracking-wide">{{ config.nameEn }}</span>
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
                            class="flex items-center gap-1.5 px-3 py-2 rounded-xl text-sm font-medium text-slate-600 hover:bg-slate-100 border border-slate-200/80 transition-colors"
                            @click="countryOpen = !countryOpen; langOpen = false"
                        >
                            <span class="text-base">{{ currentCountry?.flag }}</span>
                            <span class="hidden sm:inline max-w-[80px] truncate">{{ countryName }}</span>
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </button>
                        <div
                            v-show="countryOpen"
                            class="absolute top-full mt-2 end-0 w-56 py-2 bg-white rounded-2xl shadow-xl border border-slate-100 z-50 max-h-72 overflow-y-auto"
                        >
                            <button
                                v-for="c in countryList"
                                :key="c.code"
                                type="button"
                                class="w-full flex items-center gap-3 px-4 py-2.5 text-sm hover:bg-tract-50 transition-colors"
                                :class="countryCode === c.code ? 'text-tract-700 font-semibold bg-tract-50/50' : 'text-slate-700'"
                                @click="selectCountry(c.code)"
                            >
                                <span class="text-lg">{{ c.flag }}</span>
                                <span>{{ c.location[locale] || c.location.ar }}</span>
                                <span class="ms-auto text-xs text-slate-400">{{ c.currency.code }}</span>
                            </button>
                        </div>
                    </div>

                    <!-- Language selector -->
                    <div class="relative" @click.stop>
                        <button
                            type="button"
                            class="flex items-center gap-1.5 px-3 py-2 rounded-xl text-sm font-medium text-slate-600 hover:bg-slate-100 border border-slate-200/80 transition-colors"
                            @click="langOpen = !langOpen; countryOpen = false"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129" /></svg>
                            <span class="hidden sm:inline">{{ currentLang }}</span>
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
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
                        class="hidden lg:inline-flex items-center px-5 py-2.5 rounded-xl bg-tract-600 text-white text-sm font-semibold hover:bg-tract-700 shadow-lg shadow-tract-600/25 transition-all hover:-translate-y-0.5"
                    >
                        {{ t('nav.startProject') }}
                    </a>

                    <button
                        class="lg:hidden p-2 rounded-lg text-slate-600 hover:bg-slate-100"
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

            <div
                v-show="mobileOpen"
                class="lg:hidden pb-4 border-t border-slate-100 mt-2 pt-4 space-y-2"
            >
                <a
                    v-for="link in links"
                    :key="link.href"
                    :href="link.href"
                    class="block px-4 py-3 rounded-xl text-slate-700 hover:bg-tract-50 hover:text-tract-700 font-medium"
                    @click="closeMobile"
                >
                    {{ link.label }}
                </a>
                <a
                    href="#contact"
                    class="block mx-4 mt-2 text-center px-5 py-3 rounded-xl bg-tract-600 text-white font-semibold"
                    @click="closeMobile"
                >
                    {{ t('nav.startProject') }}
                </a>
            </div>
        </nav>
    </header>
</template>
