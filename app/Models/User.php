<?php

namespace App\Models;

use App\Models\Address;
use App\Models\Article;
use App\Models\ArticleVote;
use App\Models\PasswordReset;
use App\Models\ArticleComment;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, HasApiTokens, SoftDeletes;

    const STATUS_INACTIVE = 1;
    const STATUS_ACTIVE = 2;
    const STATUS_BLOCKED = 3;

    protected $dates = ['deleted_at'];

    protected $table = 'users';

    protected $guard = 'user-api';

    protected $fillable = [
        'first_name', 'last_name', 'gender', 'dob', 'age', 'phone', 'email', 'password', 'photo', 'lang', 'latitude', 'longitude', 'status', 'address_id', 'verified_at', 'username'
    ];

    protected $hidden = [
        'password'
    ];

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function passwordReset(): HasOne
    {
        return $this->hasOne(PasswordReset::class);
    }

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    public function articleVotes(): HasMany
    {
        return $this->hasMany(ArticleVote::class);
    }

    public function articleComments(): HasMany
    {
        return $this->hasMany(ArticleComment::class);
    }

    public function fullName()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function isSuperAdmin()
    {
        return false;
    }

    public function isEditor()
    {
        return false;
    }

    public function isReporter()
    {
        return false;
    }

    public function isUser()
    {
        return true;
    }
}
