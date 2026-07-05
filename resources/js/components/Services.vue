<script setup>
import { computed } from 'vue';
import { useSite } from '../composables/useSite';
import { useContent, loc, locFeatures } from '../composables/useContent';

const { locale, t } = useSite();
const { content } = useContent();

const staticServices = computed(() => [
    { slug: 'erp-systems', icon: 'erp', title: t('services.erp.title'), description: t('services.erp.description'), features: [t('services.erp.features.0'), t('services.erp.features.1'), t('services.erp.features.2')], highlight: true },
    { slug: 'websites', icon: 'web', title: t('services.web.title'), description: t('services.web.description'), features: [t('services.web.features.0'), t('services.web.features.1'), t('services.web.features.2')], highlight: false },
    { slug: 'e-commerce', icon: 'store', title: t('services.store.title'), description: t('services.store.description'), features: [t('services.store.features.0'), t('services.store.features.1'), t('services.store.features.2')], highlight: false },
    { slug: 'digital-marketing', icon: 'marketing', title: t('services.marketing.title'), description: t('services.marketing.description'), features: [t('services.marketing.features.0'), t('services.marketing.features.1'), t('services.marketing.features.2')], highlight: false },
]);

const services = computed(() => {
    if (content.value?.services?.length) {
        return content.value.services.map((service) => ({
            slug: service.slug || service.icon,
            icon: service.icon,
            title: loc(service.title, locale.value),
            description: loc(service.description, locale.value),
            features: locFeatures(service.features, locale.value),
            highlight: service.highlight,
            url: service.slug ? `/services/${service.slug}` : '#services',
        }));
    }

    return staticServices.value.map((s) => ({ ...s, url: `/services/${s.slug}` }));
});
</script>

<template>
    <section id="services" class="py-20 lg:py-28 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="inline-block px-4 py-1.5 rounded-full bg-tract-50 text-tract-700 text-sm font-semibold mb-4">{{ t('services.badge') }}</span>
                <h2 class="text-3xl sm:text-4xl font-bold text-slate-900 mb-4">{{ t('services.title') }}</h2>
                <p class="text-lg text-slate-600">{{ t('services.subtitle') }}</p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
                <a
                    v-for="service in services"
                    :key="service.slug || service.title"
                    :href="service.url"
                    :class="[
                        'group relative block p-6 lg:p-8 rounded-2xl border transition-all duration-300 hover:-translate-y-1 cursor-pointer',
                        service.highlight
                            ? 'bg-gradient-to-br from-tract-50 to-white border-tract-200 hover:shadow-xl hover:shadow-tract-600/10 ring-1 ring-tract-100'
                            : 'bg-slate-50 border-slate-100 hover:bg-white hover:shadow-xl hover:shadow-tract-600/5 hover:border-tract-200',
                    ]"
                >
                    <div
                        v-if="service.highlight"
                        class="absolute -top-3 start-4 px-3 py-1 rounded-full bg-tract-600 text-white text-xs font-semibold"
                    >
                        {{ t('hero.specialty') }}
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-tract-500 to-tract-700 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform shadow-lg shadow-tract-600/20">
                        <svg v-if="service.icon === 'erp'" class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4" /></svg>
                        <svg v-else-if="service.icon === 'web'" class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" /></svg>
                        <svg v-else-if="service.icon === 'store'" class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                        <svg v-else class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3 group-hover:text-tract-700 transition-colors">{{ service.title }}</h3>
                    <p class="text-slate-600 text-sm leading-relaxed mb-5">{{ service.description }}</p>
                    <ul class="space-y-2 mb-4">
                        <li v-for="feature in service.features" :key="feature" class="flex items-center gap-2 text-sm text-tract-700">
                            <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                            {{ feature }}
                        </li>
                    </ul>
                    <span class="text-tract-700 text-sm font-semibold group-hover:text-tract-800">{{ t('services.viewDetails') }} ←</span>
                </a>
            </div>
        </div>
    </section>
</template>
