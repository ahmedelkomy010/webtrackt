@extends('layouts.admin')

@section('title', 'أعمالنا')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">أعمالنا</h1>
        <p class="text-slate-600 text-sm mt-1">مشاريع وأعمال سابقة — صورة، وصف، ورابط لكل عمل</p>
    </div>
    <a href="{{ route('admin.works.create') }}" class="px-4 py-2.5 rounded-xl bg-tract-600 text-white text-sm font-semibold hover:bg-tract-700">+ إضافة عمل</a>
</div>

<div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 border-b"><tr>
            <th class="text-start px-6 py-3 font-semibold text-slate-600">الصورة</th>
            <th class="text-start px-6 py-3 font-semibold text-slate-600">العنوان</th>
            <th class="text-start px-6 py-3 font-semibold text-slate-600">الرابط</th>
            <th class="text-start px-6 py-3 font-semibold text-slate-600">الترتيب</th>
            <th class="text-start px-6 py-3 font-semibold text-slate-600">الحالة</th>
            <th class="text-start px-6 py-3 font-semibold text-slate-600">إجراءات</th>
        </tr></thead>
        <tbody class="divide-y divide-slate-100">
            @forelse ($works as $work)
                <tr class="hover:bg-slate-50">
                    <td class="px-6 py-4">
                        <img src="{{ asset('storage/'.$work->image) }}" alt="" class="h-14 w-24 object-cover rounded-lg border border-slate-100">
                    </td>
                    <td class="px-6 py-4">{{ $work->localized('title') }}</td>
                    <td class="px-6 py-4 max-w-[180px] truncate" dir="ltr"><a href="{{ $work->url }}" target="_blank" class="text-tract-600 hover:underline">{{ $work->url }}</a></td>
                    <td class="px-6 py-4">{{ $work->sort_order }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded-full text-xs font-medium {{ $work->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">{{ $work->is_active ? 'نشط' : 'مخفي' }}</span>
                    </td>
                    <td class="px-6 py-4 flex gap-2">
                        <a href="{{ route('admin.works.edit', $work) }}" class="text-tract-600 font-medium">تعديل</a>
                        <form method="POST" action="{{ route('admin.works.destroy', $work) }}" onsubmit="return confirm('حذف؟')">@csrf @method('DELETE')<button class="text-red-500 font-medium">حذف</button></form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="px-6 py-8 text-center text-slate-500">لا توجد أعمال بعد</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
