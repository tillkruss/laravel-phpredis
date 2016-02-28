# PHPRedis driver for Laravel 5.2+

[![Build Status](https://travis-ci.org/tillkruss/laravel-phpredis.svg?branch=master)](https://travis-ci.org/tillkruss/laravel-phpredis)
[![Latest Stable Version](https://poser.pugx.org/tillkruss/larvel-phpredis/v/stable)](https://packagist.org/packages/tillkruss/larvel-phpredis)
[![License](https://poser.pugx.org/tillkruss/larvel-phpredis/license)](https://packagist.org/packages/tillkruss/larvel-phpredis)

This package provides a drop-in replacement for Laravel's `RedisServiceProvider`, that adds compatibility for PHPRedis, the PCEL Redis Extension.

PHPRedis does not support sharding, using the `cluster` option in your configuration will lead to an exception.

## Requirements

- PHP 5.5.9+
- Laravel 5.2+
- PHPRedis

## Installation

Install this package via Composer:

```
composer require tillkruss/laravel-phpredis
```

Then open your `app` configuration file and remove (or comment-out) the default Redis service provider from your `providers` list:

```
// Illuminate\Redis\RedisServiceProvider::class,
```

Next, register the new service provider by adding it to the end of your `providers` list:

```
TillKruss\LaravelPHPRedis\RedisServiceProvider::class,
```

Make sure you already renamed or removed the alias for Redis in your `aliases` list.


## License

Laravel Socialite is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
