<?php

declare(strict_types=1);

namespace NotificationChannels\Pushbullet;

use Exception;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\ClientException;
use NotificationChannels\Pushbullet\Exceptions\CouldNotSendNotification;
use Psr\Http\Message\ResponseInterface;

class Pushbullet
{
    private string $token;

    private HttpClient $httpClient;

    public function __construct(string $token, HttpClient $httpClient)
    {
        $this->token = $token;
        $this->httpClient = $httpClient;
    }

    /**
     * Get url to send to Pushbullet API?
     */
    private function getPushbulletUrl(): string
    {
        return 'https://api.pushbullet.com/v2/pushes';
    }

    /**
     * Get headers for API calls.
     *
     * @return array<string, string>
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
     */
    public function send($params): ResponseInterface
    {
        $url = $this->getPushbulletUrl();

        try {
            return $this->httpClient->post($url, [
                'json' => $params,
                'headers' => $this->getHeaders(),
            ]);
        } catch (ClientException $exception) {
            throw CouldNotSendNotification::pushbulletRespondedWithAnError($exception->getResponse());
        } catch (Exception $exception) {
            throw CouldNotSendNotification::couldNotCommunicateWithPushbullet();
        }
    }
}
