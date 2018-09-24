<?php

declare(strict_types=1);

namespace NotificationChannels\Pushbullet;

use Throwable;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\ClientException;
use NotificationChannels\Pushbullet\Exceptions\CouldNotSendNotification;

class PushbulletClient
{
    /** @var string */
    protected $token;

    /** @var \GuzzleHttp\Client */
    protected $httpClient;

    /**
     * @param  string  $token
     * @param  \GuzzleHttp\Client  $httpClient
     */
    public function __construct(string $token, HttpClient $httpClient)
    {
        $this->token = $token;
        $this->httpClient = $httpClient;
    }

    /**
     * Get url to send to Pushbullet API?
     *
     * @return string
     */
    protected function getPushbulletUrl(): string
    {
        return 'https://api.pushbullet.com/v2/pushes';
    }

    /**
     * Get headers for API calls.
     *
     * @return array
     */
    protected function getHeaders(): array
    {
        return [
            'Access-Token' => $this->token,
        ];
    }

    /**
     * Send request to Pushbullet API.
     *
     * @param  array  $params
     * @return \Psr\Http\Message\ResponseInterface
     *
     * @throws \NotificationChannels\Pushbullet\Exceptions\CouldNotSendNotification
     */
    public function send(array $params)
    {
        $url = $this->getPushbulletUrl();

        try {
            return $this->httpClient->post($url, [
                'json' => $params,
                'headers' => $this->getHeaders(),
            ]);
        } catch (ClientException $exception) {
            throw CouldNotSendNotification::pushbulletRespondedWithAnError($exception);
        } catch (Throwable $exception) {
            throw CouldNotSendNotification::couldNotCommunicateWithPushbullet();
        }
    }
}
