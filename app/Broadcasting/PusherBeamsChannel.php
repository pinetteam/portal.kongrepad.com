<?php

namespace App\Broadcasting;

use App\Service\Announcement\Beams;

class PusherBeamsChannel
{
    protected Beams $beams;

    public function __construct()
    {
        $this->beams = new Beams();
    }

    public function send($notifiable, $notification)
    {
        if (method_exists($notification, 'toPushNotification')) {
            $data = $notification->toPushNotification($notifiable);
            $interests = $data['interests'] ?? [$notifiable->routeNotificationFor('pusher_beams')];
            $title = $data['title'] ?? 'No announcements to publish';
            $body = $data['body'] ?? 'No announcements to publish';
            return $this->beams->sendNotification($interests, $title, $body);
        }
        throw new \Exception('Notification does not implement toPushNotification method.');
    }
}
