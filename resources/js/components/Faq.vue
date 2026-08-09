<script setup>
import { computed, ref } from 'vue';
import { useSite } from '../composables/useSite';
import { useContent, loc } from '../composables/useContent';

const { locale, t } = useSite();
const { content } = useContent();
const openId = ref(null);

const items = computed(() => {
    if (!content.value?.faqs?.length) return [];

    return content.value.faqs.map((item) => ({
        id: item.id,
        question: loc(item.question, locale.value),
        answer: loc(item.answer, locale.value),
    }));
});

const toggle = (id) => {
    openId.value = openId.value === id ? null : id;
};
</script>

<template>
    <section v-if="items.length" id="faq" class="py-16 lg:py-24 bg-white">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 lg:mb-16">
                <span class="inline-block px-4 py-1.5 rounded-full bg-tract-50 text-tract-700 text-sm font-semibold mb-4">{{ t('faq.badge') }}</span>
                <h2 class="text-3xl sm:text-4xl font-bold text-slate-900 mb-4">{{ t('faq.title') }}</h2>
                <p class="text-lg text-slate-600">{{ t('faq.subtitle') }}</p>
            </div>

            <div class="faq-accordion">
                <div
                    v-for="item in items"
                    :key="item.id"
                    class="faq-item"
                    :class="{ 'is-open': openId === item.id }"
                >
                    <button
                        type="button"
                        class="faq-item__trigger"
                        :aria-expanded="openId === item.id"
                        @click="toggle(item.id)"
                    >
                        <span>{{ item.question }}</span>
                        <svg class="faq-item__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div v-show="openId === item.id" class="faq-item__panel">
                        <p>{{ item.answer }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
