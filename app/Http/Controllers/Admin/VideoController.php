<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Level;
use App\Models\Video;
use App\Services\BunnyService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VideoController extends Controller
{

    protected $bunnyService;

    public function __construct(BunnyService $bunnyService)
    {
        $this->bunnyService = $bunnyService;
    }

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
        $levels = Level::orderBy('order')->get();
        return view('admin.videos.index', compact('videos', 'levels', 'levelId') + ['bunny' => $this->bunnyService]);
    }

    /**
     * Show the form for creating a new video.
     */
    public function create(Request $request, BunnyService $bunny)
    {
        $levels        = Level::all();
        $selectedLevel = $request->get('level_id');

        // جلب جميع فيديوهات Bunny من المكتبة
        $bunnyVideos = $bunny->getVideos()['items'] ?? [];

        // استبعاد الفيديوهات المرتبطة مسبقاً
        $existingBunnyIds = Video::pluck('bunny_video_id')->toArray();
        $availableVideos  = array_filter($bunnyVideos, function ($video) use ($existingBunnyIds) {
            return ! in_array($video['guid'], $existingBunnyIds);
        });

        return view('admin.videos.create', compact('levels', 'selectedLevel', 'availableVideos'));
    }

    /**
     * Store a newly created video in storage.
     */
    public function store(Request $request, BunnyService $bunny)
    {
        $request->validate([
            'level_id'       => 'required|exists:levels,id',
            'title'          => 'required|string|max:255',
            'description'    => 'nullable|string',
            'bunny_video_id' => 'required|string', // معرف الفيديو على Bunny.net
            'order'          => 'nullable|integer',
        ]);
        $videoData = $bunny->getVideo($request->bunny_video_id);
        if (! $videoData) {
            return back()->with('error', 'لم يتم العثور على الفيديو في Bunny');
        }

        Video::create([
            'level_id'              => $request->level_id,
            'title'                 => $request->title ?: $videoData['title'],
            'description'           => $request->description,
            'bunny_video_id'        => $request->bunny_video_id,
            'duration'              => $videoData['length'] ?? null,
            'width'                 => $videoData['width'] ?? null,
            'height'                => $videoData['height'] ?? null,
            'available_resolutions' => $videoData['availableResolutions'] ?? null,
            'thumbnail_file_name'   => $videoData['thumbnailFileName'] ?? null,
            'status'                => $videoData['status'] ?? null,
            'storage_size'          => $videoData['storageSize'] ?? null,
            'views'                 => $videoData['views'] ?? 0,
            'uploaded_at'           => isset($videoData['dateUploaded']) ? Carbon::parse($videoData['dateUploaded']) : null,
            'order'                 => $request->order ?? 0,
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
    public function update(Request $request, Video $video, BunnyService $bunny)
    {
        $request->validate([
            'level_id'       => 'required|exists:levels,id',
            'title'          => 'required|string|max:255',
            'description'    => 'nullable|string',
            'bunny_video_id' => 'required|string',
            'order'          => 'nullable|integer',
        ]);

        $videoData = $bunny->getVideo($request->bunny_video_id);
        if (! $videoData) {
            return back()->with('error', 'لم يتم العثور على الفيديو في Bunny');
        }

        $video->update([
            'level_id'              => $request->level_id,
            'title'                 => $request->title,
            'description'           => $request->description,
            'bunny_video_id'        => $request->bunny_video_id,
            'duration'              => $videoData['length'] ?? null,
            'width'                 => $videoData['width'] ?? null,
            'height'                => $videoData['height'] ?? null,
            'available_resolutions' => $videoData['availableResolutions'] ?? null,
            'thumbnail_file_name'   => $videoData['thumbnailFileName'] ?? null,
            'status'                => $videoData['status'] ?? null,
            'storage_size'          => $videoData['storageSize'] ?? null,
            'views'                 => $videoData['views'] ?? 0,
            'uploaded_at'           => isset($videoData['dateUploaded']) ? Carbon::parse($videoData['dateUploaded']) : null,
            'order'                 => $request->order ?? $video->order,
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
