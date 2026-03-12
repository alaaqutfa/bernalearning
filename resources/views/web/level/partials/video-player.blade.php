@props(['video', 'signedUrl', 'user'])

<div class="relative pb-[56.25%] h-0 overflow-hidden video-player-wrapper flex justify-start items-start"
    id="video-player-wrapper-{{ $video->id }}">
    <div class="absolute inset-0 z-10" style="background: transparent; height: 80%;"></div>
    <div class="absolute z-20 pointer-events-none select-none"
        style="top: 50%; left: 15px; color: rgba(255,255,255,0.7); font-size: 16px; font-weight: bold; text-shadow: 2px 2px 4px rgba(0,0,0,0.8);">
        {{ $user->name }} ({{ $user->email }} - {{ $user->phone }})
    </div>
    <div class="absolute z-20 pointer-events-none select-none"
        style="top: 15px; right: 15px; color: rgba(255,255,255,0.4); font-size: 12px; text-shadow: 1px 1px 2px black;">
        IP: {{ request()->ip() }}
    </div>

    <!-- مشغل الفيديو (iframe) - أضفنا id لتحديده بسهولة -->
    <iframe id="bunny-player-{{ $video->id }}" src="{{ $signedUrl }}" class="absolute top-0 left-0 w-full h-full"
        frameborder="0" allow="autoplay;">
    </iframe>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const playerIframe = document.getElementById('bunny-player-{{ $video->id }}');
            if (!playerIframe) return;
            let currentViewId = null;
            let lastReportedTime = 0;
            const REPORT_INTERVAL = 30;
            const BUNNY_ORIGIN = 'https://iframe.mediadelivery.net';

            // دالة لإرسال التحديثات إلى الخادم
            async function updateWatchProgress(watchTime) {
                if (!currentViewId) return;

                try {
                    await fetch('{{ route('video.watch.progress') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            view_id: currentViewId,
                            watch_time: watchTime
                        })
                    });
                } catch (error) {
                    console.error('فشل تحديث وقت المشاهدة:', error);
                }
            }

            // دالة لإكمال المشاهدة
            async function completeWatch() {
                if (!currentViewId) return;

                try {
                    await fetch('{{ route('video.watch.complete') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            view_id: currentViewId
                        })
                    });
                } catch (error) {
                    console.error('فشل تحديث حالة الاكتمال:', error);
                }
            }

            // 1. الاستماع للرسائل من iframe
            window.addEventListener('message', function(event) {

                // 2. التحقق من مصدر الرسالة (الأمان)
                if (!event.origin.startsWith(BUNNY_ORIGIN)) {
                    return; // تجاهل الرسائل من مصادر غير موثوقة
                }

                // 3. محاولة تحليل البيانات (نتأكد أنها JSON)
                let messageData;
                try {
                    messageData = typeof event.data === 'string' ? JSON.parse(event.data) : event.data;
                } catch (e) {
                    // إذا لم تكن JSON صالحة، نتجاهلها
                    return;
                }

                // 4. التأكد من وجود الحدث والبيانات المطلوبة
                if (!messageData || !messageData.event) {
                    return;
                }

                const videoEvent = messageData.event;
                const eventData = messageData.data || {};

                // 5. التعامل مع الأحداث المختلفة
                switch (videoEvent) {
                    case 'play':
                        if (!currentViewId) {
                            fetch('{{ route('video.watch.start') }}', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: JSON.stringify({
                                        video_id: '{{ $video->id }}'
                                    })
                                })
                                .then(res => res.json())
                                .then(data => {
                                    if (data.view_id) {
                                        currentViewId = data.view_id;
                                    }
                                })
                                .catch(error => console.error('فشل بدء تسجيل المشاهدة:', error));
                        }
                        break;

                    case 'timeupdate':
                        if (eventData.currentTime) {
                            const currentTime = Math.floor(eventData.currentTime);
                            if (currentTime - lastReportedTime >= REPORT_INTERVAL) {
                                updateWatchProgress(currentTime);
                                lastReportedTime = currentTime;
                            }
                        }
                        break;

                    case 'ended':
                        completeWatch();
                        break;

                }
            });

            playerIframe.addEventListener('load', function() {});
        });
    </script>
@endpush
