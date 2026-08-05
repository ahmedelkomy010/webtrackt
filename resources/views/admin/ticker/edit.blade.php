@extends('layouts.admin')

@section('title', 'الشريط المتحرك')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-900">الشريط المتحرك (Ticker)</h1>
    <p class="text-slate-600 text-sm mt-1">يظهر في أعلى الموقع — رسائل متحركة للعروض والتنبيهات</p>
</div>

<form method="POST" action="{{ route('admin.ticker.update') }}" class="space-y-6">
    @csrf @method('PUT')

    <div class="bg-white rounded-2xl border p-6">
        <label class="flex items-center gap-2">
            <input type="checkbox" name="enabled" value="1" @checked(old('enabled', $settings['enabled'] ?? true)) class="rounded text-tract-600">
            <span class="text-sm font-medium">تفعيل الشريط المتحرك</span>
        </label>
    </div>

    @foreach (['ar' => 'العربية', 'en' => 'English', 'ur' => 'اردو'] as $lang => $label)
        @php
            $messages = old('messages_'.$lang, implode("\n", $settings['messages_'.$lang] ?? []));
        @endphp
        <div class="bg-white rounded-2xl border p-6 space-y-3">
            <h3 class="font-bold text-slate-900">{{ $label }}</h3>
            <p class="text-xs text-slate-500">سطر لكل رسالة — تتحرك أفقياً في الشريط</p>
            <textarea name="messages_{{ $lang }}" rows="4" class="w-full px-4 py-2.5 rounded-xl border font-mono text-sm">{{ $messages }}</textarea>
        </div>
    @endforeach

    <button type="submit" class="px-6 py-3 rounded-xl bg-tract-600 text-white font-semibold hover:bg-tract-700">حفظ الشريط المتحرك</button>
</form>
@endsection
