<?php

namespace App\Http\Controllers\Api;

use App\Models\Advertiser;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\AdvertiserResource;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class AdvertiserController extends Controller
{
    public function index(): JsonResource
    {
        $auth_user = auth()->user();

        if (!$auth_user->isSuperAdmin()) {
            throw new HttpException(403, 'You are not allowed to see list of advertisers.');
        }

        $advertisers = Advertiser::query();

        if (request("from_date")) {
            $advertisers->where("created_at", ">=", date("Y-m-d", strtotime(request("from_date"))));
        }

        if (request("to_date")) {
            $advertisers->where("created_at", "<=", date("Y-m-d", strtotime(request("to_date"))));
        }

        if ($v = request("search")) {
            $advertisers->where('name', 'LIKE', "%{$v}%");
        }

        if ($auth_user->isSuperAdmin() && ($v = (int) request("status"))) {
            $advertisers->where('status', $v);
        }

        $advertisers = $advertisers->orderBy('id', 'DESC')->paginate(20);

        return AdvertiserResource::collection($advertisers);
    }

    public function store(Request $request): JsonResource
    {
        $auth_user = auth()->user();
        if (!$auth_user->isSuperAdmin()) {
            throw new HttpException(403, 'You are not allowed to create advertiser');
        }

        $validated = $request->validate([
            'name'      => 'required|max:32',
            'phone'     => 'required|numeric|digits:10|unique:advertisers',
            'email'     => 'required|email|unique:advertisers|max:64',
            'password'  => 'required|min:8|max:30',
            'company_name'  => 'nullable|max:256',
            'company_type'  => 'nullable|integer',
            'company_size'  => 'nullable|integer',
        ]);
        $validated['admin_id'] =  $auth_user->id;
        $validated['password'] = Hash::make($validated['password']);
        $validated['logo_url'] = env('DEFAULT_IMG_URL');

        $advertiser = Advertiser::create($validated);

        return new AdvertiserResource($advertiser);
    }

    public function update(Request $request, int $id): JsonResource
    {
        $auth_user = auth()->user();
        if (!$auth_user->isSuperAdmin()) {
            throw new HttpException(403, 'You are not allowed to update advertiser.');
        }

        $validated = $request->validate([
            'name'      => 'required|max:32',
            'phone'     => 'required|numeric|digits:10|unique:advertisers,phone,'.$id,
            'email'     => 'required|email|max:64|unique:advertisers,email,'.$id,
            'company_name'  => 'nullable|max:256',
            'company_type'  => 'nullable|integer',
            'company_size'  => 'nullable|integer',
        ]);

        $advertiser = Advertiser::find($id);
        if (is_null($advertiser)) {
            throw new NotFoundResourceException("The advertiser with ID '$id' does not exist.");
        }

        if ($auth_user->id !== $advertiser->admin_id) {
            throw ValidationException::withMessages([
                'error' => ["Advertiser with ID '{$advertiser->id}' does not belong to you"],
            ]);
        }

        $validated['logo_url'] = $advertiser->logo_url;

        $advertiser->update($validated);

        return new AdvertiserResource($advertiser);
    }

    public function upload(Request $request, int $id): JsonResource
    {
        $auth_user = auth()->user();
        if (!$auth_user->isSuperAdmin()) {
            throw new HttpException(403, 'You are not allowed to upload advertiser image.');
        }

        $validated = $request->validate([
            'photo'     => 'nullable|file|mimes:jpeg,png,jpg|max:1024',
        ]);

        $advertiser = Advertiser::find($id);
        if (is_null($advertiser)) {
            throw new NotFoundResourceException("The advertiser with ID '$id' does not exist.");
        }

        if ($auth_user->id !== $advertiser->admin_id) {
            throw ValidationException::withMessages([
                'error' => ["Advertiser with ID '{$advertiser->id}' does not belong to you"],
            ]);
        }

        $old_image = $advertiser->logo_url;
        $validated['logo_url'] =  $old_image;

        if ($file = $request->file('photo')) {
            $name = time().Str::random(16).'.jpg';
            $file->move('uploads', $name);
            $validated['logo_url'] = env('ASSETS_CDN') . $name;
        }

        $advertiser->update($validated);

        if (!is_null($old_image) && $request->hasFile('photo')) {
            $file_name = strrchr($old_image, "/");
            if ($file_name !== false) {
                $image_path = public_path('uploads'.$file_name);
                unlink($image_path);
            }
        }

        return new AdvertiserResource($advertiser);
    }

    public function show(int $id): JsonResource
    {
        $auth_user = auth()->user();
        if (!$auth_user->isSuperAdmin()) {
            throw new HttpException(403, 'You are not allowed to see advertiser details.');
        }

        $advertiser = Advertiser::find($id);
        if (is_null($advertiser)) {
            throw new NotFoundResourceException("The advertiser with ID '$id' does not exist.");
        }

        if ($auth_user->id !== $advertiser->admin_id) {
            throw ValidationException::withMessages([
                'error' => ["Advertiser with ID '{$advertiser->id}' does not belong to you"],
            ]);
        }

        $digital_ad = $advertiser->digitalAd()->get();
        $result = [
            "advertiser" => $advertiser,
            "digital_ad" => $digital_ad
        ];

        return new AdvertiserResource($result);
    }

    public function updateStatus(Request $request, int $id): JsonResource
    {
        $auth_user = auth()->user();
        if (!$auth_user->isSuperAdmin()) {
            throw new HttpException(403, 'You are not allowed to update advertiser status.');
        }

        $validated = $request->validate([
            'status' => 'required|integer|in:1,2,3'
        ]);

        $advertiser = Advertiser::find($id);
        if (is_null($advertiser)) {
            throw new NotFoundResourceException("The advertiser with ID '$id' does not exist.");
        }

        if ($auth_user->id !== $advertiser->admin_id) {
            throw ValidationException::withMessages([
                'error' => ["Advertiser with ID '{$advertiser->id}' does not belong to you"],
            ]);
        }

        $advertiser->update($validated);

        return new AdvertiserResource($advertiser);
    }
}
