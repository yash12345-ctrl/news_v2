<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class TermsController extends Controller
{
    //
    public function index()
    {
        $categories = Category::paginate(8);
        return view('Terms.index', [
            'categories' => $categories
        ]);
    }
}
