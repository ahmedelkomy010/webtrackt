export function storageUrl(path) {
    if (!path) {
        return '';
    }

    const base = window.__TRACT__?.storageUrl || '/storage';

    return `${base.replace(/\/$/, '')}/${String(path).replace(/^\//, '')}`;
}
