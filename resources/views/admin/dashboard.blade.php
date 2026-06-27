@extends('layouts.admin')

@section('title', 'الرئيسية')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-slate-900">مرحباً بك 👋</h1>
    <p class="text-slate-600 mt-1">إدارة محتوى موقع Trakkt Marketing — أي تعديل هنا يظهر تلقائياً في الموقع</p>
</div>

<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
    @foreach ([
        ['label' => 'الخدمات', 'value' => $stats['services'], 'route' => 'admin.services.index', 'color' => 'tract'],
        ['label' => 'الإحصائيات', 'value' => $stats['stats'], 'route' => 'admin.stats.index', 'color' => 'blue'],
        ['label' => 'لماذا تراكت', 'value' => $stats['why_us'], 'route' => 'admin.why-us.index', 'color' => 'amber'],
        ['label' => 'روابط القائمة', 'value' => $stats['nav_links'], 'route' => 'admin.nav-links.index', 'color' => 'purple'],
        ['label' => 'مقالات المدونة', 'value' => $stats['published_posts'], 'route' => 'admin.posts.index', 'color' => 'indigo'],
        ['label' => 'تقييمات العملاء', 'value' => $stats['reviews'], 'route' => 'admin.reviews.index', 'color' => 'gold'],
        ['label' => 'تقييمات معلقة', 'value' => $stats['pending_reviews'], 'route' => 'admin.reviews.index', 'color' => 'amber'],
        ['label' => 'رسائل التواصل', 'value' => $stats['messages'], 'route' => 'admin.messages.index', 'color' => 'emerald'],
        ['label' => 'رسائل هذا الأسبوع', 'value' => $stats['unread_messages'], 'route' => 'admin.messages.index', 'color' => 'rose'],
    ] as $card)
        <a href="{{ route($card['route']) }}" class="bg-white rounded-2xl p-6 border border-slate-200 hover:shadow-lg hover:border-tract-200 transition-all group">
            <p class="text-sm text-slate-500 mb-1">{{ $card['label'] }}</p>
            <p class="text-3xl font-bold text-slate-900 group-hover:text-tract-700 transition-colors">{{ $card['value'] }}</p>
        </a>
    @endforeach
</div>

<div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
        <h2 class="font-bold text-slate-900">آخر رسائل التواصل</h2>
        <a href="{{ route('admin.messages.index') }}" class="text-sm text-tract-600 hover:text-tract-700 font-medium">عرض الكل</a>
    </div>
    @if ($recentMessages->isEmpty())
        <p class="px-6 py-8 text-slate-500 text-sm text-center">لا توجد رسائل بعد</p>
    @else
        <div class="divide-y divide-slate-100">
            @foreach ($recentMessages as $msg)
                <a href="{{ route('admin.messages.show', $msg) }}" class="flex items-center justify-between px-6 py-4 hover:bg-slate-50 transition-colors">
                    <div>
                        <p class="font-medium text-slate-900">{{ $msg->name }}</p>
                        <p class="text-sm text-slate-500">{{ $msg->email }} — {{ $msg->service }}</p>
                    </div>
                    <span class="text-xs text-slate-400">{{ $msg->created_at->diffForHumans() }}</span>
                </a>
            @endforeach
        </div>
    @endif
</div>
@endsection
