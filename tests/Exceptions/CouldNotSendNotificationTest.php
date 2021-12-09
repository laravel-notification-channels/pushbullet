<?php

declare(strict_types=1);

namespace NotificationChannels\Pushbullet\Test\Exceptions;

use Exception;
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
        $previousException = new Exception();
        $exception = CouldNotSendNotification::couldNotCommunicateWithPushbullet($previousException);

        $this->assertEquals(
            'Could not connect to Pushbullet API.',
            $exception->getMessage()
        );
        $this->assertSame($previousException, $exception->getPrevious());
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

        $previousException = new Exception();

        $exception = CouldNotSendNotification::pushbulletRespondedWithAnError($response, $previousException);

        $this->assertEquals(
            'Pushbullet responded with error: `400 - Oops`.',
            $exception->getMessage()
        );
        $this->assertSame($previousException, $exception->getPrevious());
    }
}
