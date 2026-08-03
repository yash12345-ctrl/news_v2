<?php declare(strict_types=1);

namespace App\TTS\Interfaces;

interface TTSResponseInterface
{
	public function getSpeechBytes(): string;
	public function saveFile(string $filename): bool;
}