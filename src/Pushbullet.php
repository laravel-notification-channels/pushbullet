<?php

namespace NotificationChannels\Pushbullet;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\ClientException;
use NotificationChannels\Pushbullet\Exceptions\CouldNotSendNotification;

class Pushbullet
{
    /**
     * @var string
     */
    protected $token;

    /**
     * @var \GuzzleHttp\Client
     */
    protected $http;

    /**
     * Create small Pushbullet client.
     *
     * @param  string  $token
     * @param  \GuzzleHttp\Client  $httpClient
     */
    public function __construct($token, HttpClient $httpClient)
    {
        $this->token = $token;
        $this->http = $httpClient;
    }

    /**
     * Get url to send to pushbullet API
     *
     * @return string
     */
    protected function getPushbulletUrl()
    {
        return 'https://api.pushbullet.com/v2/pushes';
    }

    /**
     * Get headers for API callse
     *
     * @return array
     */
    protected function getHeaders()
    {
        return [
            'Access-Token' => $this->token
        ];
    }

    /**
     * Send request to Pushbullet API
     *
     * @param  array  $params
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function send($params)
    {
        $url = $this->getPushbulletUrl();

        try {
            return $this->http->post($url, [
                'json' => $params,
                'headers' => $this->getHeaders()
            ]);
        } catch (ClientException $exception) {
            throw CouldNotSendNotification::pushbulletRespondedWithAnError($exception);
        } catch (\Exception $exception) {
            throw CouldNotSendNotification::couldNotCommunicateWithPushbullet();
        }
    }

}