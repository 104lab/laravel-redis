<?php

namespace Benchmarks\FoundItemIsNone;

use Benchmarks\Traits;

/**
 * Benchmark keys
 *
 * @BeforeMethods({"initItem"})
 * @AfterMethods({"checkItem"})
 */
class KeysBench
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
    public function benchKeys(): void
    {
        $this->keys = $this->connection->keys('foo:*');
    }
}