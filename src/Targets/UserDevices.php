<?php

declare(strict_types=1);

namespace NotificationChannels\Pushbullet\Targets;

class UserDevices implements Targetable
{
    public function getTarget(): array
    {
        return [];
    }
}
