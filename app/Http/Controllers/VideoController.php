<?php
namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Support\Facades\Auth;

class VideoController extends Controller
{
    public function show(Video $video)
    {
        $user = Auth::user();
        if (! $user->subscribedLevels->contains($video->level_id)) {
            abort(403);
        }

        $bunny     = new \App\Services\BunnyService();
        $signedUrl = $bunny->signedStreamUrl($video->bunny_video_id, 3600); // صلاحية ساعة

        $playlist = $video->level->videos;
        return view('web.video.show', compact('video', 'signedUrl', 'playlist'));
    }
}
