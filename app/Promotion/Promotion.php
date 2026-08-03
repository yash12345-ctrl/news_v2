<?php

namespace App\Promotion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;
    const IRRITATING_VISITOR = 1;
    const NON_IRRITATING_VISITOR = 2;

    const STATUS_DRAFT = 1;
    const STATUS_PUBLISHED = 2;
    const STATUS_UNPUBLISHED = 3;

    protected $table = 'promotions';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'image_url', 'small_image_url', 'link', 'irritating_visitor', 'expires_at', 'deleted_at', 'scheduled_at', 'status'
    ];

    public function isExpired()
    {
        $now = new \DateTime();
        $expires_at = new \DateTime($this->expires_at);

        return $now > $expires_at ? 1 : 0;
    }

    public static function publishedPromotion()
    {
        return self::where('status', '=', self::STATUS_PUBLISHED);
    }

    public static function activePromotion()
    {
        $now = new \DateTime();
        return self::where('expires_at', '>', $now)
                    ->where('status', '=', self::STATUS_PUBLISHED);
    }
}
