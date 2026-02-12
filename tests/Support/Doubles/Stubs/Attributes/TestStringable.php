<?php

namespace Tests\Support\Doubles\Stubs\Attributes;

class TestStringable implements \Stringable
{
    public function __toString(): string
    {
        return 'stringable';
    }
}
