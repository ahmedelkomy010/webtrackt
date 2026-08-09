@extends('layouts.admin')

@section('title', 'شركاؤنا في النجاح')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">شركاؤنا في النجاح</h1>
        <p class="text-slate-600 text-sm mt-1">شعارات الشركات التي تم التعامل معها — تظهر في الصفحة الرئيسية</p>
    </div>
    <a href="{{ route('admin.success-partners.create') }}" class="px-4 py-2.5 rounded-xl bg-tract-600 text-white text-sm font-semibold hover:bg-tract-700">+ إضافة شريك</a>
</div>

<div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 border-b"><tr>
            <th class="text-start px-6 py-3 font-semibold text-slate-600">الشعار</th>
            <th class="text-start px-6 py-3 font-semibold text-slate-600">الاسم</th>
            <th class="text-start px-6 py-3 font-semibold text-slate-600">الترتيب</th>
            <th class="text-start px-6 py-3 font-semibold text-slate-600">الحالة</th>
            <th class="text-start px-6 py-3 font-semibold text-slate-600">إجراءات</th>
        </tr></thead>
        <tbody class="divide-y divide-slate-100">
            @forelse ($partners as $partner)
                <tr class="hover:bg-slate-50">
                    <td class="px-6 py-4">
                        <img src="{{ asset('storage/'.$partner->logo) }}" alt="{{ $partner->localizedName() }}" class="h-12 w-24 object-contain bg-slate-50 rounded-lg border border-slate-100 p-1">
                    </td>
                    <td class="px-6 py-4">{{ $partner->localizedName() ?: '—' }}</td>
                    <td class="px-6 py-4">{{ $partner->sort_order }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded-full text-xs font-medium {{ $partner->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">{{ $partner->is_active ? 'نشط' : 'مخفي' }}</span>
                    </td>
                    <td class="px-6 py-4 flex gap-2">
                        <a href="{{ route('admin.success-partners.edit', $partner) }}" class="text-tract-600 font-medium">تعديل</a>
                        <form method="POST" action="{{ route('admin.success-partners.destroy', $partner) }}" onsubmit="return confirm('حذف؟')">@csrf @method('DELETE')<button class="text-red-500 font-medium">حذف</button></form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-6 py-8 text-center text-slate-500">لا يوجد شركاء بعد — أضف أول شعار</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
