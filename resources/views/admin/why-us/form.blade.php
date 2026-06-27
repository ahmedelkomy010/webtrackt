@php $isEdit = $item->exists; @endphp

@extends('layouts.admin')

@section('title', $isEdit ? 'تعديل' : 'إضافة')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.why-us.index') }}" class="text-sm text-tract-600">← العودة</a>
    <h1 class="text-2xl font-bold mt-2">{{ $isEdit ? 'تعديل عنصر' : 'إضافة عنصر جديد' }}</h1>
</div>

<form method="POST" action="{{ $isEdit ? route('admin.why-us.update', $item) : route('admin.why-us.store') }}" class="space-y-6">
    @csrf @if ($isEdit) @method('PUT') @endif

    <div class="bg-white rounded-2xl border p-6 grid sm:grid-cols-2 gap-4">
        <div><label class="block text-sm font-medium mb-1">الترتيب</label><input type="number" name="sort_order" value="{{ old('sort_order', $item->sort_order ?? 0) }}" min="0" class="w-full px-4 py-2.5 rounded-xl border"></div>
        <label class="flex items-center gap-2"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $item->is_active ?? true)) class="rounded text-tract-600"><span class="text-sm">نشط</span></label>
    </div>

    @foreach (['ar' => 'العربية', 'en' => 'English', 'ur' => 'اردو'] as $lang => $langLabel)
        <div class="bg-white rounded-2xl border p-6 space-y-4">
            <h3 class="font-bold border-b pb-2">{{ $langLabel }}</h3>
            <div><label class="block text-sm font-medium mb-1">العنوان</label><input type="text" name="title_{{ $lang }}" value="{{ old('title_'.$lang, $item->title[$lang] ?? '') }}" required class="w-full px-4 py-2.5 rounded-xl border"></div>
            <div><label class="block text-sm font-medium mb-1">الوصف</label><textarea name="description_{{ $lang }}" rows="3" required class="w-full px-4 py-2.5 rounded-xl border">{{ old('description_'.$lang, $item->description[$lang] ?? '') }}</textarea></div>
        </div>
    @endforeach

    <button type="submit" class="px-6 py-3 rounded-xl bg-tract-600 text-white font-semibold hover:bg-tract-700">حفظ</button>
</form>
@endsection
