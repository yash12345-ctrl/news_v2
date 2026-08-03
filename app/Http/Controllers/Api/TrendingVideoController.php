<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\TrendingVideo;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class TrendingVideoController extends Controller
{
    public function index(Request $request)
    {
        $videos = TrendingVideo::orderBy('id', 'desc')->paginate(20);
        return response()->json($videos);
    }

    public function store(Request $request)
    {
        $auth_user = auth()->user();
        if (!$auth_user->isSuperAdmin()) {
            throw new HttpException(403, 'You are not allowed to create Trending Video.');
        }

        $validated = $request->validate([
            'title' => 'required|max:256',
            'description' => 'nullable',
            'video_url' => 'required|max:512',
            'status' => 'nullable|integer'
        ]);

        $video = TrendingVideo::create($validated);
        return response()->json(['data' => $video]);
    }

    public function update(Request $request, $id)
    {
        $auth_user = auth()->user();
        if (!$auth_user->isSuperAdmin()) {
            throw new HttpException(403, 'You are not allowed to update Trending Video.');
        }

        $video = TrendingVideo::find($id);
        if (!$video) {
            throw new NotFoundResourceException("The video with ID '$id' does not exist.");
        }

        $validated = $request->validate([
            'title' => 'required|max:256',
            'description' => 'nullable',
            'video_url' => 'required|max:512',
            'status' => 'nullable|integer'
        ]);

        $video->update($validated);
        return response()->json(['data' => $video]);
    }

    public function upload(Request $request, $id = null)
    {
        $auth_user = auth()->user();
        if (!$auth_user->isSuperAdmin()) {
            throw new HttpException(403, 'You are not allowed to upload media.');
        }

        // 1. Strict validation: requires file, restricts extensions, max size 20MB (20480 KB)
        $request->validate([
            'file' => 'required|file|mimes:mp4,mov,avi,webm,jpeg,jpg,png,webp|max:20480'
        ], [
            'file.max' => 'File size exceeds the 20MB limit. Please reduce the size.',
            'file.mimes' => 'Invalid file format. Only video and image files are allowed.'
        ]);

        $file = $request->file('file');
        
        // 2. Ensure the uploads directory exists to prevent crashes
        $uploads_dir = public_path('uploads');
        if (!file_exists($uploads_dir)) {
            mkdir($uploads_dir, 0755, true);
        }

        $mimeType = $file->getMimeType();
        $name = time().Str::random(16).'.'.$file->getClientOriginalExtension();
        
        // 3. Move file to absolute public path
        $file->move($uploads_dir, $name);
        
        // 4. Use relative URL path so it works across localhost, ngrok, and live server
        $url = '/uploads/' . $name;

        if ($id) {
            $video = TrendingVideo::find($id);
            if ($video) {
                if (strpos($mimeType, 'image') !== false) {
                    $video->update(['thumbnail_url' => $url]);
                } else {
                    $video->update(['video_url' => $url]);
                }
                return response()->json(['message' => 'Upload successful', 'url' => $url, 'video' => $video]);
            }
            return response()->json(['message' => 'Video not found'], 404);
        }

        return response()->json(['url' => $url]);
    }

    public function destroy($id)
    {
        $auth_user = auth()->user();
        if (!$auth_user->isSuperAdmin()) {
            throw new HttpException(403, 'You are not allowed to delete.');
        }

        TrendingVideo::destroy($id);
        return response()->json(['message' => 'Deleted']);
    }

    public function updateStatus(Request $request, $id)
    {
        $auth_user = auth()->user();
        if (!$auth_user->isSuperAdmin()) {
            throw new HttpException(403, 'You are not allowed to update status.');
        }

        $video = TrendingVideo::findOrFail($id);
        $video->update(['status' => $request->status]);
        return response()->json(['data' => $video]);
    }
}
