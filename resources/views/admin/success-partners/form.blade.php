@php $isEdit = $partner->exists; @endphp

@extends('layouts.admin')

@section('title', $isEdit ? 'تعديل شريك' : 'إضافة شريك')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.success-partners.index') }}" class="text-sm text-tract-600 hover:text-tract-700">← العودة للشركاء</a>
    <h1 class="text-2xl font-bold text-slate-900 mt-2">{{ $isEdit ? 'تعديل شريك' : 'إضافة شريك' }}</h1>
</div>

<form method="POST" action="{{ $isEdit ? route('admin.success-partners.update', $partner) : route('admin.success-partners.store') }}" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @if ($isEdit) @method('PUT') @endif

    <div class="bg-white rounded-2xl border border-slate-200 p-6 grid sm:grid-cols-2 gap-4">
        <div class="sm:col-span-2">
            <label class="block text-sm font-medium mb-1">شعار الشركة {{ $isEdit ? '(اختياري للتحديث)' : '' }}</label>
            @if ($isEdit && $partner->logo)
                <img src="{{ asset('storage/'.$partner->logo) }}" alt="" class="h-16 w-32 object-contain bg-slate-50 rounded-xl border border-slate-200 p-2 mb-3">
            @endif
            <input type="file" name="logo_file" accept="image/*" {{ $isEdit ? '' : 'required' }} class="w-full text-sm">
            <p class="text-xs text-slate-500 mt-1">PNG أو JPG — خلفية شفافة مفضلة — حد أقصى 2MB</p>
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">الترتيب</label>
            <input type="number" name="sort_order" value="{{ old('sort_order', $partner->sort_order ?? 0) }}" min="0" class="w-full px-4 py-2.5 rounded-xl border border-slate-200">
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">رابط الموقع (اختياري)</label>
            <input type="url" name="url" value="{{ old('url', $partner->url) }}" placeholder="https://example.com" class="w-full px-4 py-2.5 rounded-xl border border-slate-200" dir="ltr">
        </div>
        <label class="flex items-center gap-2 sm:col-span-2">
            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $partner->is_active ?? true)) class="rounded text-tract-600">
            <span class="text-sm">نشط — يظهر في الموقع</span>
        </label>
    </div>

    @foreach (['ar' => 'العربية', 'en' => 'English', 'ur' => 'اردو'] as $lang => $langLabel)
        <div class="bg-white rounded-2xl border border-slate-200 p-6">
            <label class="block text-sm font-medium mb-1">{{ $langLabel }} — اسم الشركة (اختياري)</label>
            <input type="text" name="name_{{ $lang }}" value="{{ old('name_'.$lang, data_get($partner->name, $lang, '')) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200">
        </div>
    @endforeach

    <button type="submit" class="px-6 py-3 rounded-xl bg-tract-600 text-white font-semibold hover:bg-tract-700">حفظ</button>
</form>
@endsection
