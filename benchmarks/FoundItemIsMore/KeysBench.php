<?php

namespace Benchmarks\FoundItemIsMore;

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
        $this->init($this->more, $this->less);
    }

    public function checkItem(): void
    {
        $this->check($this->more);
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