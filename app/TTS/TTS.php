<?php declare(strict_types=1);

namespace App\TTS;

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

	public function remember(string|int $id): self
	{
		$this->remember_value = $id;

		return $this;
	}

	public function textToSpeech(string $text, ?string $voice_id = null): TTSSpeech
	{
		// It may throw exeception.
		// Caller needs to handle this exception.
		$response = $this->tts_service->textToSpeech($text, $voice_id);

		return new TTSSpeech($response);
	}
}