<?php declare(strict_types=1);

namespace App\TTS;

use Illuminate\Support\Facades\Storage;

/**
 * TTSSpeech - Text To Speech
 */
class TTSSpeech
{
	protected $audio_bytes;

	public function __construct(string $audio_bytes)
	{
		$this->audio_bytes = $audio_bytes;
	}

	public function getSpeechBytes(): string
	{
		return $this->audio_bytes;
	}

	public function saveFile(string $filename): bool
	{
		Storage::disk('public')->put($filename, $this->audio_bytes);
		return true;
	}
}