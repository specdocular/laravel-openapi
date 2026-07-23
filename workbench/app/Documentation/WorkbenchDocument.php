<?php

namespace Workbench\App\Documentation;

final readonly class WorkbenchDocument implements \Stringable
{
    public function __toString(): string
    {
        return 'Workbench';
    }
}
