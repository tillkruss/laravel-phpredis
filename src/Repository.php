<?php

namespace TillKruss\LaravelPhpRedis;

use Illuminate\Cache\Repository as BaseRepository;

class Repository extends BaseRepository
{
    use RepositoryTrait;
}
