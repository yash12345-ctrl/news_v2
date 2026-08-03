<?php

namespace App\Models;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    use HasFactory;

    protected $table = 'pg_payments';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'payment_id', 'amount', 'pg_refund_id', 'pg_status'
    ];

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }


}
