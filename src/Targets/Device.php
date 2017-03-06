<?php

namespace NotificationChannels\Pushbullet\Targets;

class Device implements Targetable
{
    /**
     * Recipient device id.
     *
     * @var string
     */
    protected $deviceId;

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
    public function getTarget()
    {
        return ['device_iden' => $this->deviceId];
    }
}
