@php $isEdit = $work->exists; @endphp

@extends('layouts.admin')

@section('title', $isEdit ? 'تعديل عمل' : 'إضافة عمل')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.works.index') }}" class="text-sm text-tract-600">← العودة</a>
    <h1 class="text-2xl font-bold mt-2">{{ $isEdit ? 'تعديل عمل' : 'إضافة عمل جديد' }}</h1>
</div>

<form method="POST" action="{{ $isEdit ? route('admin.works.update', $work) : route('admin.works.store') }}" enctype="multipart/form-data" class="space-y-6">
    @csrf @if ($isEdit) @method('PUT') @endif

    <div class="bg-white rounded-2xl border p-6 grid sm:grid-cols-2 gap-4">
        <div class="sm:col-span-2">
            <label class="block text-sm font-medium mb-1">صورة العمل {{ $isEdit ? '(اختياري للتحديث)' : '' }}</label>
            @if ($isEdit && $work->image)
                <img src="{{ asset('storage/'.$work->image) }}" alt="" class="h-32 w-full max-w-sm object-cover rounded-xl border border-slate-200 mb-3">
            @endif
            <input type="file" name="image_file" accept="image/*" {{ $isEdit ? '' : 'required' }} class="w-full text-sm">
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">رابط العمل</label>
            <input type="url" name="url" value="{{ old('url', $work->url) }}" required placeholder="https://example.com" class="w-full px-4 py-2.5 rounded-xl border" dir="ltr">
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">الترتيب</label>
            <input type="number" name="sort_order" value="{{ old('sort_order', $work->sort_order ?? 0) }}" min="0" class="w-full px-4 py-2.5 rounded-xl border">
        </div>
        <label class="flex items-center gap-2 sm:col-span-2"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $work->is_active ?? true)) class="rounded text-tract-600"><span class="text-sm">نشط — يظهر في الموقع</span></label>
    </div>

    @foreach (['ar' => 'العربية', 'en' => 'English', 'ur' => 'اردو'] as $lang => $langLabel)
        <div class="bg-white rounded-2xl border p-6 space-y-4">
            <h3 class="font-bold border-b pb-2">{{ $langLabel }}</h3>
            <div><label class="block text-sm font-medium mb-1">عنوان العمل</label><input type="text" name="title_{{ $lang }}" value="{{ old('title_'.$lang, data_get($work->title, $lang, '')) }}" required class="w-full px-4 py-2.5 rounded-xl border"></div>
            <div><label class="block text-sm font-medium mb-1">وصف العمل</label><textarea name="description_{{ $lang }}" rows="3" required class="w-full px-4 py-2.5 rounded-xl border">{{ old('description_'.$lang, data_get($work->description, $lang, '')) }}</textarea></div>
        </div>
    @endforeach

    <button type="submit" class="px-6 py-3 rounded-xl bg-tract-600 text-white font-semibold hover:bg-tract-700">حفظ</button>
</form>
@endsection
