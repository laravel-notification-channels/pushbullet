<?php

namespace NotificationChannels\Pushbullet\Targets;

interface Targetable
{
    /**
     * Get proper target object for pushbullet client.
     *
     * @return array
     */
    public function getTarget();
}
