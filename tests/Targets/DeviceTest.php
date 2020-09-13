<?php

declare(strict_types=1);

namespace NotificationChannels\Pushbullet\Test\Targets;

use NotificationChannels\Pushbullet\Targets\Device;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \NotificationChannels\Pushbullet\Targets\Device
 */
class DeviceTest extends TestCase
{
    /**
     * @test
     *
     * @covers ::__construct
     * @covers ::getTarget
     */
    public function it_is_properly_represented_as_array()
    {
        $sut = new Device('deviceId');

        $this->assertEquals(['device_iden' => 'deviceId'], $sut->getTarget());
    }
}
