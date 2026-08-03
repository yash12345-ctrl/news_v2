<?php

namespace App\Http\Controllers\Api\Quiz;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UserProfileController extends Controller
{
    public function avatars(Request $request)
    {
        $all_images = $this->getAllImages();

        return [
            "data" => $all_images
        ];
    }

    private function getImagesFromDirectory($path, $url_prefix)
    {
        if (!File::exists($path)) {
            return [];
        }

        $files = File::files($path);

        return array_map(function ($file) use ($url_prefix) {
            return asset($url_prefix . '/' . $file->getFilename());
        }, $files);
    }

    private function getAllImages()
    {
        $animal_path = public_path('assets/profile-images/animal-avatar');
        $profile_path = public_path('assets/profile-images/profile-avatar');

        $animal_images = $this->getImagesFromDirectory($animal_path, 'assets/profile-images/animal-avatar');
        $profile_images = $this->getImagesFromDirectory($profile_path, 'assets/profile-images/profile-avatar');

        $all_images = array_merge($animal_images, $profile_images);

        return $all_images;
    }

    public function uploadProfileImage(Request $request): JsonResource
    {
        $user = auth()->user();
        if (!$user->isUser()) {
            throw new HttpException(403, 'You are not allow to upload profile image');
        }

        $validated = $request->validate([
            'photo'     => 'required',
        ]);

        $all_images = $this->getAllImages();

        if (!in_array($validated['photo'], $all_images)) {
            throw new HttpException(422, 'The selected photo is invalid.');
        }

        $user->update($validated);

        return new UserResource($user);
    }
}
