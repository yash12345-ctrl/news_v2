<?php
namespace App\Support;

use App\Models\Article;
use App\Models\Category;
use App\Models\DigitalAd;
use App\Models\Guldastah;
use App\Models\ENewsPaper;
use Illuminate\Http\Request;

class HomePageArticle {
    
    public static function generate(Request $request)
    {
        $lang = Article::BOTH;

        if (lang_urdu()) {
            $lang = Article::URDU;
        }

        if (lang_english()) {
            $lang = Article::HINDUSTANI;
        }

        // $top_categories = ['testdata', 'ab', 'et', 'quasi'];     // Top Categories id
        $top_categories = ['Kolkata', 'Bengal', 'National', 'International', 'Sports', 'Activities', 'Entertainment'];
        $top_categories_articles = [];
        $trending_articles = [];
        $latest_article = [];
        $past_popular_articles = [];
        $category_map = [];
        $popular_articles = [];
        $last_article = null;
        $enews_paper = null;
        $guldastah_pages = null;
        $random_ad = null;
        $items = 5;

        if (request('items')) {
            $items = $request->query('items');
        }

        $categories = Category::whereIn('name_en', $top_categories)->get();  
  
        // @TODO Optimize this query I don't like to hit db multiple times.
        foreach ($categories as $c) {
            $category_name = strtolower($c->name_en);
            $category_map[$category_name] = $c->id;
            $top_categories_articles[$category_name] = Article::where('category_id', $c->id)
                                                        ->where('status', Article::PUBLISHED)
                                                        ->where('visible_in', $lang)
                                                        ->orWhere('visible_in', Article::BOTH)
                                                        ->orderBy('views', 'DESC')
                                                        ->take($items)
                                                        ->get();
        }

        $trending_articles          = Article::trendingArticles(15, $lang)->get();
        $past_popular_articles      = Article::pastPopularArticle($lang);
        $last_article               = Article::mainArticles($lang)->first();
        $latest_article             = Article::latestArticles(12, $lang);
        $popular_articles           = Article::popularToday(10, $lang);
        $enews                      = ENewsPaper::lastEnews();
        $enews_paper_page           = $enews ? $enews->enewsPaperPage()->get() : collect();
        $first                      = $enews_paper_page->shift();
        $guldastah                  = Guldastah::lastGuldastah()->first();
        $digital_ads                = DigitalAd::latestAds(10)->get();

        $random_ad                  = null;

        if (count($digital_ads) > 0) {
            $other_ads = DigitalAd::RandomAd()->where('id', '!=', $digital_ads[0]->id)->get();
            if ($other_ads->count() > 0) {
                $random_ad = $other_ads->random();
            }
        }
        
        if (!is_null($guldastah)) {
            $guldastah_pages = $guldastah->guldastahPage()->get();
        }

        $result = [
            "top_categories_articles"   => $top_categories_articles,
            "popular_articles"          => $popular_articles,
            "trending_articles"         => $trending_articles,
            "last_article"              => $last_article,
            "latest_article"            => $latest_article,
            "past_popular_articles"     => $past_popular_articles,
            "enews"                     => $enews,
            "enews_paper_page"          => $enews_paper_page,
            "category_map"              => $category_map,
            "guldastah"                 => $guldastah,
            "guldastah_pages"           => $guldastah_pages,
            "digital_ads"               => $digital_ads,
            "random_ad"                 => $random_ad,
        ];

        return $result;
    }
}