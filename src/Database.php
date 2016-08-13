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
            $client->connect($server['host'], $server['port']);

            if (isset($server['password'])) {
                $client->auth($server['password']);
            }

            $client->select($server['database']);

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
