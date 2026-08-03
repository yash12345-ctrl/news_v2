<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\TrendingVideo;
use Illuminate\Http\Request;

class TrendingVideoController extends Controller
{
    public function index()
    {
        $categories = Category::paginate(8);
        $trending_articles = Article::trendingArticles(10)->get();
        $past_popular_articles = Article::pastPopularArticle(Article::BOTH);
        $videos = TrendingVideo::where('status', 1)->orderBy('id', 'desc')->get();
        
        return view("TrendingVideo.index", [
            'categories' => $categories,
            'trending_articles' => $trending_articles,
            'past_popular_articles' => $past_popular_articles,
            'videos' => $videos
        ]);
    }
}
