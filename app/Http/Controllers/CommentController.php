<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\ArticleComment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CommentController extends Controller
{
    //
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name'   => 'required|max:32',
            'email'        => 'required|email|max:64',
            'comment'      => 'required',
            'article_id'   => 'required|integer|exists:articles,id',
        ]);

        $user = null;
        if (Auth::check()) {
            $user = Auth::user();
        } else {
            $user = User::where('email', '=', $validated['email'])->first();
        }

        if (is_null($user)) {
            $validated['last_name'] = "";
            $validated['gender'] = 1;
            $validated['dob'] = null;
            $validated['age'] = null;
            $validated['phone'] = null;
            $validated['password'] = Hash::make(env('DEFAULT_PASSWORD'));

            $user = User::create($validated);
        }

        $validated['user_id'] = $user->id;
        $validated['created_at'] = date("Y-m-d H:i:s");

        $comment = ArticleComment::create($validated);
        return redirect()->back()->with('message', 'Your comment will be posted successfully');
    }
}
