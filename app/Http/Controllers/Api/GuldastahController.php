<?php

namespace App\Http\Controllers\Api;

use App\Models\Admin;
use App\Models\Guldastah;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\GuldastahResource;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class GuldastahController extends Controller
{
    //
    public function index(Request $request): JsonResource
    {
        $auth_user = auth()->user();
        $guldastahs = Guldastah::query();

        if (request("from_date")) {
            $guldastahs->where("created_at", ">=", date("Y-m-d", strtotime(request("from_date"))));
        }

        if (request("to_date")) {
            $guldastahs->where("created_at", "<=", date("Y-m-d", strtotime(request("to_date"))));
        }

        if ($v = request("search")) {
            $guldastahs->where("title", "LIKE", "%{$v}%");
        }

        if ($auth_user && $auth_user->isSuperAdmin() && ($v = (int) request("status"))) {
            $guldastahs->where('status', $v);
        }

        // If no one logged-in or logged-in user is not admin then return only
        // published e-paper
        if (!(($auth = auth()) && ($auth->user() instanceof Admin))) {
            $guldastahs->where('status', Guldastah::PUBLISHED);
        }
        $guldastahs = $guldastahs->orderBy('id', 'DESC')->paginate(20);

        return GuldastahResource::collection($guldastahs);
    }

    public function store(Request $request): JsonResource
    {
        $auth_user = auth()->user();
        if (!$auth_user->isSuperAdmin() && !$auth_user->isEditor()) {
            throw new HttpException(403, 'You are not allowed to create guldastah.');
        }

        $validated = $request->validate([
            'title'         => 'required|max:128',
            'subtitle'      => 'nullable|max:256',
            'created_at'    => 'nullable|date|after_or_equal:today',
        ]);

        $validated['admin_id']  = $auth_user->id;
        $validated['image_url'] = env('DEFAULT_IMG_URL');
        $created_at = $updated_at = date('Y-m-d H:i:s');

        if (isset($validated['created_at'])) {
            $created_at = date("Y-m-d 00:00:00", strtotime($validated['created_at']));
        }

        $validated['created_at'] = $created_at;
        $validated['updated_at'] = $updated_at;

        $guldastah = Guldastah::create($validated);

        return new GuldastahResource($guldastah);
    }

    public function update(Request $request, int $id): JsonResource
    {
        $auth_user = auth()->user();
        if (!$auth_user->isSuperAdmin() && !$auth_user->isEditor()) {
            throw new HttpException(403, 'You are not allowed to update guldastah.');
        }

        $validated = $request->validate([
            'title'         => 'required|max:128',
            'subtitle'      => 'nullable|max:256',
            'created_at'    => 'nullable|date|after_or_equal:today',
        ]);

        $guldastah = Guldastah::find($id);
        if (is_null($guldastah)) {
            throw new NotFoundResourceException("The Guldastah with ID '$id' does not exist.");
        }

        if ($auth_user->isEditor() && $auth_user->id !== $guldastah->admin_id) {
            throw ValidationException::withMessages([
                'error' => ["Guldastah with ID '{$guldastah->id}' does not belong to you"],
            ]);
        }

        $old_image = $guldastah->image_url;
        $validated['image_url'] = $old_image;
        $validated['updated_at'] = date('Y-m-d H:i:s');
        if (isset($validated['created_at'])) {
            $validated['created_at'] = date("Y-m-d 00:00:00", strtotime($validated['created_at']));
        }

        $guldastah->update($validated);

        return new GuldastahResource($guldastah);
    }

    public function show($id): JsonResource
    {
        $guldastah = Guldastah::find($id);
        $guldastah_page = null;
        if (is_null($guldastah)) {
            throw new NotFoundResourceException("The Guldastah with ID '$id' does not exist.");
        }

        $guldastah_pages = $guldastah->guldastahPage()->get();

        $data = [
            'guldastah' => $guldastah,
            'guldastah_pages' => $guldastah_pages
        ];
        return GuldastahResource::collection($data);

    }

    public function statusUpdate(Request $request, int $id): JsonResource
    {
        $auth_user = auth()->user();
        if (!$auth_user->isSuperAdmin() && !$auth_user->isEditor()) {
            throw new HttpException(403, 'You are not allowed to update guldastah.');
        }

        $validated = $request->validate([
            'status'   => 'required|integer|in:2,3',
        ]);

        $guldastah = Guldastah::find($id);
        if (is_null($guldastah)) {
            throw new NotFoundResourceException("The guldastah with ID '$id' does not exist.");
        }

        if ($auth_user->isEditor() && $auth_user->id !== $guldastah->admin_id) {
            throw ValidationException::withMessages([
                'error' => ["Guldastah with ID '{$guldastah->id}' does not belong to you"],
            ]);
        }

        $guldastah->update($validated);
        return new GuldastahResource($guldastah);
    }
}
