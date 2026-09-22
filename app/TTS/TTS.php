<?php declare(strict_types=1);

namespace App\TTS;

use Illuminate\Support\Facades\Cache;
use App\TTS\Interfaces\TTSGeneratorInterface;

/**
 * TTS - Text To Speech
 */
class TTS
{
	protected $remember_value;
	private $tts_service;

	public function __construct(TTSGeneratorInterface $tts_service)
	{
		$this->tts_service = $tts_service;
	}

	/**
	 * Set a cache key identifier (e.g., article ID + voice) so that repeated
	 * calls for the same content skip the external API entirely.
	 */
	public function remember(string|int $id): self
	{
		$this->remember_value = $id;

		return $this;
	}

	public function textToSpeech(string $text, ?string $voice_id = null): TTSSpeech
	{
		if ($this->remember_value !== null) {
			$cacheKey = 'tts_audio_' . $this->remember_value . '_' . ($voice_id ?? 'default');

			$audioBytes = Cache::remember($cacheKey, now()->addDays(7), function () use ($text, $voice_id) {
				// Caller needs to handle this exception.
				return $this->tts_service->textToSpeech($text, $voice_id);
			});

			return new TTSSpeech($audioBytes);
		}

		// No caching — call API directly.
		// Caller needs to handle this exception.
		$response = $this->tts_service->textToSpeech($text, $voice_id);

		return new TTSSpeech($response);
	}
}