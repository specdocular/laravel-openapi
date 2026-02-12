<?php

namespace Tests\Support\Doubles\Stubs\Objects;

use Specdocular\LaravelOpenAPI\Attributes\PathItem;

#[PathItem]
class InvocableController
{
    public function __invoke(): void
    {
    }
}
