<?php

namespace TillKruss\LaravelPHPRedis;

use Illuminate\Cache\RedisTaggedCache as TaggedCache;

class RedisTaggedCache extends TaggedCache
{
    use RepositoryTrait;
}
