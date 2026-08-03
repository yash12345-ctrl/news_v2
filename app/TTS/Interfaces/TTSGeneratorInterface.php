<?php declare(strict_types=1);

namespace App\TTS\Interfaces;

interface TTSGeneratorInterface
{
	public function textToSpeech(string $text, ?string $voice_id = null);
}