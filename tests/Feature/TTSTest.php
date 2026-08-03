<?php

namespace Tests\Feature;

use App\TTS\TTS;
use App\TTS\OpenAI;
use Tests\TestCase;
use App\TTS\TTSSpeech;
use App\TTS\ElevenlabsTTS;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TTSTest extends TestCase
{
    public function test_can_create_tts_instance(): void
    {
        $elevenlabs = new ElevenlabsTTS(api_key: env("ELEVENLABS_APIKEY"));
        $tts = new TTS($elevenlabs);
        $this->assertInstanceOf(TTS::class, $tts);
    }

    public function test_tts_can_be_generated(): void
    {
        $id = 1;
        $text = "Hello, World!";

        $elevenlabs = new ElevenlabsTTS(api_key: env("ELEVENLABS_APIKEY"));
        $tts = new TTS($elevenlabs);
        $speech = $tts->remember($id)->textToSpeech($text);

        $this->assertInstanceOf(TTSSpeech::class, $speech);

        $audio_bytes = $speech->getSpeechBytes();
        $this->assertNotNull($audio_bytes);

        file_put_contents("/tmp/test.mp3", $audio_bytes);
    }

    public function _test_openai_can_generate_tts(): void
    {
        $id = 1;
        $text = "ایس آئی آر کی ڈرافٹ لسٹ شائع ہونے پر بدامنی کا خدشہ! پولیس پیشگی احتیاطی تدابیر اختیار کی";

        $openai = new OpenAI(api_key: env("OPENAI_APIKEY"));
        $tts = new TTS($openai);
        $speech = $tts->remember($id)->textToSpeech($text);

        $this->assertInstanceOf(TTSSpeech::class, $speech);

        $audio_bytes = $speech->getSpeechBytes();
        $this->assertNotNull($audio_bytes);

        // @NOTE Best would be to use article slug for file name.
        // Saves the file in storage/app/
        $speech->saveFile("test2.mp3");

        // http://localhost:8000/storage/test2.mp3
        // dump(asset('storage/test2.mp3'));

        // Or you can save it in your custom location
        // file_put_contents("/tmp/test.mp3", $audio_bytes);
    }
}
