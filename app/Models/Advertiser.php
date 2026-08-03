<?php

namespace App\Models;

use App\Models\Admin;
use App\Models\DigitalAd;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Advertiser extends Model
{
    use HasFactory;

    const STATUS_ACTIVE = 1;
    const STATUS_BLOCKED = 2;
    const STATUS_SUSPENDED = 3;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'password',
        'logo_url',
        'company_name',
        'company_type',
        'company_size',
        'admin_id',
        'status'
    ];

    public function digitalAd(): hasMany
    {
        return $this->hasMany(DigitalAd::class);
    }

}
