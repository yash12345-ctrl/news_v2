<?php declare(strict_types=1);

namespace App\TTS;

use Illuminate\Support\Facades\Http;
use App\TTS\Interfaces\TTSGeneratorInterface;

/**
 * ElevenlabsTTS
 */
class ElevenlabsTTS implements TTSGeneratorInterface
{
	public $model_id = "eleven_multilingual_v2";
	public $output_format = "mp3_44100_128";
	private $default_voice_id = "P1bg08DkjqiVEzOn76yG";
	private $baseEndpoint = "https://api.elevenlabs.io/v1/text-to-speech";
	private $api_key;

	public function __construct(string $api_key, ?string $model_id = null)
	{
		$this->api_key = $api_key;
		$this->model_id = $model_id ?? $this->model_id;
	}

	public function textToSpeech(string $text, ?string $voice_id = null)
	{
		$voice_id = $voice_id ?? $this->default_voice_id;
		$endpoint = $this->baseEndpoint . "/{$voice_id}?output_format={$this->output_format}";

		$response = Http::withHeaders([
			// 'Content-Type' 	=> 'application/json',
			'xi-api-key' 	=> $this->api_key,
			])->post($endpoint, [
				'text' 		=> $text,
				'model_id' 	=> $this->model_id,
			]);

		if ($response->failed()) {
			throw new \Exception("{$response->status()}: {$response->reason()}");
		}

		return $response->body();
	}
}