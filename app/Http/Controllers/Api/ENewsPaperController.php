<?php

namespace App\Http\Controllers\Api;

use App\Models\Admin;
use App\Models\ENewsPaper;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ENewsPaperResource;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class ENewsPaperController extends Controller
{
	public function index(Request $request): JsonResource
	{
        $auth_user = auth()->user();
        $enews_papers = ENewsPaper::query();

        if (request("from_date")) {
            $enews_papers->where("created_at", ">=", date("Y-m-d", strtotime(request("from_date"))));
        }

        if (request("to_date")) {
            $enews_papers->where("created_at", "<=", date("Y-m-d", strtotime(request("to_date"))));
        }

        if (request("edition")) {
            $enews_papers->where("edition", "=", (int) request("edition"));
        }

        if ($v = request("search")) {
            $enews_papers->where("title", "LIKE", "%{$v}%");
        }

        if ($auth_user && $auth_user->isSuperAdmin() && ($v = (int) request("status"))) {
            $enews_papers->where('status', $v);
        }

        // If no one logged-in or logged-in user is not admin then return only
        // published e-paper
        if (!(($auth = auth()) && ($auth->user() instanceof Admin))) {
            $enews_papers->where('status', ENewsPaper::PUBLISHED);
        }
        $enews_papers = $enews_papers->orderBy('id', 'DESC')->paginate(20);

		return ENewsPaperResource::collection($enews_papers);
	}

	public function store(Request $request): JsonResource
	{
        $auth_user = auth()->user();
        if (!$auth_user->isSuperAdmin() && !$auth_user->isEditor()) {
            throw new HttpException(403, 'You are not allowed to create E-News.');
        }

		$validated = $request->validate([
			'title'			=> 'required|max:128',
			'edition'       => 'required|integer',
			'subtitle'      => 'nullable|max:256',
			'description'   => 'nullable|max:512',
            'created_at'    => 'nullable|date|after_or_equal:today',
		]);

		$validated['slug'] = $this->createSlug($validated['title']);
		$validated['admin_id'] =  $auth_user->id;
        $validated['image_url'] =  env('DEFAULT_IMG_URL');
        $created_at = $updated_at = date('Y-m-d H:i:s');

         if (isset($validated['created_at'])) {
            $created_at = date("Y-m-d 00:00:00", strtotime($validated['created_at']));
        }

        $validated['created_at'] = $created_at;
        $validated['updated_at'] = $updated_at;
        

		$enews = ENewsPaper::create($validated);

		return new ENewsPaperResource($enews);
	}

	protected function createSlug(string $title): string
    {
        $slug = Str::slug($title);
        $slugsFound = ENewsPaper::getSlugs($slug);
        $counter = 0;
        $counter += $slugsFound;


        if ($counter) {
            $slug = $slug . '-' . $counter;
        }
        return $slug;
    }

    public function search(Request $request): JsonResource
    {
    	$validated = $request->validate([
			'search'	=> 'required|max:128',
		]);
    	$enews_papers = ENewsPaper::searchByTitle($validated['search']);

    	return ENewsPaperResource::collection($enews_papers);
    }

    public function show($id): JsonResource
    {
        $enews = ENewsPaper::with('editor')->find($id);
    	$enews_paper = null;
        if (is_null($enews)) {
            throw new NotFoundResourceException("The E-News Paper with ID '$id' does not exist.");
        }

        $enews_paper = $enews->enewsPaperPage()->get();

        $data = [
        	'enews' => $enews,
        	'enews_paper_pages' => $enews_paper
        ];
        return ENewsPaperResource::collection($data);

    }

    public function upload(Request $request, int $id): JsonResource
    {
        $auth_user = auth()->user();
        if (!$auth_user->isSuperAdmin() && !$auth_user->isEditor()) {
            throw new HttpException(403, 'You are not allowed to upload E-News image.');
        }

        $validated = $request->validate([
            'photo'     => 'nullable|file|mimes:jpeg,png,jpg|max:1024',
        ]);

        $enews = ENewsPaper::find($id);
        if (is_null($enews)) {
            throw new NotFoundResourceException("The E-News with ID '$id' does not exist.");
        }

        if ($auth_user->isEditor() && $auth_user->id !== $enews->admin_id) {
            throw ValidationException::withMessages([
                'error' => ["E-News with ID '{$enews->id}' does not belong to you"],
            ]);
        }

        $old_image = $enews->image_url;
        $validated['image_url'] = $old_image;

        if ($file = $request->file('photo')) {
            $name = time().Str::random(16).'.jpg';
            $file->move('uploads', $name);
            $validated['image_url'] = env('ASSETS_CDN') . $name;
        }

        $enews->update($validated);

        if (!is_null($old_image) && $request->hasFile('photo')) {
            $file_name = strrchr($old_image, "/");
            if ($file_name !== false) {
                $image_path = public_path('uploads'.$file_name);
                if (file_exists($image_path)) {
                    unlink($image_path);
                }
            }
        }

        return new ENewsPaperResource($enews);
    }

    public function update(Request $request, int $id): JsonResource
    {
        $auth_user = auth()->user();
        if (!$auth_user->isSuperAdmin() && !$auth_user->isEditor()) {
            throw new HttpException(403, 'You are not allowed to update E-News.');
        }

        $validated = $request->validate([
            'title'         => 'required|max:128',
            'edition'       => 'required|integer',
            'subtitle'      => 'nullable|max:256',
            'description'   => 'nullable|max:512',
            'created_at'    => 'nullable|date|after_or_equal:today',
        ]);

        $enews = ENewsPaper::find($id);
        if (is_null($enews)) {
            throw new NotFoundResourceException("The E-News with ID '$id' does not exist.");
        }

        if ($auth_user->isEditor() && $auth_user->id !== $enews->admin_id) {
            throw ValidationException::withMessages([
                'error' => ["E-News with ID '{$enews->id}' does not belong to you"],
            ]);
        }

        $old_image = $enews->image_url;
        $validated['image_url'] = $old_image;
        $validated['updated_at'] = date('Y-m-d H:i:s');
        if (isset($validated['created_at'])) {
            $validated['created_at'] = date("Y-m-d 00:00:00", strtotime($validated['created_at']));
        }

        $enews->update($validated);

        return new ENewsPaperResource($enews);
    }

    public function statusUpdate(Request $request, int $id): JsonResource
    {
        $auth_user = auth()->user();
        if (!$auth_user->isSuperAdmin() && !$auth_user->isEditor()) {
            throw new HttpException(403, 'You are not allowed to update status E-News.');
        }

        $validated = $request->validate([
            'status'   => 'required|integer|in:2,3',
        ]);

        $enews = ENewsPaper::find($id);
        if (is_null($enews)) {
            throw new NotFoundResourceException("The E-News with ID '$id' does not exist.");
        }

        if ($auth_user->isEditor() && $auth_user->id !== $enews->admin_id) {
            throw ValidationException::withMessages([
                'error' => ["E-News with ID '{$enews->id}' does not belong to you"],
            ]);
        }

        $enews->update($validated);
        return new ENewsPaperResource($enews);
    }
    
}
