@extends('admin.layouts.app')

@section('title', 'إدارة الطلبات')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6">الطلبات</h1>

    <form method="GET" class="mb-4">
        <select name="status" onchange="this.form.submit()" class="border border-blue-500 rounded p-2">
            <option value="">جميع الحالات</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
            <option value="payment_link_added" {{ request('status') == 'payment_link_added' ? 'selected' : '' }}>تم إنشاء رابط الدفع</option>
            <option value="pending_review" {{ request('status') == 'pending_review' ? 'selected' : '' }}>بانتظار المراجعة</option>
            <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>مدفوع</option>
            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>ملغي</option>
        </select>
    </form>

    <div class="bg-white rounded-lg shadow shadow-blue-200 overflow-hidden">
        <table class="min-w-full divide-y divide-blue-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500">#</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500">الطالب</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500">المستوى</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500">المبلغ</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500">الحالة</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500">تاريخ الطلب</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500"></th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-blue-200">
                @forelse($orders as $order)
                <tr>
                    <td class="px-6 py-4">{{ $order->id }}</td>
                    <td class="px-6 py-4">{{ $order->user->phone }}<br>{{ $order->user->email }}</td>
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
                        <a href="{{ route('admin.orders.show', $order) }}" class="text-blue-600 hover:text-blue-900">عرض</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">لا توجد طلبات</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $orders->links() }}
</div>
@endsection
