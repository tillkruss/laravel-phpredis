<?php

namespace TillKruss\LaravelPhpRedis;

use Illuminate\Cache\TagSet;
use Illuminate\Cache\RedisStore as Store;

class RedisStore extends Store
{
    /**
     * Retrieve an item from the cache by key.
     *
     * @param  string|array  $key
     * @return mixed
     */
    public function get($key)
    {
        $value = $this->connection()->get($this->prefix.$key);

        if (! is_null($value) && $value !== false) {
            return is_numeric($value) ? $value : unserialize($value);
        }
    }

    /**
     * Begin executing a new tags operation.
     *
     * @param  array|mixed  $names
     * @return \TillKruss\LaravelPhpRedis\RedisTaggedCache
     */
    public function tags($names)
    {
        return new RedisTaggedCache($this, new TagSet($this, is_array($names) ? $names : func_get_args()));
    }
}
