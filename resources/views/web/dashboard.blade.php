@extends('web.layouts.app')

@section('title', 'لوحة التحكم')

@section('content')
    <div class="bg-gray-50 min-h-screen py-8">
        <div class="container mx-auto px-4">
            <!-- Header with user info -->
            <div
                class="bg-white rounded-2xl shadow-sm p-6 mb-8 flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-800">مرحباً بك، {{ $user->name ?? 'عزيزي المستخدم' }}
                    </h1>
                    <p class="text-gray-600 mt-1">{{ $user->email ?? $user->phone }}</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <span class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-800 rounded-full text-sm">
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        {{ $coupons->count() }} كوبونات
                    </span>
                </div>
            </div>

            <!-- Subscribed Levels Section -->
            @if ($subscribedLevels->count() > 0)
                <div class="mb-12">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                        <svg class="w-6 h-6 ml-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        مستوياتي المشترك بها
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($subscribedLevels as $level)
                            <div
                                class="bg-white rounded-xl shadow-md overflow-hidden border-t-4 border-green-500 hover:shadow-lg transition">
                                <div class="p-5">
                                    <h3 class="text-lg font-bold text-gray-800 mb-2">{{ $level->title }}</h3>
                                    <p class="text-gray-600 text-sm mb-4">{{ Str::limit($level->description, 80) }}</p>
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-500">
                                            <svg class="w-4 h-4 inline ml-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                            {{ $level->videos_count ?? $level->videos->count() }} فيديو
                                        </span>
                                        <a href="{{ route('level.show', $level->slug) }}"
                                            class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm rounded-lg transition">
                                            الدخول للمحتوى
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- All Levels Section (for subscription) -->
            <div class="mb-12">
                <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <svg class="w-6 h-6 ml-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                        </path>
                    </svg>
                    جميع المستويات المتاحة
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($levels as $level)
                        <div class="bg-white rounded-xl shadow-md overflow-hidden border hover:shadow-lg transition">
                            <div class="p-5">
                                <h3 class="text-lg font-bold text-gray-800 mb-2">{{ $level->title }}</h3>
                                <p class="text-gray-600 text-sm mb-3">{{ Str::limit($level->description, 80) }}</p>
                                <div class="flex justify-between items-center mb-4">
                                    <span
                                        class="text-xl font-bold text-blue-600">${{ number_format($level->price, 2) }}</span>
                                    <span class="text-sm text-gray-500">
                                        <svg class="w-4 h-4 inline ml-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        {{ $level->videos_count ?? $level->videos->count() }} فيديو
                                    </span>
                                </div>
                                @if ($subscribedLevels->contains('id', $level->id))
                                    <span
                                        class="inline-block w-full text-center px-4 py-2 bg-gray-100 text-gray-600 rounded-lg text-sm">
                                        <svg class="w-4 h-4 inline ml-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        مشترك بالفعل
                                    </span>
                                @else
                                    <a href="https://wa.me/+96181139596?text={{ urlencode('مرحبا أريد الاشتراك في دورة ' . $level->title . ' من موقع Berna Violin Art') }}"
                                        target="_blank"
                                        class="inline-flex items-center justify-center w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-lg transition">
                                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                            </path>
                                        </svg>
                                        اشترك الآن عبر واتساب
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- My Coupons Section -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <svg class="w-6 h-6 ml-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z">
                        </path>
                    </svg>
                    كوبوناتي
                </h2>
                @if ($coupons->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500">الكوبون</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500">المستوى</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500">تاريخ الإنشاء</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500">الحالة</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($coupons as $coupon)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap font-mono text-sm text-gray-900">
                                            {{ $coupon->code }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $coupon->level->title }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $coupon->created_at->format('Y-m-d') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($coupon->is_active)
                                                <span
                                                    class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">نشط</span>
                                            @else
                                                <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">غير
                                                    نشط</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">لا توجد كوبونات بعد. اشترك في أحد المستويات لتحصل على كوبونك.
                    </p>
                @endif
            </div>
        </div>
    </div>
@endsection
