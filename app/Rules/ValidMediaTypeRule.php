<?php

namespace App\Rules;

use Closure;
use App\Models\MediaResource;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidMediaTypeRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    protected $media_type;

    public function __construct($media_type)
    {
        $this->media_type = $media_type;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->media_type == MediaResource::MEDIA_TYPE_IMAGE) {
            if (is_null($value) || !method_exists($value, 'getMimeType') || !method_exists($value, 'getClientOriginalExtension')) {
                $fail('The media type is not a valid image.');
                return;
            }

            $mime_type = $value->getMimeType();
            if (!in_array($mime_type, ['image/jpeg', 'image/png', 'image/jpg']) ||
                !in_array($value->getClientOriginalExtension(), ['jpeg', 'png', 'jpg'])) {
                $fail('The media type is not a valid image.');
            }
            return;
        }

        if ($this->media_type == MediaResource::MEDIA_TYPE_AUDIO) {
            if (is_null($value) || !method_exists($value, 'getMimeType') || !method_exists($value, 'getClientOriginalExtension')) {
                $fail('The media type is not a valid audio file.');
                return;
            }

            $mime_type = $value->getMimeType();
            if (!in_array($mime_type, ['audio/mpeg', 'audio/wav']) ||
                !in_array($value->getClientOriginalExtension(), ['mp3', 'wav'])) {
                $fail('The media type is not a valid audio file.');
            }
            return;
        }

        if ($this->media_type == MediaResource::MEDIA_TYPE_VIDEO) {
            $pattern1 = "/^https:\/\/www\.youtube\.com\/watch\?v=(.+)/";
            $pattern2 = "/^https:\/\/youtu.be\/(.+)\?*(.*)$/";

            // Check if the URL matches either of the patterns
            if (!preg_match($pattern1, $value) && !preg_match($pattern2, $value)) {
                $fail('The media type must be a valid YouTube URL.');
            }
            return;
        }

        $fail('The media is not valid for the selected media type.');

    }

    public function message()
    {
        return 'The media is not valid for the selected media type.';
    }

}
