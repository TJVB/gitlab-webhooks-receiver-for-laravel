# GitLab webhooks receiver for Laravel

[![Latest Stable Version](https://poser.pugx.org/tjvb/gitlab-webhooks-receiver-for-laravel/v)](https://packagist.org/packages/tjvb/gitlab-webhooks-receiver-for-laravel)
[![Pipeline status](https://gitlab.com/tjvb/gitlab-webhooks-receiver-for-laravel/badges/master/pipeline.svg)](https://gitlab.com/tjvb/gitlab-webhooks-receiver-for-laravel/-/pipelines?page=1&scope=all&ref=master)
[![Coverage report](https://gitlab.com/tjvb/gitlab-webhooks-receiver-for-laravel/badges/master/coverage.svg)](https://gitlab.com/tjvb/gitlab-webhooks-receiver-for-laravel/-/pipelines?page=1&scope=all&ref=master)
[![Tested on PHP 8.1 to 8.3](https://img.shields.io/badge/Tested%20on-PHP%208.1%20|%208.2%20|%208.3-brightgreen.svg?maxAge=2419200)](https://gitlab.com/tjvb/gitlab-webhooks-receiver-for-laravel/-/pipelines?page=1&scope=all&ref=master)
[![Tested on Laravel 9 to 10](https://img.shields.io/badge/Tested%20on-Laravel%209%20|%2010-brightgreen.svg?maxAge=2419200)](https://gitlab.com/tjvb/gitlab-webhooks-receiver-for-laravel/-/pipelines?page=1&scope=all&ref=master)
[![Latest Unstable Version](https://poser.pugx.org/tjvb/gitlab-webhooks-receiver-for-laravel/v/unstable)](https://packagist.org/packages/tjvb/gitlab-webhooks-receiver-for-laravel)


[![PHP Version Require](https://poser.pugx.org/tjvb/gitlab-webhooks-receiver-for-laravel/require/php)](https://packagist.org/packages/tjvb/gitlab-webhooks-receiver-for-laravel)
[![Laravel Version Require](https://poser.pugx.org/tjvb/gitlab-webhooks-receiver-for-laravel/require/laravel/framework)](https://packagist.org/packages/tjvb/gitlab-webhooks-receiver-for-laravel)
[![PHPMD](https://img.shields.io/badge/PHPMD-checked-brightgreen.svg)](https://gitlab.com/tjvb/gitlab-webhooks-receiver-for-laravel/-/blob/master/phpmd.xml.dist)
[![PHPCS](https://img.shields.io/badge/PHPCS-PSR12-brightgreen.svg)](https://gitlab.com/tjvb/gitlab-webhooks-receiver-for-laravel/-/blob/master/phpcs.xml.dist)

[![License](https://poser.pugx.org/tjvb/gitlab-webhooks-receiver-for-laravel/license)](https://packagist.org/packages/tjvb/gitlab-webhooks-receiver-for-laravel)


GitLab has the option to send webhooks for multiple events that can be used for different purposes. This package handle the receiving, validating and storing of the webhook data. After receiving it will dispatch an event that can be used to do with the data what fits your application.

## Installation

1. You can install the package via composer:
```bash
composer require tjvb/gitlab-webhooks-receiver-for-laravel
```

2. You can publish and run the migrations with:

```bash
php artisan vendor:publish --provider="TJVB\GitLabWebhooks\GitLabWebhooksServiceProvider" --tag="migrations"
php artisan migrate
```

3. Listen to the `\TJVB\GitLabWebhooks\Events\HookStored::class` event.
   The package store the webhook data and dispatch an event, you can listen to the HookStored event and handle it the way you want. The [Laravel documentation](https://laravel.com/docs/8.x/events) can explain more about events and listeners.
   
4. Set the `GITLAB_WEBHOOK_SECRET` env variable (most used version is to set it in the .env file) to have the token you use for your webhook. See [https://docs.gitlab.com/ee/user/project/integrations/webhooks.html#secret-token](https://docs.gitlab.com/ee/user/project/integrations/webhooks.html#secret-token "the GitLab documentation") for more information.

5. Create a webhook in GitLab.
   You can create a webhook in GitLab for your project, group or system. The default url is `<application.tld>/gitlabwebhook` this can be changed in the [configuration from tjvb/gitlab-webhooks-receiver-for-laravel](https://gitlab.com/tjvb/gitlab-webhooks-receiver-for-laravel#configuration).
   
6. Optional configure the package.

### Manual register the service provider.
If you disable the package discovery you need to add `\TJVB\GitLabWebhooks\GitLabWebhooksServiceProvider::class,` to the providers array in config/app.php


## Configuration

### Customization
You can publish the config file with:
```bash
php artisan vendor:publish --provider="TJVB\GitLabWebhooks\GitLabWebhooksServiceProvider" --tag="config"
```

### Security
The default configuration validates the `X-Gitlab-Token` in the header of the webhook request. It is possible to add multiple values in the config file or disabling the middleware to stop the verification. If you need more validation for the request (as example and i.p. filter) you can add more middleware to the configuration.


## Changelog
We (try to) document all the changes in [CHANGELOG](CHANGELOG.md) so read it for more information.

## Contributing
You are very welcome to contribute, read about it in [CONTRIBUTING](CONTRIBUTING.md)

## Security
If you discover any security related issues, please email info@tjvb.nl instead of using the issue tracker.

## Tips

### Fast response
As described [here](https://docs.gitlab.com/ee/user/project/integrations/webhooks.html#webhook-endpoint-tips) GitLab want to have a fast response. That means that it is useful to have a queue driver configured that run the jobs in the background. That means that if you use the sync driver it can happen that the response is to slow, so you get the webhook another time.

### Test your webhook
On the GitLab pages with the webhook settings it is possible to test the webhook, use it to verify that everything works as suspected.

### Cleanup your hooks
If you don't need the data saved in the webhook it can be a good idea to periodic remove the old data. Depending on the kind of hooks the body can be very big. This can be done on the end of your event listener or with a package like [spatie/laravel-model-cleanup](https://github.com/spatie/laravel-model-cleanup).

## Credits

- [Tobias van Beek](https://tjvb.nl/about)
- [All Contributors](https://gitlab.com/tjvb/gitlab-webhooks-receiver-for-laravel/-/graphs/master)

## Thanks to
- [GitLab](https://gitlab.com) for the great product, without that this package isn't needed.

## License
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

