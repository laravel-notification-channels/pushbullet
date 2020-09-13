<?php

declare(strict_types=1);

namespace NotificationChannels\Pushbullet;

use GuzzleHttp\Client as HttpClient;
use Illuminate\Support\ServiceProvider;

class PushbulletServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->when(PushbulletChannel::class)
            ->needs(Pushbullet::class)
            ->give(function () {
                $config = config('services.pushbullet');

                return new Pushbullet($config['access_token'], new HttpClient());
            });
    }
}
