@extends('layouts.admin')

@section('title', 'حسابي')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold">حسابي</h1>
    <p class="text-slate-600 text-sm mt-1">تغيير الاسم، البريد، أو كلمة المرور</p>
</div>

<form method="POST" action="{{ route('admin.profile.update') }}" class="max-w-xl bg-white rounded-2xl border p-6 space-y-4">
    @csrf @method('PUT')

    <div>
        <label class="block text-sm font-medium mb-1">الاسم *</label>
        <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full px-4 py-2.5 rounded-xl border">
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">البريد الإلكتروني *</label>
        <input type="email" name="email" value="{{ old('email', $user->email) }}" required dir="ltr" class="w-full px-4 py-2.5 rounded-xl border">
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">كلمة مرور جديدة (اختياري)</label>
        <input type="password" name="password" minlength="8" class="w-full px-4 py-2.5 rounded-xl border" dir="ltr">
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">تأكيد كلمة المرور</label>
        <input type="password" name="password_confirmation" minlength="8" class="w-full px-4 py-2.5 rounded-xl border" dir="ltr">
    </div>

    <button type="submit" class="px-6 py-3 rounded-xl bg-tract-600 text-white font-semibold hover:bg-tract-700">حفظ التغييرات</button>
</form>
@endsection
