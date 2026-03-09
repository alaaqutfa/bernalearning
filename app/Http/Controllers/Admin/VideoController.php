<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Level;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    /**
     * Display a listing of the videos.
     */
    public function index(Request $request)
    {
        $levelId = $request->get('level_id');
        if ($levelId) {
            $videos = Video::where('level_id', $levelId)->orderBy('order')->get();
        } else {
            $videos = Video::with('level')->orderBy('level_id')->orderBy('order')->get();
        }
        $levels = Level::all(); // للفلترة
        return view('admin.videos.index', compact('videos', 'levels', 'levelId'));
    }

    /**
     * Show the form for creating a new video.
     */
    public function create(Request $request)
    {
        $levels        = Level::all();
        $selectedLevel = $request->get('level_id');
        return view('admin.videos.create', compact('levels', 'selectedLevel'));
    }

    /**
     * Store a newly created video in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'level_id'       => 'required|exists:levels,id',
            'title'          => 'required|string|max:255',
            'description'    => 'nullable|string',
            'bunny_video_id' => 'required|string', // معرف الفيديو على Bunny.net
            'order'          => 'nullable|integer',
        ]);

        Video::create([
            'level_id'       => $request->level_id,
            'title'          => $request->title,
            'description'    => $request->description,
            'bunny_video_id' => $request->bunny_video_id,
            'order'          => $request->order ?? 0,
        ]);

        return redirect()->route('admin.videos.index', ['level_id' => $request->level_id])
            ->with('success', 'تم إضافة الفيديو بنجاح.');
    }

    /**
     * Show the form for editing the specified video.
     */
    public function edit(Video $video)
    {
        $levels = Level::all();
        return view('admin.videos.edit', compact('video', 'levels'));
    }

    /**
     * Update the specified video in storage.
     */
    public function update(Request $request, Video $video)
    {
        $request->validate([
            'level_id'       => 'required|exists:levels,id',
            'title'          => 'required|string|max:255',
            'description'    => 'nullable|string',
            'bunny_video_id' => 'required|string',
            'order'          => 'nullable|integer',
        ]);

        $video->update([
            'level_id'       => $request->level_id,
            'title'          => $request->title,
            'description'    => $request->description,
            'bunny_video_id' => $request->bunny_video_id,
            'order'          => $request->order ?? $video->order,
        ]);

        return redirect()->route('admin.videos.index', ['level_id' => $video->level_id])
            ->with('success', 'تم تحديث الفيديو بنجاح.');
    }

    /**
     * Remove the specified video from storage.
     */
    public function destroy(Video $video)
    {
        $levelId = $video->level_id;
        $video->delete();

        return redirect()->route('admin.videos.index', ['level_id' => $levelId])
            ->with('success', 'تم حذف الفيديو.');
    }
}
