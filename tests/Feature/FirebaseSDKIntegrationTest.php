<?php

namespace Tests\Feature;

use Tests\TestCase;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Illuminate\Foundation\Testing\WithFaker;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FirebaseSDKIntegrationTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        // Return an instance of the Auth component for the default Firebase project
        $defaultAuth = Firebase::auth();
        $messaging = Firebase::messaging();
        $this->assertNotNull($defaultAuth);

        $title = 'My Notification Title';
        $body = 'My Notification Body';
        $imageUrl = 'https://placehold.co/400x200?text='.$title;

        $notification = Notification::fromArray([
            'title' => $title,
            'body'  => $body,
            'image' => $imageUrl,
        ]);

        $topic = 'latest_article';
        $token = 'd8zu-MRiTvGxr08uMWe4D7:APA91bE01b7p0mKYDf1VuT4kswUdMJh02MvyUlrZZrjFwooI0qoYHqo0ljOV0GZPzyYE2ju7xHPcqJLoeqAQ69YRDik8gch2O3xSFbWHTCm72s6I_lHWDIMlyuLRho6Nfp7rwD-Jnjf5';
        $notification = Notification::create($title, $body);
        $message = CloudMessage::withTarget('topic', $topic)
                    ->withNotification($notification);

        $ret = $messaging->send($message);

        dd($ret);
    }
}
