<?php

namespace Benchmarks;

use Lab104\Laravel\Redis\KeysByScan;

/**
 * Benchmark keys
 *
 * @BeforeMethods({"init"})
 * @AfterMethods({"check"})
 */
class KeysByScanBench
{
    use Traits\Init;

    /**
     * @Revs(100)
     * @Iterations(3)
     */
    public function benchKeysByScan(): void
    {
        $this->keys = (new KeysByScan($this->connection))('foo:*');
    }
}
