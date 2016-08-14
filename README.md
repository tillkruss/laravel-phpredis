# PhpRedis driver for Laravel & Lumen

[![Build Status](https://travis-ci.org/tillkruss/laravel-phpredis.svg?branch=master)](https://travis-ci.org/tillkruss/laravel-phpredis)
[![Latest Stable Version](https://poser.pugx.org/tillkruss/laravel-phpredis/v/stable)](https://packagist.org/packages/tillkruss/laravel-phpredis)
[![License](https://poser.pugx.org/tillkruss/laravel-phpredis/license)](https://packagist.org/packages/tillkruss/laravel-phpredis)

This package provides a drop-in replacement for Laravel’s and Lumen’s `RedisServiceProvider`, that adds compatibility for PhpRedis, the PCEL Redis Extension.

Using PhpRedis instead of Predis with Laravel’s default `RedisServiceProvider` will result in false-positives across the framework, because PhpRedis returns `false` instead of `null` if a key does not exist.


## Requirements

- PHP 5.5.9+
- Laravel 5.1+
- Lumen 5.1+
- PhpRedis 2.2.8+


## Laravel Installation

First, install this package via Composer:

```
composer require tillkruss/laravel-phpredis
```

Then open your `app` configuration file and remove (or comment-out) the default Redis service provider from your `providers` list:

```php
// Illuminate\Redis\RedisServiceProvider::class,
```

Next, register the new service provider by adding it to the end of your `providers` list:

```php
TillKruss\LaravelPhpRedis\RedisServiceProvider::class,
```

Finally, fake sure you already renamed or removed the alias for Redis in your `aliases` list.


## Lumen Installation

First, install this package via Composer:

```
composer require tillkruss/laravel-phpredis
```

If you haven’t already, install `illuminate/redis` as well:

```
composer require illuminate/redis
```

Next, register the Redis service provider in your `bootstrap/app.php` file.

```php
$app->register(TillKruss\LaravelPhpRedis\RedisServiceProvider::class);
```

Finally, if you have not called `$app->withEloquent()` in your `bootstrap/app.php` file, then you need to call `$app->configure('database');` to ensure the Redis database configuration is properly loaded.


## License

This package is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
