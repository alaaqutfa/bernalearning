@props(['video', 'signedUrl', 'user'])

<div class="relative pb-[56.25%] h-0 overflow-hidden video-player-wrapper">
    <!-- طبقة شفافة للحماية (بدون منع التفاعل مع الفيديو) -->
    <div class="absolute inset-0 z-10" style="background: transparent; pointer-events: none;"></div>

    <!-- التوقيع المائي: اسم المستخدم والبريد الإلكتروني والهاتف (في أعلى اليسار) -->
    <div class="absolute z-20 pointer-events-none select-none"
        style="top: 50%; left: 15px; color: rgba(255,255,255,0.7); font-size: 16px; font-weight: bold; text-shadow: 2px 2px 4px rgba(0,0,0,0.8);">
        {{ $user->name }} ({{ $user->email }} - {{ $user->phone }})
    </div>

    <!-- التوقيع المائي: رقم IP (في أعلى اليمين) -->
    <div class="absolute z-20 pointer-events-none select-none"
        style="top: 15px; right: 15px; color: rgba(255,255,255,0.4); font-size: 12px; text-shadow: 1px 1px 2px black;">
        IP: {{ request()->ip() }}
    </div>

    <!-- مشغل الفيديو (iframe) -->
    <iframe src="{{ $signedUrl }}" class="absolute top-0 left-0 w-full h-full" frameborder="0"
        allow="autoplay; fullscreen" allowfullscreen>
    </iframe>
</div>
