<?php

namespace App\Models;

use App\Models\ENewsPaper;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ENewsPaperPage extends Model
{
    use HasFactory;

    protected $table = 'enews_paper_pages';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'page_url', 'page_sm_url', 'page_number', 'enews_paper_id'
    ];

    public function enewsPaper(): BelongsTo
    {
        return $this->belongsTo(ENewsPaper::class);
    }

    public static function getPagebyIdAndNumber($id, $page_number)
    {
        return self::where('page_number', '=', $page_number)
                    ->where('enews_paper_id', '=', $id)->first();
    }
}
