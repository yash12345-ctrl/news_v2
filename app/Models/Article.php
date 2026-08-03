<?php

namespace App\Models;

use App\Models\User;
use App\Models\Admin;
use App\Models\Category;
use App\Models\ArticleVote;
use App\Models\ArticleComment;
use App\Support\VideoUrlTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    use HasFactory;
    use VideoUrlTrait;

    protected $table = 'articles';

    const DRAFT = 1;
    const PUBLISHED = 2;
    const INACTIVE = 3;
    const MAIN = 1;
    const POPULAR = 2;
    const NOFLAG = 0;
    const URDU = 1;
    const HINDUSTANI = 2;
    const BOTH = 3;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title_en',
        'title_ur',
        'content_short_en',
        'content_short_ur',
        'content_en',
        'content_ur',
        'slug',
        'article_url',
        'image_url',
        'image_sm_url',
        'video_url',
        'source',
        'category_id',
        'admin_id',
        'views',
        'status',
        'visible_in',
        'published_at',
        'flag'
    ];

    public function articleVotes(): HasMany
    {
        return $this->hasMany(ArticleVote::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function articleComments(): HasMany
    {
        return $this->hasMany(ArticleComment::class);
    }

    public static function getSlugs($slug): int
    {
        return self::select()->where('slug', 'like', $slug.'%')->count();
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    public static function makeQueryForVisibleIn($query, $lang)
    {
        $query->where(function($query) use ($lang) {
            $query->where('visible_in', $lang)
                ->orWhere('visible_in', Article::BOTH);
        });
    }

    public static function trendingArticles($items = 20, $lang = null)
    {
        return self::where('status', '=', self::PUBLISHED)
                            ->when($lang, fn($query) => self::makeQueryForVisibleIn($query, $lang))
                            ->orderByRaw('DATE(created_at) = CURDATE() DESC')
                            ->orderBy('views', 'DESC')
                            ->take($items);
    }

    public static function popularToday($items = 20, $lang = null)
    {
        return self::where('status', '=', self::PUBLISHED)
                                    ->where('flag', '=', self::POPULAR)
                                    ->when($lang, fn($query) => self::makeQueryForVisibleIn($query, $lang))
                                    ->orderBy('id', 'DESC')->take(10)->get();

    }

    public static function popularArticles($items = 20, $lang = null)
    {
        return self::where('status', '=', self::PUBLISHED)
                    ->when($lang, fn($query) => self::makeQueryForVisibleIn($query, $lang))
                    ->orderBy('views', 'DESC');
    }

    public static function pastPopularArticle($lang = null)
    {
        return self::where('status', '=', self::PUBLISHED)
                    ->when($lang, fn($query) => self::makeQueryForVisibleIn($query, $lang))
                    ->orderBy('views', 'DESC')->take(24)->get();
    }

    public static function searchByTitle($title) {
        return self::where('title_en', 'like', '%' . $title . '%')
                        ->orWhere('title_ur', 'like', '%' . $title . '%')
                        ->where('status', '=', self::PUBLISHED)
                        ->paginate(20);
    }

    public static function relatedArticles($category_id, $lang = null,  $items = 10, $skip = 0)
    {
        return self::where('category_id', '=', $category_id)
                        ->where('status', '=', self::PUBLISHED)
                        ->when($lang, fn($query) => self::makeQueryForVisibleIn($query, $lang))
                        ->orderBy('views', 'DESC')->skip($skip)->paginate($items);
    }

    public static function latestArticles($item = 6, $lang = null)
    {
        return self::where('status', '=', self::PUBLISHED)
                        ->when($lang, fn($query) => self::makeQueryForVisibleIn($query, $lang))
                        ->orderBy('id', 'DESC')->take($item)->get();
    }

    public static function mainArticles($lang = null)
    {
        // If there is any Main article set by admin then return that otherwise
        // return the last article added.
        $main_article = self::where('status', '=', self::PUBLISHED)
                                ->when($lang, fn($query) => self::makeQueryForVisibleIn($query, $lang))
                                ->where('flag', '=', self::MAIN);
        // @NOTE(mukhtar): It is very important to pick the last set main article
        // So that the current main article should be returned instead of old one.
        if ($main_article->latest('id')->first()) {
            return $main_article;
        }

        return self::whereDate('created_at', '>=', date('Y-m-d')." 00:00:00")
                            ->where('status', '=', self::PUBLISHED)
                            ->when($lang, fn($query) => self::makeQueryForVisibleIn($query, $lang))
                            ->orderBy('id', 'DESC');
    }

    public static function articlesByCategoryId($category_id)
    {
        return self::where('category_id', $category_id)
                    ->orderBy('views', 'DESC')
                    ->take(6);
    }

    public function hasFlag(): bool
    {
        return (bool) ((int) $this->flag);
    }


    public static function articleStats()
    {
        return self::query()
            ->selectRaw("sum(status = ". self::PUBLISHED .") as published_count")
            ->selectRaw("sum(status =  ". self::DRAFT .") as draft_count")
            ->selectRaw("sum(status =  ". self::INACTIVE .") as inactive_count")
            ->first();
    }
    public static function findLastMainArticle($visible_in)
    {
        return self::where('status', '=', self::PUBLISHED)
                            ->where('visible_in', '=', $visible_in)
                            ->where('flag', '=', self::MAIN);
    }

    /**
     * Property accessors
     * Returns correct prefered lang field value
     *
     *
     */
    public function getTitleAttribute($value)
    {
        return lang_english() ? $this->title_en : $this->title_ur;
    }

    public function getArticleUrlAttribute($value)
    {
        return url('/articles/' . $this->slug);
    }

    public function getContentShortAttribute($value)
    {
        return lang_english() ? $this->content_short_en : $this->content_short_ur;
    }

    public function getContentAttribute($value)
    {
        return lang_english() ? $this->content_en : $this->content_ur;
    }

    // public function extractVideoId($link)
    // {
    //     // https://www.youtube.com/watch?v=_bPCjIWeVKY
    //     // https://youtu.be/_bPCjIWeVKY
    //     // https://youtu.be/_bPCjIWeVKY?si=2qlsc5Qrtdjg3DDI

    //     $matches = [];
    //     $pattern1 = "/^https:\/\/www\.youtube\.com\/watch\?v=(.+)/";
    //     $pattern2 = "/^https:\/\/youtu.be\/(.+)\?*(.*)$/";
    //     if (preg_match($pattern1, $link, $matches)) {
    //         return $matches[1];
    //     } else if (preg_match($pattern2, $link, $matches)) {
    //         return $matches[1];
    //     }

    //     return "";
    // }

    public function isVideoArticle()
    {
        return $this->video_url == null;
    }

}
