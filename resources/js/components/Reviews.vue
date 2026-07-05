<script setup>
import { ref, reactive, computed } from 'vue';
import axios from 'axios';
import { useSite } from '../composables/useSite';
import { useContent, loc } from '../composables/useContent';

const { config, locale, t } = useSite();
const { content } = useContent();

const form = reactive({
    name: '',
    company: '',
    rating: 5,
    comment: '',
});

const loading = ref(false);
const success = ref(false);
const error = ref('');
const hoverRating = ref(0);

const reviews = computed(() => {
    if (!content.value?.reviews?.length) return [];

    return content.value.reviews.map((review) => ({
        id: review.id,
        name: review.name,
        company: review.company,
        rating: review.rating,
        comment: loc(review.comment, locale.value),
        isFeatured: review.isFeatured,
    }));
});

const averageRating = computed(() => {
    if (!reviews.value.length) return 0;

    const sum = reviews.value.reduce((acc, r) => acc + r.rating, 0);

    return (sum / reviews.value.length).toFixed(1);
});

const submit = async () => {
    loading.value = true;
    error.value = '';
    success.value = false;

    try {
        await axios.post('/api/reviews', form, {
            headers: {
                'X-CSRF-TOKEN': config.csrfToken,
                Accept: 'application/json',
            },
        });
        success.value = true;
        form.name = '';
        form.company = '';
        form.rating = 5;
        form.comment = '';
    } catch (e) {
        if (e.response?.data?.message) {
            error.value = e.response.data.message;
        } else if (e.response?.data?.errors) {
            error.value = Object.values(e.response.data.errors).flat().join(' ');
        } else {
            error.value = t('reviews.error');
        }
    } finally {
        loading.value = false;
    }
};
</script>

<template>
    <section id="reviews" class="py-20 lg:py-28 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-14">
                <span class="inline-block px-4 py-1.5 rounded-full bg-gold-500/10 text-gold-600 text-sm font-semibold mb-4">{{ t('reviews.badge') }}</span>
                <h2 class="text-3xl sm:text-4xl font-bold text-slate-900 mb-4">{{ t('reviews.title') }}</h2>
                <p class="text-lg text-slate-600">{{ t('reviews.subtitle') }}</p>
                <div v-if="reviews.length" class="flex items-center justify-center gap-2 mt-6">
                    <div class="flex gap-0.5">
                        <svg v-for="i in 5" :key="i" class="w-5 h-5" :class="i <= Math.round(averageRating) ? 'text-gold-500' : 'text-slate-300'" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                    </div>
                    <span class="text-slate-700 font-semibold">{{ averageRating }}</span>
                    <span class="text-slate-500 text-sm">({{ reviews.length }} {{ t('reviews.countLabel') }})</span>
                </div>
            </div>

            <div v-if="reviews.length" class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-16">
                <article
                    v-for="review in reviews"
                    :key="review.id"
                    :class="[
                        'p-6 lg:p-8 rounded-2xl bg-white border transition-all hover:shadow-lg',
                        review.isFeatured ? 'border-gold-300 ring-1 ring-gold-200 shadow-md' : 'border-slate-100 hover:border-tract-200',
                    ]"
                >
                    <div v-if="review.isFeatured" class="text-xs font-semibold text-gold-600 mb-3">{{ t('reviews.featured') }}</div>
                    <div class="flex gap-0.5 mb-4">
                        <svg v-for="i in 5" :key="i" class="w-4 h-4" :class="i <= review.rating ? 'text-gold-500' : 'text-slate-200'" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                    </div>
                    <p class="text-slate-600 text-sm leading-relaxed mb-6">"{{ review.comment }}"</p>
                    <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-tract-500 to-tract-700 flex items-center justify-center text-white font-bold text-sm">
                            {{ review.name.charAt(0) }}
                        </div>
                        <div>
                            <p class="font-semibold text-slate-900 text-sm">{{ review.name }}</p>
                            <p v-if="review.company" class="text-xs text-slate-500">{{ review.company }}</p>
                        </div>
                    </div>
                </article>
            </div>

            <div class="max-w-2xl mx-auto">
                <div class="p-6 lg:p-8 rounded-3xl bg-white border border-slate-200 shadow-sm">
                    <h3 class="text-xl font-bold text-slate-900 mb-2">{{ t('reviews.formTitle') }}</h3>
                    <p class="text-slate-600 text-sm mb-6">{{ t('reviews.formSubtitle') }}</p>

                    <form class="space-y-5" @submit.prevent="submit">
                        <div v-if="success" class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm">
                            {{ t('reviews.success') }}
                        </div>
                        <div v-if="error" class="p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm">
                            {{ error }}
                        </div>

                        <div class="grid sm:grid-cols-2 gap-5">
                            <div>
                                <label for="review-name" class="block text-sm font-medium text-slate-700 mb-2">{{ t('reviews.name') }}</label>
                                <input id="review-name" v-model="form.name" type="text" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-tract-500 focus:ring-2 focus:ring-tract-500/20 outline-none" :placeholder="t('reviews.namePlaceholder')">
                            </div>
                            <div>
                                <label for="review-company" class="block text-sm font-medium text-slate-700 mb-2">{{ t('reviews.company') }}</label>
                                <input id="review-company" v-model="form.company" type="text" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-tract-500 focus:ring-2 focus:ring-tract-500/20 outline-none" :placeholder="t('reviews.companyPlaceholder')">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">{{ t('reviews.rating') }}</label>
                            <div class="flex gap-1">
                                <button
                                    v-for="star in 5"
                                    :key="star"
                                    type="button"
                                    class="p-1 transition-transform hover:scale-110"
                                    :aria-label="`${star} ${t('reviews.rating')}`"
                                    :aria-pressed="form.rating >= star"
                                    @click="form.rating = star"
                                    @mouseenter="hoverRating = star"
                                    @mouseleave="hoverRating = 0"
                                >
                                    <svg class="w-8 h-8" aria-hidden="true" :class="star <= (hoverRating || form.rating) ? 'text-gold-500' : 'text-slate-300'" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                                </button>
                            </div>
                        </div>

                        <div>
                            <label for="review-comment" class="block text-sm font-medium text-slate-700 mb-2">{{ t('reviews.comment') }}</label>
                            <textarea id="review-comment" v-model="form.comment" required rows="4" maxlength="2000" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-tract-500 focus:ring-2 focus:ring-tract-500/20 outline-none resize-none" :placeholder="t('reviews.commentPlaceholder')" :aria-describedby="'review-char-count'" />
                            <p id="review-char-count" class="text-xs text-slate-400 mt-1 text-end">{{ form.comment.length }} / 2000</p>
                        </div>

                        <button
                            type="submit"
                            :disabled="loading"
                            class="w-full py-4 rounded-xl bg-tract-700 text-white font-semibold hover:bg-tract-800 disabled:opacity-60 transition-all shadow-lg shadow-tract-700/20"
                        >
                            {{ loading ? t('reviews.submitting') : t('reviews.submit') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</template>
