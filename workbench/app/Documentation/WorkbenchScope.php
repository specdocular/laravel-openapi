<?php

namespace Workbench\App\Documentation;

final readonly class WorkbenchScope implements \Stringable
{
    public function __toString(): string
    {
        return 'Workbench';
    }
}
