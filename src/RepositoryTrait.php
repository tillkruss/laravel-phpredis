<?php

namespace TillKruss\LaravelPhpRedis;

use Closure;

trait RepositoryTrait
{
    /**
     * Determine if an item exists in the cache.
     *
     * @param  string  $key
     * @return bool
     */
    public function has($key)
    {
        $value = $this->get($key);

        return ! is_null($value) && $value !== false;
    }

    /**
     * Retrieve an item from the cache by key.
     *
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        if (is_array($key)) {
            return $this->many($key);
        }

        $value = $this->store->get($this->itemKey($key));

        if (is_null($value) || $value === false) {
            $this->fireCacheEvent('missed', [$key]);

            $value = value($default);
        } else {
            $this->fireCacheEvent('hit', [$key, $value]);
        }

        return $value;
    }

    /**
     * Retrieve multiple items from the cache by key.
     *
     * Items not found in the cache will have a null value.
     *
     * @param  array  $keys
     * @return array
     */
    public function many(array $keys)
    {
        $normalizedKeys = [];

        foreach ($keys as $key => $value) {
            $normalizedKeys[] = is_string($key) ? $key : $value;
        }

        $values = $this->store->many($normalizedKeys);

        foreach ($values as $key => &$value) {
            if (is_null($value) || $value === false) {
                $this->fireCacheEvent('missed', [$key]);

                $value = isset($keys[$key]) ? value($keys[$key]) : null;
            } else {
                $this->fireCacheEvent('hit', [$key, $value]);
            }
        }

        return $values;
    }

    /**
     * Store an item in the cache if the key does not exist.
     *
     * @param  string  $key
     * @param  mixed   $value
     * @param  \DateTime|int  $minutes
     * @return bool
     */
    public function add($key, $value, $minutes)
    {
        $minutes = $this->getMinutes($minutes);

        if (is_null($minutes)) {
            return false;
        }

        if (method_exists($this->store, 'add')) {
            return $this->store->add($this->itemKey($key), $value, $minutes);
        }

        $result = $this->get($key);

        if (is_null($result) || $result === false) {
            $this->put($key, $value, $minutes);

            return true;
        }

        return false;
    }

    /**
     * Get an item from the cache, or store the default value.
     *
     * @param  string  $key
     * @param  \DateTime|int  $minutes
     * @param  \Closure  $callback
     * @return mixed
     */
    public function remember($key, $minutes, Closure $callback)
    {
        $value = $this->get($key);

        // If the item exists in the cache we will just return this immediately
        // otherwise we will execute the given Closure and cache the result
        // of that execution for the given number of minutes in storage.
        if (! is_null($value) && $value !== false) {
            return $value;
        }

        $this->put($key, $value = $callback(), $minutes);

        return $value;
    }

    /**
     * Get an item from the cache, or store the default value forever.
     *
     * @param  string   $key
     * @param  \Closure  $callback
     * @return mixed
     */
    public function rememberForever($key, Closure $callback)
    {
        $value = $this->get($key);

        // If the item exists in the cache we will just return this immediately
        // otherwise we will execute the given Closure and cache the result
        // of that execution for the given number of minutes. It's easy.
        if (! is_null($value) && $value !== false) {
            return $value;
        }

        $this->forever($key, $value = $callback());

        return $value;
    }
}
