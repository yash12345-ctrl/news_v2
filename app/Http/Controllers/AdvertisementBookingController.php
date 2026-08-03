<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class AdvertisementBookingController extends Controller
{
    //
    public function index()
    {
        $categories = Category::paginate(8);
        return view('Advertisement.index', [
            'categories' => $categories
        ]);
    }
}
