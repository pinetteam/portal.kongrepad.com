<?php

namespace App\Notifications;

use NotificationChannels\PusherPushNotifications\PusherChannel;
use NotificationChannels\PusherPushNotifications\PusherMessage;
use Illuminate\Notifications\Notification;

class AnnouncementNotification extends Notification
{
    public $announcement;

    public function __construct($announcement)
    {
        $this->announcement = $announcement;
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
            ->body($this->announcement->title)
            ->setOption('apns.data.event', 'announcement')
            ->withAndroid(
                PusherMessage::create()
                    ->title($this->announcement->title)
            );
    }
}
