@extends('layouts.admin')

@section('title', 'رسائل التواصل')

@section('content')
<h1 class="text-2xl font-bold mb-6">رسائل التواصل</h1>

<div class="bg-white rounded-2xl border overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 border-b"><tr>
            <th class="text-start px-6 py-3 font-semibold text-slate-600">الاسم</th>
            <th class="text-start px-6 py-3 font-semibold text-slate-600">البريد</th>
            <th class="text-start px-6 py-3 font-semibold text-slate-600">الخدمة</th>
            <th class="text-start px-6 py-3 font-semibold text-slate-600">التاريخ</th>
            <th class="text-start px-6 py-3 font-semibold text-slate-600">إجراءات</th>
        </tr></thead>
        <tbody class="divide-y">
            @forelse ($messages as $message)
                <tr class="hover:bg-slate-50">
                    <td class="px-6 py-4 font-medium">{{ $message->name }}</td>
                    <td class="px-6 py-4">{{ $message->email }}</td>
                    <td class="px-6 py-4">{{ $message->service }}</td>
                    <td class="px-6 py-4 text-slate-500">{{ $message->created_at->format('Y-m-d H:i') }}</td>
                    <td class="px-6 py-4 flex gap-2">
                        <a href="{{ route('admin.messages.show', $message) }}" class="text-tract-600 font-medium">عرض</a>
                        <form method="POST" action="{{ route('admin.messages.destroy', $message) }}" onsubmit="return confirm('حذف؟')">@csrf @method('DELETE')<button class="text-red-500 font-medium">حذف</button></form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-6 py-8 text-center text-slate-500">لا توجد رسائل</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@if ($messages->hasPages())
    <div class="mt-4">{{ $messages->links() }}</div>
@endif
@endsection
