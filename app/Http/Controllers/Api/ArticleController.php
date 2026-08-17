<?php

namespace App\Http\Controllers\Api;

use App\TTS\TTS;
use App\TTS\OpenAI;
use App\Models\Admin;
use App\Models\Article;
use App\Models\Category;
use App\TTS\ElevenlabsTTS;
use App\Models\ArticleVote;
use App\Models\ArticleInteraction;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Rules\ValidYouTubeUrl;
use App\Support\VideoUrlTrait;
use App\Jobs\OptimizeArticleImage;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Support\ControllerHelperTrait;
use App\Http\Resources\ArticleResource;
use App\Jobs\ArticlePublishedNotification;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class ArticleController extends Controller
{
    use VideoUrlTrait;
    use ControllerHelperTrait;

    public function index(Request $request): JsonResource
    {
        $lang = Article::BOTH;

        if (lang_urdu()) {
            $lang = Article::URDU;
        }

        if (lang_english()) {
            $lang = Article::HINDUSTANI;
        }

         $validated = $request->validate([
                'from_date'     => 'nullable|date',
                'to_date'       => 'nullable|date',
                'category_id'   => 'nullable|exists:categories,id',
                'todays'        => 'nullable|min:1',
                'search'        => 'nullable|max:255',
                'status'        => 'nullable|in:1,2,3',
                'flag'          => 'nullable|in:1,2',
            ]);

        $query = Article::query();

        if (request('from_date')) {
            $query->where('created_at', '>=', $validated['from_date'] . ' 00:00:00');
        }

        if (request('to_date')) {
            $query->where('created_at', '<=', $validated['to_date'] . ' 23:59:59');
        }

        if (request('category_id')) {
            $query->where('category_id', '=', $validated['category_id']);
        }

        if (request('todays')) {
            $query->whereBetween('created_at', [now()->startOfDay(), now()->endOfDay()]);
        }

        if (request('flag')) {
            $query->where('flag', '=', $validated['flag']);
        }

        if (request('search')) {
            $query->where('title_en', 'like', '%' .$validated['search'] . '%')
                        ->orWhere('title_ur', 'like', '%' . $validated['search'] . '%');
        }

        // @NOTE(mukhtar): Only admin is allowed to filter by status.
        // It's a security loop hole. Previously user can see the unpublished article.
        if (request('status') && Auth::check() && (auth()->user() instanceof Admin)) {
            $query->where('status', '=', $validated['status']);
        }

        // @NOTE(mukhtar): If Not logged in (i.e. User) or logged in but the user is not admin
        // only then apply language prefrence query.
        if (!Auth::check() || !(auth()->user() instanceof Admin)) {
            $query->where(function($query) use ($lang) {
                $query->where('visible_in', $lang)
                    ->orWhere('visible_in', Article::BOTH);
            })
            ->where('status', Article::PUBLISHED);
        }

        $articles = $query->with('category')
            ->select('id', 'title_en', 'title_ur', 'slug', 'category_id', 'status', 'created_at', 'visible_in', 'flag', 'image_url', 'image_sm_url', 'views', 'source', 'video_url', 'admin_id')
            ->orderBy('id', 'DESC')
            ->paginate(20);

        return ArticleResource::collection($articles);
    }

    public function store(Request $request): JsonResource
    {
        $auth_user = auth()->user();
        if (!$auth_user->isSuperAdmin() && !$auth_user->isEditor()) {
            throw new HttpException(403, 'You are not allowed to create article.');
        }

        $validated = $request->validate([
            'title_en'          => 'nullable|max:255',
            'title_ur'          => 'required|max:255',
            'content_short_en'  => 'nullable|max:256',
            'content_short_ur'  => 'nullable|max:256',
            'content_en'        => 'nullable',
            'content_ur'        => 'required',
            'category_id'       => 'required|exists:categories,id',
            'article_url'       => 'nullable|url',
            'source'            => 'required|max:255',
            'visible_in'        => 'required|integer|in:1,2,3',
            'video_url'         => ['nullable', 'url', new ValidYouTubeUrl],
        ]);


        $slugSource = !empty($validated['title_en']) ? $validated['title_en'] : 'article-' . time();
        $validated['slug'] = $this->createSlug($slugSource);
        $validated['admin_id'] =  $auth_user->id;
        $validated['published_at'] =  date("Y-m-d H:i:s");
        $validated['image_url'] = $validated['image_sm_url'] = env('DEFAULT_IMG_URL');

        // Prevent MySQL NOT NULL constraint violations
        $validated['title_en'] = $validated['title_en'] ?? '';
        $validated['content_en'] = $validated['content_en'] ?? '';
        $validated['content_short_en'] = $validated['content_short_en'] ?? '';

        if (!request('article_url')) {
            $validated['article_url'] = env('APP_URL') . '/articles/' . $validated['slug'];
        }

        $articles = Article::create($validated);

        return new ArticleResource($articles);
    }

    protected function createSlug(string $title): string
    {

        $slug = Str::slug($title);
        $slugsFound = Article::getSlugs($slug);
        $counter = 0;
        $counter += $slugsFound;

        if ($counter) {
            $slug = $slug . '-' . $counter;
        }
        return $slug;
    }


    public function show(int $id)
    {
        $article = Article::find($id);
        $result = null;
        $category = null;
        if (is_null($article)) {
            throw new NotFoundResourceException("The article with ID '$id' does not exist.");
        }

        if (Auth::check()) {
            $result = ArticleVote::voteStat($id);
        }

        $category = $article->category()->first();
        $comments = $article->articleComments()->get();
        return [
            "article" => $article,
            "result" => $result,
            "category" => $category,
            "comments" => $comments,
        ];
    }

    public function getCommentByArticleId(int $id): JsonResource
    {
        $article = Article::find($id);
        if (is_null($article)) {
            throw new NotFoundResourceException("The article with ID '$id' does not exist.");
        }

        $comments = $article->articleComments()->orderBy('id', 'DESC')->paginate(20);

        return new ArticleResource($comments);
    }

    public function update(Request $request, int $id): JsonResource
    {
        $auth_user = auth()->user();
        if (!$auth_user->isSuperAdmin() && !$auth_user->isEditor()) {
            throw new HttpException(403, 'You are not allowed to update article.');
        }

        $validated = $request->validate([
            'title_en'          => 'nullable|max:255',
            'title_ur'          => 'required|max:255',
            'content_short_en'  => 'nullable|max:256',
            'content_short_ur'  => 'nullable|max:256',
            'content_en'        => 'nullable',
            'content_ur'        => 'required',
            'category_id'       => 'required|numeric|exists:categories,id',
            'source'            => 'required|max:255',
            'visible_in'        => 'required|integer|in:1,2,3',
            'video_url'         => ['nullable', 'url', new ValidYouTubeUrl],
            'status'            => 'nullable|integer|in:1,2,3',
        ]);

        $article = Article::find($id);
        if (is_null($article)) {
            throw new NotFoundResourceException("The article with ID '$id' does not exist.");
        }

        if ($auth_user->isEditor() && $auth_user->id !== $article->admin_id) {
            throw ValidationException::withMessages([
                'error' => ["Article with ID '{$article->id}' does not belong to you"],
            ]);
        }

        // Prevent MySQL NOT NULL constraint violations
        $validated['title_en'] = $validated['title_en'] ?? '';
        $validated['content_en'] = $validated['content_en'] ?? '';
        $validated['content_short_en'] = $validated['content_short_en'] ?? '';
        
        $old_status = $article->status;

        $article->update($validated);
        
        if (isset($validated['status']) && $validated['status'] == Article::PUBLISHED && $old_status != Article::PUBLISHED) {
            ArticlePublishedNotification::dispatchSync($article);
        }

        return new ArticleResource($article);
    }

    public function statusUpdate(Request $request, int $id): JsonResource
    {
        \Illuminate\Support\Facades\Log::info("statusUpdate hit for article {$id} with data: " . json_encode($request->all()));
        
        $auth_user = auth()->user();
        if (!$auth_user->isSuperAdmin() && !$auth_user->isEditor()) {
            throw new HttpException(403, 'You are not allowed to update status of article.');
        }

        $validated = $request->validate([
            'status'   => 'required|integer|in:2,3',
        ]);

        $article = Article::find($id);
        if (is_null($article)) {
            throw new NotFoundResourceException("The article with ID '$id' does not exist.");
        }

        if ($auth_user->isEditor() && $auth_user->id !== $article->admin_id) {
            throw ValidationException::withMessages([
                'error' => ["Article with ID '{$article->id}' does not belong to you"],
            ]);
        }

        if ($validated['status'] == Article::PUBLISHED) {
            $validated['published_at'] = date('Y-m-d H:i:s');
        }

        $article->update($validated);

        if ($validated['status'] == Article::PUBLISHED) {
            ArticlePublishedNotification::dispatchSync($article);
        }
        return new ArticleResource($article);
    }

    public function trendingArticles(Request $request): JsonResource
    {
        $lang = Article::BOTH;

        if (lang_urdu()) {
            $lang = Article::URDU;
        }

        if (lang_english()) {
            $lang = Article::HINDUSTANI;
        }

        $articles = Article::trendingArticles(10, $lang);
        if (request('category_id')) {
            $articles->where('category_id', '=', $request->query('category_id'));
        }

        $articles = $articles->paginate(20);

        return ArticleResource::collection($articles);
    }

    public function relatedArticles(int $id): JsonResource
    {
        $lang = Article::BOTH;

        if (lang_urdu()) {
            $lang = Article::URDU;
        }

        if (lang_english()) {
            $lang = Article::HINDUSTANI;
        }

       $article = Article::find($id);
    
        if (is_null($article)) {
            throw new NotFoundResourceException("The article with ID '$id' does not exist.");
        }

        $articles = Article::relatedArticles($article->category_id, $lang);
        return ArticleResource::collection($articles);
    }

    public function upload(Request $request, int $id): JsonResource
    {
        $auth_user = auth()->user();
        if (!$auth_user->isSuperAdmin() && !$auth_user->isEditor()) {
            throw new HttpException(403, 'You are not allowed to upload article image.');
        }

        $validated = $request->validate([
            'photo'     => 'nullable|file|mimes:jpeg,png,jpg|max:1024',
        ]);

        $article = Article::find($id);
        if (is_null($article)) {
            throw new NotFoundResourceException("The article with ID '$id' does not exist.");
        }

        if ($auth_user->isEditor() && $auth_user->id !== $article->admin_id) {
            throw ValidationException::withMessages([
                'error' => ["Article with ID '{$article->id}' does not belong to you"],
            ]);
        }

        $image_url = $article->image_url;
        $image_sm_url = $article->image_sm_url;

        if ($file = $request->file('photo')) {
            $name = time().Str::random(16).'.'.$file->extension();
            $file->move('uploads', $name);
            OptimizeArticleImage::dispatch($name, $article, $image_url, $image_sm_url);
            $validated["image_url"] = env('ASSETS_CDN') . $name;
            $validated["image_sm_url"] = env('ASSETS_CDN') . $name;
        }

        $article->update($validated);

        return new ArticleResource($article);
    }


    public function popularArticles(Request $request): JsonResource
    {
        $lang = Article::BOTH;

        if (lang_urdu()) {
            $lang = Article::URDU;
        }

        if (lang_english()) {
            $lang = Article::HINDUSTANI;
        }

        $articles = Article::popularArticles(10, $lang);
        if (request('category_id')) {
            $articles->where('category_id', '=', $request->query('category_id'));
        }

        $articles = $articles->paginate(20);

        return ArticleResource::collection($articles);
    }

    public function flag(Request $request, int $id): JsonResource
    {
        $auth_user = auth()->user();
        if (!$auth_user->isSuperAdmin() && !$auth_user->isEditor()) {
            throw new HttpException(403, 'You are not allowed to update flags.');
        }

        $validated = $request->validate([
            'flag'         => 'required|integer|in:1,2',
        ]);

        $article = Article::find($id);
    
        if (is_null($article)) {
            throw new NotFoundResourceException("The article with ID '$id' does not exist.");
        }

        if ($auth_user->isEditor() && $auth_user->id !== $article->admin_id) {
            throw ValidationException::withMessages([
                'error' => ["Article with ID '{$article->id}' does not belong to you"],
            ]);
        }

        // Clear flag if already set
        if ($article->hasFlag()) {
            $validated['flag'] = 0;
        }

        if ($validated['flag'] == Article::MAIN) {
            $validated['flag'] = Article::MAIN;
            $last_main_article = Article::findLastMainArticle($article->visible_in)->first();

            if (!is_null($last_main_article)) {
                if ($last_main_article->hasFlag()) {
                    $validate_update['flag'] = 0;
                }
                $last_main_article->update($validate_update);
            }
        }

        if ($validated['flag'] == Article::POPULAR) {
            $validated['flag'] = Article::POPULAR;
        }

        $article->update($validated);

        return new ArticleResource($article);
    }

    public function addFlag(Request $request, int $id): JsonResource
    {
        $auth_user = auth()->user();
        if (!$auth_user->isSuperAdmin() && !$auth_user->isEditor()) {
            throw new HttpException(403, 'You are not allowed to add flags.');
        }

        $validated = $request->validate([
            'flag'         => 'required|integer|in:1,2',
        ]);

        $article = Article::find($id);
    
        if (is_null($article)) {
            throw new NotFoundResourceException("The article with ID '$id' does not exist.");
        }

        if ($auth_user->isEditor() && $auth_user->id !== $article->admin_id) {
            throw ValidationException::withMessages([
                'error' => ["Article with ID '{$article->id}' does not belong to you"],
            ]);
        }

        if ($validated['flag'] == Article::MAIN) {
            $validated['flag'] = Article::MAIN;
            $last_main_article = Article::findLastMainArticle($article->visible_in)->first();

            if (!is_null($last_main_article)) {
                $validate_update['flag'] = Article::NOFLAG;
                $last_main_article->update($validate_update);
            }
        }

        if ($validated['flag'] == Article::POPULAR) {
            $validated['flag'] = Article::POPULAR;
        }

        $article->update($validated);

        return new ArticleResource($article);
    }

    public function removeFlag(Request $request, int $id): JsonResource
    {
        $article = Article::find($id);
    
        if (is_null($article)) {
            throw new NotFoundResourceException("The article with ID '$id' does not exist.");
        }

        $validated['flag'] = Article::NOFLAG;
        
        $article->update($validated);

        return new ArticleResource($article);
    }

    public function textToSpeech(Request $request, int $id)
    {
        $article = Article::find($id);
        if (is_null($article)) {
            throw new NotFoundResourceException("The article with ID '$id' does not exist.");
        }

        $device = $request->query('device', 'unknown');
        Log::channel('tts_requests')->info('TTS request received', [
            'article_id' => $id,
            'device'     => $device,
            'ip'         => request()->ip(),
        ]);

        if (lang_urdu()) {
            $text = $article->content_short_ur;
            if ($device == 'web') {
                $text = $article->content_ur;
            }
            $lang = Article::URDU;
        }

        if (lang_english()) {
            $text = $article->content_short_en;
            if ($device == 'web') {
                $text = $article->content_en;
            }
            $lang = Article::HINDUSTANI;
        }

        if (Article::BOTH != $article->visible_in && $article->visible_in != $lang) {
            return null;
        }

        $elevenlabs = new ElevenlabsTTS(api_key: env("ELEVENLABS_APIKEY"));
        $tts = new TTS($elevenlabs);
        $speech = $tts->remember($id)->textToSpeech($text);



        // @NOTE Best would be to use article slug for file name.
        // Saves the file in storage/app/
        $filename = $article->slug . ".mp3";
        $speech->saveFile($filename);

        // http://localhost:8000/storage/test2.mp3
        $url = asset('storage/' . $filename);

        return response()->json([
            "url" => $url
        ]);
    }
    
    public function translateText(Request $request)
    {
        $keysStr = env('GROQ_API_KEYS') ?: env('GROQ_API_KEY');
        $allKeys = array_filter(array_map('trim', explode(',', $keysStr)));
        // Use only the first 2 API keys for the Admin Portal
        $apiKeys = array_slice($allKeys, 0, 2);
        
        if (empty($apiKeys)) {
            return response()->json(['error' => 'No API keys configured'], 500);
        }

        $title = $request->input('title', '');
        $content = $request->input('content', '');
        $content_short = $request->input('content_short', '');

        $prompt = "You are a professional journalist translator. You MUST translate the following Urdu text into proper, grammatically correct ENGLISH language.\n\nCRITICAL RULE: Do NOT use Roman Urdu or Hinglish. Your output must be 100% English words (e.g., use 'Tonight the moon will be directly above the Kaaba' instead of 'Aaj raat moon Kaaba ke directly upar hoga').\n\nReturn ONLY a valid JSON object with the keys: 'title', 'content', and 'content_short'. No other text.\n\nTitle:\n" . $title . "\n\nShort Content:\n" . $content_short . "\n\nMain Content:\n" . $content;

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

            if (!$response->successful()) { \Illuminate\Support\Facades\Log::error("Groq API Failed: " . $response->body()); }
            if ($response->successful()) {
                $data = $response->json();
                $content = $data['choices'][0]['message']['content'] ?? '';
                
                // Log the raw response so we can see what the model is outputting
                \Illuminate\Support\Facades\Log::info("Groq Raw Response: " . $content);
                
                // Strip markdown code blocks if the model wrapped the JSON
                $content = preg_replace('/```json\s*(.*?)\s*```/is', '$1', $content);
                $content = preg_replace('/```\s*(.*?)\s*```/is', '$1', $content);
                
                $decoded = json_decode(trim($content), true);
                if ($decoded) {
                    return response()->json($decoded);
                } else {
                    \Illuminate\Support\Facades\Log::error("Groq JSON Decode Failed! Cleaned content: " . $content);
                }
            }
        }

        return response()->json(['error' => 'Translation failed'], 500);
    }

    public function trackInteraction(Request $request, $id)
    {
        $uuid = $request->header('X-Device-ID') ?: $request->input('uuid');
        if (!$uuid) {
            return response()->json(['error' => 'Device ID is required'], 400);
        }

        $article = Article::find($id);
        if (!$article) {
            return response()->json(['error' => 'Article not found'], 404);
        }

        $userId = Auth::check() ? Auth::id() : null;

        // Prevent spam tracking
        $recent = ArticleInteraction::where('uuid', $uuid)
            ->where('article_id', $id)
            ->where('created_at', '>=', now()->subHours(1))
            ->first();

        if (!$recent) {
            ArticleInteraction::create([
                'uuid' => $uuid,
                'user_id' => $userId,
                'article_id' => $id,
                'category_id' => $article->category_id,
            ]);
        }

        return response()->json(['message' => 'Interaction tracked successfully']);
    }

    public function myFeed(Request $request): JsonResource
    {
        $uuid = $request->header('X-Device-ID') ?: $request->input('uuid');
        
        $lang = Article::BOTH;
        if (lang_urdu()) $lang = Article::URDU;
        if (lang_english()) $lang = Article::HINDUSTANI;

        $query = Article::query()->where('status', Article::PUBLISHED)
            ->whereIn('visible_in', [$lang, Article::BOTH]);

        if ($uuid) {
            // Find top 3 categories the user interacted with
            $topCategoryIds = ArticleInteraction::where('uuid', $uuid)
                ->selectRaw('category_id, count(*) as count')
                ->groupBy('category_id')
                ->orderByDesc('count')
                ->limit(3)
                ->pluck('category_id')
                ->toArray();

            if (!empty($topCategoryIds)) {
                $ids = implode(',', $topCategoryIds);
                $query->orderByRaw("CASE WHEN category_id IN ({$ids}) THEN 1 ELSE 2 END ASC");
            }
        }

        $articles = $query->latest('published_at')->paginate(20);

        return ArticleResource::collection($articles);
    }
}
