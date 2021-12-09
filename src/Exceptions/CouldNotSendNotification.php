<?php

declare(strict_types=1);

namespace NotificationChannels\Pushbullet\Exceptions;

use Psr\Http\Message\ResponseInterface;
use RuntimeException;
use Throwable;

class CouldNotSendNotification extends RuntimeException
{
    public static function pushbulletRespondedWithAnError(ResponseInterface $response, Throwable $previous = null): self
    {
        $code = $response->getStatusCode();

        $message = $response->getBody();

        return new self("Pushbullet responded with error: `{$code} - {$message}`.", 0, $previous);
    }

    public static function providedEmailIsInvalid(string $email): self
    {
        return new self("Provided email `{$email}` of `notifiable` is not valid.");
    }

    public static function couldNotCommunicateWithPushbullet(Throwable $previous = null): self
    {
        return new self('Could not connect to Pushbullet API.', 0, $previous);
    }
}
