<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidYouTubeUrl implements Rule
{
    public function passes($attribute, $value)
    {
        // Define patterns for YouTube URLs
        $pattern1 = "/^https:\/\/www\.youtube\.com\/watch\?v=(.+)/";
        $pattern2 = "/^https:\/\/youtu.be\/(.+)\?*(.*)$/";

        // Check if the URL matches either of the patterns
        return preg_match($pattern1, $value) || preg_match($pattern2, $value);
    }

    public function message()
    {
        return 'The :attribute must be a valid YouTube URL.';
    }
}