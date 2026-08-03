<?php

namespace App\Models;

use App\Models\User;
use App\Models\Article;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ArticleComment extends Model
{
    use HasFactory;

    protected $table = "article_comments";

    public $timestamps = false;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

     protected $fillable = [
        'comment', 'article_id', 'user_id', 'created_at'
     ];

     public function user(): BelongsTo
     {
        return $this->belongsTo(User::class);
     }

     public function article(): BelongsTo
     {
        return $this->belongsTo(Article::class);
     }
}
