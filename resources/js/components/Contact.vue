<script setup>
import { ref, reactive, computed } from 'vue';
import axios from 'axios';
import { useSite } from '../composables/useSite';

const { config, country, countryName, phonePlaceholder, t } = useSite();

const form = reactive({
    name: '',
    email: '',
    phone: '',
    service: '',
    message: '',
});

const serviceOptions = computed(() => [
    t('contact.serviceOptions.erp'),
    t('contact.serviceOptions.web'),
    t('contact.serviceOptions.store'),
    t('contact.serviceOptions.marketing'),
    t('contact.serviceOptions.general'),
]);

const loading = ref(false);
const success = ref(false);
const error = ref('');

const submit = async () => {
    loading.value = true;
    error.value = '';
    success.value = false;

    try {
        await axios.post('/api/contact', form, {
            headers: {
                'X-CSRF-TOKEN': config.csrfToken,
                Accept: 'application/json',
            },
        });
        success.value = true;
        form.name = '';
        form.email = '';
        form.phone = '';
        form.service = '';
        form.message = '';
    } catch (e) {
        if (e.response?.data?.message) {
            error.value = e.response.data.message;
        } else if (e.response?.data?.errors) {
            error.value = Object.values(e.response.data.errors).flat().join(' ');
        } else {
            error.value = t('contact.error');
        }
    } finally {
        loading.value = false;
    }
};
</script>

<template>
    <section id="contact" class="py-20 lg:py-28 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-20">
                <div>
                    <span class="inline-block px-4 py-1.5 rounded-full bg-tract-50 text-tract-700 text-sm font-semibold mb-4">{{ t('contact.badge') }}</span>
                    <h2 class="text-3xl sm:text-4xl font-bold text-slate-900 mb-4">{{ t('contact.title') }}</h2>
                    <p class="text-lg text-slate-600 mb-4">{{ t('contact.subtitle') }}</p>
                    <p class="text-sm text-slate-500 mb-8 flex items-center gap-2">
                        <span>{{ countryName }}</span>
                        <span class="text-slate-300">|</span>
                        <span>{{ country.currency.code }} ({{ country.currency.symbol }})</span>
                    </p>

                    <div class="space-y-5">
                        <a :href="`mailto:${country.email}`" class="flex items-center gap-4 p-4 rounded-2xl bg-slate-50 hover:bg-tract-50 transition-colors group">
                            <div class="w-12 h-12 rounded-xl bg-tract-100 flex items-center justify-center group-hover:bg-tract-200 transition-colors">
                                <svg class="w-5 h-5 text-tract-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                            </div>
                            <div>
                                <p class="text-sm text-slate-500">{{ t('contact.email') }}</p>
                                <p class="font-semibold text-slate-900" dir="ltr">{{ country.email }}</p>
                            </div>
                        </a>

                        <a :href="`tel:${country.phone}`" class="flex items-center gap-4 p-4 rounded-2xl bg-slate-50 hover:bg-tract-50 transition-colors group">
                            <div class="w-12 h-12 rounded-xl bg-tract-100 flex items-center justify-center group-hover:bg-tract-200 transition-colors">
                                <svg class="w-5 h-5 text-tract-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                            </div>
                            <div>
                                <p class="text-sm text-slate-500">{{ t('contact.phone') }}</p>
                                <p class="font-semibold text-slate-900" dir="ltr">{{ country.phone }}</p>
                            </div>
                        </a>

                        <a :href="`https://wa.me/${country.whatsapp.replace(/[^0-9]/g, '')}`" target="_blank" rel="noopener" class="flex items-center gap-4 p-4 rounded-2xl bg-green-50 hover:bg-green-100 transition-colors group">
                            <div class="w-12 h-12 rounded-xl bg-green-500 flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.435 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                            </div>
                            <div>
                                <p class="text-sm text-green-700">{{ t('contact.whatsapp') }}</p>
                                <p class="font-semibold text-green-900">{{ t('contact.whatsappAction') }}</p>
                            </div>
                        </a>
                    </div>
                </div>

                <form class="p-6 lg:p-8 rounded-3xl bg-slate-50 border border-slate-100 shadow-sm space-y-5" @submit.prevent="submit">
                    <div v-if="success" class="p-4 rounded-xl bg-tract-50 border border-tract-200 text-tract-800 text-sm">
                        {{ t('contact.success') }}
                    </div>
                    <div v-if="error" class="p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm">
                        {{ error }}
                    </div>

                    <div>
                        <label for="contact-name" class="block text-sm font-medium text-slate-700 mb-2">{{ t('contact.name') }}</label>
                        <input id="contact-name" v-model="form.name" type="text" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-tract-500 focus:ring-2 focus:ring-tract-500/20 outline-none transition-all" :placeholder="t('contact.namePlaceholder')">
                    </div>

                    <div class="grid sm:grid-cols-2 gap-5">
                        <div>
                            <label for="contact-email" class="block text-sm font-medium text-slate-700 mb-2">{{ t('contact.emailLabel') }}</label>
                            <input id="contact-email" v-model="form.email" type="email" required dir="ltr" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-tract-500 focus:ring-2 focus:ring-tract-500/20 outline-none transition-all" placeholder="email@example.com">
                        </div>
                        <div>
                            <label for="contact-phone" class="block text-sm font-medium text-slate-700 mb-2">{{ t('contact.phoneLabel') }}</label>
                            <input id="contact-phone" v-model="form.phone" type="tel" required dir="ltr" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-tract-500 focus:ring-2 focus:ring-tract-500/20 outline-none transition-all" :placeholder="phonePlaceholder">
                        </div>
                    </div>

                    <div>
                        <label for="contact-service" class="block text-sm font-medium text-slate-700 mb-2">{{ t('contact.service') }}</label>
                        <select id="contact-service" v-model="form.service" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-tract-500 focus:ring-2 focus:ring-tract-500/20 outline-none transition-all bg-white" :aria-label="t('contact.service')">
                            <option value="" disabled>{{ t('contact.servicePlaceholder') }}</option>
                            <option v-for="s in serviceOptions" :key="s" :value="s">{{ s }}</option>
                        </select>
                    </div>

                    <div>
                        <label for="contact-message" class="block text-sm font-medium text-slate-700 mb-2">{{ t('contact.message') }}</label>
                        <textarea id="contact-message" v-model="form.message" required rows="4" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-tract-500 focus:ring-2 focus:ring-tract-500/20 outline-none transition-all resize-none" :placeholder="t('contact.messagePlaceholder')" />
                    </div>

                    <button
                        type="submit"
                        :disabled="loading"
                        class="w-full py-4 rounded-xl bg-tract-700 text-white font-semibold hover:bg-tract-800 disabled:opacity-60 disabled:cursor-not-allowed shadow-lg shadow-tract-700/25 transition-all hover:-translate-y-0.5"
                    >
                        {{ loading ? t('contact.submitting') : t('contact.submit') }}
                    </button>
                </form>
            </div>
        </div>
    </section>
</template>
