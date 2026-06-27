import { ref, computed, watch } from 'vue';
import { translate } from '../i18n';
import { countries, defaultCountry } from '../data/countries';

const locale = ref(localStorage.getItem('tract_locale') || 'ar');
const countryCode = ref(localStorage.getItem('tract_country') || defaultCountry);

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

export function useSite() {
    const config = window.__TRACT__ ?? {
        name: 'تراكت',
        nameEn: 'Trakkt',
        tagline: 'Track Every Step. Control Every Result.',
        taglineAr: 'تابع كل خطوة. تحكم في كل نتيجة.',
        description: '',
        website: '/',
        email: '',
        phone: '',
        phoneLocal: '',
        whatsapp: '',
        csrfToken: '',
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
        locale.value = value;
    };

    const setCountry = (value) => {
        countryCode.value = value;
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
