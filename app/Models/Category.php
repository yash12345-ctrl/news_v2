<?php

namespace App\Models;

use App\Models\Article;
use App\Models\ENewsPaper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name_ur', 'name_en', 'description_ur', 'description_en', 'parent_id', 'image_url',
    ];

    public function getNameAttribute($value)
    {
        return lang_english() ? $this->name_en : $this->name_ur;
    }

    public function enewsPaper(): hasMany
    {
        return $this->hasMany(ENewsPaper::class);
    }

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }
}
