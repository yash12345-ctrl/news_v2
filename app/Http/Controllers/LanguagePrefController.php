<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguagePrefController extends Controller
{
    public function __invoke(Request $request, string $lang)
    {
        $pref_lang = 'ur';
        if ($lang == 'en') {
            $pref_lang = 'en';
        }

        // Set cookie
        return redirect()->back()->withCookie(cookie('lang_pref', $pref_lang, $minutes = 60 * 24 * 365));
    }
}
