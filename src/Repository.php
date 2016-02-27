<?php

namespace TillKruss\LaravelPHPRedis;

use Closure;
use Illuminate\Cache\Repository as BaseRepository;

class Repository extends BaseRepository
{
    use RepositoryTrait;
}
