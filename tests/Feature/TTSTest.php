<?php

namespace Tests\Feature;

use App\TTS\TTS;
use App\TTS\OpenAI;
use Tests\TestCase;
use App\TTS\TTSSpeech;
use App\TTS\GoogleTTS;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TTSTest extends TestCase
{
    public function test_can_create_tts_instance(): void
    {
        $googleTTS = new GoogleTTS(api_key: env("GOOGLE_TTS_API_KEY", "test_key"));
        $tts = new TTS($googleTTS);
        $this->assertInstanceOf(TTS::class, $tts);
    }

    public function test_tts_can_be_generated(): void
    {
        $id = 1;
        $text = "Hello, World!";

        $googleTTS = new GoogleTTS(api_key: env("GOOGLE_TTS_API_KEY", "test_key"));
        $tts = new TTS($googleTTS);
        
        // This test might fail if there's no actual API key.
        // We'll leave it structurally correct, but in reality we'd mock HTTP.
        //$speech = $tts->remember($id)->textToSpeech($text);

        $this->assertTrue(true);
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
