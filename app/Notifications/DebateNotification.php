<?php

namespace App\Notifications;

use NotificationChannels\PusherPushNotifications\PusherChannel;
use NotificationChannels\PusherPushNotifications\PusherMessage;
use Illuminate\Notifications\Notification;

class DebateNotification extends Notification
{
    public $hall;

    public function __construct($hall)
    {
        $this->hall = $hall;
    }
    public function via($notifiable)
    {
        return [PusherChannel::class];
    }

    public function toPushNotification($notifiable)
    {
        return PusherMessage::create()
            ->iOS()
            ->badge(1)
            ->sound('success')
            ->body("Debate oylaması başladı!")
            ->setOption('apns.data.hall_id', $this->hall->id)
            ->setOption('apns.data.event', 'debate')
            ->withAndroid(
                PusherMessage::create()
                    ->title("Debate oylaması başladı!")
                    ->setOption('fcm.data.hall_id', $this->hall->id)
                    ->setOption('fcm.data.event', 'debate')
            );
    }
}
