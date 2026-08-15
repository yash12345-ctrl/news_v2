<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Article;
use App\Models\DigitalAd;
use App\Models\Advertiser;
use App\Models\ENewsPaper;
use App\Models\VisitorAnalytic;
use Illuminate\Support\Facades\Cache;

class CacheDashboardStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dashboard:cache-stats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pre-calculate and cache the dashboard statistics for the admin portal';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $ranges = ['1year', '30days'];

        foreach ($ranges as $range) {
            $this->info("Caching stats for range: $range");

            $data = [
                "visitor_stats" => [
                    "unique_count" => VisitorAnalytic::count(),
                    "returning_count" => VisitorAnalytic::returningCount(),
                    "source" => VisitorAnalytic::visitorStats(),
                    "graph" => VisitorAnalytic::graph($range),
                    "today_visitors" => VisitorAnalytic::whereBetween('last_visited_at', [now()->startOfDay(), now()->endOfDay()])->count(),
                    "month_visitors" => VisitorAnalytic::whereBetween('last_visited_at', [now()->startOfMonth(), now()->endOfMonth()])->count(),
                    "three_months_visitors" => VisitorAnalytic::where('last_visited_at', '>=', now()->subMonths(3))->count(),
                    "today_new_visitors" => VisitorAnalytic::whereBetween('last_visited_at', [now()->startOfDay(), now()->endOfDay()])->where('visit_count', 1)->count(),
                ],
                "article_stats" => Article::articleStats(),
                "epaper_stats" => ENewsPaper::epaperStats(),
                "advertiser_count" => Advertiser::count(),
                "digital_ad_count" => DigitalAd::digitalAdStats(),
                "user_count" => User::count(),
            ];

            // Cache for 60 minutes
            Cache::put('admin_dashboard_stats_' . $range, $data, now()->addMinutes(60));
        }

        $this->info("Dashboard stats cached successfully.");
    }
}
