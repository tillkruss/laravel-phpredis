<?php

namespace TillKruss\LaravelPhpRedis;

use Illuminate\Cache\RedisTaggedCache as TaggedCache;

class RedisTaggedCache extends TaggedCache
{
    use RepositoryTrait;
}
