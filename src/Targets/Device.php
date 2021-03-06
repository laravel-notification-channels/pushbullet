<?php

declare(strict_types=1);

namespace NotificationChannels\Pushbullet\Targets;

class Device implements Targetable
{
    /**
     * Recipient device id.
     *
     * @var string
     */
    private $deviceId;

    /**
     * Set recipient device id.
     *
     * @param  string  $device
     */
    public function __construct($device)
    {
        $this->deviceId = $device;
    }

    /**
     * {@inheritdoc}
     */
    public function getTarget(): array
    {
        return ['device_iden' => $this->deviceId];
    }
}
