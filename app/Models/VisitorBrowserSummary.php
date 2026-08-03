<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VisitorBrowserSummary extends Model
{
    use HasFactory;

    protected $table = 'visitor_browser_summary';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'browser', 'browser_count', 'visitor_summary_id'
    ];

    public static function summaryByBrowser($from_date = null, $to_date = null)
    {
        return self::query()
                ->when($from_date && $to_date, function ($query) use ($from_date, $to_date) {
                    $query->whereBetween('created_at', [$from_date, $to_date]);
                })
                ->selectRaw("
                    browser,
                    SUM(browser_count) as total
                ")
                ->groupBy('browser');
    }
}
