<?php

namespace App\Http\Controllers\Api;

use App\Models\DigitalAd;
use Illuminate\Http\Request;
use App\Models\DigitalAdsAnalytic;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\DigitalAdsAnalyticResource;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class DigitalAdsAnalyticController extends Controller
{
    //
    public function store(Request $request): JsonResource
    {
        $validated = $request->validate([
            'digital_ad_id'     => 'required|integer',
        ]);

        $digital_ad = DigitalAd::find($validated['digital_ad_id']);
        if (is_null($digital_ad)) {
            throw new NotFoundResourceException("The digital_ad does not exist.");
        }

        $validated['advertiser_id'] = $digital_ad->advertiser_id;
        $validated['user_id'] = Auth::check() ? Auth::user()->id : 1; // 1 is the ID of Anonymous user

        $analytic = DigitalAdsAnalytic::recordAnalytics($validated['digital_ad_id'], $validated['user_id'])->first();
        if ($analytic) {
            $validated['clicked'] = request('clicked') ? 1 : 0;
            $analytic->update($validated);
        } else {
            $validated['viewed'] = 1;
            $validated['clicked'] = request('clicked') ? 1 : 0;
            $validated['created_at'] = date('Y-m-d H:i:s');
            $analytic = DigitalAdsAnalytic::create($validated);
        }

        return new DigitalAdsAnalyticResource($analytic);
    }
}
