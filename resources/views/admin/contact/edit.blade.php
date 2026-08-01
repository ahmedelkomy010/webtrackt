@extends('layouts.admin')

@section('title', 'إعدادات التواصل والسوشيال ميديا')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-900">إعدادات التواصل والسوشيال ميديا</h1>
    <p class="text-slate-600 text-sm mt-1">تحكم في بيانات التواصل وروابط منصات التواصل الاجتماعي</p>
</div>

<form method="POST" action="{{ route('admin.contact.update') }}" class="space-y-6">
    @csrf @method('PUT')

    {{-- Contact Info --}}
    <div class="bg-white rounded-2xl border p-6 space-y-4">
        <div class="flex items-center gap-3 mb-2">
            <div class="w-9 h-9 rounded-xl bg-tract-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-tract-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
            </div>
            <h2 class="font-bold text-lg">بيانات التواصل</h2>
        </div>

        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">رقم الجوال (محلي)</label>
                <input type="text" name="phone"
                    value="{{ old('phone', $settings['phone'] ?? '') }}"
                    placeholder="0502943846"
                    dir="ltr"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-tract-500 outline-none font-mono text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">رقم الجوال (دولي)</label>
                <input type="text" name="phone_intl"
                    value="{{ old('phone_intl', $settings['phone_intl'] ?? '') }}"
                    placeholder="+966 50 294 3846"
                    dir="ltr"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-tract-500 outline-none font-mono text-sm">
                <p class="text-xs text-slate-400 mt-1">يُستخدم في روابط الاتصال المباشر</p>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">رقم الواتساب</label>
                <input type="text" name="whatsapp"
                    value="{{ old('whatsapp', $settings['whatsapp'] ?? '') }}"
                    placeholder="966502943846"
                    dir="ltr"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-tract-500 outline-none font-mono text-sm">
                <p class="text-xs text-slate-400 mt-1">بدون + أو مسافات (مثال: 966502943846)</p>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">البريد الإلكتروني</label>
                <input type="email" name="email"
                    value="{{ old('email', $settings['email'] ?? '') }}"
                    placeholder="info@trackkt.com"
                    dir="ltr"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-tract-500 outline-none text-sm">
            </div>
        </div>
    </div>

    {{-- Social Media --}}
    <div class="bg-white rounded-2xl border p-6 space-y-4">
        <div class="flex items-center gap-3 mb-2">
            <div class="w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                </svg>
            </div>
            <h2 class="font-bold text-lg">روابط السوشيال ميديا</h2>
        </div>

        <div class="grid sm:grid-cols-2 gap-4">
            {{-- Twitter/X --}}
            <div>
                <label class="flex items-center gap-2 text-sm font-medium mb-1">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.748l7.73-8.835L1.254 2.25H8.08l4.259 5.63 5.905-5.63zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                    </svg>
                    Twitter / X
                </label>
                <input type="url" name="twitter_url"
                    value="{{ old('twitter_url', $settings['twitter_url'] ?? '') }}"
                    placeholder="https://x.com/trackkt"
                    dir="ltr"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-tract-500 outline-none text-sm">
            </div>

            {{-- Instagram --}}
            <div>
                <label class="flex items-center gap-2 text-sm font-medium mb-1">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                    </svg>
                    Instagram
                </label>
                <input type="url" name="instagram_url"
                    value="{{ old('instagram_url', $settings['instagram_url'] ?? '') }}"
                    placeholder="https://instagram.com/trackkt"
                    dir="ltr"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-tract-500 outline-none text-sm">
            </div>

            {{-- Facebook --}}
            <div>
                <label class="flex items-center gap-2 text-sm font-medium mb-1">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                    Facebook
                </label>
                <input type="url" name="facebook_url"
                    value="{{ old('facebook_url', $settings['facebook_url'] ?? '') }}"
                    placeholder="https://facebook.com/trackkt"
                    dir="ltr"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-tract-500 outline-none text-sm">
            </div>

            {{-- Snapchat --}}
            <div>
                <label class="flex items-center gap-2 text-sm font-medium mb-1">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12.206.793c.99 0 4.347.276 5.93 3.821.529 1.193.403 3.219.317 4.793l-.004.08c-.012.322.049.625.241.808.265.25.696.196 1.073.14l.054-.009c.162-.025.35-.05.551-.05.198 0 .359.031.491.092.246.113.382.3.382.51 0 .217-.143.437-.406.616-.666.472-1.429.843-1.659 1.011-.172.125-.215.265-.211.41.006.274.179.58.38.899.093.153.187.31.258.474.177.4.137.743-.116.99-.222.212-.54.312-.942.312-.186 0-.384-.028-.592-.081l-.024-.005c-.33-.075-.634-.133-.884-.133-.336 0-.549.091-.682.259-.178.225-.221.537-.226.815v.025c-.01.547-.027 1.488-1.073 2.025l-.142.073c-.538.275-1.279.65-2.549.65-1.268 0-2.008-.374-2.545-.648l-.142-.073c-1.046-.537-1.064-1.479-1.073-2.026v-.025c-.005-.278-.048-.59-.226-.815-.133-.168-.346-.259-.682-.259-.25 0-.554.058-.884.133l-.024.005c-.208.053-.406.081-.592.081-.402 0-.72-.1-.942-.312-.253-.247-.293-.59-.116-.99.071-.164.165-.321.258-.474.201-.319.374-.625.38-.899.004-.145-.039-.285-.211-.41-.23-.168-.993-.539-1.659-1.011-.263-.179-.406-.399-.406-.616 0-.21.136-.397.382-.51.132-.061.293-.092.491-.092.2 0 .389.025.551.05l.054.009c.377.056.808.11 1.073-.14.192-.183.253-.486.241-.808l-.004-.08c-.086-1.574-.212-3.6.317-4.793C7.837 1.069 11.194.793 12.206.793z"/>
                    </svg>
                    Snapchat
                </label>
                <input type="url" name="snapchat_url"
                    value="{{ old('snapchat_url', $settings['snapchat_url'] ?? '') }}"
                    placeholder="https://snapchat.com/add/trackkt"
                    dir="ltr"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-tract-500 outline-none text-sm">
            </div>

            {{-- LinkedIn --}}
            <div>
                <label class="flex items-center gap-2 text-sm font-medium mb-1">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                    </svg>
                    LinkedIn
                </label>
                <input type="url" name="linkedin_url"
                    value="{{ old('linkedin_url', $settings['linkedin_url'] ?? '') }}"
                    placeholder="https://linkedin.com/company/trackkt"
                    dir="ltr"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-tract-500 outline-none text-sm">
            </div>

            {{-- TikTok --}}
            <div>
                <label class="flex items-center gap-2 text-sm font-medium mb-1">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
                    </svg>
                    TikTok
                </label>
                <input type="url" name="tiktok_url"
                    value="{{ old('tiktok_url', $settings['tiktok_url'] ?? '') }}"
                    placeholder="https://tiktok.com/@trackkt"
                    dir="ltr"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-tract-500 outline-none text-sm">
            </div>
        </div>
    </div>

    {{-- Preview --}}
    @if(array_filter(array_intersect_key($settings, array_flip(['twitter_url','instagram_url','facebook_url','snapchat_url','linkedin_url','tiktok_url']))))
    <div class="bg-slate-50 rounded-2xl border p-4">
        <p class="text-sm font-medium text-slate-600 mb-3">روابط محفوظة:</p>
        <div class="flex flex-wrap gap-2">
            @foreach(['twitter_url'=>'X','instagram_url'=>'Instagram','facebook_url'=>'Facebook','snapchat_url'=>'Snapchat','linkedin_url'=>'LinkedIn','tiktok_url'=>'TikTok'] as $key=>$label)
                @if(!empty($settings[$key]))
                <a href="{{ $settings[$key] }}" target="_blank" rel="noopener"
                   class="px-3 py-1.5 rounded-full bg-white border border-slate-200 text-xs font-medium text-slate-700 hover:text-tract-700 hover:border-tract-300 transition-colors">
                    {{ $label }} ↗
                </a>
                @endif
            @endforeach
        </div>
    </div>
    @endif

    <button type="submit" class="px-6 py-3 rounded-xl bg-tract-700 text-white font-semibold hover:bg-tract-800 transition-colors">
        حفظ الإعدادات
    </button>
</form>
@endsection
