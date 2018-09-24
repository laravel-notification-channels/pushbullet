<?php

declare(strict_types=1);

namespace NotificationChannels\Pushbullet;

use GuzzleHttp\Client as HttpClient;
use Illuminate\Support\ServiceProvider;

class PushbulletServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        // Bootstrap code here.
        $this->app->when(PushbulletChannel::class)
            ->needs(PushbulletClient::class)
            ->give(function () {
                $config = $this->app['config']['services.pushbullet'];

                return new PushbulletClient($config['access_token'], new HttpClient);
            });
    }
}
