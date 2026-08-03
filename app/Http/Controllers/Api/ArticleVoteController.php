<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Article;
use App\Models\ArticleVote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleVoteResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class ArticleVoteController extends Controller
{
    //
    public static function voteStats(Request $request, int $id)
    {

        $result = ArticleVote::voteStat($id);
        return ArticleVoteResource::collection($result);
        
    }

    public function store(Request $request, int $id): JsonResource
    {
        
        $validated = $request->validate([
            'vote_type'     => 'required|integer|in:1,2,3,4',
            'article_id'    => 'required|integer',
            'first_name'    => 'required|max:32',
            'last_name'     => 'required|max:32',
            'email'         => 'required|email|max:64',
        ]);

        $user = null;
        if (Auth::check()) {
            $user = Auth::user();
        } else {
            $user = User::where('email', '=', $request->email)->first();
        }

        if (is_null($user)) {
            $validated['gender'] = 1;
            $validated['dob'] = null;
            $validated['age'] = null;
            $validated['phone'] = null;
            $validated['password'] = Hash::make(env('DEFAULT_PASSWORD'));

            $user = User::create($validated);
        }

        $vote = ArticleVote::where('article_id', '=', $id)
                                ->where('user_id', '=', $user->id)
                                ->first();

        $validated['user_id'] = $user->id;
        if (is_null($vote)) {
            $vote = ArticleVote::create($validated);
        } else if ($validated['vote_type'] != $vote->vote_type) {
           $vote->update($validated);
        }


        return new ArticleVoteResource($vote);
    }

}
