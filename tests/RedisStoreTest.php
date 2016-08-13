<?php

class RedisStoreTest extends PHPUnit_Framework_TestCase
{
    public function testGetReturnsNullWhenResultIsNull()
    {
        $redis = $this->redisStore();
        $redis->getRedis()->shouldReceive('connection')->once()->with('default')->andReturn($redis->getRedis());
        $redis->getRedis()->shouldReceive('get')->once()->with('foo')->andReturn(null);
        $this->assertNull($redis->get('foo'));
    }

    public function testGetReturnsNullWhenResultIsFalse()
    {
        $redis = $this->redisStore();
        $redis->getRedis()->shouldReceive('connection')->once()->with('default')->andReturn($redis->getRedis());
        $redis->getRedis()->shouldReceive('get')->once()->with('foo')->andReturn(false);
        $this->assertNull($redis->get('foo'));
    }

    protected function redisStore()
    {
        return new TillKruss\LaravelPhpRedis\RedisStore(
            Mockery::mock('TillKruss\LaravelPhpRedis\Database')
        );
    }
}
