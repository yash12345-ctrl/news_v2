<?php

namespace App\Http\Controllers\Api;

use App\Models\Admin;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\AdminResource;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class AdminController extends Controller
{
    public function index(): JsonResource
    {
        $auth_user = auth()->user();
        if (!$auth_user->isSuperAdmin()) {
            throw new HttpException(403, 'You are not allowed to see list of admins.');
        }

        $admins = Admin::query();

        if (request("from_date")) {
            $admins->where("created_at", ">=", date("Y-m-d", strtotime(request("from_date"))));
        }

        if (request("to_date")) {
            $admins->where("created_at", "<=", date("Y-m-d", strtotime(request("to_date"))));
        }

        if (request("status")) {
            $admins->where("status", "=", (int) request("status"));
        }

        if ($v = request("search")) {
            $admins->where('first_name', 'LIKE', "%{$v}%")
                ->orWhere('last_name', 'LIKE', "%{$v}%")
                ->orWhere('phone', 'LIKE', "%{$v}%")
                ->orWhere('email', 'LIKE', "%{$v}%");
        }

        $admins = $admins->orderBy('id', 'DESC')->paginate(20);

        return AdminResource::collection($admins);
    }

    public function store(Request $request): JsonResource
    {
        $auth_user = auth()->user();
        if (!$auth_user->isSuperAdmin()) {
            throw new HttpException(403, 'You are not allowed to create admins.');
        }

        $validated = $request->validate([
            'first_name'     => 'required|max:32',
            'last_name'      => 'required|max:32',
            'gender'         => 'required|integer|in:1,2',
            'phone'          => 'required|numeric|digits:10|unique:admins',
            'email'          => 'required|email|unique:admins|max:64',
            'password'       => 'required|min:8|max:30',
            'role'           => 'required|integer|in:1,2,3,4',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['status'] = Admin::STATUS_ACTIVE;
        $validated['photo'] = env('DEFAULT_IMG');

        $admin = Admin::create($validated);

        return new AdminResource($admin);
    }

    public function update(Request $request, int $id): JsonResource
    {
        $auth_user = auth()->user();
        if (!$auth_user->isSuperAdmin()) {
            throw new HttpException(403, 'You are not allowed to update admins.');
        }

        $validated = $request->validate([
            'first_name'     => 'required|max:32',
            'last_name'      => 'required|max:32',
            'gender'         => 'required|integer|in:1,2',
            'phone'          => 'required|numeric|digits:10|unique:admins,phone,'.$id,
            'email'          => 'required|email|max:64|unique:admins,email,'.$id,
            'role'           => 'required|integer|in:1,2,3,4',
        ]);

        $admin = Admin::find($id);
        if (is_null($admin)) {
            throw new NotFoundResourceException("The admin with ID '$id' does not exist.");
        }

        $validated['photo'] = $admin->photo;

        $admin->update($validated);

        return new AdminResource($admin);
    }

    public function upload(Request $request, int $id): JsonResource
    {
        $auth_user = auth()->user();
        if (!$auth_user->isSuperAdmin() && $auth_user->id !== $id) {
            throw new HttpException(403, 'You are not allowed to upload admins image.');
        }

        $validated = $request->validate([
            'photo'     => 'nullable|file|mimes:jpeg,png,jpg|max:1024',
        ]);

        $admin = Admin::find($id);
        if (is_null($admin)) {
            throw new NotFoundResourceException("The admin with ID '$id' does not exist.");
        }

        $old_image = $admin->photo;
        $validated['photo'] =  $old_image;

        if ($file = $request->file('photo')) {
            $name = time().Str::random(16).'.jpg';
            $file->move('uploads', $name);
            $validated['photo'] = env('ASSETS_CDN') . $name;
        }

        $admin->update($validated);

        if (!is_null($old_image) && $request->hasFile('photo')) {
            $file_name = strrchr($old_image, "/");
            if ($file_name !== false) {
                $image_path = public_path('uploads'.$file_name);
                unlink($image_path);
            }
        }

        return new AdminResource($admin);
    }

    public function show(int $id): JsonResource
    {
        $auth_user = auth()->user();
        if (!$auth_user->isSuperAdmin()) {
            throw new HttpException(403, 'You are not allowed to see admins details.');
        }

        $admin = Admin::find($id);
        if (is_null($admin)) {
            throw new NotFoundResourceException("The admin with ID '$id' does not exist.");
        }

        $articles = $admin->articles()->with('category')->orderBy('id', 'desc')->paginate(20);

        $result = [
            "admin"     => $admin,
            "articles"  => $articles
        ];

        return new AdminResource($result);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            "email" => ["required", "email"],
            "password" => ["required", "max:32"],
        ]);

        if (Auth::attempt($credentials) === false) {
            throw ValidationException::withMessages([
                "email" => ["Invalid email or password."]
            ]);
        }

        $admin = Admin::where('email', $request->email)->first();

        // if (is_null($admin) || !Hash::check($request->password, $admin->password)) {
        //     throw ValidationException::withMessages([
        //         "email" => ["Invalid email or password."]
        //     ]);
        // }


        // $token = $admin->createToken('admin-token');

        return [
            "admin" => $admin,
            // "token" => $token->plainTextToken,
        ];
    }

    public function logout(Request $request)
    {
        // @TODO @DANGEROUS @FIXME Delete admin token
        // $admin = $request->admin();
        // $admin->tokens()->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return [
            "status" => "success",
        ];
    }

    public function profile(Request $request): JsonResource
    {
        $admin = Auth::user();
        
        return new AdminResource($admin);
    }

    public function resetPassword(Request $request, Admin $admin)
    {
        $auth_user = auth()->user();

        if (!$auth_user->isSuperAdmin()) {
            throw new HttpException(403, "You are not allowed to reset password");
        }

        // @TODO Later we will send default password on Admin Email
        $admin->update([
            "password" => Hash::make(env('DEFAULT_PASSWORD'))
        ]);

        return new AdminResource($admin);
    }

    public function updateStatus(Request $request, Admin $admin)
    {
        $auth_user = auth()->user();

        if (!$auth_user->isSuperAdmin()) {
            throw new HttpException(403, "You are not allowed to update status");
        }

        $validated = $request->validate([
            'status'   => 'required|integer|in:2,3',
        ]);

        $admin->update($validated);

        return new AdminResource($admin);
    }

    public function updatePassword(Request $request): JsonResource
    {
        $user = auth()->user();
        $validated = $request->validate([
            'current_password'  => 'required',
            'new_password'      => 'required|string|min:8|max:32|different:current_password',
            'confirm_password'  => 'required|string|same:new_password',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['The provided current password is incorrect.'],
            ]);
        }

        $validated['password'] = Hash::make($request->new_password);
        $user->update($validated);

        return new AdminResource($user);
    }

    public function updateProfile(Request $request): JsonResource
    {
        $user = auth()->user();
        $id = $user->id;
        $validated = $request->validate([
            'first_name'     => 'required|max:32|regex:/^[A-Za-z ]+$/',
            'last_name'      => 'required|max:32|regex:/^[A-Za-z ]+$/',
            'phone'          => 'required|numeric|unique:admins,phone,'.$id,
            'email'          => 'required|email|max:64|unique:admins,email,'.$id,
        ]);
        $validated['email'] = strtolower($validated['email']);

        $user->update($validated);

        return new AdminResource($user);
    }
}
