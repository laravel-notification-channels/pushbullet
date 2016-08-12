<?php

namespace NotificationChannels\Pushbullet;

use NotificationChannels\Pushbullet\Exceptions\CouldNotSendNotification;
use NotificationChannels\Pushbullet\Targets\Targetable;

class PushbulletMessage
{
    const TYPE_NOTE = 'note';
    const TYPE_LINK = 'link';

    /**
     * Type of message (currently: note or link)
     *
     * @var string
     */
    public $type = 'note';

    /**
     * @var \NotificationChannels\Pushbullet\Targets\Targetable
     */
    protected $target;

    /**
     * Notification title
     *
     * @var string
     */
    public $title;

    /**
     * Notification message
     *
     * @var string
     */
    public $message;

    /**
     * URL if notification is of link type
     *
     * @var string
     */
    public $url;

    /**
     * @param  \NotificationChannels\Pushbullet\Targets\Targetable  $targetable
     * @return $this
     */
    public function target(Targetable $targetable)
    {
        $this->target = $targetable;

        return $this;
    }

    /**
     * Specify that notification is of `note` type
     *
     * @return $this
     */
    public function note()
    {
        $this->type = static::TYPE_NOTE;

        return $this;
    }

    /**
     * Specify that notification is of `link` type
     *
     * @return $this
     */
    public function link()
    {
        $this->type = static::TYPE_LINK;

        return $this;
    }

    /**
     * Set notification title
     *
     * @param  string  $title
     * @return $this
     */
    public function title($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Set notification message
     *
     * @param  string  $message
     * @return $this
     */
    public function message($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Set notification url (if notification is of `link` type)
     *
     * @param  string  $url
     * @return $this
     */
    public function url($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get array representation of message for pushbullet client
     *
     * @return array
     */
    public function toArray()
    {
        $payload = [
            'target' => $this->target->getTarget(),
            'type' => $this->type,
            'title' => $this->title,
            'body' => $this->message
        ];

        if ($this->type === static::TYPE_LINK) {
            $payload['url'] = $this->url;
        }

        return $payload;
    }

}
