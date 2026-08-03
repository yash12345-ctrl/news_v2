<?php

namespace App\Models;

use App\Models\Article;
use App\Models\Advertiser;
use App\Models\ENewsPaper;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class Admin extends Model implements AuthenticatableContract, AuthorizableContract
{
    use HasApiTokens, HasFactory, Authenticatable, Authorizable;

    const SUPER_ADMIN = 1;
    const EDITOR = 2;
    const REPORTER = 3;

    const STATUS_INACTIVE = 1;
    const STATUS_ACTIVE = 2;
    const STATUS_BLOCKED = 3;

    protected $table = 'admins';

    protected $fillable = [
        'first_name', 'last_name', 'gender', 'phone', 'email', 'password', 'role', 'status', 'photo', 'verified_at' 
    ];

    protected $hidden = [
        'password'
    ];

    public function enewsPaper(): HasOne
    {
        return $this->hasOne(ENewsPaper::class);
    }

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    public function roleAsString()
    {
        if ($this->role === self::SUPER_ADMIN) {
            return "Super Admin";
        }

        if ($this->role === self::EDITOR) {
            return "Editor";
        }

        if ($this->role === self::REPORTER) {
            return "Reporter";
        }

        return "";
    }

    public function fullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function isSuperAdmin()
    {
        return $this->role == self::SUPER_ADMIN;
    }

    public function isEditor()
    {
        return $this->role == self::EDITOR;
    }

    public function isReporter()
    {
        return $this->role == self::REPORTER;
    }

    public function isUser()
    {
        return false;
    }

    public function getAuthPasswordName()
    {
        return 'password';
    }
}
