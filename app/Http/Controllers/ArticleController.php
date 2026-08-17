<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\DigitalAd;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $items = ($items = request('items')) ? $items : 10;
        $selected_category_id = (int) $request->category_id;
        $selected_category = null;
        $categories = Category::paginate(8);
        $articles = Article::latest('id')->with('category');
        $trending_articles = Article::trendingArticles($items)->get();
        $lang = Article::BOTH;

        if (lang_urdu()) {
            $lang = Article::URDU;
        }

        if (lang_english()) {
            $lang = Article::HINDUSTANI;
        }

        // Language preferred query.
        $articles->where(function($query) use ($lang) {
            $query->where('visible_in', $lang)
                ->orWhere('visible_in', Article::BOTH);
        });

        // Apply filter based on request params
        if (request('search')) {
            $search = $request->search;
            $articles->where(function($q) use ($search) {
                $q->where('title_ur', 'LIKE', "%{$search}%")
                  ->orWhere('title_en', 'LIKE', "%{$search}%")
                  ->orWhere('content_en', 'LIKE', "%{$search}%")
                  ->orWhere('content_ur', 'LIKE', "%{$search}%");
            });
        }

        if ($selected_category_id) {
            $selected_category = $categories->filter(function($category) use ($selected_category_id) {
                return (int) $category->id === $selected_category_id;
            })->first();
            $articles->where('category_id', $selected_category_id);
        }

        $articles->where('status', Article::PUBLISHED);
        $articles = $articles->paginate(15);

        return view('Article.index', [
            'categories'        => $categories,
            'selected_category' => $selected_category,
            'articles'          => $articles,
            'trending_articles' => $trending_articles,
        ]);
    }

    public function indexByCategory(Request $request, string $slug)
    {
        $items = ($items = request('items')) ? $items : 10;
        $categories = Category::paginate(8);
        $articles = Article::latest('id')->with('category');
        $trending_articles = Article::trendingArticles($items)->get();
        $lang = Article::BOTH;

        if (lang_urdu()) {
            $lang = Article::URDU;
        }

        if (lang_english()) {
            $lang = Article::HINDUSTANI;
        }

        // Language preferred query.
        $articles->where(function($query) use ($lang) {
            $query->where('visible_in', $lang)
                ->orWhere('visible_in', Article::BOTH);
        });

        // Apply filter based on request params
        if (request('search')) {
            $search = $request->search;
            $articles->where(function($q) use ($search) {
                $q->where('title_ur', 'LIKE', "%{$search}%")
                  ->orWhere('title_en', 'LIKE', "%{$search}%")
                  ->orWhere('content_en', 'LIKE', "%{$search}%")
                  ->orWhere('content_ur', 'LIKE', "%{$search}%");
            });
        }

        $selected_category = $categories->filter(function($category) use ($slug) {
            return strtolower($category->name_en) === $slug;
        })->first();
        if (is_null($selected_category)) {
            return abort(404);
        }
        $articles->where('category_id', $selected_category->id);

        $articles->where('status', Article::PUBLISHED);
        $articles = $articles->paginate(15);

        return view('Article.index', [
            'categories'        => $categories,
            'selected_category' => $selected_category,
            'articles'          => $articles,
            'trending_articles' => $trending_articles,
        ]);
    }

    public function show($slug)
    {
        $top_categories = ['Kolkata', 'Politics', 'Entertainment', 'Sports'];
        $digital_ad = null;
        $article = Article::where('slug', 'like', $slug.'%')->first();
        if (is_null($article)) {
            return redirect()->back();
        }

        $article->increment('views');
        $categories = Category::paginate(8);
        $category_id = $article->category_id;
        $article_comments = $article->articleComments()->get();
        $count_vote = $article->articleVotes()->count();
        $related_articles = Article::relatedArticles($category_id);
        $popular_articles = Article::articlesByCategoryId($category_id)->get();
        $digital_ads      = DigitalAd::latestAds()->get();
        if (count($digital_ads) > 0) {
            $digital_ad = $digital_ads->random();
        }

        $categories_top = Category::whereIn('name_en', $top_categories)->get();
        $category_map = [];
  
        foreach ($categories_top as $c) {
            $category_name = strtolower($c->name_en);
            $category_map[$category_name] = $c->id;
        }

        return view('Article.show', [
            'category_map'    => $category_map,
            'categories'        => $categories,
            'article'           => $article,
            'related_articles'  => $related_articles,
            'popular_articles'  => $popular_articles,
            'count_comment'     => $article_comments->count(),
            'count_vote'        => $count_vote,
            'article_comments'  => $article_comments,
            "digital_ad"        => $digital_ad,
        ]);
    }
    public function translate(Request $request, $id)
    {
        $article = Article::find($id);
        
        if ($article) {
            // Check if English content already exists in the database
            if (!empty(trim($article->title_en)) && !empty(trim($article->content_en))) {
                return response()->json([
                    'title' => $article->title_en,
                    'content' => $article->content_en
                ]);
            }

            $cacheKey = 'article_translation_' . $article->id;

            $translated = \Illuminate\Support\Facades\Cache::rememberForever($cacheKey, function () use ($article) {
                return $this->callTranslationApi($article->title, $article->content);
            });

            if ($translated) {
                return response()->json($translated);
            }
        }

        \Illuminate\Support\Facades\Log::error("Translation Controller: Failed to translate article. Translated is null. ID: " . $id);
        return response()->json(['error' => $article ? 'Translation failed or API key missing.' : 'Article not found'], $article ? 500 : 404);
    }

    private function callTranslationApi($title, $content)
    {
        $keysStr = env('GROQ_API_KEYS') ?: env('GROQ_API_KEY');
        $allKeys = array_filter(array_map('trim', explode(',', $keysStr)));
        // Use the remaining API keys (skip the first 2) for the public fallback
        $apiKeys = array_slice($allKeys, 2);
        
        \Illuminate\Support\Facades\Log::info("Translation Controller: Keys string: " . $keysStr . ", Remaining Keys Count: " . count($apiKeys));

        if (empty($apiKeys)) {
            return null;
        }

        $prompt = "You are a professional journalist translator. You MUST translate the following Urdu text into proper, grammatically correct ENGLISH language.\n\nCRITICAL RULE: Do NOT use Roman Urdu or Hinglish. Your output must be 100% English words (e.g., use 'Tonight the moon will be directly above the Kaaba' instead of 'Aaj raat moon Kaaba ke directly upar hoga').\n\nReturn ONLY a valid JSON object with exactly two keys: 'title' and 'content'. No other text.\n\nTitle:\n" . $title . "\n\nContent:\n" . $content;

        foreach ($apiKeys as $apiKey) {
            $response = \Illuminate\Support\Facades\Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ])->post('https://api.groq.com/openai/v1/chat/completions', [
                'model' => 'openai/gpt-oss-120b',
                'messages' => [
                    ['role' => 'system', 'content' => 'You are a professional translator that strictly returns valid JSON and translates Urdu to pure, formal English.'],
                    ['role' => 'user', 'content' => $prompt]
                ],
                'response_format' => ['type' => 'json_object'],
                'temperature' => 0.3,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $text = $data['choices'][0]['message']['content'] ?? '';
                
                \Illuminate\Support\Facades\Log::info("Translation Controller Raw Response: " . $text);
                
                $text = preg_replace('/```json\s*(.*?)\s*```/is', '$1', $text);
                $text = preg_replace('/```\s*(.*?)\s*```/is', '$1', $text);
                
                $decoded = json_decode(trim($text), true);
                if ($decoded) {
                    \Illuminate\Support\Facades\Log::info("Translation Controller: Success! Decoded JSON.");
                    return $decoded;
                } else {
                    \Illuminate\Support\Facades\Log::error("Translation Controller: JSON Decode Failed! Cleaned text: " . $text);
                }
            } else {
                \Illuminate\Support\Facades\Log::error("Translation Controller: HTTP Failed! Status: " . $response->status() . ", Body: " . $response->body());
            }
        }

        \Illuminate\Support\Facades\Log::error("Translation Controller: All keys failed or returned invalid JSON.");
        return null;
    }
}

