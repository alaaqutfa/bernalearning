@extends('web.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">طلباتي</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500">#</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500">المستوى</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500">المبلغ</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500">الحالة</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500">تاريخ الطلب</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500"></th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($orders as $order)
                <tr>
                    <td class="px-6 py-4">{{ $order->id }}</td>
                    <td class="px-6 py-4">{{ $order->level->title }}</td>
                    <td class="px-6 py-4">${{ number_format($order->amount, 2) }}</td>
                    <td class="px-6 py-4">
                        @switch($order->status)
                            @case('pending') <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded">قيد الانتظار</span> @break
                            @case('payment_link_added') <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded">تم إنشاء رابط الدفع</span> @break
                            @case('pending_review') <span class="px-2 py-1 bg-purple-100 text-purple-800 rounded">بانتظار المراجعة</span> @break
                            @case('paid') <span class="px-2 py-1 bg-green-100 text-green-800 rounded">مدفوع</span> @break
                            @case('cancelled') <span class="px-2 py-1 bg-red-100 text-red-800 rounded">ملغي</span> @break
                        @endswitch
                    </td>
                    <td class="px-6 py-4">{{ $order->created_at->format('Y-m-d') }}</td>
                    <td class="px-6 py-4">
                        <a href="{{ route('orders.show', $order) }}" class="text-blue-600 hover:text-blue-900">عرض التفاصيل</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">لا توجد طلبات</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
