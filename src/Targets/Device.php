<?php

declare(strict_types=1);

namespace NotificationChannels\Pushbullet\Targets;

class Device implements Targetable
{
    private string $deviceId;

    /**
     * @param  string  $device
     */
    public function __construct($device)
    {
        $this->deviceId = (string)$device;
    }

    /**
     * {@inheritdoc}
     */
    public function getTarget(): array
    {
        return ['device_iden' => $this->deviceId];
    }
}
