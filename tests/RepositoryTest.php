<?php

class RepositoryTest extends PHPUnit_Framework_TestCase
{
    public function testGetReturnsNullWhenResultIsNull()
    {
        $redis = $this->repository();
        $redis->getStore()->shouldReceive('get')->once()->with('foo')->andReturn(null);
        $this->assertNull($redis->get('foo'));
    }

    public function testGetReturnsNullWhenResultIsFalse()
    {
        $redis = $this->repository();
        $redis->getStore()->shouldReceive('get')->once()->with('foo')->andReturn(false);
        $this->assertNull($redis->get('foo'));
    }

    public function testGetReturnsStoredValue()
    {
        $redis = $this->repository();
        $redis->getStore()->shouldReceive('get')->once()->with('foo')->andReturn('bar');
        $this->assertEquals('bar', $redis->get('foo'));
    }

    public function testHasReturnsFalseWhenResultIsNull()
    {
        $redis = $this->repository();
        $redis->getStore()->shouldReceive('get')->once()->with('foo')->andReturn(null);
        $this->assertFalse($redis->has('foo'));
    }

    public function testHasReturnsFalseWhenResultIsFalse()
    {
        $redis = $this->repository();
        $redis->getStore()->shouldReceive('get')->once()->with('foo')->andReturn(false);
        $this->assertFalse($redis->has('foo'));
    }

    // ToDo: Tests for `many()`

    public function testAddStoresItemWhenGetResultIsNull()
    {
        $redis = $this->repository();
        $redis->getStore()->shouldReceive('get')->once()->with('foo')->andReturn(null);
        $redis->getStore()->shouldReceive('put')->once()->with('foo', 'bar', 60);
        $this->assertTrue($redis->add('foo', 'bar', 60));
    }

    public function testAddStoresItemWhenGetResultIsFalse()
    {
        $redis = $this->repository();
        $redis->getStore()->shouldReceive('get')->once()->with('foo')->andReturn(false);
        $redis->getStore()->shouldReceive('put')->once()->with('foo', 'bar', 60);
        $this->assertTrue($redis->add('foo', 'bar', 60));
    }

    // ToDo: Tests for `remember()`
    // ToDo: Tests for `rememberForever()`

    protected function repository()
    {
        return new TillKruss\LaravelPhpRedis\Repository(
            Mockery::mock('TillKruss\LaravelPhpRedis\RedisStore')
        );
    }
}
