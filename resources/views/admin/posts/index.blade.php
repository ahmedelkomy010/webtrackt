@extends('layouts.admin')

@section('title', 'المقالات')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">مقالات المدونة (SEO)</h1>
        <p class="text-slate-600 text-sm mt-1">المقالات المنشورة تظهر تلقائياً في <a href="{{ route('blog.index') }}" target="_blank" class="text-tract-600 hover:underline">/blog</a> وتُفهرس في Google</p>
    </div>
    <a href="{{ route('admin.posts.create') }}" class="px-4 py-2.5 rounded-xl bg-tract-600 text-white text-sm font-semibold hover:bg-tract-700">+ مقال جديد</a>
</div>

<div class="bg-white rounded-2xl border overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 border-b"><tr>
            <th class="text-start px-6 py-3 font-semibold text-slate-600">العنوان</th>
            <th class="text-start px-6 py-3 font-semibold text-slate-600">Slug</th>
            <th class="text-start px-6 py-3 font-semibold text-slate-600">المشاهدات</th>
            <th class="text-start px-6 py-3 font-semibold text-slate-600">الحالة</th>
            <th class="text-start px-6 py-3 font-semibold text-slate-600">إجراءات</th>
        </tr></thead>
        <tbody class="divide-y">
            @forelse ($posts as $post)
                <tr class="hover:bg-slate-50">
                    <td class="px-6 py-4">
                        <p class="font-medium">{{ $post->title['ar'] ?? '' }}</p>
                        <p class="text-xs text-slate-400">{{ $post->published_at?->format('Y-m-d') ?? '—' }}</p>
                    </td>
                    <td class="px-6 py-4 font-mono text-xs text-tract-600">
                        <a href="{{ route('blog.show', $post->slug) }}" target="_blank" class="hover:underline">{{ $post->slug }}</a>
                    </td>
                    <td class="px-6 py-4">{{ $post->views }}</td>
                    <td class="px-6 py-4">
                        @if ($post->is_published)
                            <span class="px-2 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-medium">منشور</span>
                        @else
                            <span class="px-2 py-1 rounded-full bg-amber-50 text-amber-700 text-xs font-medium">مسودة</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 flex gap-2">
                        <a href="{{ route('admin.posts.edit', $post) }}" class="text-tract-600 font-medium">تعديل</a>
                        <form method="POST" action="{{ route('admin.posts.destroy', $post) }}" onsubmit="return confirm('حذف المقال؟')">@csrf @method('DELETE')<button class="text-red-500 font-medium">حذف</button></form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-6 py-8 text-center text-slate-500">لا توجد مقالات — <a href="{{ route('admin.posts.create') }}" class="text-tract-600">أضف أول مقال SEO</a></td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@if ($posts->hasPages())<div class="mt-4">{{ $posts->links() }}</div>@endif
@endsection
