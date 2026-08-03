<?php

namespace App\Http\Controllers;

use App\Models\DigitalAd;
use Illuminate\Http\Request;
use App\Models\DigitalAdsAnalytic;

class AdsTrackController extends Controller
{
    public function store(Request $request, int $id)
    {
        $ad = DigitalAd::find($id);

        if (is_null($ad)) {
            return redirect()->back()->with('error', 'Ad not found'); 
        }

        $validated['advertiser_id'] = $ad->advertiser_id;
        $validated['digital_ad_id'] = $ad->id;
        $validated['created_at'] = date('Y-m-d H:i:s');

        $ad_track = DigitalAdsAnalytic::create($validated);

        if ($ad_track == false) {
            return redirect('/');
        }

        return redirect($ad->ad_url . "?utm_source=" .env('APP_NAME'));
    }
}
