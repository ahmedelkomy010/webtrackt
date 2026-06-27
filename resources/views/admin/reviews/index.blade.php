@extends('layouts.admin')

@section('title', 'تقييمات العملاء')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">تقييمات العملاء</h1>
        <p class="text-slate-600 text-sm mt-1">
            التقييمات المعتمدة تظهر في <a href="/#reviews" target="_blank" class="text-tract-600 hover:underline">قسم آراء العملاء</a>
            @if ($pendingCount > 0)
                — <span class="text-amber-600 font-semibold">{{ $pendingCount }} بانتظار الموافقة</span>
            @endif
        </p>
    </div>
    <a href="{{ route('admin.reviews.create') }}" class="px-4 py-2.5 rounded-xl bg-tract-600 text-white text-sm font-semibold hover:bg-tract-700">+ إضافة تقييم</a>
</div>

<div class="bg-white rounded-2xl border overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 border-b"><tr>
            <th class="text-start px-6 py-3 font-semibold text-slate-600">العميل</th>
            <th class="text-start px-6 py-3 font-semibold text-slate-600">التقييم</th>
            <th class="text-start px-6 py-3 font-semibold text-slate-600">الرأي</th>
            <th class="text-start px-6 py-3 font-semibold text-slate-600">الحالة</th>
            <th class="text-start px-6 py-3 font-semibold text-slate-600">إجراءات</th>
        </tr></thead>
        <tbody class="divide-y">
            @forelse ($reviews as $review)
                <tr class="hover:bg-slate-50 {{ !$review->is_approved ? 'bg-amber-50/50' : '' }}">
                    <td class="px-6 py-4">
                        <p class="font-medium">{{ $review->name }}</p>
                        @if ($review->company)<p class="text-xs text-slate-500">{{ $review->company }}</p>@endif
                        <p class="text-xs text-slate-400">{{ $review->created_at->format('Y-m-d') }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-gold-500 font-bold">{{ str_repeat('★', $review->rating) }}</span>
                        <span class="text-slate-300">{{ str_repeat('★', 5 - $review->rating) }}</span>
                    </td>
                    <td class="px-6 py-4 max-w-xs">
                        <p class="text-slate-600 line-clamp-2">{{ $review->comment['ar'] ?? '' }}</p>
                    </td>
                    <td class="px-6 py-4">
                        @if ($review->is_approved)
                            <span class="px-2 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-medium">منشور</span>
                        @else
                            <span class="px-2 py-1 rounded-full bg-amber-50 text-amber-700 text-xs font-medium">معلق</span>
                        @endif
                        @if ($review->is_featured)
                            <span class="block mt-1 px-2 py-1 rounded-full bg-gold-50 text-gold-700 text-xs font-medium w-fit">مميز</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex flex-wrap gap-2">
                            @if (!$review->is_approved)
                                <form method="POST" action="{{ route('admin.reviews.approve', $review) }}">@csrf @method('PATCH')
                                    <button type="submit" class="text-emerald-600 font-medium hover:text-emerald-700">موافقة</button>
                                </form>
                            @endif
                            <a href="{{ route('admin.reviews.edit', $review) }}" class="text-tract-600 font-medium">تعديل</a>
                            <form method="POST" action="{{ route('admin.reviews.destroy', $review) }}" onsubmit="return confirm('حذف؟')">@csrf @method('DELETE')
                                <button class="text-red-500 font-medium">حذف</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-6 py-8 text-center text-slate-500">لا توجد تقييمات</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@if ($reviews->hasPages())<div class="mt-4">{{ $reviews->links() }}</div>@endif
@endsection
