<?php

declare(strict_types=1);

namespace NotificationChannels\Pushbullet\Test\Exceptions;

use NotificationChannels\Pushbullet\Exceptions\CouldNotSendNotification;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

class CouldNotSendNotificationTest extends TestCase
{
    /** @test */
    public function invalid_email_exception_can_be_created(): void
    {
        $exception = CouldNotSendNotification::providedEmailIsInvalid('test@example.com');

        $this->assertEquals(
            'Provided email `test@example.com` of `notifiable` is not valid.',
            $exception->getMessage()
        );
    }

    /** @test */
    public function pushbullet_connection_exception_can_be_created(): void
    {
        $exception = CouldNotSendNotification::couldNotCommunicateWithPushbullet();

        $this->assertEquals(
            'Could not connect to Pushbullet API.',
            $exception->getMessage()
        );
    }

    /** @test */
    public function pushbullet_error_exception_can_be_created(): void
    {
        $response = $this->createMock(ResponseInterface::class);

        $response
            ->method('getStatusCode')
            ->willReturn(400);

        $response
            ->method('getBody')
            ->willReturn('Oops');

        $exception = CouldNotSendNotification::pushbulletRespondedWithAnError($response);

        $this->assertEquals(
            'Pushbullet responded with error: `400 - Oops`.',
            $exception->getMessage()
        );
    }
}
