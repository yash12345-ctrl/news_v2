<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminAppController extends Controller
{
    public function index(Request $request)
    {
        return view('AdminApp.index');
    }
}
