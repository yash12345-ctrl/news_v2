<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Webpatser\Uuid\Uuid;
use App\Models\DigitalAd;
use App\Models\Advertiser;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\DigitalAdsAnalytic;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\DigitalAdResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class DigitalAdController extends Controller
{
    //
    public function index(): JsonResource
    {
        $digital_ads = DigitalAd::query();

        if (request("from_date")) {
            $digital_ads->where("created_at", ">=", date("Y-m-d", strtotime(request("from_date"))));
        }

        if (request("to_date")) {
            $digital_ads->where("created_at", "<=", date("Y-m-d", strtotime(request("to_date"))));
        }

        if ($v = request("search")) {
            $digital_ads->where('title', 'LIKE', "%{$v}%");
        }

        if (request("status")) {
            $digital_ads->where("status", "=", (int) request("status"));
        }

        if (request("ad_kind")) {
            $digital_ads->where("ad_kind", "=", (int) request("ad_kind"));
        }

        if (request("media_kind")) {
            $digital_ads->where("media_kind", "=", (int) request("media_kind"));
        }

        $digital_ads = $digital_ads->orderBy('id', 'DESC')->paginate(20);

        return DigitalAdResource::collection($digital_ads);
    }

    public function store(Request $request): JsonResource
    {
        $auth_user = auth()->user();
        if (!$auth_user->isSuperAdmin()) {
            throw new HttpException(403, 'You are not allowed to create DigitalAd.');
        }

        $validated = $request->validate([
            'title'             => 'required|max:256',
            'description'       => 'nullable',
            'cta_url'           => 'required|max:256',
            'cta_text'          => 'nullable|max:256',
            'media_url'         => 'required_if:media_kind,2|max:256',
            'media_kind'        => 'required|integer|in:1,2',
            'ad_kind'           => 'nullable|integer|in:1,2,3,4,5',
            'ad_url'            => 'required|max:256',
            'advertiser_id'     => 'required|integer|exists:advertisers,id',
            'expires_at'        => 'required|date',
            'price'             => 'nullable|integer',
            'rejection_reason'  => 'nullable|max:1024',
            'status'            => 'nullable|integer|in:1,2,3,4,5'
        ]);

        if (isset($validated['status']) && $validated['status'] == DigitalAd::ACTIVE) {
            $activeCount = DigitalAd::whereDate('expires_at', '>=', date('Y-m-d')." 23:59:59")
                                    ->where('status', DigitalAd::ACTIVE)
                                    ->count();
            
            if ($activeCount >= 3) {
                throw new HttpException(400, 'You are not allowed to add this ad as Active. A maximum of 3 active ads are already running. If you want to activate this, first remove an active ad or wait for its deadline.');
            }
        }

        $validated['expires_at'] = date('Y-m-d 23:59:59', strtotime($validated['expires_at']));

        $validated['uuid'] = Uuid::generate()->string;
        if(request('media_kind') === 1) {
            $validated['media_url'] = env('DEFAULT_URL');
        }

        $validated['price'] = env('PRICE');
        $digital_ad = DigitalAd::create($validated);

        return new DigitalAdResource($digital_ad);
    }

    public function update(Request $request, int $id): JsonResource
    {
        $auth_user = auth()->user();
        if (!$auth_user->isSuperAdmin()) {
            throw new HttpException(403, 'You are not allowed to update DigitalAd.');
        }

        $validated = $request->validate([
            'title'             => 'required|max:256',
            'description'       => 'nullable',
            'cta_url'           => 'required|max:256',
            'cta_text'          => 'nullable|max:256',
            'media_url'         => 'required_if:media_kind,2|max:256',
            'media_kind'        => 'required|integer|in:1,2',
            'ad_kind'           => 'nullable|integer|in:1,2,3,4,5',
            'ad_url'            => 'required|max:256',
            'advertiser_id'     => 'required|integer|exists:advertisers,id',
            'expires_at'        => 'required|date',
            'price'             => 'required|integer',
            'rejection_reason'  => 'nullable|max:1024',
            'status'            => 'nullable|integer|in:1,2,3,4,5'
        ]);

        if (isset($validated['status']) && $validated['status'] == DigitalAd::ACTIVE) {
            $activeCount = DigitalAd::whereDate('expires_at', '>=', date('Y-m-d')." 23:59:59")
                                    ->where('status', DigitalAd::ACTIVE)
                                    ->where('id', '!=', $id)
                                    ->count();
            if ($activeCount >= 3) {
                throw new HttpException(400, 'You are not allowed to activate this ad. A maximum of 3 active ads are already running. If you want to activate this, first remove an active ad or wait for its deadline.');
            }
        }

        $digital_ad = DigitalAd::find($id);
        $old_media_kind = $digital_ad->media_kind;
        if (is_null($digital_ad)) {
            throw new NotFoundResourceException("The digital_ad with ID '$id' does not exist.");
        }

        $old_media = $digital_ad->media_url;
        if(request('media_kind') == 1) {
            $validated['media_url'] = $old_media;
        }

        $digital_ad->update($validated);

        return new DigitalAdResource($digital_ad);
    }

    public function upload(Request $request, int $id): JsonResource
    {
        $auth_user = auth()->user();
        if (!$auth_user->isSuperAdmin()) {
            throw new HttpException(403, 'You are not allowed to upload DigitalAd image.');
        }

        $validated = $request->validate([
            'photo'         => 'required|file|mimes:jpeg,png,jpg',
        ]);

        $digital_ad = DigitalAd::find($id);
        if (is_null($digital_ad)) {
            throw new NotFoundResourceException("The digital_ad with ID '$id' does not exist.");
        }
        $old_media_kind = $digital_ad->media_kind;

        $old_media = $digital_ad->media_url;
        $validated['media_url'] = $old_media;

        if ($file = $request->file('photo')) {
            $name = time().Str::random(16).'.jpg';
            $file->move('uploads', $name);
            $validated['media_url'] = env('ASSETS_CDN') . $name;
        }

        $digital_ad->update($validated);

         if (!is_null($old_media) && $request->hasFile('photo')) {
            $file_name = strrchr($old_media, "/");
            if ($file_name !== false && !strstr($file_name, "default-image.jpg")) {
                $image_path = public_path('uploads' . $file_name);
                if (file_exists($image_path)) {
                    unlink($image_path);
                }
            }
        }

        return new DigitalAdResource($digital_ad);
    }

    public function show(int $id): JsonResource
    {
        $auth_user = auth()->user();
        if (!$auth_user->isSuperAdmin()) {
            throw new HttpException(403, 'You are not allowed to see DigitalAd details.');
        }

        $digital_ad = DigitalAd::find($id);
        if (is_null($digital_ad)) {
            throw new NotFoundResourceException("The digital_ad with ID '$id' does not exist.");
        }

        $views = DigitalAdsAnalytic::countSeen($id)->count();
        $clicks = DigitalAdsAnalytic::countClicked($id)->count();

        $result = DB::select("select count(viewed=1) as views, count(clicked=1) as clicks, DATE(created_at) as created_at from (select * from digital_ads_analytics where digital_ad_id = '$id' ORDER BY created_at DESC LIMIT 30) as ads group by DATE(created_at)");

        $analytic = [
            "views" => $views,
            "clicks" => $clicks,
            "line_graph" => $result
        ];


        $data = [
            "digital_ad" => $digital_ad,
            "analytics"  => $analytic
        ];

        return new DigitalAdResource($data);

    }

    public function updateStatus(Request $request, int $id): JsonResource
    {
        $auth_user = auth()->user();
        if (!$auth_user->isSuperAdmin()) {
            throw new HttpException(403, 'You are not allowed to update status.');
        }

        $validated = $request->validate([
            'status' => 'required|integer|in:1,2,3,4,5'
        ]);

        $digital_ad = DigitalAd::find($id);
        if (is_null($digital_ad)) {
            throw new NotFoundResourceException("The digital_ad with ID '$id' does not exist.");
        }

        $digital_ad->update($validated);

        return new DigitalAdResource($digital_ad);
    }

    public function resume(Request $request, int $id): JsonResource
    {
        $auth_user = auth()->user();
        if (!$auth_user->isSuperAdmin()) {
            throw new HttpException(403, 'You are not allowed to resume.');
        }

        $digital_ad = DigitalAd::find($id);
        if (is_null($digital_ad)) {
            throw new NotFoundResourceException("The digital_ad with ID '$id' does not exist.");
        }

        if ($digital_ad->status === DigitalAd::PAUSED) {
            $validated['status'] =(int) DigitalAd::ACTIVE;
            $digital_ad->update($validated);
        }


        return new DigitalAdResource($digital_ad);
    }

    public function stats(Request $request, int $id)
    {
        if (Auth::check() && (auth()->user() instanceof User)) {
            abort(403);
        }

        $digital_ad = DigitalAd::find($id);
        if (is_null($digital_ad)) {
            throw new NotFoundResourceException("The digital_ad with ID '$id' does not exist.");
        }

        if (Auth::check() && (auth()->user() instanceof Advertiser)) {
            $click_count = DigitalAdsAnalytic::countClicked($id, auth()->user()->id)->count();
            $graph = DigitalAdsAnalytic::countClickedByDate($id, auth()->user()->id);
        }  else {
            $click_count = DigitalAdsAnalytic::countClicked($id)->count();
            $graph = DigitalAdsAnalytic::countClickedByDate($id);
        }

        $data = [
            "click_count" => $click_count,
            "graph" => $graph,
        ];

        return $data;
    }
}
