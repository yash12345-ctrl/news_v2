<?php

namespace App\Models;

use App\Models\Guldastah;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GuldastahPage extends Model
{
    use HasFactory;

    protected $table = 'guldastah_pages';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'page_url', 'page_sm_url', 'page_number', 'guldastah_id'
    ];

    public function guldastah(): BelongsTo
    {
        return $this->belongsTo(Guldastah::class);
    }

    public static function getPagebyIdAndNumber($id, $page_number)
    {
        return self::where('page_number', '=', $page_number)
                    ->where('guldastah_id', '=', $id);
    }

}
