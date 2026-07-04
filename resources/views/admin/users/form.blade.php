@php $isEdit = $user->exists; @endphp

@extends('layouts.admin')

@section('title', $isEdit ? 'تعديل مشرف' : 'مشرف جديد')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.users.index') }}" class="text-sm text-tract-600">← العودة للمشرفين</a>
    <h1 class="text-2xl font-bold mt-2">{{ $isEdit ? 'تعديل مشرف' : 'إضافة مشرف' }}</h1>
</div>

<form method="POST" action="{{ $isEdit ? route('admin.users.update', $user) : route('admin.users.store') }}" class="max-w-xl bg-white rounded-2xl border p-6 space-y-4">
    @csrf @if ($isEdit) @method('PUT') @endif

    <div>
        <label class="block text-sm font-medium mb-1">الاسم *</label>
        <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full px-4 py-2.5 rounded-xl border">
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">البريد الإلكتروني *</label>
        <input type="email" name="email" value="{{ old('email', $user->email) }}" required dir="ltr" class="w-full px-4 py-2.5 rounded-xl border">
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">كلمة المرور {{ $isEdit ? '(اتركها فارغة بدون تغيير)' : '*' }}</label>
        <input type="password" name="password" {{ $isEdit ? '' : 'required' }} minlength="8" class="w-full px-4 py-2.5 rounded-xl border" dir="ltr">
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">تأكيد كلمة المرور</label>
        <input type="password" name="password_confirmation" minlength="8" class="w-full px-4 py-2.5 rounded-xl border" dir="ltr">
    </div>

    <button type="submit" class="px-6 py-3 rounded-xl bg-tract-600 text-white font-semibold hover:bg-tract-700">
        {{ $isEdit ? 'حفظ التعديلات' : 'إنشاء المشرف' }}
    </button>
</form>
@endsection
