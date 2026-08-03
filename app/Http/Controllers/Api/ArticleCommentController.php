<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\ArticleComment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\ArticleCommentResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class ArticleCommentController extends Controller
{
    //
    public function index(): JsonResource
    {
        $article_comments = ArticleComment::orderBy('id', 'DESC')->paginate(50);

        return ArticleCommentResource::collection($article_comments);
    }

    public function store(Request $request): JsonResource
    {

        $validated = $request->validate([
            'comment'       => 'required',
            'article_id'    => 'required|integer',
            'first_name'    => 'required|max:32',
            'email'         => 'required|email|max:64',
        ]);

        $user = null;
        if (Auth::check()) {
            $user = Auth::user();
        } else {
            $user = User::where('email', '=', $validated['email'])->first();
        }

        if (is_null($user)) {
            $validated['gender'] = 1;
            $validated['dob'] = null;
            $validated['age'] = null;
            $validated['phone'] = null;
            $validated['password'] = Hash::make(env('DEFAULT_PASSWORD'));

            $user = User::create($validated);
        }

        $validated['user_id'] = $user->id;
        $validated['created_at'] =  date('Y-m-d H:i:s');
        
        $comment = ArticleComment::create($validated);

        return new ArticleCommentResource($comment);
    }

    public function show(int $id): JsonResource
    {
        $comment = ArticleComment::find($id);
        if (is_null($comment)) {
            throw new NotFoundResourceException("The comment with ID '$id' does not exist.");
        }

         return new ArticleCommentResource($comment);
    }

    public function destroy(int $id): JsonResource
    {
        $comment = ArticleComment::find($id);
        if (is_null($comment)) {
            throw new NotFoundResourceException("The comment with ID '$id' does not exist.");
        }

       $comment->delete();
       return new ArticleCommentResource($comment);

    }

    public function update(Request $request, int $id): JsonResource
    {
        $validated = $request->validate([
            'comment'      => 'required',
            'article_id'   => 'required|integer|exists:articles,id',
        ]);

        $comment = ArticleComment::find($id);
        if (is_null($comment)) {
            throw new NotFoundResourceException("The comment with ID '$id' does not exist.");
        }

        $comment->update($validated);

        return new ArticleCommentResource($comment);
    }
}
