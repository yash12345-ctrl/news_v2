<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuizAppController extends Controller
{
    public function host(Request $request)
    {
        return view('QuizApp.host');
    }

    public function player(Request $request)
    {
        return view('QuizApp.player');
    }
}
