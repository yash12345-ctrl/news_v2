<?php

namespace App\Models;

use App\Models\User;
use App\Models\Article;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ArticleVote extends Model
{
    use HasFactory;

    protected $table = "article_votes";

    const BEST = 1;
    const GOOD = 2;
    const OKAY = 3;
    const BAD = 4;
    const WORST = 5;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

     protected $fillable = [
        'vote_type', 'article_id', 'user_id', 'created_at'
     ];

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function voteStat($id)
    {
        return ArticleVote::query()
            ->selectRaw("COALESCE(SUM(vote_type = " . self::BEST . "), 0) as best")
            ->selectRaw("COALESCE(SUM(vote_type = " . self::GOOD . "), 0) as good")
            ->selectRaw("COALESCE(SUM(vote_type = " . self::OKAY . "), 0) as okay")
            ->selectRaw("COALESCE(SUM(vote_type = " . self::BAD . "), 0) as bad")
            ->selectRaw("COALESCE(SUM(vote_type = " . self::WORST . "), 0) as worst")
            ->where('article_id', $id)
            ->first();
    }
}