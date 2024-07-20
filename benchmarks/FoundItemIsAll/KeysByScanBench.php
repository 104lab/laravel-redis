<?php

namespace Benchmarks\FoundItemIsAll;

use Benchmarks\Traits;
use Lab104\Laravel\Redis\KeysByScan;

/**
 * Benchmark keys
 *
 * @BeforeMethods({"initItem"})
 * @AfterMethods({"checkItem"})
 */
class KeysByScanBench
{
    use Traits\Prepare;

    public function initItem(): void
    {
        $this->init($this->more, 0);
    }

    public function checkItem(): void
    {
        $this->check($this->more);
    }

    /**
     * @Revs(10)
     * @Iterations(3)
     */
    public function benchKeysByScan(): void
    {
        $this->keys = (new KeysByScan($this->connection))('foo:*', $this->chunk);
    }
}
