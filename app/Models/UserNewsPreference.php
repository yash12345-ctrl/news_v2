<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserNewsPreference extends Model
{
    use HasFactory;

    protected $table = 'user_news_preferences';

    protected $fillable = [
        'user_id', 'category_id'
    ];
}
