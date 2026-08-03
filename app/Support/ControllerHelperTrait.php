<?php

namespace App\Support;

use Illuminate\Support\Str;
use Illuminate\Http\Request;

trait ControllerHelperTrait
{
	public function _uploadImage($request, $model, $field_name, $column_name = "image_url")
    {
        $validated = $request->validate([
            $field_name     => 'required|file|mimes:jpeg,png,jpg|max:1024',
        ]);

        $old_image = $model[$column_name];
        $validated[$column_name] = $old_image;

        if ($file = $request->file($field_name)) {
            $name = time().Str::random(16).'.'.$file->extension();
            $file->move('uploads', $name);
            $validated[$column_name] = env('ASSETS_CDN') . $name;
        }

        $model->update($validated);

        if (!is_null($old_image) && $request->hasFile($field_name)) {
            $file_name = strrchr($old_image, "/");
            if ($file_name !== false && !strstr($file_name, "default-image.jpg")) {
                $image_path = public_path('uploads' . $file_name);
                if (file_exists($image_path)) {
                    unlink($image_path);
                }
            }
        }

        return $model;
    }

    function generateWebpFilenames(string $filename): array {
        $basename = pathinfo($filename, PATHINFO_FILENAME);
        $output_filename = $basename . '.webp';
        $sm_output_filename = $basename . '_sm.webp';

        return [
            'webp' => $output_filename,
            'webp_sm' => $sm_output_filename
        ];
    }

}