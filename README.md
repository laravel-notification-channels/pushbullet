# Pushbullet notification channel for Laravel 5.3+

[![Latest Version on Packagist](https://img.shields.io/packagist/v/laravel-notification-channels/pushbullet.svg?style=flat-square)](https://packagist.org/packages/laravel-notification-channels/pushbullet)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/laravel-notification-channels/pushbullet/master.svg?style=flat-square)](https://travis-ci.org/laravel-notification-channels/pushbullet)
[![StyleCI](https://styleci.io/repos/65558300/shield)](https://styleci.io/repos/65558300)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/2283805a-e7cc-4e83-8cda-b91b8336cb57.svg?style=flat-square)](https://insight.sensiolabs.com/projects/2283805a-e7cc-4e83-8cda-b91b8336cb57)
[![Quality Score](https://img.shields.io/scrutinizer/g/laravel-notification-channels/pushbullet.svg?style=flat-square)](https://scrutinizer-ci.com/g/laravel-notification-channels/pushbullet)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/laravel-notification-channels/pushbullet/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/laravel-notification-channels/pushbullet/?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/laravel-notification-channels/pushbullet.svg?style=flat-square)](https://packagist.org/packages/laravel-notification-channels/pushbullet)

This package makes it easy to send notifications using [Pushbullet](http://pushbullet.com) with Laravel 5.3+.

## Contents

- [Installation](#installation)
    - [Setting up the Pushbullet service](#setting-up-the-pushbullet-service)
- [Usage](#usage)
    - [Available Message methods](#available-message-methods)
- [Changelog](#changelog)
- [Testing](#testing)
- [Security](#security)
- [Contributing](#contributing)
- [Credits](#credits)
- [License](#license)


## Installation

To get the latest version of Pushbullet Notification channel for Laravel 5.3, simply require the project using [Composer](https://getcomposer.org):

```bash
$ composer require laravel-notification-channels/pushbullet
```

Or you can manually update your require block and run `composer update` if you choose so:

```json
{
    "require": {
        "laravel-notification-channels/pushbullet": "^1.0"
    }
}
```

You will also need to install `guzzlehttp/guzzle` http client to send request to Pushbullet API.

If you use Laravel 5.5 you don't need the following step.
If not, once package is installed, you need to register the service provider. Open up `config/app.php` and add the following to the `providers` key.

* `NotificationChannels\Pushbullet\PushbulletServiceProvider::class`

### Setting up the Pushbullet service

In your pushbullet account go to [Account settings](https://www.pushbullet.com/#settings/account) page. Click `Create Access Token` button and you will get access_token.

You need to put it to `config/services.php` configuration file. You may copy the example configuration below to get started:
```php
'pushbullet' => [
    'access_token' => env('PUSHBULLET_ACCESS_TOKEN')
]
```

## Usage

### Routing Pushbullet notifications
In order to send notifications to Pushbullet you need to specify recipient for each notifiable entity. There are currently 2 options: pushbullet email or device id of recipient.
To provide library with correct notification recipient you need to define `routeNotificationForPushbullet` method on notifiable entity.

#### Sending notification to email:
```php
public function routeNotificationForPushbullet()
{
    return new \NotificationChannels\Pushbullet\Targets\Email($this->email);
}
```

#### Sending notification to device id:
```php
public function routeNotificationForPushbullet()
{
    return new \NotificationChannels\Pushbullet\Targets\Device($this->pushbullet_device_id);
}
```

#### Sending notification to all subscribers of channel that has tag:
```php
public function routeNotificationForPushbullet()
{
    return new \NotificationChannels\Pushbullet\Targets\Channel($this->channel_tag);
}
```

### `via` Method
On notification entity just add `\NotificationChannels\Pushbullet\PushbulletChannel::class` item to array that is returned from `via` method.

### `toPushbullet` Method
In your notification class you also should define `toPushbullet` method which will return instance of `\NotificationChannels\Pushbullet\PushbulletMessage`.
```php
/**
 * Get the pushbullet representation of the notification.
 *
 * @param  mixed  $notifiable
 * @return \NotificationChannels\Pushbullet\PushbulletMessage
 */
public function toPushbullet($notifiable)
{
    $url = url('/invoice/' . $this->invoice->id);

    return PushbulletMessage::create('Thank you for using our application!')
        ->link()
        ->title('One of your invoices has been paid!')
        ->url($url);
}
```

#### Available Message methods
- `note()`: set notification type to note (title and message for notification are available)
- `link()`: set notification type to link (title, message and url are available)
- `title($title)`: (string) set notification title
- `message($message)`: (string) set notification message
- `url($url)`: (string) set notification url (will be in notification if type is `link`)

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Security

If you discover any security related issues, please email themsaid@gmail.com instead of using the issue tracker.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Alex Plekhanov](https://github.com/alexsoft)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
