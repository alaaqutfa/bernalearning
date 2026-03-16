@extends('admin.layouts.app')

@section('title', 'تفاصيل الطلب #'.$order->id)

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6">تفاصيل الطلب #{{ $order->id }}</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-bold mb-4">معلومات الطالب</h2>
            <p><strong>الاسم:</strong> {{ $order->user->name ?? 'غير محدد' }}</p>
            <p><strong>البريد:</strong> {{ $order->user->email }}</p>
            <p><strong>الهاتف:</strong> {{ $order->user->phone }}</p>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-bold mb-4">معلومات الطلب</h2>
            <p><strong>المستوى:</strong> {{ $order->level->title }}</p>
            <p><strong>المبلغ:</strong> ${{ number_format($order->amount, 2) }}</p>
            <p><strong>الحالة:</strong>
                @switch($order->status)
                    @case('pending') <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded">قيد الانتظار</span> @break
                    @case('payment_link_added') <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded">تم إنشاء رابط الدفع</span> @break
                    @case('pending_review') <span class="px-2 py-1 bg-purple-100 text-purple-800 rounded">بانتظار المراجعة</span> @break
                    @case('paid') <span class="px-2 py-1 bg-green-100 text-green-800 rounded">مدفوع</span> @break
                    @case('cancelled') <span class="px-2 py-1 bg-red-100 text-red-800 rounded">ملغي</span> @break
                @endswitch
            </p>
            <p><strong>تاريخ الطلب:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</p>
            @if($order->payment_link)
                <p><strong>رابط الدفع:</strong> <a href="{{ $order->payment_link }}" target="_blank" class="text-blue-600">{{ $order->payment_link }}</a></p>
                <p><strong>تاريخ إضافة الرابط:</strong> {{ $order->payment_link_created_at ? $order->payment_link_created_at->format('Y-m-d H:i') : '' }}</p>
            @endif
            @if($order->receipt_image)
                <p><strong>الإيصال:</strong> <a href="{{ Storage::url($order->receipt_image) }}" target="_blank" class="text-blue-600">عرض</a></p>
            @endif
            @if($order->notes)
                <p><strong>ملاحظات:</strong> {{ $order->notes }}</p>
            @endif
        </div>
    </div>

    @if($order->status === 'pending')
        <div class="mt-6 bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-bold mb-4">إضافة رابط الدفع</h2>
            <form action="{{ route('admin.orders.add-payment-link', $order) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">رابط الدفع</label>
                    <input type="url" name="payment_link" required class="w-full border rounded p-2">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">ملاحظات</label>
                    <textarea name="notes" rows="3" class="w-full border rounded p-2"></textarea>
                </div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">حفظ الرابط</button>
            </form>
        </div>
    @endif

    @if($order->status === 'pending_review')
        <div class="mt-6 bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-bold mb-4">مراجعة الإيصال وتأكيد الدفع</h2>
            @if($order->receipt_image)
                <div class="mb-4">
                    <img src="{{ asset("storage/app/public/".$order->receipt_image) }}" alt="Receipt" class="max-w-md border">
                </div>
            @endif
            <form action="{{ route('admin.orders.confirm-payment', $order) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">ملاحظات</label>
                    <textarea name="notes" rows="3" class="w-full border rounded p-2"></textarea>
                </div>
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">تأكيد الدفع وإنشاء الكوبون</button>
                <a href="{{ route('admin.orders.cancel', $order) }}" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700" onclick="event.preventDefault(); if(confirm('هل أنت متأكد؟')) document.getElementById('cancel-form').submit();">إلغاء الطلب</a>
            </form>
            <form id="cancel-form" action="{{ route('admin.orders.cancel', $order) }}" method="POST" class="hidden">
                @csrf
            </form>
        </div>
    @endif

    @if($order->status === 'paid')
        <div class="mt-6 bg-white rounded-lg shadow p-6">
            <p class="text-green-700">تم تأكيد الدفع وإنشاء الكوبون للمستخدم.</p>
        </div>
    @endif
</div>
@endsection
