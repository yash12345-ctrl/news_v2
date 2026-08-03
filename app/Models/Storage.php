<?php

namespace App\Models;

use App\Models\StoreItem;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Storage extends Model
{
    use HasFactory;

    protected $table = 'storages';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'storage'
    ];

    public function storeItem(): HasOne
    {
        return $this->hasOne(StoreItem::class);
    }
}
