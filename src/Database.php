<?php

namespace TillKruss\LaravelPhpRedis;

use Redis;
use BadMethodCallException;
use Illuminate\Redis\Database as BaseDatabase;
use Illuminate\Contracts\Redis\Database as DatabaseContract;

class Database extends BaseDatabase implements DatabaseContract
{
    /**
     * Create an array of single connection clients.
     *
     * @param  array  $servers
     * @param  array  $options
     * @return array
     */
    protected function createSingleClients(array $servers, array $options = [])
    {
        $clients = [];

        foreach ($servers as $key => $server) {
            $client = new Redis();

            $timeout = empty($server['timeout']) ? 0 : $server['timeout'];

            if (isset($server['persistent']) && $server['persistent']) {
                $client->pconnect($server['host'], $server['port'], $timeout);
            } else {
                $client->connect($server['host'], $server['port'], $timeout);
            }

            if (! empty($server['prefix'])) {
                $redis->setOption(Redis::OPT_PREFIX, $server['prefix']);
            }

            if (! empty($server['password'])) {
                $client->auth($server['password']);
            }

            if (! empty($server['database'])) {
                $client->select($server['database']);
            }

            $clients[$key] = $client;
        }

        return $clients;
    }

    /**
     * Create a new aggregate client supporting sharding.
     * Throws exception, since PHPRedis doesn't support client sharding.
     *
     * @param  array  $servers
     * @param  array  $options
     *
     * @throws BadMethodCallException
     */
    protected function createAggregateClient(array $servers, array $options = [])
    {
        throw new BadMethodCallException('PHPRedis does not support sharding.');
    }
}
