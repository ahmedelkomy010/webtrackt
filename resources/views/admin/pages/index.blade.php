@extends('layouts.admin')

@section('title', 'محتوى الصفحات')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-900">محتوى الصفحات</h1>
    <p class="text-slate-600 text-sm mt-1">تحكم في نصوص الصفحة الرئيسية، من نحن، أعمالنا، التواصل، وسياسة الخصوصية</p>
</div>

<div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
    @foreach ($pages as $slug => $label)
        <a href="{{ route('admin.pages.edit', $slug) }}" class="block p-6 rounded-2xl bg-white border border-slate-200 hover:border-tract-300 hover:shadow-md transition-all">
            <h2 class="font-bold text-slate-900 mb-2">{{ $label }}</h2>
            <p class="text-sm text-tract-600 font-medium">تعديل المحتوى ←</p>
            <p class="text-xs text-slate-400 mt-2 font-mono" dir="ltr">/{{ $slug === 'home' ? '' : $slug }}</p>
        </a>
    @endforeach
</div>
@endsection
