<script setup>
import { computed } from 'vue';
import { useSite } from '../composables/useSite';
import { useContent, loc } from '../composables/useContent';
import { localizedPath } from '../utils/locale';
import { storageUrl } from '../utils/storage';

const { locale, countryCode, t } = useSite();
const { content } = useContent();

const works = computed(() => {
    if (!content.value?.works?.length) return [];

    return content.value.works.map((work) => ({
        id: work.id,
        imageUrl: storageUrl(work.image),
        title: loc(work.title, locale.value),
        description: loc(work.description, locale.value),
        url: work.url,
    }));
});

const worksPageUrl = computed(() => localizedPath('works', locale.value, countryCode.value));
const previewWorks = computed(() => works.value.slice(0, 6));
</script>

<template>
    <section v-if="works.length" id="works" class="py-16 lg:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-12 lg:mb-16">
                <span class="inline-block px-4 py-1.5 rounded-full bg-tract-50 text-tract-700 text-sm font-semibold mb-4">{{ t('works.badge') }}</span>
                <h2 class="text-3xl sm:text-4xl font-bold text-slate-900 mb-4">{{ t('works.title') }}</h2>
                <p class="text-lg text-slate-600">{{ t('works.subtitle') }}</p>
            </div>

            <div class="works-grid">
                <a
                    v-for="work in previewWorks"
                    :key="work.id"
                    :href="work.url"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="works-card group"
                >
                    <div class="works-card__media">
                        <img :src="work.imageUrl" :alt="work.title" loading="lazy" class="works-card__image">
                    </div>
                    <div class="works-card__body">
                        <h3 class="works-card__title">{{ work.title }}</h3>
                        <p class="works-card__desc">{{ work.description }}</p>
                        <span class="works-card__link">{{ t('works.viewProject') }}</span>
                    </div>
                </a>
            </div>

            <div v-if="works.length > 6" class="text-center mt-12">
                <a :href="worksPageUrl" class="inline-flex items-center px-8 py-3 rounded-xl bg-tract-700 text-white font-semibold hover:bg-tract-800 transition-colors">
                    {{ t('works.viewAll') }}
                </a>
            </div>
        </div>
    </section>
</template>
