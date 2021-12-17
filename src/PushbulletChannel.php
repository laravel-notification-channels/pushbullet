<?php

declare(strict_types=1);

namespace NotificationChannels\Pushbullet;

use Illuminate\Notifications\Notification;
use NotificationChannels\Pushbullet\Targets\Device;
use NotificationChannels\Pushbullet\Targets\Email;
use NotificationChannels\Pushbullet\Targets\Targetable;

class PushbulletChannel
{
    private Pushbullet $pushbullet;

    public function __construct(Pushbullet $pushbullet)
    {
        $this->pushbullet = $pushbullet;
    }

    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     *
     * @throws \NotificationChannels\Pushbullet\Exceptions\CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification): void
    {
        if (! $target = $this->getTarget($notifiable)) {
            return;
        }

        /** @var \NotificationChannels\Pushbullet\PushbulletMessage $message */
        $message = $notification->toPushbullet($notifiable)->target($target);

        $this->pushbullet->send($message->toArray());
    }

    /**
     * @param  Targetable|string  $notifiable
     */
    private function getTarget($notifiable): ?Targetable
    {
        if (! $target = $notifiable->routeNotificationFor('pushbullet')) {
            return null;
        }

        if ($target instanceof Targetable) {
            return $target;
        }

        $target = (string) $target;

        if (filter_var($target, FILTER_VALIDATE_EMAIL) !== false) {
            return new Email($target);
        }

        return new Device($target);
    }
}
