<?php

declare(strict_types=1);

namespace NotificationChannels\Pushbullet;

use Illuminate\Notifications\Notification;
use NotificationChannels\Pushbullet\Targets\Targetable;
use NotificationChannels\Pushbullet\Exceptions\CouldNotSendNotification;

class PushbulletChannel
{
    /** @var \NotificationChannels\Pushbullet\PushbulletClient */
    protected $pushbulletClient;

    /**
     * Create pushbullet notification channel.
     * @param  \NotificationChannels\Pushbullet\PushbulletClient  $pushbulletClient
     */
    public function __construct(PushbulletClient $pushbulletClient)
    {
        $this->pushbulletClient = $pushbulletClient;
    }

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     *
     * @throws \NotificationChannels\Pushbullet\Exceptions\CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        $target = $this->getTarget($notifiable);

        /** @var \NotificationChannels\Pushbullet\PushbulletMessage $message */
        $message = $notification->toPushbullet($notifiable)
            ->target($target);

        $this->pushbulletClient->send($message->toArray());
    }

    /**
     * @param $notifiable
     * @return  \NotificationChannels\Pushbullet\Targets\Targetable
     * @throws  \NotificationChannels\Pushbullet\Exceptions\CouldNotSendNotification
     */
    protected function getTarget($notifiable): Targetable
    {
        $target = $notifiable->routeNotificationFor('pushbullet');

        if ($target instanceof Targetable) {
            return $target;
        }

        throw CouldNotSendNotification::invalidTargetSpecifiedByNotifiable();
    }
}
