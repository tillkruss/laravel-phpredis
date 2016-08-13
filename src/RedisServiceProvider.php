<?php

namespace TillKruss\LaravelPhpRedis;

use Cache;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;

class RedisServiceProvider extends ServiceProvider
{
    /**
     * Don't defer the loadig of the service provider.
     */
    protected $defer = false;

    /**
     * Register custom Redis cache driver.
     *
     * @return void
     */
    public function boot()
    {
        Cache::extend('redis', function ($app, $config) {
            $store = new RedisStore(
                $app['redis'],
                Arr::get($config, 'prefix', $this->app['config']['cache.prefix']),
                Arr::get($config, 'connection', 'default')
            );

            $repository = new Repository($store);

            if ($app->bound('Illuminate\Contracts\Events\Dispatcher')) {
                $repository->setEventDispatcher(
                    $app['Illuminate\Contracts\Events\Dispatcher']
                );
            }

            return $repository;
        });
    }

    /**
     * Register custom bindings.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('redis', function ($app) {
            return new Database($app['config']['database.redis']);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['redis'];
    }
}
