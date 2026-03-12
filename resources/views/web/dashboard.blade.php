@extends('web.layouts.app')

@section('title', 'لوحة التحكم')

@section('content')
    <div class="bg-gray-50 min-h-screen py-8">
        <div class="container mx-auto px-4">
            <!-- Header with user info -->
            <div
                class="bg-white rounded-2xl shadow-sm p-6 mb-8 flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-800">مرحباً بك، {{ $user->name ?? 'عزيزي الطالب' }}
                    </h1>
                    <p class="text-gray-600 mt-1">{{ $user->email ?? $user->phone }}</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <span class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-800 rounded-full text-sm">
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        {{ $coupons->count() }} اشتراكات
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
                                    <p class="text-gray-600 text-sm mb-4 line-clamp-1" title="{{ $level->description }}">
                                        {{ Str::limit($level->description, 80) }}</p>
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
                                            <svg class="w-4 h-4 mr-2 rtl:rotate-180" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                                <div class="p-5 border-t border-blue-500 hover:shadow-lg transition">
                                    @if (count($level->videos) > 0)
                                        <ul class="flex justify-start items-start flex-col gap-2">
                                            @foreach ($level->videos as $video)
                                                @php
                                                    $isWatched = in_array($video->id, $watchedVideoIds);
                                                @endphp
                                                <li
                                                    class="flex justify-start items-start gap-2 @if (!$isWatched) text-blue-500 hover:text-blue-600 @else text-green-500 hover:text-green-600 @endif h-4">
                                                    @if ($isWatched)
                                                        <svg class="w-4 h-4 inline ml-1" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                        </svg>
                                                    @else
                                                        <svg class="w-4 h-4 inline ml-1" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z">
                                                            </path>
                                                        </svg>
                                                    @endif
                                                    <span class="text-sm">{{ $video->title }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- My Coupons Section -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <svg class="w-6 h-6 ml-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z">
                        </path>
                    </svg>
                    اشتراكاتي
                </h2>
                @if ($coupons->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500">الاشتراك</th>
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
                    <p class="text-gray-500 text-center py-4">
                        لا توجد اشتراكات بعد. اشترك في أحد <a href="{{ route('level.index') }}"
                            class="text-blue-500">المستويات</a> لتحصل على اشتراكك.
                    </p>
                @endif
            </div>
        </div>
    </div>
@endsection
