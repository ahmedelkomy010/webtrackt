@extends('layouts.admin')

@section('title', 'الطلبات')

@section('content')
<h1 class="text-2xl font-bold mb-6">الطلبات والمدفوعات</h1>

<div class="bg-white rounded-2xl border overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 border-b"><tr>
            <th class="text-start px-6 py-3 font-semibold text-slate-600">المرجع</th>
            <th class="text-start px-6 py-3 font-semibold text-slate-600">العميل</th>
            <th class="text-start px-6 py-3 font-semibold text-slate-600">المبلغ</th>
            <th class="text-start px-6 py-3 font-semibold text-slate-600">الحالة</th>
            <th class="text-start px-6 py-3 font-semibold text-slate-600">التاريخ</th>
            <th class="text-start px-6 py-3 font-semibold text-slate-600">إجراءات</th>
        </tr></thead>
        <tbody class="divide-y">
            @forelse ($orders as $order)
                <tr class="hover:bg-slate-50">
                    <td class="px-6 py-4 font-mono text-xs" dir="ltr">{{ $order->reference }}</td>
                    <td class="px-6 py-4">
                        <p class="font-medium">{{ $order->customer_name }}</p>
                        <p class="text-slate-500 text-xs">{{ $order->customer_email }}</p>
                    </td>
                    <td class="px-6 py-4">{{ $order->formattedAmount() }}</td>
                    <td class="px-6 py-4">
                        @php
                            $statusColors = [
                                'paid' => 'bg-emerald-100 text-emerald-800',
                                'unpaid' => 'bg-amber-100 text-amber-800',
                                'failed' => 'bg-red-100 text-red-800',
                                'processing' => 'bg-blue-100 text-blue-800',
                            ];
                            $color = $statusColors[$order->payment_status] ?? 'bg-slate-100 text-slate-700';
                        @endphp
                        <span class="px-2 py-1 rounded-full text-xs font-medium {{ $color }}">{{ $order->payment_status }}</span>
                    </td>
                    <td class="px-6 py-4 text-slate-500">{{ $order->created_at->format('Y-m-d H:i') }}</td>
                    <td class="px-6 py-4">
                        <a href="{{ route('admin.orders.show', $order) }}" class="text-tract-600 font-medium">عرض</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="px-6 py-8 text-center text-slate-500">لا توجد طلبات بعد</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@if ($orders->hasPages())
    <div class="mt-4">{{ $orders->links() }}</div>
@endif
@endsection
