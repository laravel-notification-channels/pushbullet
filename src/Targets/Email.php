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
            throw CouldNotSendNotification::providedEmailIsInvalid();
        }

        $this->email = $email;
    }

    /**
     * {@inheritdoc}
     */
    public function getTarget()
    {
        return ['email' => $this->email];
    }
}
