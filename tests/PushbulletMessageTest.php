<?php

namespace NotificationChannels\Pushbullet\Test;

use NotificationChannels\Pushbullet\PushbulletMessage;

class PushbulletMessageTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function message_can_be_instantiated_with_text()
    {
        $message = new PushbulletMessage('Hello');

        $this->assertEquals('Hello', $message->message);
    }

    /** @test */
    public function new_message_is_of_note_type()
    {
        $message = new PushbulletMessage('Hello');

        $this->assertEquals(PushbulletMessage::TYPE_NOTE, $message->type);
    }

    /** @test */
    public function message_can_be_set_to_link_type()
    {
        $message = new PushbulletMessage('Hello');

        $message->link();

        $this->assertEquals(PushbulletMessage::TYPE_LINK, $message->type);
    }

    /** @test */
    public function message_can_be_set_to_note_type()
    {
        $message = new PushbulletMessage('Hello');

        $message->link();

        $message->note();

        $this->assertEquals(PushbulletMessage::TYPE_NOTE, $message->type);
    }

    /** @test */
    public function message_can_have_title_set()
    {
        $message = new PushbulletMessage('Hello');

        $message->title('Title');

        $this->assertEquals('Title', $message->title);
    }

    /** @test */
    public function message_can_have_message_set()
    {
        $message = new PushbulletMessage('Hello');

        $message->message('Different message');

        $this->assertEquals('Different message', $message->message);
    }

    /** @test */
    public function message_can_have_url_set()
    {
        $message = new PushbulletMessage('Hello');

        $message->url('http://example.com');

        $this->assertEquals('http://example.com', $message->url);
    }

    /** @test */
    public function message_can_be_send_too_all()
    {
        $message = new PushbulletMessage('Hello');
        $message->toAll();

        $this->assertTrue($message->toAll);
    }
}
