<?php

namespace App\Support;

use Illuminate\Http\Request;

trait VideoUrlTrait
{
	
    public function extractVideoId($link)
    {
        // https://www.youtube.com/watch?v=_bPCjIWeVKY
        // https://youtu.be/_bPCjIWeVKY
        // https://youtu.be/_bPCjIWeVKY?si=2qlsc5Qrtdjg3DDI

        $matches = [];
        $pattern1 = "/^https:\/\/www\.youtube\.com\/watch\?v=(.+)/";
        $pattern2 = "/^https:\/\/youtu.be\/(.+)\?*(.*)$/";
        if (preg_match($pattern1, $link, $matches)) {
            return $matches[1];
        } else if (preg_match($pattern2, $link, $matches)) {
            return $matches[1];
        }

        return "";
    }

}