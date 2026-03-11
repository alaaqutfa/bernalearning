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
        $securityKey = env('BUNNY_SIGNING_SECRET');
        $cdnHost     = env('BUNNY_CDN_HOST_NAME');

        $expiresAt = time() + $expires;

        $tokenPath = "/{$guid}/";
        $filePath  = "{$tokenPath}thumbnail.jpg";

        // النص الذي سيتم توقيعه
        $hashableBase = $securityKey . $filePath . $expiresAt;

        $token = md5($hashableBase, true);
        $token = base64_encode($token);
        $token = strtr($token, '+/', '-_');
        $token = str_replace('=', '', $token);

        $encodedTokenPath = rawurlencode($tokenPath);

        return "https://{$cdnHost}/bcdn_token={$token}&expires={$expiresAt}&token_path={$encodedTokenPath}{$filePath}";
    }
    /*
        القيمة الصحيحة من bunny هي :
        https://
        vz-1d6b7983-037.b-cdn.net
        /bcdn_token=3kVDJB-emH2mtdUUcKrU99UY6UR49m0gJ5DEOh2lPoI
        &expires=1773318181
        &token_path=%2Ff347b2b5-044e-4138-9cb8-14a6cd2a810b%2F
        /f347b2b5-044e-4138-9cb8-14a6cd2a810b/thumbnail.jpg

        =====================================

        القيمة الظاهرة حالياً
        https://
        vz-1d6b7983-037.b-cdn.net
        /bcdn_token=hCl1LiGF9HxF8a5VCulSrpEL9pBjoVv7pv7v5gJQCPU
        &expires=1775824014
        &token_path=%2Ff347b2b5-044e-4138-9cb8-14a6cd2a810b%2F
        /f347b2b5-044e-4138-9cb8-14a6cd2a810b/thumbnail.jpg
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
