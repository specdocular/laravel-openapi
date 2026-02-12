<?php

namespace Tests;

use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
{
    use WithWorkbench;

    /** @var array<int, callable(): void> */
    public array $cleanupCallbacks = [];

    public function pushCleanupCallback(callable $callback): void
    {
        $this->cleanupCallbacks[] = $callback;
    }
}
