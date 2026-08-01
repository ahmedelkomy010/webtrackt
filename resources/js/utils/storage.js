import { appBasePath } from './assets';

export function storageUrl(path) {
    if (!path) {
        return '';
    }

    const configured = window.__TRACT__?.storageUrl;
    const base = configured
        ? configured.replace(/\/$/, '')
        : `${appBasePath()}/storage`.replace(/\/$/, '') || '/storage';

    return `${base}/${String(path).replace(/^\//, '')}`;
}
