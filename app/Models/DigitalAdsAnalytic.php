<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DigitalAdsAnalytic extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'digital_ads_analytics';

    protected $fillable = [
        'advertiser_id', 'digital_ad_id', 'user_id', 'viewed', 'clicked', 'created_at'
    ];

    public static function recordAnalytics($digital_ad_id, $user_id)
    {
       return self::where('digital_ad_id', '=', $digital_ad_id)
                    ->where('user_id', '=', $user_id);
    }

    public static function countSeen($id)
    {
        return self::where('digital_ad_id', '=', $id)
                        ->where('viewed', '=', 1);
    }

    public static function countClicked($id, $advertiser_id = null)
    {
        if (is_null($advertiser_id)) {
            return self::where('digital_ad_id', '=', $id)
                        ->where('clicked', '=', 1);
        }
        return self::where('digital_ad_id', '=', $id)
                        ->where('advertiser_id', '=', $advertiser_id)
                        ->where('clicked', '=', 1);
    }

    public static function countClickedByDate($id, $advertiser_id = null)
    {
        if (is_null($advertiser_id)) {
            return self::groupByRaw('DATE(created_at)')
                        ->selectRaw('count(*) as total, DATE(created_at) as date')
                        ->where('digital_ad_id', '=', $id)
                        ->where('clicked', '=', 1)
                        ->get();
        }
        
        return self::groupByRaw('DATE(created_at)')
                        ->selectRaw('count(*) as total, DATE(created_at) as date')
                        ->where('digital_ad_id', '=', $id)
                        ->where('advertiser_id', '=', $advertiser_id)
                        ->where('clicked', '=', 1)
                        ->get();
    } 
}
