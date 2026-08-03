<?php

namespace App\Models;

use App\Models\Advertiser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DigitalAd extends Model
{
    use HasFactory;

    protected $table = 'digital_ads';

    const INACTIVE = 1;
    const ACTIVE = 2;
    const PAUSED = 3;
    const STOPED = 4;
    const REJECTED = 5;

    protected $fillable = [
        'uuid', 'title', 'description', 'cta_url', 'cta_text', 'media_url', 'media_kind', 'ad_kind', 'ad_url', 'advertiser_id', 'price', 'status', 'rejection_reason', 'expires_at'
    ];

    public function advertiser(): BelongsTo
    {
        return $this->belongsTo(Advertiser::class);
    }

    public static function digitalAdStats()
    {
        return self::query()
            ->selectRaw("sum(status = ". self::INACTIVE .") as inactive_count")
            ->selectRaw("sum(status =  ". self::ACTIVE .") as active_count")
            ->selectRaw("sum(status =  ". self::PAUSED .") as paused_count")
            ->first();
    }

    public static function latestAds($items = 3)
    {
        return self::whereDate('expires_at', '>=', now()->toDateString())
                            ->where('status', '=', self::ACTIVE)
                            ->orderBy('id', 'DESC')->take($items);
    }

    public static function RandomAd()
    {
        return self::whereDate('expires_at', '>=', now()->toDateString())
                            ->where('status', '=', self::ACTIVE)
                            ->orderBy('id', 'DESC');
    }
}
