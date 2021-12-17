<?php

declare(strict_types=1);

namespace NotificationChannels\Pushbullet\Targets;

class Channel implements Targetable
{
    private string $channelTag;

    /**
     * @param  string  $channelTag
     */
    public function __construct($channelTag)
    {
        $this->channelTag = (string)$channelTag;
    }

    /**
     * {@inheritdoc}
     */
    public function getTarget(): array
    {
        return ['channel_tag' => $this->channelTag];
    }
}
