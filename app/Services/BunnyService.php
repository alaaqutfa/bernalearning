<?php
namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class BunnyService
{
    protected $libraryId;
    protected $apiKey;
    protected $baseUrl = 'https://video.bunnycdn.com/library/';

    public function __construct()
    {
        $this->libraryId = env('BUNNY_LIBRARY_ID');
        $this->apiKey    = env('BUNNY_API_KEY');
    }

    /**
     * جلب قائمة الفيديوهات من المكتبة (مخزنة مؤقتاً)
     */
    public function getVideos($page = 1, $perPage = 100)
    {
        $cacheKey = "bunny_videos_page_{$page}";
        return Cache::remember($cacheKey, now()->addMinutes(30), function () use ($page, $perPage) {
            $response = Http::withHeaders([
                'AccessKey' => $this->apiKey,
            ])->get($this->baseUrl . $this->libraryId . '/videos', [
                'page'         => $page,
                'itemsPerPage' => $perPage,
            ]);

            if ($response->failed()) {
                return null;
            }

            return $response->json();
        });
    }

    /**
     * جلب فيديو واحد بواسطة GUID
     */
    public function getVideo($guid)
    {
        $response = Http::withHeaders([
            'AccessKey' => $this->apiKey,
        ])->get($this->baseUrl . $this->libraryId . '/videos/' . $guid);

        if ($response->failed()) {
            return null;
        }

        return $response->json();
    }

    public function signedStreamUrl($guid, $expires = 3600)
    {
        $libraryId = env('BUNNY_LIBRARY_ID');
        $secret    = env('BUNNY_SIGNING_SECRET');

        if (! $secret) {
            // إذا لم يكن هناك مفتاح، نرجع رابطاً عادياً (غير آمن)
            return "https://iframe.mediadelivery.net/embed/{$libraryId}/{$guid}";
        }

        $expiresAt = time() + $expires;
        $token     = hash_hmac('sha256', $libraryId . $guid . $expiresAt, $secret);

        // رابط المشغل المضمن (iframe)
        return "https://iframe.mediadelivery.net/embed/{$libraryId}/{$guid}?token={$token}&expires={$expiresAt}";
    }

    /**
     * تحديث عنوان الفيديو (اختياري)
     */
    public function updateVideo($guid, $data)
    {
        $response = Http::withHeaders([
            'AccessKey' => $this->apiKey,
        ])->post($this->baseUrl . $this->libraryId . '/videos/' . $guid, $data);

        return $response->successful();
    }
}
