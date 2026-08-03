<?php

namespace App\Promotion;

use Illuminate\Support\Str;
use App\Promotion\Promotion;
use Illuminate\Http\Request;
use App\Models\MediaResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\PromotionResource;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class PromotionController extends Controller
{
    public function index(Request $request): JsonResource
    {
        $query = Promotion::query();

        if ($v = request("from_date")) {
            $query->whereDate("created_at", ">=", date("Y-m-d", strtotime($v)));
        }

        if ($v = request("to_date")) {
            $query->whereDate("created_at", "<=", date("Y-m-d", strtotime($v)));
        }

        if ($v = request('status')) {
            $query->where("status", "=", (int) $v);
        }

        if ($v = request("search")) {
            $query->where('name', 'LIKE', "%{$v}%");
        }

        $promotions = $query->orderBy('id', 'DESC')->paginate(20);

        return PromotionResource::collection($promotions);
    }


    public function store(Request $request): JsonResource
    {
        $auth_user = auth()->user();
        if (!$auth_user->isSuperAdmin() && !$auth_user->isEditor()) {
            throw new HttpException(403, 'You are not allowed to create promotion.');
        }

        $validated = $request->validate([
            "name" => "required|regex:/^[A-Za-z ]+$/|max:128",
            "irritating_visitor" => "nullable|integer|in:1,2",
            "expires_at"    => "required|date_format:Y-m-d H:i:s|after_or_equal:today",
            "scheduled_at"    => "nullable|date_format:Y-m-d H:i:s|after_or_equal:today",
            "link"    => "nullable",
            "media_resource" => "required",
            "media_resource.id" => "required_with:media_resource|integer",
        ]);

        $id = $validated['media_resource']['id'];
        if (is_null($media_resource = MediaResource::find($id))) {
            throw ValidationException::withMessages([
                "error" => ["Media Resource Not Found"],
            ]);
        }

        $validated['image_url'] = $media_resource->media_url;

        $promotion = Promotion::create($validated);
        $media_resource->delete();

        return new PromotionResource($promotion);
    }

    public function update(Request $request, int $id): JsonResource
    {
        $auth_user = auth()->user();
        if (!$auth_user->isSuperAdmin() && !$auth_user->isEditor()) {
            throw new HttpException(403, 'You are not allowed to update promotion.');
        }

        $promotion = Promotion::find($id);
        if (is_null($promotion)) {
            throw new NotFoundResourceException("Promotion with ID '$id' does not exist.");
        }

        $validated = $request->validate([
            "name" => "required|regex:/^[A-Za-z ]+$/|max:128",
            "irritating_visitor" => "nullable|integer|in:1,2",
            "expires_at"    => "required|date_format:Y-m-d H:i:s|after_or_equal:today",
            "scheduled_at"    => "nullable|date_format:Y-m-d H:i:s|after_or_equal:today",
            "link"    => "nullable",
        ]);

        $promotion->update($validated);

        return new PromotionResource($promotion);
    }

    public function show(Request $request, int $id): JsonResource
    {
        $promotion = Promotion::find($id);
        if (is_null($promotion)) {
            throw new NotFoundResourceException("Promotion with ID '$id' does not exist.");
        }

        return new PromotionResource($promotion);
    }

    public function upload(Request $request, int $id): JsonResource
    {
        $auth_user = auth()->user();
        if (!$auth_user->isSuperAdmin() && !$auth_user->isEditor()) {
            throw new HttpException(403, 'You are not allowed to upload promotion creative.');
        }

        $validated = $request->validate([
            'photo'     => 'nullable|file|mimes:jpeg,png,jpg|max:1024',
        ]);

        $promotion = Promotion::find($id);
        if (is_null($promotion)) {
            throw new NotFoundResourceException("Promotion with ID '$id' does not exist.");
        }

        $old_image = $promotion->image_url;
        $validated['image_url'] =  $old_image;

        if ($file = $request->file('photo')) {
            $name = time().Str::random(16).'.jpg';
            $file->move('uploads', $name);
            $validated['image_url'] = env('ASSETS_CDN') . $name;
        }

        $promotion->update($validated);

        if (!is_null($old_image) && $request->hasFile('photo')) {
            $file_name = strrchr($old_image, "/");
            if ($file_name !== false && !strstr($file_name, "avatar")) {
                $image_path = public_path('uploads'.$file_name);
                unlink($image_path);
            }
        }

        return new PromotionResource($promotion);
    }

    public function updateStatus(Request $request, int $id): JsonResource
    {
        $auth_user = auth()->user();
        if (!$auth_user->isSuperAdmin() && !$auth_user->isEditor()) {
            throw new HttpException(403, 'You are not allowed to update status of promotion.');
        }

        $promotion = Promotion::find($id);
        if (is_null($promotion)) {
            throw new NotFoundResourceException("Promotion with ID '$id' does not exist.");
        }

        $validated = $request->validate([
            "status" => "required|integer|in:2,3"
        ]);

        if ($validated['status'] == Promotion::STATUS_PUBLISHED) {
            if ($promotion->isExpired()) {
                throw ValidationException::withMessages([
                   "error" => ["Expired promotion can not be published"]
                ]);
            }

            $published_promotion = Promotion::publishedPromotion()->first();

            if (!is_null($published_promotion)) {
                $published_promotion->status = Promotion::STATUS_UNPUBLISHED;
                $published_promotion->save();
            }
        }

        $promotion->update($validated);

        return new PromotionResource($promotion);
    }

    public function destroy(Request $request, int $id): JsonResource
    {
        $auth_user = auth()->user();
        if (!$auth_user->isSuperAdmin() && !$auth_user->isEditor()) {
            throw new HttpException(403, 'You are not allowed to delete promotion.');
        }

        $promotion = Promotion::find($id);
        if (is_null($promotion)) {
            throw new NotFoundResourceException("Promotion with ID '$id' does not exist.");
        }

        $small_image_url = $promotion->small_image_url;
        $image_url = $promotion->image_url;

        if (!is_null($small_image_url) || !is_null($image_url)) {
            $file_name1 = strrchr($small_image_url, "/");
            $file_name2 = strrchr($image_url, "/");
            if ($file_name1 !== false) {
                $image_path1 = public_path('uploads'.$file_name1);
                if (file_exists($image_path1)) {
                    unlink($image_path1);
                }
            }

            if ($file_name2 !== false) {
                $image_path2 = public_path('uploads'.$file_name2);
                if (file_exists($image_path2)) {
                    unlink($image_path2);
                }
            }
        }

        $promotion->delete();

        return new PromotionResource($promotion);
    }
}
