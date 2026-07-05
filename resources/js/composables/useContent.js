import { ref } from 'vue';
import axios from 'axios';

/* Use server-injected data if available (SSR preload from HomeController) */
const content = ref(window.__TRACT_CONTENT__ ?? null);
const loading = ref(false);
let fetchPromise = null;

export function loc(obj, locale) {
    if (!obj) return '';
    if (typeof obj === 'string') return obj;

    return obj[locale] || obj.ar || obj.en || '';
}

export function locFeatures(features, locale) {
    if (!Array.isArray(features)) return [];

    return features.map((f) => loc(f, locale)).filter(Boolean);
}

export async function fetchContent() {
    /* Already loaded from SSR preload — skip API call */
    if (content.value) return content.value;
    if (fetchPromise) return fetchPromise;

    loading.value = true;
    fetchPromise = axios.get('/api/content')
        .then(({ data }) => {
            content.value = data;
            return data;
        })
        .catch(() => {
            content.value = null;
            return null;
        })
        .finally(() => {
            loading.value = false;
        });

    return fetchPromise;
}

export function useContent() {
    return {
        content,
        loading,
        fetchContent,
        loc,
        locFeatures,
    };
}
