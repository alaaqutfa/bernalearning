<?php
namespace App\Http\Controllers;

use App\Models\BunnyView;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrackViewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'video_id'       => 'required|exists:videos,id',
            'bunny_video_id' => 'required|string',
            'event'          => 'required|in:start,progress,end',
            'watch_time'     => 'nullable|integer',
            'completed'      => 'nullable|boolean',
        ]);

        $video = Video::find($request->video_id);

        BunnyView::create([
            'bunny_video_id' => $request->bunny_video_id,
            'video_id'       => $video->id,
            'user_id'        => Auth::user()->id,
            'ip_address'     => $request->ip(),
            'watch_time'     => $request->watch_time ?? 0,
            'completed'      => $request->completed ?? false,
            'bandwidth_used' => 0, // يمكن تحديثه لاحقاً من API Bunny
            'viewed_at'      => now(),
        ]);

        return response()->json(['success' => true]);
    }

    public function start(Request $request)
    {
        $user  = Auth::user();
        $video = Video::findOrFail($request->video_id);

        // التحقق من أن المستخدم مشترك في مستوى هذا الفيديو (اختياري)
        if (! $user->subscribedLevels->contains($video->level_id)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // هل هناك مشاهدة مسجلة مسبقاً للمستخدم لهذا الفيديو اليوم؟ (تجنب التكرار)
        $existingView = BunnyView::where('user_id', $user->id)
            ->where('video_id', $video->id)
            ->whereDate('viewed_at', now()->toDateString())
            ->first();

        if ($existingView) {
            return response()->json(['view_id' => $existingView->id]);
        }

        // إنشاء سجل مشاهدة جديد
        $view = BunnyView::create([
            'bunny_video_id' => $video->bunny_video_id,
            'video_id'       => $video->id,
            'user_id'        => $user->id,
            'ip_address'     => $request->ip(),
            'watch_time'     => 0,
            'completed'      => false,
            'bandwidth_used' => 0,
            'viewed_at'      => now(),
        ]);

        return response()->json(['view_id' => $view->id]);
    }

    public function progress(Request $request)
    {
        $request->validate([
            'view_id'    => 'required|exists:bunny_views,id',
            'watch_time' => 'required|integer',
        ]);

        $view = BunnyView::findOrFail($request->view_id);

        // تأكد أن المستخدم هو صاحب المشاهدة
        if ($view->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // تحديث وقت المشاهدة (إذا كان أكبر من المسجل)
        if ($request->watch_time > $view->watch_time) {
            $view->update(['watch_time' => $request->watch_time]);
        }

        return response()->json(['success' => true]);
    }

    public function complete(Request $request)
    {
        $request->validate([
            'view_id' => 'required|exists:bunny_views,id',
        ]);

        $view = BunnyView::findOrFail($request->view_id);

        if ($view->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // تحديث حالة الاكتمال
        $view->update(['completed' => true]);

        // هنا يمكنك إرسال Job لجلب bandwidth_used من Bunny API (اختياري)
        // FetchBandwidthUsage::dispatch($view);

        return response()->json(['success' => true]);
    }
}
