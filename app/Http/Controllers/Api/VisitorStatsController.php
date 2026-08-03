<?php

namespace App\Http\Controllers\Api;

use App\Models\VisitorSummary;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class VisitorStatsController extends Controller
{
    public function stats()
    {
        $user = auth()->user();

        if (!$user->isSuperAdmin()) {
            throw new HttpException(403, "You are not allow to view visitor stats");
        }
        $start = request('from_date');
        $end   = request('to_date');
        $range = request('range', '30days');
        $data = VisitorSummary::getVisitorStats($range, $start, $end);

        return $data;
    }
}