<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VisitorSummary extends Model
{
    use HasFactory;

    protected $table = 'visitors_summary';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'day', 'month', 'year', 'visitor_count', 'returning_visit_count'
    ];

    public static function getVisitorStats($range = '30days', $start_date = null, $end_date = null)
    {
        if ($start_date && $end_date) {
            $days = floor((strtotime($end_date) - strtotime($start_date)) / (60 * 60 * 24)) + 1;
            $records = self::query()
                ->selectRaw("
                    COALESCE(SUM(visitor_count), 0) as total_visitors,
                    COALESCE(SUM(returning_visit_count), 0) as total_returning
                ")
                ->whereBetween("created_at", [$start_date, $end_date])
                ->first();

                return self::summarizeVisitorStats($records, $days);
        }

        if ($range === '30days') {
            $today      = date('Y-m-d 23:59:59');
            $past_date = date('Y-m-d 00:00:00', strtotime('-29 days'));

            $records = self::query()
                ->selectRaw("
                    COALESCE(SUM(visitor_count), 0) as total_visitors,
                    COALESCE(SUM(returning_visit_count), 0) as total_returning
                ")
                ->whereBetween("created_at", [$past_date, $today])
                ->first();

            return self::summarizeVisitorStats($records, 30);
        }

        $today      = date('Y-m-d 23:59:59');
        $past_date = date('Y-m-d 00:00:00', strtotime('-1 year'));
        $records = self::query()
                ->selectRaw("
                    COALESCE(SUM(visitor_count), 0) as total_visitors,
                    COALESCE(SUM(returning_visit_count), 0) as total_returning
                ")
                ->whereBetween("created_at", [$past_date, $today])
                ->first();

        return self::summarizeVisitorStats($records, 365);
    }

    public static function summarizeVisitorStats($records, $count)
    {
        $total_visitors  = (int) $records->total_visitors;
        $total_returning = (int) $records->total_returning;

        return [
            'total_visitors'    => $total_visitors,
            'total_returning'   => $total_returning,
            'average_visitors'  => floor($total_visitors / $count),
            'average_returning' => floor($total_returning / $count),
        ];
    }

    public static function monthlySummary()
    {
        return self::query()
                ->selectRaw("
                    month,
                    year,
                    SUM(visitor_count) AS visitor_count,
                    SUM(returning_visit_count) AS returning_visit_count
                ")
                ->groupBy('year', 'month')
                ->orderBy('year', 'desc')
                ->orderBy('month', 'desc');
    }
}
