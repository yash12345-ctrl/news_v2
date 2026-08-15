<?php

namespace App\Jobs;

use App\Models\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class ArticlePublishedNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var int
     */
    public $tries = 3;

    private $article;

    /**
     * Create a new job instance.
     */
    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Return an instance of the Auth component for the default Firebase project
        $defaultAuth = Firebase::auth();
        $messaging = Firebase::messaging();

        $title = $this->article->title ?? $this->article->title_ur;
        $body = $this->article->content_short_ur ?? '';
        $image_url = $this->article->image_url ?? '';

        $topic = env('FIREBASE_FCM_TOPIC');
        $message = CloudMessage::withTarget('topic', $topic)
                    ->withNotification(\Kreait\Firebase\Messaging\Notification::create($title, $body, $image_url))
                    ->withData([
                        'title' => $title,
                        'body' => $body,
                        'image' => $image_url,
                    ])
                    ->withAndroidConfig(\Kreait\Firebase\Messaging\AndroidConfig::fromArray([
                        'priority' => 'high',
                    ]))
                    ->withApnsConfig(\Kreait\Firebase\Messaging\ApnsConfig::fromArray([
                        'headers' => [
                            'apns-priority' => '10',
                        ],
                        'payload' => [
                            'aps' => [
                                'content-available' => 1,
                            ],
                        ],
                    ]));

        try {
            $ret = $messaging->send($message);
            \Illuminate\Support\Facades\Log::info('FCM Send Success: ' . json_encode($ret));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('FCM Send Error: '. $e->getMessage());
        }

    }
}
