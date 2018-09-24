<?php

declare(strict_types=1);

namespace NotificationChannels\Pushbullet;

use NotificationChannels\Pushbullet\Targets\Targetable;

class PushbulletMessage
{
    const TYPE_NOTE = 'note';
    const TYPE_LINK = 'link';

    /** @var string [note|link] */
    public $type = 'note';

    /** @var \NotificationChannels\Pushbullet\Targets\Targetable */
    protected $target;

    /**
     * Notification title.
     *
     * @var string
     */
    public $title;

    /**
     * Notification message.
     *
     * @var string
     */
    public $message;

    /**
     * Url for the link type notification.
     *
     * @var string
     */
    public $url;

    /**
     * @param string $message
     *
     * @return static
     */
    public static function create(string $message): self
    {
        return new static($message);
    }

    /**
     * @param string $message
     */
    public function __construct(string $message)
    {
        $this->message = $message;
    }

    /**
     * @param  \NotificationChannels\Pushbullet\Targets\Targetable  $targetable
     *
     * @return $this
     */
    public function target(Targetable $targetable): self
    {
        $this->target = $targetable;

        return $this;
    }

    /**
     * Specify that notification is of `note` type.
     *
     * @return $this
     */
    public function note(): self
    {
        $this->type = static::TYPE_NOTE;

        return $this;
    }

    /**
     * Specify that notification is of `link` type.
     *
     * @return $this
     */
    public function link(): self
    {
        $this->type = static::TYPE_LINK;

        return $this;
    }

    /**
     * Set notification title.
     *
     * @param  string  $title
     *
     * @return $this
     */
    public function title(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Set notification message.
     *
     * @param  string  $message
     *
     * @return $this
     */
    public function message(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Set notification url (if notification is of `link` type).
     *
     * @param  string  $url
     *
     * @return $this
     */
    public function url(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get array representation of message for Pushbullet client.
     *
     * @return array
     */
    public function toArray(): array
    {
        $payload = [
            'target' => $this->target->getTarget(),
            'type' => $this->type,
            'title' => $this->title,
            'body' => $this->message,
        ];

        if ($this->isLink()) {
            $payload['url'] = $this->url;
        }

        return $payload;
    }

    /**
     * @return bool
     */
    public function isLink(): bool
    {
        return $this->type === static::TYPE_LINK;
    }
}
