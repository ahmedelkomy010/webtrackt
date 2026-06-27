@extends('layouts.admin')

@section('title', 'الخدمات')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">الخدمات والباقات</h1>
        <p class="text-slate-600 text-sm mt-1">عدّل كل خدمة من «تعديل» — الباقات والأسعار في أسفل صفحة التعديل وتظهر تلقائياً في صفحة الخدمة</p>
    </div>
    <a href="{{ route('admin.services.create') }}" class="px-4 py-2.5 rounded-xl bg-tract-600 text-white text-sm font-semibold hover:bg-tract-700 transition-colors">
        + إضافة خدمة
    </a>
</div>

<div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 border-b border-slate-200">
            <tr>
                <th class="text-start px-6 py-3 font-semibold text-slate-600">#</th>
                <th class="text-start px-6 py-3 font-semibold text-slate-600">العنوان</th>
                <th class="text-start px-6 py-3 font-semibold text-slate-600">الباقات</th>
                <th class="text-start px-6 py-3 font-semibold text-slate-600">الأيقونة</th>
                <th class="text-start px-6 py-3 font-semibold text-slate-600">الحالة</th>
                <th class="text-start px-6 py-3 font-semibold text-slate-600">إجراءات</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse ($services as $service)
                <tr class="hover:bg-slate-50">
                    <td class="px-6 py-4 text-slate-500">{{ $service->sort_order }}</td>
                    <td class="px-6 py-4">
                        <p class="font-medium">{{ $service->title['ar'] ?? '' }}</p>
                        @if ($service->slug)
                            <a href="{{ route('services.show', $service->slug) }}" target="_blank" class="text-xs text-tract-600 font-mono hover:underline">/services/{{ $service->slug }}</a>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @php $offerCount = count($service->offers ?? []); @endphp
                        @if ($offerCount > 0)
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-tract-50 text-tract-700 text-xs font-semibold">{{ $offerCount }} باقة</span>
                            <ul class="mt-2 space-y-0.5 text-xs text-slate-500">
                                @foreach (collect($service->offers)->take(3) as $offer)
                                    <li>{{ $offer['name']['ar'] ?? '—' }} @if($offer['highlight'] ?? false)<span class="text-tract-600">★</span>@endif</li>
                                @endforeach
                            </ul>
                        @else
                            <span class="text-xs text-slate-400">لا توجد باقات</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">{{ $service->icon }}</td>
                    <td class="px-6 py-4">
                        @if ($service->is_active)
                            <span class="px-2 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-medium">نشط</span>
                        @else
                            <span class="px-2 py-1 rounded-full bg-slate-100 text-slate-500 text-xs font-medium">مخفي</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.services.edit', $service) }}#service-packages" class="text-amber-600 hover:text-amber-700 font-medium" title="تعديل الباقات">الباقات</a>
                            <span class="text-slate-300">|</span>
                            <a href="{{ route('admin.services.edit', $service) }}" class="text-tract-600 hover:text-tract-700 font-medium">تعديل</a>
                            <form method="POST" action="{{ route('admin.services.destroy', $service) }}" onsubmit="return confirm('هل أنت متأكد؟')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 font-medium">حذف</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="px-6 py-8 text-center text-slate-500">لا توجد خدمات — <a href="{{ route('admin.services.create') }}" class="text-tract-600">أضف أول خدمة</a></td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
