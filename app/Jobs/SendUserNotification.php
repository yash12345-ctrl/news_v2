<?php

namespace App\Jobs;

use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Laravel\Firebase\Facades\Firebase;

class SendUserNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $data;
    /**
     * Create a new job instance.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $defaultAuth = Firebase::auth();
        $messaging = Firebase::messaging();

        $title = $this->data['title'];
        $message = $this->data['message'];

        $topic = env('FIREBASE_FCM_TOPIC');
        $message = CloudMessage::withTarget('topic', $topic)
                    ->withData([
                        'title' => $title,
                        'message' => $message,
                    ])
                    ->withAndroidConfig(\Kreait\Firebase\Messaging\AndroidConfig::fromArray([
                        // Data-only message configuration
                    ]));

        try {
            $ret = $messaging->send($message);
        } catch (\Exception $e) {
            Log::error('FCM: '. $e->getMessage());
        }
    }
}
