<?php

declare(strict_types=1);

namespace NotificationChannels\Pushbullet;

use GuzzleHttp\Client as HttpClient;
use Illuminate\Support\ServiceProvider;

class PushbulletServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->app->when(PushbulletChannel::class)
            ->needs(Pushbullet::class)
            ->give(static function (): Pushbullet {
                $config = config('services.pushbullet');

                return new Pushbullet($config['access_token'], new HttpClient());
            });
    }
}
