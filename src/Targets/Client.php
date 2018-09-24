<?php

declare(strict_types=1);

namespace NotificationChannels\Pushbullet\Targets;

class Client implements Targetable
{
    /** @var string */
    protected $clientId;

    /**
     * @param string $clientId
     */
    public function __construct(string $clientId)
    {
        $this->clientId = $clientId;
    }

    /**
     * {@inheritdoc}
     */
    public function getTarget(): array
    {
        return ['client_iden' => $this->clientId];
    }
}
