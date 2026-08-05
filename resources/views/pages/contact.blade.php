@extends('layouts.site')

@php
    use App\Support\Locale;
    use App\Support\SiteUrl;

    $cty = $country ?? SiteUrl::DEFAULT_COUNTRY;
    $canonical = $siteUrl.Locale::path('contact', $locale, $cty);
    $phone = $contactSettings['phone_intl'] ?? config('tract.phone_intl');
    $phoneLocal = $contactSettings['phone'] ?? config('tract.phone');
    $email = $contactSettings['email'] ?? config('tract.email');
    $whatsapp = preg_replace('/[^0-9]/', '', $contactSettings['whatsapp'] ?? config('tract.whatsapp'));
@endphp

@section('title', $copy['title'])
@section('meta_description', $copy['subtitle'])
@section('canonical', $canonical)

@section('content')
<section class="py-10 sm:py-14 lg:py-16 bg-gradient-to-br from-tract-600 to-tract-900 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="text-sm text-tract-200 mb-8">
            <a href="{{ Locale::home($locale, $cty) }}" class="hover:text-white">{{ $locale === 'en' ? 'Home' : ($locale === 'ur' ? 'ہوم' : 'الرئيسية') }}</a>
            <span class="mx-2">/</span>
            <span class="text-white">{{ $copy['title'] }}</span>
        </nav>
        <span class="inline-block px-4 py-1.5 rounded-full bg-white/10 text-sm font-semibold mb-4">{{ $copy['badge'] }}</span>
        <h1 class="text-3xl sm:text-4xl font-bold mb-3">{{ $copy['heading'] }}</h1>
        <p class="text-lg text-tract-100 max-w-2xl">{{ $copy['subtitle'] }}</p>
    </div>
</section>

<section class="py-12 lg:py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-20">
            <div class="space-y-5">
                <a href="mailto:{{ $email }}" class="flex items-center gap-4 p-4 rounded-2xl bg-slate-50 hover:bg-tract-50 transition-colors group">
                    <div class="w-12 h-12 rounded-xl bg-tract-100 flex items-center justify-center">
                        <svg class="w-5 h-5 text-tract-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500">{{ $copy['email'] }}</p>
                        <p class="font-semibold text-slate-900" dir="ltr">{{ $email }}</p>
                    </div>
                </a>
                <a href="tel:{{ $phoneLocal }}" class="flex items-center gap-4 p-4 rounded-2xl bg-slate-50 hover:bg-tract-50 transition-colors group">
                    <div class="w-12 h-12 rounded-xl bg-tract-100 flex items-center justify-center">
                        <svg class="w-5 h-5 text-tract-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500">{{ $copy['phone'] }}</p>
                        <p class="font-semibold text-slate-900" dir="ltr">{{ $phone }}</p>
                    </div>
                </a>
                <a href="https://wa.me/{{ $whatsapp }}" target="_blank" rel="noopener" class="flex items-center gap-4 p-4 rounded-2xl bg-green-50 hover:bg-green-100 transition-colors">
                    <div class="w-12 h-12 rounded-xl bg-green-500 flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.435 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm text-green-700">{{ $copy['whatsapp'] }}</p>
                        <p class="font-semibold text-green-900">{{ $copy['whatsappAction'] }}</p>
                    </div>
                </a>
            </div>

            <form id="contact-page-form" class="p-6 lg:p-8 rounded-3xl bg-slate-50 border border-slate-100 shadow-sm space-y-5">
                <div id="contact-success" class="hidden p-4 rounded-xl bg-tract-50 border border-tract-200 text-tract-800 text-sm"></div>
                <div id="contact-error" class="hidden p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm"></div>

                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700 mb-2">{{ $copy['name'] }}</label>
                    <input id="name" name="name" type="text" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-tract-500 focus:ring-2 focus:ring-tract-500/20 outline-none" placeholder="{{ $copy['namePlaceholder'] }}">
                </div>
                <div class="grid sm:grid-cols-2 gap-5">
                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700 mb-2">{{ $copy['emailLabel'] }}</label>
                        <input id="email" name="email" type="email" required dir="ltr" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-tract-500 focus:ring-2 focus:ring-tract-500/20 outline-none" placeholder="email@example.com">
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium text-slate-700 mb-2">{{ $copy['phoneLabel'] }}</label>
                        <input id="phone" name="phone" type="tel" required dir="ltr" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-tract-500 focus:ring-2 focus:ring-tract-500/20 outline-none" placeholder="05xxxxxxxx">
                    </div>
                </div>
                <div>
                    <label for="service" class="block text-sm font-medium text-slate-700 mb-2">{{ $copy['service'] }}</label>
                    <select id="service" name="service" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-tract-500 focus:ring-2 focus:ring-tract-500/20 outline-none bg-white">
                        <option value="" disabled selected>{{ $copy['servicePlaceholder'] }}</option>
                        @foreach ($copy['services'] as $service)
                            <option value="{{ $service }}">{{ $service }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="message" class="block text-sm font-medium text-slate-700 mb-2">{{ $copy['message'] }}</label>
                    <textarea id="message" name="message" required rows="4" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-tract-500 focus:ring-2 focus:ring-tract-500/20 outline-none resize-none" placeholder="{{ $copy['messagePlaceholder'] }}"></textarea>
                </div>
                <button type="submit" id="contact-submit" class="w-full py-4 rounded-xl bg-tract-700 text-white font-semibold hover:bg-tract-800 transition-colors">
                    {{ $copy['submit'] }}
                </button>
            </form>
        </div>
    </div>
</section>

<script>
(function () {
    const form = document.getElementById('contact-page-form');
    const successEl = document.getElementById('contact-success');
    const errorEl = document.getElementById('contact-error');
    const submitBtn = document.getElementById('contact-submit');
    const labels = @json(['submit' => $copy['submit'], 'submitting' => $copy['submitting'], 'success' => $copy['success'], 'error' => $copy['error']]);
    const csrf = @json(csrf_token());

    form?.addEventListener('submit', async (e) => {
        e.preventDefault();
        successEl.classList.add('hidden');
        errorEl.classList.add('hidden');
        submitBtn.disabled = true;
        submitBtn.textContent = labels.submitting;

        try {
            const res = await fetch('/api/contact', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                },
                body: JSON.stringify({
                    name: form.name.value,
                    email: form.email.value,
                    phone: form.phone.value,
                    service: form.service.value,
                    message: form.message.value,
                }),
            });
            const data = await res.json();
            if (!res.ok) throw new Error(data.message || labels.error);
            successEl.textContent = data.message || labels.success;
            successEl.classList.remove('hidden');
            form.reset();
        } catch (err) {
            errorEl.textContent = err.message || labels.error;
            errorEl.classList.remove('hidden');
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = labels.submit;
        }
    });
})();
</script>
@endsection
