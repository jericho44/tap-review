<?php

namespace App\Modules\Tap\Services;

class UserAgentParser
{
    /**
     * Parse User-Agent string into rough device family, platform, and browser.
     * Compliant with privacy standards: No personal identifiers, no IP tracking.
     */
    public static function parse(?string $userAgent): array
    {
        if (empty($userAgent)) {
            return [
                'device_family' => 'Unknown',
                'platform' => 'Unknown',
                'browser' => 'Unknown',
            ];
        }

        $ua = $userAgent;

        // 1. Detect Platform & Device Family
        $platform = 'Other';
        $deviceFamily = 'Desktop';

        if (stripos($ua, 'iPhone') !== false) {
            $deviceFamily = 'iPhone';
            $platform = 'iOS';
        } elseif (stripos($ua, 'iPad') !== false) {
            $deviceFamily = 'iPad';
            $platform = 'iPadOS';
        } elseif (stripos($ua, 'Android') !== false) {
            $deviceFamily = 'Android Device';
            $platform = 'Android';
        } elseif (stripos($ua, 'Macintosh') !== false || stripos($ua, 'Mac OS X') !== false) {
            $deviceFamily = 'Mac';
            $platform = 'macOS';
        } elseif (stripos($ua, 'Windows') !== false) {
            $deviceFamily = 'Windows PC';
            $platform = 'Windows';
        } elseif (stripos($ua, 'Linux') !== false) {
            $deviceFamily = 'Linux PC';
            $platform = 'Linux';
        }

        // 2. Detect Browser
        $browser = 'Other';
        if (stripos($ua, 'SamsungBrowser') !== false) {
            $browser = 'Samsung Internet';
        } elseif (stripos($ua, 'Chrome') !== false || stripos($ua, 'CriOS') !== false) {
            $browser = 'Chrome';
        } elseif (stripos($ua, 'Safari') !== false && stripos($ua, 'Chrome') === false) {
            $browser = 'Safari';
        } elseif (stripos($ua, 'Firefox') !== false || stripos($ua, 'FxiOS') !== false) {
            $browser = 'Firefox';
        } elseif (stripos($ua, 'Edg') !== false) {
            $browser = 'Edge';
        }

        return [
            'device_family' => $deviceFamily,
            'platform' => $platform,
            'browser' => $browser,
        ];
    }
}
