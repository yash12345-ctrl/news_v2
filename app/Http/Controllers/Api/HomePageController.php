<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Support\HomePageArticle;
use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use Illuminate\Http\Resources\Json\JsonResource;

class HomePageController extends Controller
{
    //
    public function homePage(Request $request): JsonResource
    {
        $articles = HomePageArticle::generate($request);
        return ArticleResource::collection($articles);
    }
}
