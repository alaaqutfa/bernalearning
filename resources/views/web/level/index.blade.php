@extends('web.layouts.app')

@section('title', 'جميع المستويات')

@section('content')
    <div class="bg-gray-50 min-h-screen py-8">
        <div class="container mx-auto px-4">
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
                        @php
                            $videosCount = $level->videos_count ?? $level->videos->count();
                        @endphp
                        <div
                            class="bg-white rounded-xl shadow-md overflow-hidden border border-blue-500 hover:shadow-lg transition">
                            <div class="p-5">
                                <h3 class="text-lg font-bold text-gray-800 mb-2">{{ $level->title }}</h3>
                                <p class="text-gray-600 text-sm mb-3 line-clamp-1" title="{{ $level->description }}">
                                    {{ Str::limit($level->description, 80) }}</p>
                                <div class="flex justify-between items-center mb-4">
                                    @if ($videosCount > 0)
                                        <span class="text-xl font-bold text-blue-600">
                                            ${{ number_format($level->price, 2) }}
                                        </span>
                                    @else
                                        <span class="text-xl font-bold text-blue-600">0.00</span>
                                    @endif
                                    <span class="text-sm text-gray-500">
                                        <svg class="w-4 h-4 inline ml-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        {{ $videosCount }} فيديو
                                    </span>
                                </div>
                                @if ($subscribedLevels->contains('id', $level->id))
                                    <span
                                        class="cursor-pointer inline-block w-full text-center px-4 py-2 bg-gray-100 text-gray-600 rounded-lg text-sm">
                                        <svg class="w-4 h-4 inline ml-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        مشترك بالفعل
                                    </span>
                                @elseif($existingPendingOrder = $user->orders()->where('level_id', $level->id)->whereNotIn('status', ['paid', 'cancelled'])->first())
                                    <a href="{{ route('orders.show', $existingPendingOrder) }}"
                                        class="inline-block w-full text-center bg-yellow-500 text-white px-4 py-2 rounded-lg">متابعة الطلب الحالي</a>
                                @else
                                    @if ($videosCount > 0)
                                        <form method="POST" action="{{ route('orders.store') }}">
                                            @csrf
                                            <input type="hidden" name="level_id" value="{{ $level->id }}">
                                            <button type="submit"
                                                class="cursor-pointer inline-block w-full text-center bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">اشترك
                                                الآن</button>
                                        </form>
                                    @else
                                        <span
                                            class="cursor-pointer inline-block w-full text-center px-4 py-2 bg-yellow-100 text-yellow-600 rounded-lg text-sm">
                                            قريباً...
                                        </span>
                                    @endif
                                @endif
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
                                                    <svg class="w-4 h-4 inline ml-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
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
        </div>
    </div>
@endsection
