<?php

namespace TillKruss\LaravelPhpRedis;

use Redis;
use RedisCluster;
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
                $client->setOption(Redis::OPT_PREFIX, $server['prefix']);
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
     *
     * @param  array  $servers
     * @param  array  $options
     * @return array
     */
    protected function createAggregateClient(array $servers, array $options = [])
    {
        $servers = array_map([$this, 'buildClusterSeed'], $servers);

        $timeout = empty($options['timeout']) ? 0 : $options['timeout'];
        $persistent = isset($options['persistent']) && $options['persistent'];

        return ['default' => new RedisCluster(
            null, array_values($servers), $timeout, null, $persistent
        )];
    }

    /**
     * Build a cluster seed string.
     *
     * @param  array  $server
     * @return string
     */
    protected function buildClusterSeed($server)
    {
        $parameters = [];

        foreach (['database', 'timeout', 'prefix'] as $parameter) {
            if (! empty($server[$parameter])) {
                $parameters[$parameter] = $server[$parameter];
            }
        }

        if (! empty($server['password'])) {
            $parameters['auth'] = $server['password'];
        }

        return $server['host'].':'.$server['port'].'?'.http_build_query($parameters);
    }
}
