<?php

 declare(strict_types=1);

namespace NotificationChannels\Pushbullet;

use Exception;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\ClientException;
use NotificationChannels\Pushbullet\Exceptions\CouldNotSendNotification;

class Pushbullet
{
    /** @var string */
    private $token;

    /** @var \GuzzleHttp\Client */
    private $httpClient;

    /**
     * Create small Pushbullet client.
     *
     * @param  string  $token
     * @param  \GuzzleHttp\Client  $httpClient
     */
    public function __construct($token, HttpClient $httpClient)
    {
        $this->token = $token;
        $this->httpClient = $httpClient;
    }

    /**
     * Get url to send to Pushbullet API?
     *
     * @return string
     */
    private function getPushbulletUrl(): string
    {
        return 'https://api.pushbullet.com/v2/pushes';
    }

    /**
     * Get headers for API calls.
     *
     * @return array
     */
    private function getHeaders(): array
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
     */
    public function send($params)
    {
        $url = $this->getPushbulletUrl();

        try {
            return $this->httpClient->post($url, [
                'json' => $params,
                'headers' => $this->getHeaders(),
            ]);
        } catch (ClientException $exception) {
            throw CouldNotSendNotification::pushbulletRespondedWithAnError($exception);
        } catch (Exception $exception) {
            throw CouldNotSendNotification::couldNotCommunicateWithPushbullet();
        }
    }
}
