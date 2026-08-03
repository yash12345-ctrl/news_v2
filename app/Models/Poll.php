<?php

namespace App\Models;

use App\Models\PollVote;
use App\Models\PollAnswer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Poll extends Model
{
    use HasFactory;
    const MEDIA_IMAGE = 1;
    const MEDIA_YOUTUBE = 2;

    const STATUS_DRAFT = 1;
    const STATUS_PUBLISHED = 2;
    const STATUS_UNPUBLISHED = 3;

    protected $table = 'polls';

    protected $fillable = [
        'title', 'description', 'question', 'media_url', 'media_kind', 'status', 'published_at'
    ];

    public function pollVotes(): HasMany
    {
        return $this->hasMany(PollVote::class);
    }

    public function pollAnswers(): HasMany
    {
        return $this->hasMany(PollAnswer::class);
    }
}
