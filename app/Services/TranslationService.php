<?php

namespace App\Services;

use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Support\Facades\Log;

class TranslationService
{
    public function urduToRomanHindustani(string $data)
    {
        $error = false;
        $output = "";
        try {
            $prompt = "Translate the following Urdu article news NATURAL ROMAN HINDUSTANI.
            Rules:
            - Roman English letters only
            - Keep meaning exactly same
            - No quotes
            - No new lines
            - No offensive words
            - Use neutral and respectful wording
            - Rewrite in formal Indian news reporting tone
            - Slightly restructure sentence for clarity while preserving exact meaning
            - Do not perform direct word-by-word transliteration
            - If ANY word cannot be translated properly
            - If ANY non-Roman character appears
            - If there is ANY uncertainty or formatting issue
            - Then return exactly this single word only: ERROR <ERROR REASON>

            Text: {$data}
            ";

            $response = OpenAI::responses()->create([
                'model' => env('CHATGPT_MODEL'),
                'input' => $prompt,
            ]);

            $output = $response->outputText;
            if (substr($output, 0, 5) === 'ERROR' || empty($output)) {                
                Log::error('Urdu to Roman translation failed', [
                    'input' => $data ?? null,
                ]);
                $error = true;
                $output = substr($output, 6);
            }
        } catch (\Exception $e) {
            Log::error('Urdu to Roman translation failed', [
                'message' => $e->getMessage(),
                'input' => $data ?? null,
            ]);
            $error = true;
            $output = "Failed to translate.";
        }

        if ($error) {
            throw new \Exception($output);
        }

        return $output;
    }
}