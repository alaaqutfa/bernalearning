<?php
namespace App\Helpers;

class BunnyHelper
{

    public static function signedStreamUrl($videoId, $libraryId, $expires = 3600)
    {
        $secret    = env('BUNNY_SIGNING_SECRET');
        $expiresAt = time() + $expires;
        $token     = hash_hmac('sha256', $libraryId . $videoId . $expiresAt, $secret);
        return "https://iframe.mediadelivery.net/embed/{$libraryId}/{$videoId}?token={$token}&expires={$expiresAt}";
    }
}
