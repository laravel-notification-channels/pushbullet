<?php

declare(strict_types=1);

namespace NotificationChannels\Pushbullet\Targets;

interface Targetable
{
    /**
     * Get proper target object for Pushbullet client.
     *
     * @return array
     */
    public function getTarget(): array;
}
