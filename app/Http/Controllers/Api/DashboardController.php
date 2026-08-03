<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Article;
use App\Models\Category;
use App\Models\DigitalAd;
use App\Models\Advertiser;
use App\Models\ENewsPaper;
use Illuminate\Http\Request;
use App\Models\VisitorAnalytic;
use App\Http\Controllers\Controller;
use App\Http\Resources\DashboardResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    //
    public function index(Request $request): JsonResource
    {
        $visitor_graph_range = request('visitor_graph_range', '1year');
        // Cache the heavy database calculations for 15 minutes based on the graph range
        $data = Cache::remember('admin_dashboard_stats_' . $visitor_graph_range, now()->addMinutes(15), function () use ($visitor_graph_range) {
            $article_stats = Article::articleStats();
            $epaper_stats = ENewsPaper::epaperStats();
            $advertiser_count = Advertiser::count();
            $digital_ad_count = DigitalAd::digitalAdStats();

            $user_count = User::count();

            $unique_count = VisitorAnalytic::count();
            $returning_count = VisitorAnalytic::returningCount();
            $source = VisitorAnalytic::visitorStats(); 
            $graph = VisitorAnalytic::graph($visitor_graph_range);
            
            $visitor_stats = [
                "unique_count" => $unique_count,
                "returning_count" => $returning_count,
                "source" => $source,
                "graph" => $graph,
                "today_visitors" => VisitorAnalytic::whereDate('last_visited_at', now()->toDateString())->count(),
                "month_visitors" => VisitorAnalytic::whereYear('last_visited_at', now()->year)->whereMonth('last_visited_at', now()->month)->count(),
                "three_months_visitors" => VisitorAnalytic::where('last_visited_at', '>=', now()->subMonths(3))->count(),
                "today_new_visitors" => VisitorAnalytic::whereDate('last_visited_at', now()->toDateString())->where('visit_count', 1)->count(),
            ];

            return [
                "visitor_stats"             => $visitor_stats,
                "article_stats"             => $article_stats,
                "epaper_stats"              => $epaper_stats,
                "advertiser_count"          => $advertiser_count,
                "digital_ad_count"          => $digital_ad_count,
                "user_count"                => $user_count,
            ];
        });
        return new DashboardResource($data);
    }
}
