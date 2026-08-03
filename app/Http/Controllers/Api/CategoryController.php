<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class CategoryController extends Controller
{
    public function index(): JsonResource
    {
        $categories = Category::query();

        if (request("from_date")) {
            $categories->where("created_at", ">=", date("Y-m-d", strtotime(request("from_date"))));
        }

        if (request("to_date")) {
            $categories->where("created_at", "<=", date("Y-m-d", strtotime(request("to_date"))));
        }

        if ($v = request("search")) {
            $categories->where('name_ur', 'LIKE', "%{$v}%");
        }

        $categories = $categories->orderBy('id', 'DESC')->paginate(20);

        return CategoryResource::collection($categories);
    }

    public function store(Request $request): JsonResource
    {
        $auth_user = auth()->user();
        if (!$auth_user->isSuperAdmin()) {
            throw new HttpException(403, 'You are not allowed to create category.');
        }

        $validated = $request->validate([
            'name_ur'           => 'required|max:64|unique:categories',
            'name_en'           => 'required|max:64|unique:categories',
            'description_en'    => 'nullable|max:512',
            'description_ur'    => 'nullable|max:512',
            'parent_id'         => 'nullable|integer|exists:categories,id',
        ]);

        $validated['image_url'] = env('DEFAULT_IMG_URL');

        $categories = Category::create($validated);

        return new CategoryResource($categories);
    }

    public function update(Request $request, int $id): JsonResource
    {
        $auth_user = auth()->user();
        if (!$auth_user->isSuperAdmin()) {
            throw new HttpException(403, 'You are not allowed to update category.');
        }

        $validated = $request->validate([
            'name_ur'           => 'required|max:64|unique:categories,name_ur,'.$id,
            'name_en'           => 'required|max:64|unique:categories,name_en,'.$id,
            'description_en'    => 'nullable|max:512',
            'description_ur'    => 'nullable|max:512',
            'parent_id'         => 'nullable|integer|exists:categories,id',
        ]);

        $category = Category::find($id);
        if (is_null($category)) {
            throw new NotFoundResourceException("The category with ID '$id' does not exist.");
        }

        $old_image = $category->image_url;
        $validated['image_url'] = $old_image;

        $category->update($validated);

        return new CategoryResource($category);
    }

    public function upload(Request $request, int $id): JsonResource
    {
        $auth_user = auth()->user();
        if (!$auth_user->isSuperAdmin()) {
            throw new HttpException(403, 'You are not allowed to upload category image.');
        }

        $validated = $request->validate([
            'photo'     => 'nullable|file|mimes:jpeg,png,jpg|max:1024',
        ]);

        $category = Category::find($id);
        if (is_null($category)) {
            throw new NotFoundResourceException("The category with ID '$id' does not exist.");
        }

        $old_image = $category->image_url;
        $validated['image_url'] = $old_image;

        if ($file = $request->file('photo')) {
            $name = time().Str::random(16).'.jpg';
            $file->move('uploads', $name);
            $validated['image_url'] = env('ASSETS_CDN') . $name;
        }

        $category->update($validated);

        if (!is_null($old_image) && $request->hasFile('photo')) {
            $file_name = strrchr($old_image, "/");
            if ($file_name !== false) {
                $image_path = public_path('uploads'.$file_name);
                unlink($image_path);
            }
        }

        return new CategoryResource($category);
    }

    public function show(int $id)
    {
        $category = Category::find($id);
        $articles = null;
        if (is_null($category)) {
            throw new NotFoundResourceException("The category with ID '$id' does not exist.");
        }

        $articles = $category->articles()->with('category')->orderBy('id', 'DESC')->paginate(20);

        $data = [
            "category" => $category,
            "articles" => $articles,
        ];

        return $data;
    }
}
