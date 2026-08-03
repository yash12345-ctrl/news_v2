<?php

namespace App\Models;

use App\Models\PgPayment;
use App\Models\Refund;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

     protected $table = 'payments';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'amount', 'status'
    ];

    public function pgPayment(): HasOne
    {
        return $this->hasOne(PgPayment::class);
    }

    public function refund(): HasOne
    {
        return $this->hasOne(Refund::class);
    }
}
