<script setup>
import { computed } from 'vue';
import { useSite } from '../composables/useSite';
import { useContent } from '../composables/useContent';

const { locale, isRtl } = useSite();
const { content } = useContent();

const ticker = computed(() => content.value?.ticker ?? window.__TRACT__?.ticker ?? {});

const messages = computed(() => {
    const key = `messages_${locale.value}`;
    const list = ticker.value[key] ?? ticker.value.messages_ar ?? [];

    return Array.isArray(list) ? list.filter(Boolean) : [];
});

const enabled = computed(() => (ticker.value.enabled ?? true) && messages.value.length > 0);
</script>

<template>
    <div v-if="enabled" class="top-ticker safe-top" :dir="isRtl ? 'rtl' : 'ltr'">
        <div class="top-ticker__viewport">
            <div class="top-ticker__track">
                <span v-for="(message, index) in [...messages, ...messages]" :key="`${index}-${message}`" class="top-ticker__item">
                    {{ message }}
                </span>
            </div>
        </div>
    </div>
</template>
