@extends('layouts.admin')

@section('title', 'عرض رسالة')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.messages.index') }}" class="text-sm text-tract-600">← العودة للرسائل</a>
</div>

<div class="bg-white rounded-2xl border p-8 max-w-2xl space-y-4">
    <div><span class="text-sm text-slate-500">الاسم</span><p class="font-bold text-lg">{{ $message->name }}</p></div>
    <div class="grid sm:grid-cols-2 gap-4">
        <div><span class="text-sm text-slate-500">البريد</span><p><a href="mailto:{{ $message->email }}" class="text-tract-600">{{ $message->email }}</a></p></div>
        <div><span class="text-sm text-slate-500">الجوال</span><p>{{ $message->phone ?: '—' }}</p></div>
    </div>
    <div><span class="text-sm text-slate-500">الخدمة</span><p>{{ $message->service }}</p></div>
    <div><span class="text-sm text-slate-500">الرسالة</span><p class="mt-1 whitespace-pre-wrap bg-slate-50 rounded-xl p-4">{{ $message->message }}</p></div>
    <div><span class="text-sm text-slate-500">التاريخ</span><p>{{ $message->created_at->format('Y-m-d H:i') }}</p></div>

    <form method="POST" action="{{ route('admin.messages.destroy', $message) }}" onsubmit="return confirm('حذف هذه الرسالة؟')" class="pt-4 border-t">
        @csrf @method('DELETE')
        <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-medium">حذف الرسالة</button>
    </form>
</div>
@endsection
