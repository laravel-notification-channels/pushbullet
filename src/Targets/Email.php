<?php

namespace NotificationChannels\Pushbullet\Targets;

use NotificationChannels\Pushbullet\Exceptions\CouldNotSendNotification;

class Email implements Targetable
{
    /**
     * Recipient email.
     *
     * @var string
     */
    protected $email;

    /**
     * Set recipient email.
     *
     * @param  string  $email
     */
    public function __construct($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            throw CouldNotSendNotification::providedEmailIsInvalid($email);
        }

        $this->email = $email;
    }

    /**
     * {@inheritdoc}
     */
    public function getTarget(): array
    {
        return ['email' => $this->email];
    }
}
