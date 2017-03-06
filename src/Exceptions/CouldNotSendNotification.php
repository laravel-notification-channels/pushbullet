<?php

namespace NotificationChannels\Pushbullet\Exceptions;

use RuntimeException;
use GuzzleHttp\Exception\ClientException;

class CouldNotSendNotification extends RuntimeException
{
    public static function pushbulletRespondedWithAnError(ClientException $exception)
    {
        $code = $exception->getResponse()->getStatusCode();

        $message = $exception->getResponse()->getBody();

        return new static("Pushbullet responded with an error `{$code} - {$message}`");
    }

    public static function providedEmailIsInvalid($email)
    {
        return new static("Provided email `{$email}` of `notifiable` is not valid");
    }

    public static function couldNotSendNotificationWithoutRecipient()
    {
        return new static('Neither device id nor email of recipient was not specified');
    }

    public static function couldNotCommunicateWithPushbullet()
    {
        return new static("Couldn't connect to Pushbullet API.");
    }
}
