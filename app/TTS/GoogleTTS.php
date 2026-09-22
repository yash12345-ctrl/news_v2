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

    private function chunkText(string $text, int $maxBytes): array
    {
        if (strlen($text) <= $maxBytes) {
            return [$text];
        }

        $chunks = [];
        while (strlen($text) > 0) {
            if (strlen($text) <= $maxBytes) {
                $chunks[] = $text;
                break;
            }

            // Cut safely by bytes up to maxBytes without splitting characters
            $chunk = mb_strcut($text, 0, $maxBytes, 'UTF-8');
            
            // Try to find the last space to avoid breaking words
            $lastSpace = mb_strrpos($chunk, ' ', 0, 'UTF-8');

            if ($lastSpace !== false && $lastSpace > 0) {
                // If we found a space, cut there using character position
                $chunk = mb_substr($chunk, 0, $lastSpace, 'UTF-8');
            }
            
            $chunks[] = $chunk;
            // Advance the text by the exact byte length of the finalized chunk
            $text = trim(substr($text, strlen($chunk)));
        }

        return $chunks;
    }
}
