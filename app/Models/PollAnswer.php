<?php

namespace App\Models;

use App\Models\Poll;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PollAnswer extends Model
{
    use HasFactory;

    protected $table = 'poll_answers';
    public $timestamps = false;

    protected $fillable = [
        'poll_id', 'answer'
    ];

    public function poll(): BelongsTo
    {
        return $this->belongsTo(Poll::class);
    }
}
