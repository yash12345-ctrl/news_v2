<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class UserController extends Controller
{
    public function index(): JsonResource
    {
        $auth_user = auth()->user();
        if (!$auth_user->isSuperAdmin()) {
            throw new HttpException(403, 'You are not allowed to see users list.');
        }

        // Hide unverified (status = 0) users by default
        $users = User::query()->where('status', '!=', 0);

        if (request("from_date")) {
            $users->where("created_at", ">=", date("Y-m-d", strtotime(request("from_date"))));
        }

        if (request("to_date")) {
            $users->where("created_at", "<=", date("Y-m-d", strtotime(request("to_date"))));
        }

        if (request("status")) {
            $users->where("status", "=", (int) request("status"));
        }

        if (request("source") === 'app') {
            $users->whereNull('email');
        } elseif (request("source") === 'web') {
            $users->whereNotNull('email');
        }

        if ($v = request("search")) {
            $users->where('first_name', 'LIKE', "%{$v}%")
                ->orWhere('last_name', 'LIKE', "%{$v}%")
                ->orWhere('phone', 'LIKE', "%{$v}%")
                ->orWhere('email', 'LIKE', "%{$v}%");
        }

        $users = $users->orderBy('id', 'DESC')->paginate(20);

        return UserResource::collection($users);
    }

    public function show(int $id): JsonResource
    {
        $auth_user = auth()->user();
        if (!$auth_user->isSuperAdmin()) {
            throw new HttpException(403, 'You are not allowed to see users details.');
        }

        $user = User::find($id);
        if (is_null($user)) {
            throw new NotFoundResourceException("The user with ID '$id' does not exist.");
        }

        return new UserResource($user);

    }

    public function update(Request $request, int $id): JsonResource
    {
        $auth_user = auth()->user();
        if (!$auth_user->isSuperAdmin()) {
            throw new HttpException(403, 'You are not allowed to update users.');
        }

        $validated = $request->validate([
            'first_name'    => 'required|max:32',
            'last_name'     => 'required|max:32',
            'gender'        => 'required|integer|in:1,2',
            'phone'         => ['required', 'numeric', 'digits:10', Rule::unique('users')->ignore($id)->whereNull('deleted_at')],
            'email'         => ['required', 'email', 'max:64', Rule::unique('users')->ignore($id)->whereNull('deleted_at')],
        ]);

        $users = User::find($id);
        if (is_null($users)) {
            throw new NotFoundResourceException("The users with ID '$id' does not exist.");
        }

        $old_image = $users->photo;
        $validated['photo'] = $old_image;

        $users->update($validated);

        return new UserResource($users);
    }

    public function upload(Request $request, int $id): JsonResource
    {
        $auth_user = auth()->user();
        if (!$auth_user->isSuperAdmin()) {
            throw new HttpException(403, 'You are not allowed to upload user image.');
        }

        $validated = $request->validate([
            'photo'     => 'nullable|file|mimes:jpeg,png,jpg|max:1024',
        ]);

        $user = User::find($id);
        if (is_null($user)) {
            throw new NotFoundResourceException("The user with ID '$id' does not exist.");
        }

        $old_image = $user->photo;
        $validated['photo'] =  $old_image;

        if ($file = $request->file('photo')) {
            $name = time().Str::random(16).'.jpg';
            $file->move('uploads', $name);
            $validated['photo'] = env('ASSETS_CDN') . $name;
        }

        $user->update($validated);

        if (!is_null($old_image) && $request->hasFile('photo')) {
            $file_name = strrchr($old_image, "/");
            if ($file_name !== false && !strstr($file_name, "avatar")) {
                $image_path = public_path('uploads'.$file_name);
                unlink($image_path);
            }
        }

        return new UserResource($user);
    }

    public function resetPassword(Request $request, User $user)
    {
        $auth_user = auth()->user();

        if (!$auth_user->isSuperAdmin()) {
            throw new HttpException(403, "You are not allowed to reset password");
        }

        // @TODO Later we will send default password on User  verified Email
        $user->update([
            "password" => Hash::make(env('DEFAULT_PASSWORD'))
        ]);

        return new UserResource($user);
    }

    public function updateStatus(Request $request, User $user)
    {
        $auth_user = auth()->user();

        if (!$auth_user->isSuperAdmin()) {
            throw new HttpException(403, "You are not allowed to update status");
        }

        $validated = $request->validate([
            'status'   => 'required|integer|in:2,3',
        ]);

        $user->update($validated);
        return new UserResource($user);
    }

    public function destroy(int $id)
    {
        $auth_user = auth()->user();

        if (!$auth_user->isSuperAdmin()) {
            throw new HttpException(403, "You are not allowed to delete users.");
        }

        $user = User::find($id);
        if (is_null($user)) {
            throw new NotFoundResourceException("The user with ID '$id' does not exist.");
        }

        if ($user->id === $auth_user->id) {
            throw new HttpException(403, "You cannot delete yourself.");
        }

        // Free up the email and phone before soft-deleting so the same email/phone can be registered again.
        $user->email = $user->email . '.deleted.' . $user->id . '.' . time();
        if ($user->phone) {
            $user->phone = $user->phone . '.del' . $user->id;
        }
        $user->save();
        $user->delete();

        return response()->json(['message' => 'User deleted successfully.']);
    }
}
