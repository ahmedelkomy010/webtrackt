@extends('layouts.admin')

@section('title', 'المشرفون')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold">المشرفون</h1>
        <p class="text-slate-600 text-sm mt-1">إدارة حسابات لوحة التحكم</p>
    </div>
    <a href="{{ route('admin.users.create') }}" class="px-4 py-2.5 rounded-xl bg-tract-600 text-white text-sm font-semibold hover:bg-tract-700">+ مشرف جديد</a>
</div>

<div class="bg-white rounded-2xl border overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 border-b">
            <tr>
                <th class="text-start px-6 py-3 font-semibold text-slate-600">الاسم</th>
                <th class="text-start px-6 py-3 font-semibold text-slate-600">البريد</th>
                <th class="text-start px-6 py-3 font-semibold text-slate-600">إجراءات</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @foreach ($users as $user)
                <tr class="hover:bg-slate-50">
                    <td class="px-6 py-4 font-medium">
                        {{ $user->name }}
                        @if ($user->id === auth()->id())
                            <span class="text-xs text-tract-600 bg-tract-50 px-2 py-0.5 rounded-full ms-1">أنت</span>
                        @endif
                    </td>
                    <td class="px-6 py-4" dir="ltr">{{ $user->email }}</td>
                    <td class="px-6 py-4">
                        <div class="flex gap-3">
                            <a href="{{ route('admin.users.edit', $user) }}" class="text-tract-600 font-medium">تعديل</a>
                            @if ($user->id !== auth()->id() && $users->count() > 1)
                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('حذف هذا المشرف؟')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-500 font-medium">حذف</button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
