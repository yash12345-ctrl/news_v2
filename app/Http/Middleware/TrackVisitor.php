<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\VisitorAnalytic;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitor
{
    /**
     * Handle an incoming request.
     * @NOTE(muktar): We will handle the collecting of visitor analytics in two steps:
     *   1. Generate and store the UUID of new visitor
     *   2. Receive the POST request from frontend with all other information like IP, State, Source etc.
     *
     * In the middleware we should only record and track the visitor using UUID. Other details should be
     * separately POSTed to API endpoint '/visitor/analytics' with IP, State, Source etc.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $ip_address = $request->server('REMOTE_ADDR');
        $user_agent = $request->server('HTTP_USER_AGENT');

        // NOTE: If the detectedBrowser is BROWSER_OTHERS, we can directly store the
        // raw HTTP_USER_AGENT string from the request header to identify browser_other.
        $data = [
            "uuid"      => "",
            "user_id"   => null, // Anonymous
            "state"     => "",
            "ip_address" => $ip_address,
            "source"    => VisitorAnalytic::SOURCE_WEB,
            "device" => VisitorAnalytic::detectDeviceOS($user_agent),
            "browser" => VisitorAnalytic::detectBrowser($user_agent),
            "browser_other" => "",
            "last_visited_at" => "",
        ];

        $response = $next($request);

        if (Auth::check()) {
            $data["user_id"] = Auth::user()->id;
        }

        $uuid = $request->cookie('visitor_uuid');
        if (!$uuid) {
            $uuid = $request->header('X-Visitor-UUID');
        }

        // @NOTE(muktar): Don't write condition like this.
        // if ($uuid = $request->cookie('visitor_uuid') || $uuid = $request->header('X-Visitor-UUID')) {
        if ($uuid) {
            if ($visitor = VisitorAnalytic::findByUuid($uuid)) {
                $visitor->visit_count++;
                $visitor->last_visited_at = date("Y-m-d H:i:s");
                $visitor->update();
            }
        } else {
            $uuid = Str::uuid()->toString();
            $data["uuid"] = $uuid;
            $data["last_visited_at"] = date("Y-m-d H:i:s");
            $data["visit_count"] = 1;
            VisitorAnalytic::create($data);

            // Set cookie for new visitor
            $response = $response->withCookie(cookie('visitor_uuid', $uuid, 60 * 24 * 365));
        }

        return $response;
    }
}
