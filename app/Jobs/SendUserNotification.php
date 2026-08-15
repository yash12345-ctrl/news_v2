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

        $notification = Notification::fromArray([
            'title' => $title,
            'message'  => $message,
        ]);

        $topic = env('FIREBASE_FCM_TOPIC');
        $notification = Notification::create($title, $message);
        $message = CloudMessage::withTarget('topic', $topic)
                    ->withNotification($notification)
                    ->withAndroidConfig(\Kreait\Firebase\Messaging\AndroidConfig::fromArray([
                        'notification' => [
                            'channel_id' => 'article_event_channel',
                        ],
                    ]));

        try {
            $ret = $messaging->send($message);
        } catch (\Exception $e) {
            Log::error('FCM: '. $e->getMessage());
        }
    }
}
