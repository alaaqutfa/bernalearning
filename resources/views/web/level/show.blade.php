@extends('web.layouts.app')

@section('title', $level->title . ' - مستوى')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-col lg:flex-row gap-6">
            <!-- العمود الرئيسي: الفيديو والمعلومات -->
            <div class="lg:w-2/3">
                <!-- مشغل الفيديو -->
                <div class="bg-black rounded-lg overflow-hidden shadow-lg mb-4">
                    @include('web.level.partials.video-player', [
                        'video' => $video,
                        'signedUrl' => $signedUrl,
                    ])
                </div>

                <!-- معلومات المستوى -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $level->title }}</h1>
                    <p class="text-gray-600 mb-4">{{ $level->description }}</p>

                    <!-- شريط تقدم المستوى -->
                    <div class="w-full bg-gray-200 rounded-full h-2.5 mb-4">
                        <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $progressPercentage }}%"></div>
                    </div>
                    <p class="text-sm text-gray-500">{{ $progressPercentage }}% مكتمل
                        ({{ count($watchedVideos) }}/{{ $videos->count() }})</p>
                </div>
            </div>

            <!-- الشريط الجانبي: قائمة التشغيل -->
            <div class="lg:w-1/3">
                <div class="bg-white rounded-lg shadow">
                    <div class="p-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">جميع فيديوهات المستوى</h3>
                        <p class="text-sm text-gray-500">{{ $videos->count() }} فيديو</p>
                    </div>
                    <div class="divide-y divide-gray-200 max-h-[600px] overflow-y-auto">
                        @foreach ($videos as $vid)
                            @php
                                $thumbUrl = $bunny->signedThumbnailUrl($vid->bunny_video_id, 2592000); // 30 يوم
                                $isWatched = in_array($vid->id, $watchedVideos);
                                $isCurrent = $vid->id === $video->id;
                            @endphp
                            <a href="{{ route('level.show', ['level' => $level->slug, 'video' => $vid->id]) }}"
                                class="flex items-start p-4 hover:bg-gray-50 transition {{ $isCurrent ? 'bg-blue-50 border-r-4 border-blue-500' : '' }}">
                                <div class="flex-shrink-0 relative">
                                    <img src="{{ $thumbUrl }}" alt="{{ $vid->title }}"
                                        class="w-40 h-24 object-cover rounded">
                                    @if ($vid->duration)
                                        <span
                                            class="absolute bottom-1 right-1 bg-black bg-opacity-70 text-white text-xs px-1 rounded">
                                            {{ gmdate('i:s', $vid->duration) }}
                                        </span>
                                    @endif
                                    @if ($isWatched)
                                        <span
                                            class="absolute top-1 left-1 bg-green-500 text-white text-xs px-1 rounded">تمت</span>
                                    @endif
                                </div>
                                <div class="mr-4 flex-1 min-w-0">
                                    <h4 class="text-sm font-medium text-gray-900 line-clamp-2">{{ $vid->title }}</h4>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        (function() {
            // منع اختصارات لوحة المفاتيح
            document.addEventListener('keydown', function(e) {
                // F12
                if (e.key === 'F12') {
                    e.preventDefault();
                    return false;
                }
                // Ctrl+Shift+I / Ctrl+Shift+J / Ctrl+U
                if (e.ctrlKey && e.shiftKey && (e.key === 'I' || e.key === 'J' || e.key === 'i' || e.key ===
                        'j')) {
                    e.preventDefault();
                    return false;
                }
                // Ctrl+U
                if (e.ctrlKey && (e.key === 'U' || e.key === 'u')) {
                    e.preventDefault();
                    return false;
                }
            });

            // منع النقر بزر الماوس الأيمن على الصفحة بأكملها
            document.addEventListener('contextmenu', function(e) {
                e.preventDefault();
                return false;
            });

            // منع السحب والإفلات للفيديو
            const video = document.getElementById('custom-video-player');
            if (video) {
                video.addEventListener('dragstart', (e) => e.preventDefault());
                video.addEventListener('drop', (e) => e.preventDefault());
            }

            // تعطيل خاصية "picture-in-picture" عبر JS أيضاً
            if (video) {
                video.disablePictureInPicture = true;
            }
        })();
    </script>
@endpush
