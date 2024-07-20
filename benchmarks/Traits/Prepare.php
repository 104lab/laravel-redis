<?php

namespace Benchmarks\Traits;

use Illuminate\Container\Container;
use Illuminate\Redis\Connections\Connection;
use Illuminate\Redis\RedisManager;
use Illuminate\Support\Collection;
use Redis;

trait Prepare
{
    private int $chunk = 100;

    private int $more = 10_000;

    private int $less = 100;

    private ?Connection $connection = null;

    private array $keys = [];

    private function createRedisManager(): RedisManager
    {
        return new RedisManager(
            new Container(),
            'phpredis',
            [
                'options' => [
                    'cluster' => 'redis',
                ],

                'default' => [
                    'host' => '127.0.0.1',
                    'port' => 6379,
                    'database' => 0,
                    'read_timeout' => 1,
                ],
            ],
        );
    }

    private function init(int $foo, int $bar): void
    {
        ini_set('memory_limit', -1);

        if ($this->connection === null) {
            $this->connection = $this->createRedisManager()->connection();
        }

        $this->connection->flushdb();
        $this->connection->pipeline(function (Redis $pipe) use ($foo, $bar) {
            Collection::times($foo, fn($num) => $pipe->set("foo:$num", 1));
            Collection::times($bar, fn($num) => $pipe->set("bar:$num", 1));
        });
    }

    private function check(int $foo): void
    {
        $count = count($this->keys);

        assert($count === $foo, "Check error, expect is $foo, actual is $count");
    }
}