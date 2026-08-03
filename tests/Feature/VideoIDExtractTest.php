<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Article;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VideoIDExtractTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_video_url_type_1(): void
    {
        $a = new Article();

        $a->video_url = "https://www.youtube.com/watch?v=2WpEMXlqljE";
        $this->assertEquals("2WpEMXlqljE", $a->extractVideoId($a->video_url));
    }

    public function test_video_url_type_2(): void
    {
        $a = new Article();


        $a->video_url = "https://youtu.be/_bPCjIWeVKY";
        $this->assertEquals("_bPCjIWeVKY", $a->extractVideoId($a->video_url));
    }
    
    public function test_video_url_type_3(): void
    {
        $a = new Article();


        $a->video_url = "https://youtu.be/_bPCjIWeVKY?si=2qlsc5Qrtdjg3DDI";
        $this->assertEquals("_bPCjIWeVKY", $a->extractVideoId($a->video_url));
    }
}
