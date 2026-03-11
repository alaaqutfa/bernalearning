@extends('admin.layouts.app')

@section('title', 'عرض المستخدم')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- رأس الصفحة -->
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">عرض المستخدم</h1>
            <p class="text-gray-600 mt-1">تفاصيل المستخدم: {{ $user->email ?? $user->phone }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.users.edit', $user) }}"
               class="inline-flex items-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg">
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                </svg>
                تعديل البيانات
            </a>
            <a href="{{ route('admin.users.add-coupon', $user) }}"
               class="inline-flex items-center px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg">
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                إضافة اشتراك جديد
            </a>
        </div>
    </div>

    <!-- معلومات المستخدم -->
    <div class="bg-white rounded-lg shadow-sm border border-blue-500 overflow-hidden mb-6">
        <div class="p-6">
            <h2 class="text-xl font-semibold mb-4">معلومات المستخدم</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-500">الاسم</p>
                    <p class="font-medium">{{ $user->name ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">البريد الإلكتروني</p>
                    <p class="font-medium">{{ $user->email ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">رقم الهاتف</p>
                    <p class="font-medium">{{ $user->phone ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">تاريخ التسجيل</p>
                    <p class="font-medium">{{ $user->created_at->format('Y-m-d') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- إحصائيات الأرباح -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg shadow-sm border border-purple-200 p-6">
            <h3 class="text-lg font-semibold text-purple-800 mb-2">أرباح المالك (75%)</h3>
            <p class="text-3xl font-bold text-purple-600">${{ number_format($totalOwnerProfit, 2) }}</p>
        </div>
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg shadow-sm border border-blue-200 p-6">
            <h3 class="text-lg font-semibold text-blue-800 mb-2">أرباح المطور (25%)</h3>
            <p class="text-3xl font-bold text-blue-600">${{ number_format($totalDeveloperProfit, 2) }}</p>
        </div>
    </div>

    <!-- جدول الكوبونات (الاشتراكات) -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-semibold">الاشتراكات (الكوبونات)</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">الكوبون</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">المستوى</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">السعر</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">ربح المالك</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">ربح المطور</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">الحالة</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">تاريخ الإنشاء</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">إجراءات</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($user->coupons as $coupon)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-mono">{{ $coupon->code }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $coupon->level->title }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">${{ number_format($coupon->price, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-purple-600">${{ number_format($coupon->profit_owner, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-600">${{ number_format($coupon->profit_developer, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            @if($coupon->is_active)
                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">نشط</span>
                            @else
                                <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">معطل</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $coupon->created_at->format('Y-m-d') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            @if($coupon->is_active)
                            <form action="{{ route('admin.users.deactivate-coupon', $coupon) }}" method="POST" class="inline-block">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('هل أنت متأكد من تعطيل هذا الكوبون؟')">
                                    تعطيل
                                </button>
                            </form>
                            @else
                                <span class="text-gray-400">معطل</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-10 text-center text-gray-500">
                            لا يوجد اشتراكات لهذا المستخدم.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
