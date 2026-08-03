<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use App\Support\ControllerHelperTrait;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Process;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class OptimizeArticleImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    use ControllerHelperTrait;

    /**
     * Create a new job instance.
     */
    private string $filename;
    private  $model;
    private  $old_image;
    private  $old_image_sm;

    public function __construct(string $filename, $model, $old_image, $old_image_sm)
    {
        $this->filename = $filename;
        $this->model = $model;
        $this->old_image = $old_image;
        $this->old_image_sm = $old_image_sm;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $upload_dir = public_path('uploads');
        ["webp" => $webp, "webp_sm" => $webp_sm] = $this->generateWebpFilenames($this->filename);
        Process::path($upload_dir)->run("convert {$this->filename} {$webp}");
        Process::path($upload_dir)->run("convert {$this->filename} -resize 200x  {$webp_sm}");
        $this->model->update([
            'image_url' => env('ASSETS_CDN') . $webp,
            'image_sm_url' => env('ASSETS_CDN') . $webp_sm
        ]);

        $org_image_path = public_path('uploads/'.$this->filename);
        if (file_exists($org_image_path)) {
            unlink($org_image_path);
        }

        $file_name = strrchr($this->old_image, "/");
        $image_path = public_path('uploads'.$file_name);
        if ($file_name !== false && file_exists($image_path)) {
            unlink($image_path);
        }

        $file_name_sm = strrchr($this->old_image_sm, "/");
        $image_path_sm = public_path('uploads'.$file_name_sm);
        if ($file_name_sm !== false && file_exists($image_path_sm)) {
            unlink($image_path_sm);
        }
    }
}
