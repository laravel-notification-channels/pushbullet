<?php

declare(strict_types=1);

namespace NotificationChannels\Pushbullet\Test;

use PHPUnit\Framework\TestCase;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use PHPUnit_Framework_MockObject_MockObject;
use NotificationChannels\Pushbullet\Targets\Email;
use NotificationChannels\Pushbullet\Targets\Client;
use NotificationChannels\Pushbullet\Targets\Device;
use NotificationChannels\Pushbullet\Targets\Channel;
use NotificationChannels\Pushbullet\PushbulletClient;
use NotificationChannels\Pushbullet\PushbulletChannel;
use NotificationChannels\Pushbullet\PushbulletMessage;
use NotificationChannels\Pushbullet\Targets\Targetable;

class PushbulletChannelTest extends TestCase
{
    /** @var PushbulletClient|PHPUnit_Framework_MockObject_MockObject */
    private $pushbullet;

    /** @var PushbulletChannel */
    private $subject;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->pushbullet = $this->createMock(PushbulletClient::class);
        $this->subject = new PushbulletChannel($this->pushbullet);
    }

    /**
     * @test
     * @expectedException \NotificationChannels\Pushbullet\Exceptions\CouldNotSendNotification
     */
    public function it_throws_exception_if_target_is_invalid()
    {
        $notifiable = new class {
            use Notifiable;
        };

        $this->pushbullet->expects($this->never())
            ->method('send');

        $notification = $this->getMockBuilder(Notification::class)
            ->setMethods(['toPushbullet'])
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock();
        $notification->expects($this->never())
            ->method('toPushbullet');

        $this->subject->send($notifiable, $notification);
    }

    /**
     * @test
     * @dataProvider targetsDataProvider
     * @param Targetable $target
     */
    public function it_sends_notification_to_targetable(Targetable $target)
    {
        $notifiable = new class($target) {
            use Notifiable;

            /** @var Targetable */
            private $target;

            public function __construct(Targetable $target)
            {
                $this->target = $target;
            }

            public function routeNotificationFor(): Targetable
            {
                return $this->target;
            }
        };

        $payload = [
            'target' => $target->getTarget(),
            'type' => 'link',
            'title' => 'Visit the website',
            'body' => 'Hello',
            'url' => 'https://example.com',
        ];

        $this->pushbullet->expects($this->once())
            ->method('send')
            ->with($payload);

        $notification = $this->getMockBuilder(Notification::class)
            ->setMethods(['toPushbullet'])
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock();
        $notification->expects($this->once())
            ->method('toPushbullet')
            ->with($notifiable)
            ->willReturn(
                PushbulletMessage::create('Hello')
                    ->link()
                    ->title('Visit the website')
                    ->url('https://example.com')
            );

        $this->subject->send($notifiable, $notification);
    }

    public function targetsDataProvider(): array
    {
        return [
            'Channel' => [new Channel('channel_tag')],
            'Client' => [new Client('client_id')],
            'Device' => [new Device('device_id')],
            'Email' => [new Email('hi@example.com')],
        ];
    }
}
