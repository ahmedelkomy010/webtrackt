@php $isEdit = $stat->exists; @endphp

@extends('layouts.admin')

@section('title', $isEdit ? 'تعديل إحصائية' : 'إضافة إحصائية')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.stats.index') }}" class="text-sm text-tract-600 hover:text-tract-700">← العودة للإحصائيات</a>
    <h1 class="text-2xl font-bold text-slate-900 mt-2">{{ $isEdit ? 'تعديل إحصائية' : 'إضافة إحصائية' }}</h1>
</div>

<form method="POST" action="{{ $isEdit ? route('admin.stats.update', $stat) : route('admin.stats.store') }}" class="space-y-6">
    @csrf
    @if ($isEdit) @method('PUT') @endif

    <div class="bg-white rounded-2xl border border-slate-200 p-6 grid sm:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium mb-1">القيمة (مثل +50)</label>
            <input type="text" name="value" value="{{ old('value', $stat->value) }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200">
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">الترتيب</label>
            <input type="number" name="sort_order" value="{{ old('sort_order', $stat->sort_order ?? 0) }}" min="0" class="w-full px-4 py-2.5 rounded-xl border border-slate-200">
        </div>
        <label class="flex items-center gap-2 sm:col-span-2">
            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $stat->is_active ?? true)) class="rounded text-tract-600">
            <span class="text-sm">نشط</span>
        </label>
    </div>

    @foreach (['ar' => 'العربية', 'en' => 'English', 'ur' => 'اردو'] as $lang => $langLabel)
        <div class="bg-white rounded-2xl border border-slate-200 p-6">
            <label class="block text-sm font-medium mb-1">{{ $langLabel }} — التسمية</label>
            <input type="text" name="label_{{ $lang }}" value="{{ old('label_'.$lang, $stat->label[$lang] ?? '') }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200">
        </div>
    @endforeach

    <button type="submit" class="px-6 py-3 rounded-xl bg-tract-600 text-white font-semibold hover:bg-tract-700">حفظ</button>
</form>
@endsection
