@extends('layouts.admin')

@section('title', 'ملف robots.txt')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">ملف robots.txt</h1>
        <p class="text-slate-600 text-sm mt-1">تحكم في محتوى الملف المتاح على <a href="{{ url('/robots.txt') }}" target="_blank" class="text-tract-600 hover:underline font-mono" dir="ltr">/robots.txt</a></p>
    </div>
    @if ($exists)
        <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-emerald-50 text-emerald-700 text-sm border border-emerald-200">
            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
            الملف موجود
        </span>
    @else
        <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-amber-50 text-amber-700 text-sm border border-amber-200">
            <span class="w-2 h-2 rounded-full bg-amber-500"></span>
            الملف غير موجود — احفظ لإنشائه
        </span>
    @endif
</div>

<form method="POST" action="{{ route('admin.robots.update') }}" class="space-y-6">
    @csrf @method('PUT')

    <div class="bg-white rounded-2xl border p-6 space-y-4">
        <div class="flex items-center justify-between gap-4">
            <h2 class="font-bold text-lg">محتوى الملف</h2>
            <button type="button" id="reset-default" class="text-sm text-tract-600 hover:text-tract-700 font-medium">
                استعادة القالب الافتراضي
            </button>
        </div>
        <p class="text-sm text-slate-500">تعليمات لمحركات البحث: السماح أو منع الزحف، وإضافة رابط sitemap.xml</p>
        <textarea
            id="robots-content"
            name="content"
            rows="16"
            dir="ltr"
            class="w-full px-4 py-3 rounded-xl border font-mono text-sm leading-relaxed bg-slate-50 focus:bg-white"
            spellcheck="false"
        >{{ old('content', $content) }}</textarea>
    </div>

    <div class="flex flex-wrap items-center gap-3">
        <button type="submit" class="px-6 py-3 rounded-xl bg-tract-600 text-white font-semibold hover:bg-tract-700">
            {{ $exists ? 'تحديث الملف' : 'إنشاء الملف' }}
        </button>
    </div>
</form>

@if ($exists)
    <form method="POST" action="{{ route('admin.robots.destroy') }}" class="mt-4" onsubmit="return confirm('هل أنت متأكد من حذف ملف robots.txt؟');">
        @csrf @method('DELETE')
        <button type="submit" class="px-6 py-3 rounded-xl bg-red-50 text-red-600 font-semibold border border-red-200 hover:bg-red-100">
            حذف الملف
        </button>
    </form>
@endif

<script>
(function () {
    const defaultContent = @json($defaultContent);
    const textarea = document.getElementById('robots-content');
    const resetBtn = document.getElementById('reset-default');

    resetBtn?.addEventListener('click', function () {
        if (confirm('استبدال المحتوى الحالي بالقالب الافتراضي؟')) {
            textarea.value = defaultContent;
        }
    });
})();
</script>
@endsection
