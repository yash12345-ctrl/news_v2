<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\VisitorAnalytic;
use Illuminate\Support\Facades\Log;

class IpGeoLookup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:ip-geo-lookup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get geo location of IP Address';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $smt = microtime(true);
        $start = date('Y-m-d 00:00:00', strtotime('-1 day'));
        $end   = date('Y-m-d 23:59:59', strtotime('-1 day'));
        $new_ip_lists = [];
        $visitor_map = [];
        $all_unique_ips = [];
        VisitorAnalytic::whereBetween('last_visited_at', [$start, $end])
        ->chunk(500, function ($visitors) use ($start, &$all_unique_ips, &$visitor_map) {
            foreach ($visitors as $index => $visitor) {
                if (is_null($visitor->ip_address) || $visitor->ip_address === '127.0.0.1' || $visitor->ip_address == '::1') {
                    continue;
                }

                $ip = $visitor->ip_address;
                if (!isset($visitor_map[$ip])) {
                    $all_unique_ips[] = $ip;
                }

                $visitor_map[$ip][] = $visitor;
            }
        });

        if (empty($visitor_map)) {
            Log::info("IPGeoLookup: No visitor found between '{$start}' and '{$end}'");
            return;
        }

        $previous_analytics = VisitorAnalytic::whereIn('ip_address', $all_unique_ips)
            ->where('last_visited_at', '<', $start)
            ->get()
            ->keyBy('ip_address');

        foreach ($visitor_map as $ip => $visitors) {
            if (isset($previous_analytics[$ip]) &&
                !empty($previous_analytics[$ip]->state) &&
                !empty($previous_analytics[$ip]->country)
            ) {
                $state   = $previous_analytics[$ip]->state;
                $country = $previous_analytics[$ip]->country;

                foreach ($visitors as $visitor) {
                    $visitor->state   = $state;
                    $visitor->country = $country;
                    $visitor->save();
                }

                unset($visitor_map[$ip]);

            } else {
                $new_ip_lists[$ip] = true;
            }
        }

        $ip_chunks = array_chunk(array_keys($new_ip_lists), 100);
        $api_st = microtime(true);
        $api_et = 0;
        foreach ($ip_chunks as $index => $batch) {
            $results = VisitorAnalytic::getIpInformationBatch($batch);

            $missed_count = count($batch) - count($results);
            Log::info("IPGeoLookup batch", [
                'batch_no'     => $index + 1,
                'batch_size'   => count($batch),
                'found_states' => count($results),
                'missed'       => $missed_count,
            ]);

            foreach ($results as $result) {
                $ip = $result->query;
                if (!isset($visitor_map[$ip])) {
                    Log::info("IPGeoLookup: This case cannot happen: IP='{$ip}'");
                    continue;
                }

                foreach ($visitor_map[$ip] as $visitor) {
                    $visitor->state   = $result->regionName ?? null;
                    $visitor->country = $result->country ?? null;
                    $visitor->save();
                }
            }
            $this->avoidAPIThrottling($index, $api_st, $api_et);
        }

        $emt = microtime(true);
        $diff = $emt - $smt;
        Log::info("IPGeoLookup: Total new IPs processed: " . count($new_ip_lists));
        Log::info("IPGeoLookup: Time taken: {$diff}ms");
    }

    private function avoidAPIThrottling($index, &$st, &$et)
    {
        // 15 is number of API calls per minute
        if ((($index + 1) % 15) == 0) {
            $et = microtime(true);
            $elapsed = ceil($et - $st);
            $diff = 60 - $elapsed;
            if ($diff > 0) {
                sleep($diff);
            }
            Log::info("avoidIPThrottling: et = {$et}  st = {$st}  remaining_sec = {$diff}");
            $st = microtime(true);
        }
    }
}