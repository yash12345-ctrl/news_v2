<?php

namespace App\Models;

use App\Models\Admin;
use App\Models\GuldastahPage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Guldastah extends Model
{
    use HasFactory;

    protected $table = 'guldastahs';

    public $timestamps = false;
    protected $casts = [
    'created_at' => 'datetime'      // When timestamp is false then you have to tell that created_at as datetime
    ];
    
    const DRAFT = 1;
    const PUBLISHED = 2;
    const UNPUBLISHED = 3;

    protected $fillable = [
        'title', 'subtitle', 'pages', 'image_url', 'admin_id', 'status', 'created_at', 'updated_at'
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    public function guldastahPage(): HasMany
    {
        return $this->hasMany(GuldastahPage::class, 'guldastah_id');
    }

    public static function filterGuldastah($from, $to)
    {
        $from = date("Y-m-d 00:00:00", strtotime($from));
        $to = date("Y-m-d 23:59:59", strtotime($to));

        return self::whereBetween('created_at', [$from, $to]);
    }

    public static function lastGuldastah()
    {
        return self::where('status', self::PUBLISHED)
                    ->where('created_at', "<=", date("Y-m-d H:i:s"))
                    ->orderBy('id', 'DESC');
    }
}
