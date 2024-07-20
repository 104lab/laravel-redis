<?php

namespace Benchmarks\FoundItemIsLess;

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
        $this->init($this->less, $this->more);
    }

    public function checkItem(): void
    {
        $this->check($this->less);
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