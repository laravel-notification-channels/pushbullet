<?php

declare(strict_types=1);

namespace NotificationChannels\Pushbullet\Exceptions;

use RuntimeException;
use GuzzleHttp\Exception\ClientException;

class CouldNotSendNotification extends RuntimeException
{
    public static function pushbulletRespondedWithAnError(ClientException $exception): self
    {
        $code = $exception->getResponse()->getStatusCode();

        $message = $exception->getResponse()->getBody();

        return new static("Pushbullet responded with an error `{$code} - {$message}`");
    }

    public static function providedEmailIsInvalid($email): self
    {
        return new static("Provided email `{$email}` of `notifiable` is not valid");
    }

    public static function couldNotSendNotificationWithoutRecipient(): self
    {
        return new static('Neither device id nor email of recipient was not specified');
    }

    public static function couldNotCommunicateWithPushbullet(): self
    {
        return new static("Couldn't connect to Pushbullet API.");
    }

    public static function invalidTargetSpecifiedByNotifiable(): self
    {
        return new static('Invalid target is specified by notifiable');
    }
}
