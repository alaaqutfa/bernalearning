<?php
namespace App\Http\Controllers;

use App\Models\Level;
use App\Models\Video;
use App\Services\BunnyService;
use Illuminate\Support\Facades\Auth;

class LevelController extends Controller
{
    protected $bunnyService;

    public function __construct(BunnyService $bunnyService)
    {
        $this->bunnyService = $bunnyService;
    }

    public function show(Level $level, ?Video $video = null)
    {
        $user = Auth::user();

        // التحقق من اشتراك المستخدم في المستوى
        if (! $user->subscribedLevels->contains($level->id)) {
            abort(403);
        }

        // جلب جميع فيديوهات المستوى
        $videos = $level->videos;

        // إذا لم يتم تحديد فيديو، استخدم أول فيديو
        if (! $video || ! $videos->contains('id', $video->id)) {
            $video = $videos->first();
        }

        // التأكد من وجود فيديو
        if (! $video) {
            abort(404, 'لا توجد فيديوهات في هذا المستوى');
        }

        // إنشاء رابط البث الموقع للفيديو الحالي
        $signedUrl = $this->bunnyService->signedStreamUrl($video->bunny_video_id);

                                                // جلب حالة مشاهدة الفيديوهات للمستخدم الحالي
        $watchedVideos = $user->watchedVideos() // نفترض وجود علاقة watchedVideos
            ->whereIn('video_id', $videos->pluck('id'))
            ->pluck('video_id')
            ->toArray();

        // حساب نسبة التقدم في المستوى
        $totalVideos        = $videos->count();
        $watchedCount       = count($watchedVideos);
        $progressPercentage = $totalVideos > 0 ? round(($watchedCount / $totalVideos) * 100) : 0;

        return view('web.level.show', compact(
            'level',
            'videos',
            'video', // الفيديو الحالي
            'signedUrl',
            'watchedVideos', // مصفوفة IDs الفيديوهات التي تمت مشاهدتها
            'progressPercentage'
        ) + ['bunny' => $this->bunnyService]);
    }
}
