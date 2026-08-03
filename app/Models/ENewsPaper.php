<?php

namespace App\Models;

use \stdClass;
use App\Models\Admin;
use App\Models\Category;
use App\Models\ENewsPaperPage;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ENewsPaper extends Model
{
    use HasFactory;

    const DRAFT = 1;
    const PUBLISHED = 2;
    const UNPUBLISHED = 3;

    protected $table = 'enews_papers';
    public $timestamps = false;
    protected $casts = [
    'created_at' => 'datetime'      // When timestamp is false then you have to tell that created_at as datetime
    ];

     // const PUBLISHED = 2;
     // const UNPUBLISHED = 1;
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'subtitle', 'description', 'slug', 'pages', 'edition', 'image_url', 'admin_id', 'status', 'created_at', 'updated_at'
    ];

    public function editor(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function enewsPaperPage(): HasMany
    {
        return $this->hasMany(ENewsPaperPage::class, 'enews_paper_id');
    }

    public static function getSlugs($slug): int
    {
        return self::select()->where('slug', 'like', $slug.'%')->count();
    }

    public static function searchByTitle($title)
    {
        return self::where('title', 'like', '%' . $title . '%')->paginate(10);
    }

    public static function filterEnewsPaper($from, $to)
    {
        $from = date("Y-m-d 00:00:00", strtotime($from));
        $to = date("Y-m-d 23:59:59", strtotime($to));

        return self::whereBetween('created_at', [$from, $to])->get();
    }

    public static function lastEnews()
    {
        return self::where('status', self::PUBLISHED)
                       -> where('edition', env('KOLKATA_EDITION'))
                        ->orderBy('id', 'DESC')->first();
    }

    public static function edition()
    {
        $edition_array = explode(',', env('EDITION_ARRAY'));

        $object = new \stdClass();
        foreach ($edition_array as $key => $value) {
            $object->{$key+1} = $value;
        }

        return $object;
    }

    public static function epaperStats()
    {
        return self::query()
            ->selectRaw("sum(status = ". self::PUBLISHED .") as published_count")
            ->selectRaw("sum(status =  ". self::UNPUBLISHED .") as unpublished_count")
            ->first();
    }

    public function isPublished(): bool
    {
        return (int) $this->status === self::PUBLISHED;
    }
}
