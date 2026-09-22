<?php declare(strict_types=1);

namespace App\TTS;

use Illuminate\Support\Facades\Storage;
use App\TTS\Interfaces\TTSResponseInterface;

/**
 * TTSSpeech - Text To Speech
 */
class TTSSpeech implements TTSResponseInterface
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
		$path = public_path('storage/' . $filename);
		$dir  = dirname($path);
		if (!is_dir($dir)) {
			mkdir($dir, 0755, true);
		}
		file_put_contents($path, $this->audio_bytes);
		return true;
	}
}