<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\MediaResource;
use App\Rules\ValidMediaTypeRule;
use App\Http\Controllers\Controller;
use App\Http\Resources\MediaResourceResource;
use Illuminate\Http\Resources\Json\JsonResource;

class MediaResourceController extends Controller
{
    public function store(Request $request): JsonResource
    {
        $validated = $request->validate([
            "media_type"    => "required|integer|in:2,3,4",
            "media"         => ['required', new ValidMediaTypeRule($request->input('media_type'))], // 1024*1.9 = 1.9MB
        ]);

        if ($validated['media_type'] == MediaResource::MEDIA_TYPE_VIDEO) {
            $validated['media_url'] = $validated['media'];
        }

        if ($file = $request->file("media")) {
            $name = time().Str::random(16).'.'.$file->extension();
            $file->move('uploads', $name);
            $validated["media_url"] = env('ASSETS_CDN') . $name;
        }
        $media_resource = MediaResource::create($validated);

        return new MediaResourceResource($media_resource);
    }
}
