<script setup>
import { computed } from 'vue';
import { useSite } from '../composables/useSite';
import { useContent, loc } from '../composables/useContent';

const { locale, t } = useSite();
const { content } = useContent();

const staticStats = computed(() => [
    { value: '+50', label: t('stats.projects') },
    { value: '+30', label: t('stats.clients') },
    { value: '4', label: t('stats.domains') },
    { value: '100%', label: t('stats.commitment') },
]);

const stats = computed(() => {
    if (content.value?.stats?.length) {
        return content.value.stats.map((stat) => ({
            value: stat.value,
            label: loc(stat.label, locale.value),
        }));
    }

    return staticStats.value;
});
</script>

<template>
    <section class="py-16 bg-gradient-to-r from-tract-700 to-tract-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-8">
                <div v-for="stat in stats" :key="stat.label" class="text-center">
                    <p class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-2">{{ stat.value }}</p>
                    <p class="text-tract-200 text-sm sm:text-base">{{ stat.label }}</p>
                </div>
            </div>
        </div>
    </section>
</template>
