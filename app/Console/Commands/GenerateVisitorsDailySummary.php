<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\VisitorAnalytic;
use App\Models\VisitorSummary;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\VisitorDeviceSummary;
use App\Models\VisitorBrowserSummary;
use App\Models\VisitorDemographicSummary;

class GenerateVisitorsDailySummary extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-visitors-daily-summary';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate daily visitors summary and breakdown (device, browser, demographics)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $start = date('Y-m-d 00:00:00', strtotime('-1 day'));
        $end   = date('Y-m-d 23:59:59', strtotime('-1 day'));
        $query = VisitorAnalytic::whereBetween('last_visited_at', [$start, $end]);

        if (!$query->exists()) {
            Log::info("No visitor data found for {$start}");
            return;
        }

        try {
            DB::transaction(function () use ($query, $start) {
                $visitor_count = (clone $query)->count();
                $returning_count = (clone $query)->where('visit_count', '>', 1)->count();

                $day   = date('d', strtotime($start));
                $month = date('m', strtotime($start));
                $year  = date('Y', strtotime($start));

                $summary = VisitorSummary::create([
                    'day'                   => $day,
                    'month'                 => $month,
                    'year'                  => $year,
                    'visitor_count'         => $visitor_count,
                    'returning_visit_count' => $returning_count,
                ]);

                $device_groups = (clone $query)
                    ->selectRaw('device, COUNT(*) as count')
                    ->groupBy('device')
                    ->get();

                $device_data = [];
                foreach ($device_groups as $row) {
                    $device_data[] = [
                        'visitor_summary_id' => $summary->id,
                        'device'             => $row->device,
                        'device_count'       => $row->count,
                        'created_at'         => now(),
                        'updated_at'         => now(),
                    ];
                }

                VisitorDeviceSummary::insert($device_data);

                $browser_groups = (clone $query)
                    ->selectRaw('browser, COUNT(*) as count')
                    ->groupBy('browser')
                    ->get();

                $browser_data = [];
                foreach ($browser_groups as $row) {
                    $browser_data[] = [
                        'visitor_summary_id' => $summary->id,
                        'browser'            => $row->browser,
                        'browser_count'      => $row->count,
                        'created_at'         => now(),
                        'updated_at'         => now(),
                    ];
                }

                VisitorBrowserSummary::insert($browser_data);

                $demographic_groups = (clone $query)
                    ->selectRaw('state, country, COUNT(*) as count')
                    ->groupBy('state', 'country')
                    ->get();

                $demographic_data = [];

                foreach ($demographic_groups as $row) {
                    if (empty($row->state) || empty($row->country)) {
                        continue;
                    }

                    $demographic_data[] = [
                        'visitor_summary_id' => $summary->id,
                        'state'              => $row->state,
                        'country'            => $row->country,
                        'state_count'        => $row->count,
                        'country_count'      => $row->count,
                        'created_at'         => now(),
                        'updated_at'         => now(),
                    ];
                }

                VisitorDemographicSummary::insert($demographic_data);
            });
        } catch (\Exception $e) {
            Log::error('Error Message: '. $e->getMessage());
        }
    }
}
