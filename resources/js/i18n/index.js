import ar from './ar';
import en from './en';
import ur from './ur';

export const translations = { ar, en, ur };

export function translate(locale, key) {
    const keys = key.split('.');
    let value = translations[locale];

    for (const k of keys) {
        value = value?.[k];
    }

    return value ?? key;
}
