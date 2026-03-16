@extends('web.layouts.app')

@section('title', 'تفاصيل الطلب #'.$order->id)

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <h1 class="text-2xl font-bold mb-6">تفاصيل الطلب #{{ $order->id }}</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow p-6">
        <div class="mb-4">
            <p class="text-gray-700"><strong>المستوى:</strong> {{ $order->level->title }}</p>
            <p class="text-gray-700"><strong>المبلغ:</strong> ${{ number_format($order->amount, 2) }}</p>
            <p class="text-gray-700"><strong>الحالة:</strong>
                @switch($order->status)
                    @case('pending') <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded">قيد الانتظار</span> @break
                    @case('payment_link_added') <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded">تم إنشاء رابط الدفع</span> @break
                    @case('pending_review') <span class="px-2 py-1 bg-purple-100 text-purple-800 rounded">بانتظار المراجعة</span> @break
                    @case('paid') <span class="px-2 py-1 bg-green-100 text-green-800 rounded">مدفوع</span> @break
                    @case('cancelled') <span class="px-2 py-1 bg-red-100 text-red-800 rounded">ملغي</span> @break
                @endswitch
            </p>
            <p class="text-gray-700"><strong>تاريخ الطلب:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</p>
        </div>

        @if($order->status === 'pending')
            <div class="bg-yellow-50 border border-yellow-200 rounded p-4 mb-4">
                <p class="text-yellow-700">طلبك قيد الانتظار. سيتم إنشاء رابط الدفع قريباً من قبل الإدارة.</p>
            </div>
        @endif

        @if($order->status === 'payment_link_added' && $order->payment_link)
            <div class="bg-blue-50 border border-blue-200 rounded p-4 mb-4">
                <p class="text-blue-700 mb-2">تم إنشاء رابط الدفع الخاص بك. يرجى النقر على الرابط أدناه لإتمام الدفع:</p>
                <a href="{{ $order->payment_link }}" target="_blank" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    رابط الدفع
                </a>
                <p class="text-sm text-gray-600 mt-2">بعد إتمام الدفع، قم برفع صورة الإيصال أدناه.</p>
            </div>

            <form action="{{ route('orders.upload-receipt', $order) }}" method="POST" enctype="multipart/form-data" class="mt-4">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">صورة الإيصال</label>
                    <input type="file" name="receipt" accept="image/*" required class="w-full border rounded p-2">
                    @error('receipt')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    رفع الإيصال وتأكيد الدفع
                </button>
            </form>
        @endif

        @if($order->status === 'pending_review')
            <div class="bg-purple-50 border border-purple-200 rounded p-4">
                <p class="text-purple-700">تم رفع الإيصال، وهو قيد المراجعة من قبل الإدارة. سيتم تفعيل اشتراكك بعد التأكيد.</p>
                @if($order->receipt_image)
                {{-- https://berna-violin.art/storage/receipts/XDeMvfhfI4jCANd4zti8Z2EYcFOWyLhMoXoq7a5T.png --}}
                    <p class="mt-2"><a href="{{ asset("storage/app/public/".$order->receipt_image) }}" target="_blank" class="text-blue-600">عرض الإيصال</a></p>
                @endif
            </div>
        @endif

        @if($order->status === 'paid')
            <div class="bg-green-50 border border-green-200 rounded p-4">
                <p class="text-green-700">تم تأكيد الدفع! يمكنك الآن الوصول إلى محتوى المستوى.</p>
                <a href="{{ route('level.show', $order->level) }}" class="inline-block mt-2 bg-green-600 text-white px-4 py-2 rounded">الذهاب إلى المستوى</a>
            </div>
        @endif

        @if($order->status === 'cancelled')
            <div class="bg-red-50 border border-red-200 rounded p-4">
                <p class="text-red-700">تم إلغاء الطلب.</p>
            </div>
        @endif
    </div>
</div>
@endsection
