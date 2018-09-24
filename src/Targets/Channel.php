<?php

namespace NotificationChannels\Pushbullet\Targets;

class Channel implements Targetable
{
    /**
     * PushBullet channel tag.
     *
     * @var string
     */
    protected $channelTag;

    /**
     * Set channel tag.
     *
     * @param  string  $channelTag
     */
    public function __construct($channelTag)
    {
        $this->channelTag = $channelTag;
    }

    /**
     * {@inheritdoc}
     */
    public function getTarget(): array
    {
        return ['channel_tag' => $this->channelTag];
    }
}
