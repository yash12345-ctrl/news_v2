<?php

namespace App\Http\Controllers;

use App\Models\ArticleVote;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    //
    public function store(Request $request)
    {
        $validated = $request->validate([
            'vote_type'     => 'required|integer|in:1,2,3,4',
            'article_id'    => 'required|integer',
        ]);

        // @TODO Decide how voting will work for users who are not logged in
        $validated['user_id'] = 1;
        $validated['created_at'] = date('Y-m-d H:i:s');

        $vote = ArticleVote::where('article_id', '=', $validated['article_id'])
                                ->where('user_id', '=', $validated['user_id'])
                                ->first();

        if (is_null($vote)) {
            $vote = ArticleVote::create($validated);
            return redirect()->back()->with('vote_message', 'Vote submitted successfully');
        } else if ($validated['vote_type'] != $vote->vote_type) {
            $vote->update($validated);
            return redirect()->back()->with('vote_message', 'Your vote updated successfully');
        }

        return redirect()->back()->with('vote_message', 'You have already submitted the vote');
    }
}
