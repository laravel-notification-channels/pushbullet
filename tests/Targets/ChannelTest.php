<?php

declare(strict_types=1);

namespace NotificationChannels\Pushbullet\Test\Targets;

use NotificationChannels\Pushbullet\Targets\Channel;
use PHPUnit\Framework\TestCase;

/**
 * @covers \NotificationChannels\Pushbullet\Targets\Channel
 */
class ChannelTest extends TestCase
{
    /**
     * @test
     */
    public function it_is_properly_represented_as_array()
    {
        $sut = new Channel('channelTag');

        $this->assertEquals(['channel_tag' => 'channelTag'], $sut->getTarget());
    }
}
