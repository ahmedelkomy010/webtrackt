@extends('layouts.admin')

@section('title', 'روابط القائمة')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div><h1 class="text-2xl font-bold">روابط القائمة</h1><p class="text-slate-600 text-sm mt-1">تظهر تلقائياً في الهيدر والفوتر</p></div>
    <a href="{{ route('admin.nav-links.create') }}" class="px-4 py-2.5 rounded-xl bg-tract-600 text-white text-sm font-semibold">+ إضافة رابط</a>
</div>

<div class="bg-white rounded-2xl border overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 border-b"><tr>
            <th class="text-start px-6 py-3 font-semibold text-slate-600">النص</th>
            <th class="text-start px-6 py-3 font-semibold text-slate-600">الرابط</th>
            <th class="text-start px-6 py-3 font-semibold text-slate-600">الحالة</th>
            <th class="text-start px-6 py-3 font-semibold text-slate-600">إجراءات</th>
        </tr></thead>
        <tbody class="divide-y">
            @forelse ($links as $link)
                <tr class="hover:bg-slate-50">
                    <td class="px-6 py-4 font-medium">{{ $link->label['ar'] ?? '' }}</td>
                    <td class="px-6 py-4 font-mono text-tract-600">{{ $link->href }}</td>
                    <td class="px-6 py-4"><span class="px-2 py-1 rounded-full text-xs {{ $link->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">{{ $link->is_active ? 'نشط' : 'مخفي' }}</span></td>
                    <td class="px-6 py-4 flex gap-2">
                        <a href="{{ route('admin.nav-links.edit', $link) }}" class="text-tract-600 font-medium">تعديل</a>
                        <form method="POST" action="{{ route('admin.nav-links.destroy', $link) }}" onsubmit="return confirm('حذف؟')">@csrf @method('DELETE')<button class="text-red-500 font-medium">حذف</button></form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="px-6 py-8 text-center text-slate-500">لا توجد روابط</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
