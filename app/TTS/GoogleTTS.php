<?php declare(strict_types=1);

namespace App\TTS;

use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\Http;
use App\TTS\Interfaces\TTSGeneratorInterface;

class GoogleTTS implements TTSGeneratorInterface
{
	private $api_key;
	private $baseEndpoint = "https://texttospeech.googleapis.com/v1/text:synthesize";

	public function __construct(string $api_key)
	{
		$this->api_key = $api_key;
	}

	public function textToSpeech(string $text, ?string $voice_id = null)
	{
        // Google TTS limits text to 5000 chars per request.
        // Chunk safely at 4500 chars, splitting on word boundaries.
        $maxLength = 4500;
        $chunks    = $this->chunkText($text, $maxLength);

        // Derive languageCode robustly from voice name (e.g. 'ur-IN-Standard-A' → 'ur-IN')
        $languageCode = implode('-', array_slice(explode('-', $voice_id ?? 'ur-IN-Standard-A'), 0, 2));
        $url = $this->baseEndpoint . '?key=' . $this->api_key;

        // Fire all chunk requests in parallel. Total wall-clock time = slowest chunk,
        // not the sum of all chunks. Each request retries up to 3× (200ms backoff)
        // on transient network errors or 5xx responses before failing.
        $responses = Http::pool(function (Pool $pool) use ($chunks, $voice_id, $languageCode, $url) {
            return array_map(
                fn ($chunk) => $pool
                    ->retry(3, 200)
                    ->timeout(30)
                    ->post($url, [
                        'input' => [
                            'text' => $chunk,
                        ],
                        'voice' => [
                            'languageCode' => $languageCode,
                            'name'         => $voice_id ?? 'ur-IN-Standard-A',
                        ],
                        'audioConfig' => [
                            'audioEncoding' => 'MP3',
                        ],
                    ]),
                $chunks
            );
        });

        // Collect decoded audio parts in order, then join once (avoids repeated
        // string reallocation that .= causes on every iteration).
        $parts = [];
        foreach ($responses as $index => $response) {
            if ($response instanceof \Throwable) {
                throw new \Exception("Google TTS chunk {$index} failed with exception: " . $response->getMessage());
            }
            if ($response->failed()) {
                throw new \Exception("Google TTS chunk {$index} failed: {$response->status()} - {$response->body()}");
            }
            $data = $response->json();
            if (isset($data['audioContent'])) {
                $parts[] = base64_decode($data['audioContent']);
            }
        }

		return implode('', $parts);
	}

    private function chunkText(string $text, int $maxLength): array
    {
        if (mb_strlen($text) <= $maxLength) {
            return [$text];
        }

        $chunks = [];
        while (mb_strlen($text) > 0) {
            if (mb_strlen($text) <= $maxLength) {
                $chunks[] = $text;
                break;
            }

            // Find the last space within the max length to avoid splitting words
            $chunk = mb_substr($text, 0, $maxLength);
            $lastSpace = mb_strrpos($chunk, ' ');

            if ($lastSpace !== false) {
                $chunk = mb_substr($text, 0, $lastSpace);
                $text = trim(mb_substr($text, $lastSpace));
            } else {
                $chunk = mb_substr($text, 0, $maxLength);
                $text = mb_substr($text, $maxLength);
            }
            $chunks[] = $chunk;
        }

        return $chunks;
    }
}
