<?php

namespace App\Http\Controllers\Api;

use App\Models\Poll;
use App\Models\PollVote;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PollResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class PollVoteController extends Controller
{
    //
    public function store(Request $request, int $id): JsonResource
    {
        $validated = $request->validate([
            'vote'         => 'required|integer|in:1,2',
        ]);

        $poll = Poll::find($id);
        if (is_null($poll)) {
            throw new NotFoundResourceException("The poll with ID '$id' does not exist.");
        }

        $validated['poll_id'] =  $id;
        $validated['user_id'] =  auth()->user()->id;
        $poll_vote = PollVote::create($validated);

        $accumulate = [];
        if ($poll->pollVotes) {
            $poll->pollVotes->map(function($vote) use (&$accumulate) {
                if (isset($accumulate[$vote->vote])) {
                    $accumulate[$vote->vote]++;
                } else {
                    $accumulate[$vote->vote] = 1;
                }
            });
        }

        $poll = [
            "id"            => $poll->id,
            "title"         => $poll->title,
            "description"   => $poll->description,
            "question"      => $poll->question,
            "media_url"     => $poll->media_url,
            "media_kind"    => $poll->media_kind,
            "status"        => $poll->status,
            "published_at"  => $poll->published_at,
            "created_at"    => $poll->created_at,
            "updated_at"    => $poll->updated_at,
            "votes"         => $accumulate,
        ];

        return new PollResource($poll);
    }
}
