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
            'video_id' => 'required|exists:videos,id',
            'bunny_video_id' => 'required|string',
            'event' => 'required|in:start,progress,end',
            'watch_time' => 'nullable|integer',
            'completed' => 'nullable|boolean',
        ]);

        $video = Video::find($request->video_id);

        BunnyView::create([
            'bunny_video_id' => $request->bunny_video_id,
            'video_id' => $video->id,
            'user_id' => Auth::user()->id,
            'ip_address' => $request->ip(),
            'watch_time' => $request->watch_time ?? 0,
            'completed' => $request->completed ?? false,
            'bandwidth_used' => 0, // يمكن تحديثه لاحقاً من API Bunny
            'viewed_at' => now(),
        ]);

        return response()->json(['success' => true]);
    }
}
