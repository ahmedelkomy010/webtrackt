import { ref, computed, watch } from 'vue';
import { translate } from '../i18n';
import { countries, defaultCountry } from '../data/countries';
import { parsePath, switchCountryUrl, switchLocaleUrl } from '../utils/locale';

function readContextFromPage() {
    const fromPath = parsePath();
    return {
        locale: fromPath.locale || window.__TRACT__?.locale || 'ar',
        country: fromPath.country || window.__TRACT__?.country || defaultCountry,
    };
}

const initial = readContextFromPage();
const locale = ref(initial.locale);
const countryCode = ref(initial.country);

localStorage.setItem('tract_locale', locale.value);
localStorage.setItem('tract_country', countryCode.value);

const htmlLangMap = { ar: 'ar-SA', en: 'en', ur: 'ur' };

function applyDocumentAttributes() {
    document.documentElement.lang = htmlLangMap[locale.value] || locale.value;
    document.documentElement.dir = locale.value === 'en' ? 'ltr' : 'rtl';
}

watch(locale, (value) => {
    localStorage.setItem('tract_locale', value);
    applyDocumentAttributes();
}, { immediate: true });

watch(countryCode, (value) => {
    localStorage.setItem('tract_country', value);
});

function navigateIfDifferent(target) {
    const current = window.location.pathname + window.location.search + window.location.hash;
    if (target !== current) {
        window.location.assign(target);
    }
}

export function useSite() {
    const config = window.__TRACT__ ?? {
        name: 'تراكت',
        nameEn: 'Trackkt',
        tagline: 'Track Every Step. Control Every Result.',
        taglineAr: 'تابع كل خطوة. تحكم في كل نتيجة.',
        description: '',
        website: '/',
        email: '',
        phone: '',
        phoneLocal: '',
        whatsapp: '',
        csrfToken: '',
        basePath: '',
        storageUrl: '/storage',
        about: {},
        pages: {},
    };

    const country = computed(() => countries[countryCode.value] || countries[defaultCountry]);

    const isRtl = computed(() => locale.value !== 'en');

    const t = (key) => translate(locale.value, key);

    const countryName = computed(() => country.value.location[locale.value] || country.value.location.ar);

    const phonePlaceholder = computed(() => {
        const ph = country.value.phonePlaceholder;
        return ph[locale.value] || ph.ar;
    });

    const setLocale = (value) => {
        navigateIfDifferent(switchLocaleUrl(value));
    };

    const setCountry = (value) => {
        navigateIfDifferent(switchCountryUrl(value));
    };

    return {
        config,
        locale,
        countryCode,
        country,
        countryName,
        phonePlaceholder,
        isRtl,
        t,
        setLocale,
        setCountry,
    };
}
