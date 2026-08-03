<?php

namespace App\Http\Controllers\Api;

use App\Models\ENewsPaper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EditionController extends Controller
{
    //
    public function index()
    {
        $editions = ENewsPaper::edition();
        
        return $editions;
    }
}
