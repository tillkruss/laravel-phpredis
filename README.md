# PhpRedis driver for Laravel 5

[![Build Status](https://travis-ci.org/tillkruss/laravel-phpredis.svg?branch=master)](https://travis-ci.org/tillkruss/laravel-phpredis)
[![Latest Stable Version](https://poser.pugx.org/tillkruss/laravel-phpredis/v/stable)](https://packagist.org/packages/tillkruss/laravel-phpredis)
[![License](https://poser.pugx.org/tillkruss/laravel-phpredis/license)](https://packagist.org/packages/tillkruss/laravel-phpredis)

This package provides a drop-in replacement for Laravel’s and Lumen’s `RedisServiceProvider`, that adds compatibility for PhpRedis, the PCEL Redis Extension.

Using PhpRedis with Laravel’s default `RedisServiceProvider` will result in issues wherever Redis is being used by Laravel, because PhpRedis returns `false` instead of `null` if a key does not exist.

*Note: PhpRedis does not support sharding, using the `cluster` option in your configuration will lead to an exception.*

## Requirements

- PHP 5.5.9
- Laravel 5.2
- PhpRedis

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
TillKruss\LaravelPhpRedis\RedisServiceProvider::class,
```

Make sure you already renamed or removed the alias for Redis in your `aliases` list.


## License

This package is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
