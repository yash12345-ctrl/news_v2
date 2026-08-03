<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
class VisitorAnalytic extends Model
{
    use HasFactory;

    const SOURCE_WEB = 1;
    const SOURCE_ANDROID = 2;
    const SOURCE_IOS = 3;

    const DEVICE_WINDOWS = 1;
    const DEVICE_MACOS = 2;
    const DEVICE_LINUX = 3;
    const DEVICE_ANDROID = 4;
    const DEVICE_IOS = 5;
    const DEVICE_CHROMEOS = 6;
    const DEVICE_OTHERS = 7;

    const BROWSER_CHROME = 1;
    const BROWSER_FIREFOX = 2;
    const BROWSER_SAFARI = 3;
    const BROWSER_EDGE = 4;
    const BROWSER_OPERA = 5;
    const BROWSER_UCBROWSER = 6;
    const BROWSER_OTHERS = 7;

    public $timestamps = false;

    protected $table = "visitor_analytics";
    protected $primaryKey = "uuid";
    public $incrementing = false;

    protected $fillable = [
        "uuid", "user_id", "state", "ip_address", "visit_count", "source", "last_visited_at", "country", "browser", "device", "browser_other"
    ];

    public static function findByUuid(string $uuid)
    {
        return self::where("uuid", $uuid)->first();
    }

    public static function findPreviousIpRecord(string $ip, $start)
    {
        return self::whereDate("last_visited_at", '<', $start)
                ->where('ip_address', $ip)->first();
    }

    public static function returningCount()
    {
        return self::query()
            ->whereRaw('visit_count > 1')->count();
    }

    public static function visitorStats()
    {
        return self::query()
            ->selectRaw("sum(source = ". self::SOURCE_WEB .") as web")
            ->selectRaw("sum(source =  ". self::SOURCE_ANDROID .") as android")
            ->selectRaw("sum(source =  ". self::SOURCE_IOS .") as ios")
            ->first();
    }

    public static function graph(string $range)
    {
        $query = self::query();

        if ($range === '30days') {
            $date = now()->subDays(30);

            return $query->selectRaw('COUNT(*) as total, DATE(last_visited_at) as day')
                         ->where('last_visited_at', '>=', $date)
                         ->groupByRaw('DATE(last_visited_at)')
                         ->orderByDesc('day')
                         ->get();
        }

        $date = now()->subMonths(12)->startOfMonth();

        return $query->selectRaw('COUNT(*) as total, MONTH(last_visited_at) as month, YEAR(last_visited_at) as year')
                     ->where('last_visited_at', '>=', $date)
                     ->groupByRaw('YEAR(last_visited_at), MONTH(last_visited_at)')
                     ->orderByDesc('year')
                     ->orderByDesc('month')
                     ->take(12)
                     ->get();

    }

    public static function detectBrowser($userAgent): int
    {
        // UC Browser
        if (preg_match('/UCBrowser|UCWEB/i', $userAgent)) {
            return self::BROWSER_UCBROWSER;
        }

        // Edge (Chromium Edge contains "Edg/")
        if (preg_match('/Edg|Edge/i', $userAgent)) {
            return self::BROWSER_EDGE;
        }

        // Opera (OPR is Opera Chromium)
        if (preg_match('/OPR|Opera/i', $userAgent)) {
            return self::BROWSER_OPERA;
        }

        // Chrome (must be BEFORE Safari check)
        // But avoid detecting Chrome inside iPhone Safari (CriOS)
        if (preg_match('/Chrome|CriOS/i', $userAgent)) {
            return self::BROWSER_CHROME;
        }

        // Safari (must be AFTER Chrome)
        if (preg_match('/Safari/i', $userAgent)) {
            return self::BROWSER_SAFARI;
        }

        // Firefox
        if (preg_match('/Firefox/i', $userAgent)) {
            return self::BROWSER_FIREFOX;
        }

        return self::BROWSER_OTHERS;
    }

    public static function detectDeviceOS($userAgent): int
    {
        // Android
        if (preg_match('/Android/i', $userAgent)) {
            return self::DEVICE_ANDROID;
        }

        // iOS
        if (preg_match('/iPhone|iPad|CPU iPhone OS|CPU OS/i', $userAgent)) {
            return self::DEVICE_IOS;
        }

        // Windows
        if (preg_match('/Windows NT/i', $userAgent)) {
            return self::DEVICE_WINDOWS;
        }

        // macOS
        if (preg_match('/Macintosh|Mac OS X/i', $userAgent)) {
            return self::DEVICE_MACOS;
        }

        // Chrome OS
        if (preg_match('/CrOS/i', $userAgent)) {
            return self::DEVICE_CHROMEOS;
        }

        // Linux (generic desktop)
        if (preg_match('/Linux|X11/i', $userAgent)) {
            return self::DEVICE_LINUX;
        }

        return self::DEVICE_OTHERS;
    }

    public static function getIpInformationBatch(array $ips)
    {
        $data = [];
        try {
            $response = Http::accept('application/json')->post('http://ip-api.com/batch', $ips);
            $data = json_decode($response->body());
        } catch (\Exception $e) {
            Log::error("Ip resolve failed: " . $e->getMessage());
        }

        return $data;
    }
}
