<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>تسجيل الدخول — Trakkt Admin</title>
    @include('partials.favicon')
    @vite(['resources/css/app.css'])
</head>
<body class="antialiased bg-slate-900 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <img src="/images/logo.png" alt="Trakkt" class="h-16 w-16 mx-auto mb-4 object-contain">
            <h1 class="text-2xl font-bold text-white">لوحة تحكم Trakkt</h1>
            <p class="text-slate-400 mt-2 text-sm">سجّل دخولك لإدارة محتوى الموقع</p>
        </div>

        <form method="POST" action="{{ route('admin.login') }}" class="bg-white rounded-2xl p-8 shadow-xl space-y-5">
            @csrf

            @if ($errors->any())
                <div class="px-4 py-3 rounded-xl bg-red-50 text-red-700 text-sm border border-red-200">
                    {{ $errors->first() }}
                </div>
            @endif

            <div>
                <label for="email" class="block text-sm font-medium text-slate-700 mb-1">البريد الإلكتروني</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                       class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-tract-500 focus:border-tract-500 outline-none">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-slate-700 mb-1">كلمة المرور</label>
                <input type="password" name="password" id="password" required
                       class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-tract-500 focus:border-tract-500 outline-none">
            </div>

            <label class="flex items-center gap-2 text-sm text-slate-600">
                <input type="checkbox" name="remember" class="rounded border-slate-300 text-tract-600 focus:ring-tract-500">
                تذكرني
            </label>

            <button type="submit" class="w-full py-3 rounded-xl bg-tract-600 text-white font-semibold hover:bg-tract-700 transition-colors">
                دخول
            </button>
        </form>

        <p class="text-center mt-6">
            <a href="/" class="text-slate-400 hover:text-white text-sm transition-colors">← العودة للموقع</a>
        </p>
    </div>
</body>
</html>
