<?php
namespace App\Http\Controllers;

use App\Models\Level;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        return redirect()->url('https://berna-violin.art/');
    }

    public function dashboard()
    {
        $user = Auth::user();
        if ($user->is_admin) {
            return redirect()->route('admin.dashboard');
        }
        $subscribedLevels = $user->subscribedLevels; // levels التي اشترك بها
        $watchedVideoIds  = $user->watchedVideos()->pluck('video_id')->toArray();
        $levels           = Level::orderBy('order')->get();         // كل المستويات
        $coupons          = $user->coupons()->with('level')->get(); // كوبونات المستخدم مع المستوى المرتبط
        return view('web.dashboard', compact('user', 'subscribedLevels', 'watchedVideoIds', 'levels', 'coupons'));
    }

    public function levels()
    {
        $user = Auth::user();

        if ($user->is_admin) {
            return redirect()->route('admin.dashboard');
        }

        $levels = Level::with('videos')->orderBy('order')->get();

        $watchedVideoIds = $user->watchedVideos()->pluck('video_id')->toArray();

        foreach ($levels as $level) {
            $level->total_videos  = $level->videos->count();
            $level->watched_count = $level->videos->filter(function ($video) use ($watchedVideoIds) {
                return in_array($video->id, $watchedVideoIds);
            })->count();
            $level->progress_percentage = $level->total_videos > 0
                ? round(($level->watched_count / $level->total_videos) * 100)
                : 0;
        }

        $subscribedLevels = $user->subscribedLevels;

        return view('web.level.index', compact('user','levels', 'subscribedLevels','watchedVideoIds'));
    }

    public function privacy()
    {
        return view('web.privacy');
    }
}
