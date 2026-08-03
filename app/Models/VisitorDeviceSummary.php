<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VisitorDeviceSummary extends Model
{
    use HasFactory;

    protected $table = 'visitor_device_summary';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'visitor_summary_id', 'device', 'device_count'
    ];

    public static function summaryByDevice($from_date = null, $to_date = null)
    {
        return self::query()
                ->when($from_date && $to_date, function ($query) use ($from_date, $to_date) {
                    $query->whereBetween('created_at', [$from_date, $to_date]);
                })
                ->selectRaw("
                    device,
                    SUM(device_count) as total
                ")
                ->groupBy('device');
    }
}
