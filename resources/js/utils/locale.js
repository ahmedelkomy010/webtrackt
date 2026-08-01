export const LOCALE_PREFIX = { ar: '', en: 'en', ur: 'or' };

export const COUNTRIES = ['sa', 'ae', 'kw', 'bh', 'om', 'qa', 'eg'];

export const COUNTRY_PREFIXES = ['ae', 'kw', 'bh', 'om', 'qa', 'eg'];

export const DEFAULT_COUNTRY = 'sa';

export function appBasePath() {
    const base = window.__TRACT__?.basePath || '';
    if (!base) return '';
    return base.startsWith('/') ? base.replace(/\/$/, '') : `/${base}`.replace(/\/$/, '');
}

export function stripBasePath(pathname = window.location.pathname) {
    const base = appBasePath();
    if (base && (pathname === base || pathname.startsWith(`${base}/`))) {
        return pathname.slice(base.length) || '/';
    }
    return pathname;
}

export function parsePath(pathname = window.location.pathname) {
    let path = stripBasePath(pathname).replace(/^\//, '');
    const segments = path ? path.split('/') : [];
    let locale = 'ar';
    let country = DEFAULT_COUNTRY;

    if (segments[0] === 'en' || segments[0] === 'or') {
        locale = segments[0] === 'en' ? 'en' : 'ur';
        segments.shift();
    }

    if (COUNTRY_PREFIXES.includes(segments[0])) {
        country = segments[0];
        segments.shift();
    }

    return { locale, country, path: segments.join('/') };
}

export function buildPrefix(locale = 'ar', country = DEFAULT_COUNTRY) {
    const parts = [];
    if (locale !== 'ar' && LOCALE_PREFIX[locale]) {
        parts.push(LOCALE_PREFIX[locale]);
    }
    if (country !== DEFAULT_COUNTRY) {
        parts.push(country);
    }
    return parts.join('/');
}

export function localizedPath(path = '', locale = 'ar', country = DEFAULT_COUNTRY) {
    const clean = String(path).replace(/^\//, '');
    const prefix = buildPrefix(locale, country);
    const base = appBasePath();
    const suffix = !prefix
        ? (clean ? `/${clean}` : '/')
        : (clean ? `/${prefix}/${clean}` : `/${prefix}`);
    return `${base}${suffix === '/' && !base ? '/' : suffix}`;
}

export function switchLocaleUrl(newLocale, pathname = window.location.pathname, hash = window.location.hash) {
    const { country, path } = parsePath(pathname);
    return localizedPath(path, newLocale, country) + hash;
}

export function switchCountryUrl(newCountry, pathname = window.location.pathname, hash = window.location.hash) {
    const { locale, path } = parsePath(pathname);
    return localizedPath(path, locale, newCountry) + hash;
}

export function localizedHome(locale = 'ar', country = DEFAULT_COUNTRY) {
    return localizedPath('', locale, country);
}

export const PREFIX = LOCALE_PREFIX;

export function localeFromPath(pathname = window.location.pathname) {
    return parsePath(pathname).locale;
}

export function countryFromPath(pathname = window.location.pathname) {
    return parsePath(pathname).country;
}

export function stripPrefix(pathname) {
    return parsePath(pathname).path;
}
