<?php

declare(strict_types=1);

namespace NotificationChannels\Pushbullet\Exceptions;

use Psr\Http\Message\ResponseInterface;
use RuntimeException;

class CouldNotSendNotification extends RuntimeException
{
    public static function pushbulletRespondedWithAnError(ResponseInterface $response): self
    {
        $code = $response->getStatusCode();

        $message = $response->getBody();

        return new self("Pushbullet responded with error: `{$code} - {$message}`.");
    }

    public static function providedEmailIsInvalid(string $email): self
    {
        return new self("Provided email `{$email}` of `notifiable` is not valid.");
    }

    public static function couldNotCommunicateWithPushbullet(): self
    {
        return new self('Could not connect to Pushbullet API.');
    }
}
