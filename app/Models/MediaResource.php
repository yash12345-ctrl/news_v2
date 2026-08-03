<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaResource extends Model
{
    use HasFactory;
    const MEDIA_TYPE_TEXT = 1;
    const MEDIA_TYPE_IMAGE = 2;
    const MEDIA_TYPE_AUDIO = 3;
    const MEDIA_TYPE_VIDEO = 4;

    protected $table = "media_resources";

    protected $fillable = [
        "media_type", "media_url", "created_at", "updated_at"
    ];
}
