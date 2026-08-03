<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$videos = App\Models\TrendingVideo::all();
foreach ($videos as $video) {
    if (strpos($video->video_url, 'localhost:8000') !== false) {
        $new_url = str_replace('http://localhost:8000', '', $video->video_url);
        $video->update(['video_url' => $new_url]);
        echo "Fixed video {$video->id}\n";
    }
}
