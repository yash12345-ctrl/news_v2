<?php

namespace App\Models;

use App\Models\Storage;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreItem extends Model
{
    use HasFactory;

    protected $table = 'store_items';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'storage_id', 'skey',
    ];

    public function storage(): BelongsTo
    {
        return $this->belongsTo(Storage::class);
    }
}
