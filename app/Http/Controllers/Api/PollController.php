<?php

namespace App\Http\Controllers\Api;

use App\Models\Poll;
use App\Models\User;
use App\Models\PollAnswer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Resources\PollResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class PollController extends Controller
{
    public function index(): JsonResource
    {
        $polls = Poll::query();

        if (request("from_date")) {
            $polls->where("created_at", ">=", date("Y-m-d", strtotime(request("from_date"))));
        }

        if (request("to_date")) {
            $polls->where("created_at", "<=", date("Y-m-d", strtotime(request("to_date"))));
        }

        if ($v = request("search")) {
            $polls->where('title', 'LIKE', "%{$v}%");
        }

        if (request("status")) {
            $polls->where("status", "=", (int) request("status"));
        }

        if (Auth::check() && (auth()->user() instanceof User)) {
            $polls->where("status", "=", Poll::STATUS_PUBLISHED);
        }

        $polls = $polls->with('pollVotes')->orderBy('id', 'DESC')->paginate(20)->map(function($poll) {
            $accumulate = [];
            $poll->pollVotes ? $poll->pollVotes->map(function($vote) use (&$accumulate) {
                if (isset($accumulate[$vote->vote])) {
                    $accumulate[$vote->vote]++;
                } else {
                    $accumulate[$vote->vote] = 1;
                }
            }) : null;

            return [
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
        });

        return PollResource::collection($polls);
    }


    public function store(Request $request): JsonResource
    {
        $validated = $request->validate([
            'title'             => 'required|max:256',
            'description'       => 'required|max:1024',
            'question'          => 'required|max:256',
            'media_kind'        => 'required|integer|in:1,2',
            'media_url'         => 'required_if:media_kind,2|max:256',
            'status'            => 'nullable|integer|in:1,2,3',
            'answers'            => 'required|array'
        ]);

        if(request('media_kind') === Poll::MEDIA_IMAGE) {
            $validated['media_url'] = env('DEFAULT_IMG_URL');
        }
        $validated['published_at'] = date('Y-m-d H:i:s');

        $polls = Poll::create($validated);
        $data['poll_id'] = $polls->id;

        foreach ($validated['answers'] as $a) {
            $data['answer'] = $a;
              PollAnswer::create($data);
            }
        $answers = $polls->pollAnswers()->get();

        $result = [
            "polls" => $polls,
            "answers" => $answers
        ];

        return new PollResource($result);
    }

    public function upload(Request $request, int $id): JsonResource
    {
        $validated = $request->validate([
            'photo'         => 'required|file|mimes:jpeg,png,jpg'
        ]);

        $poll = Poll::find($id);
        if (is_null($poll)) {
            throw new NotFoundResourceException("The poll with ID '$id' does not exist.");
        }
        $old_media_kind = $poll->media_kind;

        $old_media = $poll->media_url;
        $validated['media_url'] = $old_media;

        if ($file = $request->file('photo')) {
            $name = time().Str::random(16).'.jpg';
            $file->move('uploads', $name);
            $validated['media_url'] = env('ASSETS_CDN') . $name;
        }

        $poll->update($validated);

        if (!is_null($old_media) && $request->hasFile('photo')) {
            $file_name = strrchr($old_media, "/");
            $image_path = public_path('uploads'.$file_name);
            if ($file_name !== false && file_exists($image_path)) {
                unlink($image_path);
            }
        }

        return new PollResource($poll);
    }

    public function update(Request $request, int $id): JsonResource
    {

        $validated = $request->validate([
            'title'             => 'required|max:256',
            'description'       => 'required|max:1024',
            'question'          => 'required|max:256',
            'media_kind'        => 'required|integer|in:1,2',
            'media_url'         => 'required_if:media_kind,2|max:256',
            'status'            => 'nullable|integer|in:1,2,3',
            'answers'           => 'required|array'
        ]);

        $poll = Poll::find($id);
        if (is_null($poll)) {
            throw new NotFoundResourceException("The poll with ID '$id' does not exist.");
        }
        $old_media_kind = $poll->media_kind;

        $old_media = $poll->media_url;
        if(request('media_kind') == Poll::MEDIA_IMAGE) {
            if ($old_media_kind != Poll::MEDIA_IMAGE || empty($old_media)) {
                $validated['media_url'] = env('DEFAULT_IMG_URL');
            } else {
                $validated['media_url'] = $old_media;
            }
        }

        $poll->update($validated);
        $poll->pollAnswers()->get()->each->delete();

        $data['poll_id'] = $poll->id;
        foreach ($validated['answers'] as $a) {
            $data['answer'] = $a;
              PollAnswer::create($data);
            }
        $answers = $poll->pollAnswers()->get();

        $image_path = public_path('uploads/'.$old_media);
        if (!is_null($old_media) && $old_media_kind != $validated['media_kind'] && file_exists($image_path)) {
            unlink($image_path);
        }

         $result = [
            "poll" => $poll,
            "answers" => $answers
        ];

        return new PollResource($result);
    }

    public function show($id): JsonResource
    {
        $poll = Poll::find($id);
        if (is_null($poll)) {
            throw new NotFoundResourceException("The poll with ID '$id' does not exist.");
        }

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

        $answers = $poll->pollAnswers()->get();

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
            "answers"       => $answers,
        ];

        return new PollResource($poll);
    }

    public function updateStatus(Request $request, int $id): JsonResource
    {
        $validated = $request->validate([
            'status' => 'required|integer|in:2,3'
        ]);

        $poll = poll::find($id);
        if (is_null($poll)) {
            throw new NotFoundResourceException("The poll with ID '$id' does not exist.");
        }

        $validated['published_at'] = date('Y-m-d H:i:s');

        $poll->update($validated);

        return new PollResource($poll);
    }
}