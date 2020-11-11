<?php

declare(strict_types=1);

namespace NotificationChannels\Pushbullet\Test\Targets;

use NotificationChannels\Pushbullet\Exceptions\CouldNotSendNotification;
use NotificationChannels\Pushbullet\Targets\Email;
use PHPUnit\Framework\TestCase;

/**
 * @covers \NotificationChannels\Pushbullet\Targets\Email
 */
class EmailTest extends TestCase
{
    /**
     * @test
     */
    public function it_is_properly_represented_as_array()
    {
        $sut = new Email('email@example.com');

        $this->assertEquals(['email' => 'email@example.com'], $sut->getTarget());
    }

    /**
     * @test
     */
    public function invalid_email_is_not_accepted()
    {
        $this->expectException(CouldNotSendNotification::class);

        $sut = new Email('email');
    }
}
