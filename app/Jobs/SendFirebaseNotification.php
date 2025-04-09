<?php

namespace App\Jobs;

use App\Models\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification as FirebaseNotification;

class SendFirebaseNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $deviceToken;
    protected $title;
    protected $body;
    protected $data;

    public function __construct($deviceToken, $title, $body, $data = [])
    {
        $this->deviceToken = $deviceToken;
        $this->title = $title;
        $this->body = $body;
        $this->data = $data;
    }

    public function handle(): void
    {
        if (!isset($this->data['notification_sent'])) {
            $firebase = (new Factory)
                ->withServiceAccount(base_path('./config/firebase_credentials.json'))
                ->createMessaging();

            $message = CloudMessage::withTarget('token', $this->deviceToken)
                ->withNotification(FirebaseNotification::create($this->title, $this->body))
                ->withData($this->data);

            $firebase->send($message);

            // ضع علامة أنه تم الإرسال
            $this->data['notification_sent'] = true;

            // حفظ الإشعار في قاعدة البيانات
            Notification::create([
                'user_id' => $this->data['sender_id'],
                'recipient_id' => $this->data['recipient_id'],
                'title' => $this->title,
                'body' => $this->body,
                'data' => json_encode($this->data),
            ]);
        }
    }
}
