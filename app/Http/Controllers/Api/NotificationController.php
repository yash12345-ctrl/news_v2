<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Jobs\SendUserNotification;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\Exception\HttpException;

class NotificationController extends Controller
{
    public function send(Request $request)
    {
        $auth_user = auth()->user();

        if (!$auth_user->isSuperAdmin()) {
            throw new HttpException(403, "You are not allowed to send notification to user");
        }

        $validated = $request->validate([
            "title" => "required|max:128|min:8",
            "message" => "required|max:256|min:8"
        ]);

        SendUserNotification::dispatch($validated);

        return [
            "data" => $validated
        ];
    }
}
