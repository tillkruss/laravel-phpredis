<?php

namespace TillKruss\LaravelPHPRedis;

use Illuminate\Cache\Repository as BaseRepository;

class Repository extends BaseRepository
{
    use RepositoryTrait;
}
