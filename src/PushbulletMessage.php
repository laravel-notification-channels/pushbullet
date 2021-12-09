<?php

declare(strict_types=1);

namespace NotificationChannels\Pushbullet;

use NotificationChannels\Pushbullet\Targets\Targetable;

class PushbulletMessage
{
    private const TYPE_NOTE = 'note';
    private const TYPE_LINK = 'link';

    /**
     * Type of message (currently: note or link).
     *
     * @var string
     */
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
     * Url if notification is of link type.
     *
     * @var string
     */
    public $url;

    /**
     * @param  string  $message
     * @return static
     */
    public static function create($message): self
    {
        return new static($message);
    }

    /**
     * @param  string  $message
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * @param  \NotificationChannels\Pushbullet\Targets\Targetable  $targetable
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
        $this->type = self::TYPE_NOTE;

        return $this;
    }

    /**
     * Specify that notification is of `link` type.
     *
     * @return $this
     */
    public function link(): self
    {
        $this->type = self::TYPE_LINK;

        return $this;
    }

    /**
     * Set notification title.
     *
     * @param  string  $title
     * @return $this
     */
    public function title($title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Set notification message.
     *
     * @param  string  $message
     * @return $this
     */
    public function message($message): self
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Set notification url (if notification is of `link` type).
     *
     * @param  string  $url
     * @return $this
     */
    public function url($url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get array representation of message for Pushbullet client.
     *
     * @return array{type: string, title: string, body: string, url?: string, channel_tag?: string, device_iden?: string, email?: string, }
     */
    public function toArray(): array
    {
        $payload = [
            'type' => $this->type,
            'title' => $this->title,
            'body' => $this->message,
        ];

        return array_merge(
            $payload,
            $this->target->getTarget(),
            $this->getUrlParameter()
        );
    }

    /**
     * @return bool
     */
    private function isLink(): bool
    {
        return $this->type === self::TYPE_LINK;
    }

    /**
     * @return array{url?: string}
     */
    private function getUrlParameter(): array
    {
        return $this->isLink() ? ['url' => $this->url] : [];
    }
}
