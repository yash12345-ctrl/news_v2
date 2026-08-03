<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VisitorDemographicSummary extends Model
{
    use HasFactory;

    protected $table = 'visitor_demographic_summary';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'state', 'country', 'state_count', 'country_count', 'visitor_summary_id'
    ];

    public static function summaryByCountry($from_date = null, $to_date = null)
    {
        return self::query()
                ->when($from_date && $to_date, function ($query) use ($from_date, $to_date) {
                    $query->whereBetween('created_at', [$from_date, $to_date]);
                })
                ->selectRaw("
                country,
                SUM(country_count) as total
            ")
            ->whereNotNull('country')
            ->groupBy('country');
    }

    public static function summaryByState($from_date = null, $to_date = null)
    {
        return self::query()
                ->when($from_date && $to_date, function ($query) use ($from_date, $to_date) {
                    $query->whereBetween('created_at', [$from_date, $to_date]);
                })
                ->selectRaw("
                state,
                SUM(state_count) as total
            ")
            ->whereNotNull('state')
            ->groupBy('state');
    }
}
