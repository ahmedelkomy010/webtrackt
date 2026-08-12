@extends('layouts.admin')

@section('title', 'تفاصيل الطلب')

@section('content')
<div class="mb-6 flex items-center justify-between gap-4">
    <h1 class="text-2xl font-bold">تفاصيل الطلب</h1>
    <a href="{{ route('admin.orders.index') }}" class="text-sm text-tract-600">← العودة للطلبات</a>
</div>

<div class="grid lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-2xl border p-6">
            <h2 class="font-bold text-lg mb-4">الباقات</h2>
            <ul class="divide-y">
                @foreach ($order->items as $item)
                    <li class="py-4 flex justify-between gap-4">
                        <div>
                            <p class="font-semibold">{{ $item->name }}</p>
                            @if ($item->service)
                                <p class="text-sm text-slate-500">{{ $item->service->localized('title', 'ar') }}</p>
                            @endif
                            @if ($item->price_label)
                                <p class="text-xs text-slate-400 mt-1">{{ $item->price_label }}</p>
                            @endif
                        </div>
                        <p class="font-medium shrink-0">{{ $item->formattedAmount() }}</p>
                    </li>
                @endforeach
            </ul>
            <div class="border-t pt-4 mt-2 flex justify-between font-bold">
                <span>الإجمالي</span>
                <span>{{ $order->formattedAmount() }}</span>
            </div>
        </div>

        @if ($order->customer_notes)
            <div class="bg-white rounded-2xl border p-6">
                <h2 class="font-bold text-lg mb-2">ملاحظات العميل</h2>
                <p class="text-slate-700 whitespace-pre-wrap">{{ $order->customer_notes }}</p>
            </div>
        @endif
    </div>

    <div class="space-y-6">
        <div class="bg-white rounded-2xl border p-6 space-y-3 text-sm">
            <h2 class="font-bold text-lg mb-2">معلومات الطلب</h2>
            <p><span class="text-slate-500">المرجع:</span> <span dir="ltr" class="font-mono">{{ $order->reference }}</span></p>
            <p><span class="text-slate-500">UUID:</span> <span dir="ltr" class="font-mono text-xs break-all">{{ $order->uuid }}</span></p>
            <p><span class="text-slate-500">حالة الطلب:</span> {{ $order->status }}</p>
            <p><span class="text-slate-500">حالة الدفع:</span> {{ $order->payment_status }}</p>
            <p><span class="text-slate-500">طريقة الدفع:</span> {{ $order->payment_method ?? '—' }}</p>
            <p><span class="text-slate-500">البوابة:</span> {{ $order->payment_gateway ?? '—' }}</p>
            @if ($order->gateway_payment_id)
                <p><span class="text-slate-500">معرف الدفع:</span> <span dir="ltr" class="font-mono text-xs">{{ $order->gateway_payment_id }}</span></p>
            @endif
            @if ($order->paid_at)
                <p><span class="text-slate-500">تاريخ الدفع:</span> {{ $order->paid_at->format('Y-m-d H:i') }}</p>
            @endif
            <p><span class="text-slate-500">تاريخ الإنشاء:</span> {{ $order->created_at->format('Y-m-d H:i') }}</p>
        </div>

        <div class="bg-white rounded-2xl border p-6 space-y-2 text-sm">
            <h2 class="font-bold text-lg mb-2">العميل</h2>
            <p class="font-semibold">{{ $order->customer_name }}</p>
            <p>{{ $order->customer_email }}</p>
            <p dir="ltr">{{ $order->customer_phone }}</p>
            @if ($order->customer_company)
                <p>{{ $order->customer_company }}</p>
            @endif
        </div>
    </div>
</div>
@endsection
