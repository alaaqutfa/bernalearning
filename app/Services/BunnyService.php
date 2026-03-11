<?php
namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class BunnyService
{
    protected $libraryId;
    protected $cdnHostName;
    protected $pullZone;
    protected $apiKey;
    protected $apiAccountKey;
    protected $baseUrl             = 'https://video.bunnycdn.com/library/';
    protected $baseVideolibraryUrl = 'https://api.bunny.net/videolibrary/';
    protected $bunnyApiUrl         = 'https://api.bunny.net/';

    public function __construct()
    {
        $this->libraryId     = env('BUNNY_LIBRARY_ID');
        $this->cdnHostName   = env('BUNNY_CDN_HOST_NAME');
        $this->pullZone      = env('BUNNY_PULL_ZONE');
        $this->apiKey        = env('BUNNY_API_KEY');
        $this->apiAccountKey = env('BUNNY_API_ACCOUNT');
    }

    public function getAccountStatistics($dateFrom = null, $dateTo = null)
    {
        $dateFrom = $dateFrom ?? now()->subDays(30)->format('Y-m-d');
        $dateTo   = $dateTo ?? now()->format('Y-m-d');

        $response = Http::withHeaders([
            'AccessKey' => $this->apiAccountKey,
            'Accept'    => 'application/json',
        ])->get($this->bunnyApiUrl . 'statistics', [
            'dateFrom' => $dateFrom,
            'dateTo'   => $dateTo,
        ]);

        if ($response->failed()) {
            dd([
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);
            return null;
        }
        return $response->json();
    }

    public function getLibraryDetails()
    {
        $response = Http::withHeaders([
            'AccessKey' => $this->apiKey,
        ])->get($this->baseVideolibraryUrl . $this->libraryId);

        if ($response->failed()) {
            return null;
        }

        return $response->json();
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

    public function signedStreamUrl($guid, $expires = 1800)
    {
        $libraryId = env('BUNNY_LIBRARY_ID');
        $secret    = env('BUNNY_SIGNING_SECRET');
        if (! $secret) {
            return "https://iframe.mediadelivery.net/embed/{$libraryId}/{$guid}";
        }
        $expiresAt = time() + $expires;
        $token     = hash('sha256', $secret . $guid . $expiresAt);
        return "https://iframe.mediadelivery.net/embed/{$libraryId}/{$guid}?token={$token}&expires={$expiresAt}";
    }

    public function signedThumbnailUrl($guid, $expires = 2592000)
    {
        $secret      = env('BUNNY_SIGNING_SECRET');
        $cdnHostName = $this->cdnHostName;

        $expiresAt = time() + $expires;

        $tokenPath = "/{$guid}/";
        $filePath  = "{$tokenPath}thumbnail.jpg";

        // توقيع Bunny الصحيح
        $token = hash('sha256', $secret . $tokenPath . $expiresAt);

        $encodedTokenPath = rawurlencode($tokenPath);

        return "https://{$cdnHostName}/?bcdn_token={$token}&expires={$expiresAt}&token_path={$encodedTokenPath}{$filePath}";
    }
    /*
        القيمة الصحيحة هي :
        /bcdn_token=940pieXdukjHgtw4OrbpMrU1pts49xzAlQStXN-88kc

        =====================================

        القيمة الظاهرة حالياً
        /bcdn_token=7ed5a0eda1ce1f9cc9db1e09c63b510b01d2ec3056e06cdced3bf1771865ed85

    */

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

    public function getVideoStatistics($videoId)
    {
        $response = Http::withHeaders([
            'AccessKey' => $this->apiKey,
        ])->get($this->baseUrl . $this->libraryId . '/videos/' . $videoId . '/statistics');

        if ($response->failed()) {
            return null;
        }

        return $response->json();
    }

    public function getLibraryStatistics()
    {
        $response = Http::withHeaders([
            'AccessKey' => $this->apiKey,
        ])->get($this->baseUrl . $this->libraryId . '/statistics');

        if ($response->failed()) {
            return null;
        }

        return $response->json();
    }
}
