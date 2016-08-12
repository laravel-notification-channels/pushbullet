<?php

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
            ->needs(Pushbullet::class)
            ->give(function () {
                return new Pushbullet($this->app['config']['services.pushbullet.access_token'], new HttpClient);
            });
    }

    /**
     * Register the application services.
     */
    public function register()
    {
    }
}
