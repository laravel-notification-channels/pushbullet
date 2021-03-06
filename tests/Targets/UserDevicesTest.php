<?php

declare(strict_types=1);

namespace NotificationChannels\Pushbullet\Test\Targets;

use NotificationChannels\Pushbullet\Targets\UserDevices;
use PHPUnit\Framework\TestCase;

/**
 * @covers \NotificationChannels\Pushbullet\Targets\UserDevices
 */
class UserDevicesTest extends TestCase
{
    /**
     * @test
     */
    public function it_is_properly_represented_as_array()
    {
        $sut = new UserDevices();

        $this->assertEquals([], $sut->getTarget());
    }
}
