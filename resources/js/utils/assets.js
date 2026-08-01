export function appBasePath() {
    return (window.__TRACT__?.basePath || '').replace(/\/$/, '');
}

export function publicAsset(path = '') {
    const base = appBasePath();
    const clean = String(path).replace(/^\//, '');

    if (!clean) {
        return base || '/';
    }

    return `${base}/${clean}`;
}
