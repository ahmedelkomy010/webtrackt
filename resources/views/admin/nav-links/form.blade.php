@php $isEdit = isset($nav_link) && $nav_link->exists; $link = $nav_link ?? $link ?? new \App\Models\NavLink(); @endphp

@extends('layouts.admin')

@section('title', $isEdit ? 'تعديل رابط' : 'إضافة رابط')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.nav-links.index') }}" class="text-sm text-tract-600">← العودة</a>
    <h1 class="text-2xl font-bold mt-2">{{ $isEdit ? 'تعديل رابط' : 'إضافة رابط للقائمة' }}</h1>
</div>

<form method="POST" action="{{ $isEdit ? route('admin.nav-links.update', $link) : route('admin.nav-links.store') }}" class="space-y-6">
    @csrf @if ($isEdit) @method('PUT') @endif

    <div class="bg-white rounded-2xl border p-6 grid sm:grid-cols-2 gap-4">
        <div><label class="block text-sm font-medium mb-1">الرابط (مثل #services)</label><input type="text" name="href" value="{{ old('href', $link->href) }}" required class="w-full px-4 py-2.5 rounded-xl border" placeholder="#services"></div>
        <div><label class="block text-sm font-medium mb-1">الترتيب</label><input type="number" name="sort_order" value="{{ old('sort_order', $link->sort_order ?? 0) }}" min="0" class="w-full px-4 py-2.5 rounded-xl border"></div>
        <label class="flex items-center gap-2 sm:col-span-2"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $link->is_active ?? true)) class="rounded text-tract-600"><span class="text-sm">نشط</span></label>
    </div>

    @foreach (['ar' => 'العربية', 'en' => 'English', 'ur' => 'اردو'] as $lang => $langLabel)
        <div class="bg-white rounded-2xl border p-6">
            <label class="block text-sm font-medium mb-1">{{ $langLabel }} — النص</label>
            <input type="text" name="label_{{ $lang }}" value="{{ old('label_'.$lang, $link->label[$lang] ?? '') }}" required class="w-full px-4 py-2.5 rounded-xl border">
        </div>
    @endforeach

    <button type="submit" class="px-6 py-3 rounded-xl bg-tract-600 text-white font-semibold hover:bg-tract-700">حفظ</button>
</form>
@endsection
