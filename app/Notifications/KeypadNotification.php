<?php

namespace App\Notifications;

use NotificationChannels\PusherPushNotifications\PusherChannel;
use NotificationChannels\PusherPushNotifications\PusherMessage;
use Illuminate\Notifications\Notification;

class KeypadNotification extends Notification
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
            ->body(__('Keypad oylaması başladı'))
            ->setOption('apns.data.hall_id', $this->hall->id)
            ->setOption('apns.data.event', 'keypad')
            ->withAndroid(
                PusherMessage::create()
                    ->title(__('common.keypad-voting-started'))
            );
    }
}
