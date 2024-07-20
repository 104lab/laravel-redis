<?php

namespace Benchmarks\FoundItemIsNone;

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
        $this->init(0, $this->more);
    }

    public function checkItem(): void
    {
        $this->check(0);
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
