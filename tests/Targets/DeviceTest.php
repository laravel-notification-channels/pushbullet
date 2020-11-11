<?php

declare(strict_types=1);

namespace NotificationChannels\Pushbullet\Test\Targets;

use NotificationChannels\Pushbullet\Targets\Device;
use PHPUnit\Framework\TestCase;

/**
 * @covers \NotificationChannels\Pushbullet\Targets\Device
 */
class DeviceTest extends TestCase
{
    /**
     * @test
     */
    public function it_is_properly_represented_as_array()
    {
        $sut = new Device('deviceId');

        $this->assertEquals(['device_iden' => 'deviceId'], $sut->getTarget());
    }
}
