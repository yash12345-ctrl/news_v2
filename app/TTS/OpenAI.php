<?php declare(strict_types=1);

namespace App\TTS;

use App\TTS\TTSSpeech;
use Illuminate\Support\Facades\Http;
use App\TTS\Interfaces\TTSGeneratorInterface;

/**
 * OpenAI
 */
class OpenAI implements TTSGeneratorInterface
{
	protected $api_key;
	protected $model = "gpt-4o-mini-tts";
	protected $voice = "coral";
	protected $base_url = "https://api.openai.com";

	public function __construct(string $api_key, ?string $model = null)
	{
		$this->api_key = $api_key;
		$this->model = $model ?? $this->model;
	}

	public function textToSpeech(string $text, ?string $voice = null)
	{
		$voice = $voice ?? $this->voice;
		$api_url = "{$this->base_url}/v1/audio/speech";

		$response = Http::withToken($this->api_key)
			->withHeaders([
				'Content-Type' 	=> 'application/json',
			])->post($api_url, [
				'model' 		=> $this->model,
				'input' 		=> $text,
				'voice' 		=> $this->voice,
				'instruction' 	=> "Speek in urdu accent carefully espcially speeking urdu words that match english word.",
			]);

		if ($response->failed()) {
			throw new \Exception("{$response->status()}: {$response->reason()}");
		}

		return $response->body();
	}
}