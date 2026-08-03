<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VisitorAnalytic;
use Illuminate\Support\Facades\Auth;

class VisitorAnalyticController extends Controller
{
    public function store(Request $request)
    {
        $data = [
            "uuid"      => "",
            "user_id"   => null, // Anonymous
            "state"     => "",
            "ip_address" => "",
            "source"    => VisitorAnalytic::SOURCE_WEB,
            "last_visited_at" => date("Y-m-d H:i:s"),
        ];

        if (Auth::check()) {
            $data["user_id"] = Auth::id();
        }

        if ($v = $request->input("visitor_state")) {
            $data["state"] = $v;
        }

        if ($v = $request->input("visitor_ip")) {
            $data["ip_address"] = $v;
        }

        if ($v = $request->header('X-Source') || $v = $request->input('visitor_source')) {
            if ($v == 'web') {
                $data["source"] = VisitorAnalytic::SOURCE_WEB;
            } elseif ($v == 'android') {
                $data["source"] = VisitorAnalytic::SOURCE_ANDROID;
            } elseif ($v == 'ios') {
                $data["source"] = VisitorAnalytic::SOURCE_IOS;
            }
        }

        $uuid = $request->cookie('visitor_uuid');
        if (!$uuid) {
            $uuid = $request->header('X-Visitor-UUID');
        }

        // @NOTE(muktar): Don't write condition like this.
        // if ($uuid = $request->cookie('visitor_uuid') || $uuid = $request->header('X-Visitor-UUID')) {
        if ($uuid) {
            // We will handle only existing visitor here.
            $data["uuid"] = $uuid;
            $visitor = VisitorAnalytic::findByUuid($uuid);
            if ($visitor) {
                $data["last_visited_at"] = date("Y-m-d H:i:s");
                $visitor->update($data);
            }
        }

        return response()->json(['status' => 'ok']);
    }
}
