<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Quiz\Exam;
use App\Promotion\Promotion;
use Illuminate\Http\Request;
use App\Support\HomePageArticle;

class HomeController extends Controller
{
    //
    public function index(Request $request)
    {
        $categories = Category::all()->take(10);
        $data = HomePageArticle::generate($request);
        $promotion = $this->getPromotionData();

        return view("Home.index", [
            "categories" => $categories,
            "data" => $data,
            "promotion" => $promotion
        ]);
    }

    protected function getPromotionData()
    {
        return Promotion::activePromotion()->first();
    }
}
